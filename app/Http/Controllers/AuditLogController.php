<?php

namespace App\Http\Controllers;

use App\Models\AuditLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\AuditLogExport;

class AuditLogController extends Controller
{
    public function index(Request $request)
    {
        Gate::authorize('viewAny', AuditLog::class);

        $query = $this->buildQuery($request);

        $logs = $query->with('user')->orderByDesc('id')->paginate(20)->withQueryString();

        $distinctActions = AuditLog::select('action')->distinct()->pluck('action');
        $distinctModels = AuditLog::select('auditable_type')->distinct()->pluck('auditable_type');

        return view('audit_logs.index', compact('logs', 'distinctActions', 'distinctModels'));
    }

    private function buildQuery(Request $request)
    {
        $query = AuditLog::query();

        if ($request->filled('user_id')) $query->where('user_id', $request->user_id);
        if ($request->filled('enterprise_id')) $query->where('enterprise_id', $request->enterprise_id);
        if ($request->filled('branch_id')) $query->where('branch_id', $request->branch_id);
        if ($request->filled('action')) $query->where('action', $request->action);
        if ($request->filled('model')) $query->where('auditable_type', $request->model);
        if ($request->filled('from')) $query->whereDate('created_at', '>=', $request->from);
        if ($request->filled('to')) $query->whereDate('created_at', '<=', $request->to);

        // Escopo de admin por empresa
        if (auth()->user()?->hasRole('admin')) {
            $enterpriseIds = auth()->user()->enterprises->pluck('id');
            $query->whereIn('enterprise_id', $enterpriseIds);
        }

        return $query;
    }

    public function exportCsv(Request $request)
    {
        Gate::authorize('viewAny', AuditLog::class);

        $query = $this->buildQuery($request);

        $filename = 'audit_logs_' . now()->format('Ymd_His') . '.csv';
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ];

        return new StreamedResponse(function () use ($query) {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, ['id', 'created_at', 'user_id', 'enterprise_id', 'branch_id', 'action', 'model', 'auditable_id', 'ip_address']);
            $query->orderBy('id')->chunk(1000, function ($rows) use ($handle) {
                foreach ($rows as $log) {
                    fputcsv($handle, [
                        $log->id,
                        $log->created_at,
                        $log->user_id,
                        $log->enterprise_id,
                        $log->branch_id,
                        $log->action,
                        class_basename($log->auditable_type),
                        $log->auditable_id,
                        $log->ip_address,
                    ]);
                }
            });
            fclose($handle);
        }, 200, $headers);
    }

    public function exportExcel(Request $request)
    {
        Gate::authorize('viewAny', AuditLog::class);
        $export = new AuditLogExport($this->buildQuery($request));
        $filename = 'audit_logs_' . now()->format('Ymd_His') . '.xlsx';
        return Excel::download($export, $filename);
    }
}
