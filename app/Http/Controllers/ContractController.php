<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Contract;
use App\Models\Enterprise;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\QueryExport;

class ContractController extends Controller
{
    use AuthorizesRequests;
    public function index(Request $request)
    {
        $this->authorize('viewAny', Contract::class);

        $user = Auth::user();
        $contractsQuery = Contract::with('enterprise');

        if ($user->hasRole('superadmin')) {
            // Vê todos os contratos
        } elseif ($user->hasRole('admin')) {
            // Admin: empresa do contexto (todas filiais)
            $enterpriseIds = current_enterprise_id()
                ? [current_enterprise_id()]
                : $user->enterprises->pluck('id');
            $contractsQuery->whereIn('enterprise_id', $enterpriseIds);
        } else {
            abort(403, 'Acesso não autorizado!');
        }

        if ($request->filled('enterprise_id')) {
            $contractsQuery->where('enterprise_id', $request->enterprise_id);
        }

        $contracts = $contractsQuery->paginate(20)->withQueryString();
        $enterprises = Enterprise::orderBy('name')->get();
        $canCreateContract = Gate::allows('create', Contract::class);

        return view('contracts.index', compact('contracts', 'enterprises', 'canCreateContract'));
    }

    public function exportExcel(Request $request)
    {
        $this->authorize('viewAny', Contract::class);

        $user = Auth::user();
        $contractsQuery = Contract::with('enterprise');
        if ($user->hasRole('admin')) {
            $enterpriseIds = current_enterprise_id()
                ? [current_enterprise_id()]
                : $user->enterprises->pluck('id');
            $contractsQuery->whereIn('enterprise_id', $enterpriseIds);
        }
        if ($request->filled('enterprise_id')) {
            $contractsQuery->where('enterprise_id', $request->enterprise_id);
        }

        $headings = ['id', 'enterprise', 'plan_name', 'start_date', 'end_date', 'status'];
        $mapper = function ($c) {
            return [
                $c->id,
                optional($c->enterprise)->name,
                $c->plan_name ?? '',
                $c->start_date,
                $c->end_date,
                $c->status,
            ];
        };

        $export = new QueryExport($contractsQuery, $headings, $mapper);
        $filename = 'contracts_' . now()->format('Ymd_His') . '.xlsx';
        return Excel::download($export, $filename);
    }

    public function create()
    {
        $this->authorize('create', Contract::class);

        $user = Auth::user();
        $enterprises = $user->hasRole('superadmin')
            ? Enterprise::all()
            : ($user->enterprises);

        $branches = Branch::when(!$user->hasRole('superadmin'), function ($q) use ($user) {
            $enterpriseIds = current_enterprise_id()
                ? [current_enterprise_id()]
                : $user->enterprises->pluck('id');
            $q->whereIn('enterprise_id', $enterpriseIds);
        })->get();

        return view('contracts.create', compact('enterprises', 'branches'));
    }

    public function store(Request $request)
    {
        $this->authorize('create', Contract::class);

        $validated = $request->validate([
            'enterprise_id' => 'required|exists:enterprises,id',
            'plan_name' => 'required|string|max:100',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'status' => 'required|string|max:20',
            'max_users' => 'nullable|integer',
            'max_queries' => 'nullable|integer',
            'total_queries_used' => 'nullable|integer',
        ]);

        $user = Auth::user();
        if (
            $user->hasRole('admin') &&
            !(current_enterprise_id() ? current_enterprise_id() == $validated['enterprise_id'] : $user->enterprises->pluck('id')->contains($validated['enterprise_id']))
        ) {
            abort(403, 'Você não pode criar contrato para esta empresa!');
        }

        $contract = Contract::create($validated);

        return redirect()->route('contracts.show', $contract)->with('success', 'Contrato cadastrado!');
    }

    public function show(Contract $contract)
    {
        $this->authorize('view', $contract);

        $contract->load('enterprise');
        return view('contracts.show', compact('contract'));
    }

    public function edit(Contract $contract)
    {
        $this->authorize('update', $contract);

        $user = Auth::user();
        $enterprises = $user->hasRole('superadmin')
            ? Enterprise::all()
            : $user->enterprises;

        $branches = Branch::where('enterprise_id', $contract->enterprise_id)->get();

        return view('contracts.edit', compact('contract', 'enterprises', 'branches'));
    }

    public function update(Request $request, Contract $contract)
    {
        $this->authorize('update', $contract);

        $validated = $request->validate([
            'enterprise_id' => 'required|exists:enterprises,id',
            'plan_name' => 'required|string|max:100',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'status' => 'required|string|max:20',
            'max_users' => 'nullable|integer',
            'max_queries' => 'nullable|integer',
            'total_queries_used' => 'nullable|integer',
        ]);

        $user = Auth::user();
        if (
            $user->hasRole('admin') &&
            !(current_enterprise_id() ? current_enterprise_id() == $validated['enterprise_id'] : $user->enterprises->pluck('id')->contains($validated['enterprise_id']))
        ) {
            abort(403, 'Você não pode transferir esse contrato para outra empresa!');
        }

        $contract->update($validated);

        return redirect()->route('contracts.show', $contract)->with('success', 'Contrato atualizado!');
    }

    public function destroy(Contract $contract)
    {
        $this->authorize('delete', $contract);

        $contract->delete();
        return redirect()->route('contracts.index')->with('success', 'Contrato removido!');
    }
}
