<?php

namespace App\Http\Controllers;

use App\Models\DriverLicense;
use App\Models\Driver;
use Illuminate\Http\Request;
use App\Services\AuditLogger;

class DriverLicenseController extends Controller
{
    public function index()
    {
        $this->authorize('viewAny', DriverLicense::class);
        $licenses = DriverLicense::with('driver')->paginate(20);
        return view('driver_licenses.index', compact('licenses'));
    }

    public function create()
    {
        $this->authorize('create', DriverLicense::class);
        $drivers = Driver::all();
        return view('driver_licenses.create', compact('drivers'));
    }

    public function store(Request $request)
    {
        $this->authorize('create', DriverLicense::class);
        $validated = $request->validate([
            'driver_id' => 'required|exists:drivers,id',
            'renach_number' => 'nullable|string|max:50',
            'register_number' => 'nullable|string|max:50',
            'category' => 'nullable|string|max:10',
            'issuance_date' => 'nullable|date',
            'expiry_date' => 'nullable|date',
            'performs_paid_activity' => 'nullable|string|max:10',
            'moop_course' => 'nullable|string|max:100',
            'local_issuance' => 'nullable|string|max:100',
            'security_number' => 'nullable|string|max:50',
            'ordinance' => 'nullable|string|max:100',
            'restriction' => 'nullable|string|max:100',
            'mirror_number' => 'nullable|string|max:50',
            'total_points' => 'nullable|integer',
            'status_cnh_image' => 'nullable|string|max:50',
            'status_message_cnh_image' => 'nullable|string|max:255',
            'validation_status_document_image' => 'nullable|integer',
            'validation_status_cnh' => 'nullable|integer',
            'validation_status_security_number' => 'nullable|integer',
            'validation_status_uf' => 'nullable|integer',
            'validation_image_message' => 'nullable|string|max:255',
        ]);

        $license = DriverLicense::create($validated);
        AuditLogger::log('created', $license, [], $license->toArray());

        return redirect()->route('driver-licenses.show', $license)->with('success', 'CNH cadastrada!');
    }

    public function show(DriverLicense $driverLicense)
    {
        $this->authorize('view', $driverLicense);
        $driverLicense->load('driver');
        return view('driver_licenses.show', compact('driverLicense'));
    }

    public function edit(DriverLicense $driverLicense)
    {
        $this->authorize('update', $driverLicense);
        $drivers = Driver::all();
        return view('driver_licenses.edit', compact('driverLicense', 'drivers'));
    }

    public function update(Request $request, DriverLicense $driverLicense)
    {
        $this->authorize('update', $driverLicense);
        $validated = $request->validate([
            'driver_id' => 'required|exists:drivers,id',
            // ... mesmas regras do store
        ]);

        $old = $driverLicense->getOriginal();
        $driverLicense->update($validated);
        AuditLogger::log('updated', $driverLicense, $old, $driverLicense->toArray());

        return redirect()->route('driver-licenses.show', $driverLicense)->with('success', 'CNH atualizada!');
    }

    public function destroy(DriverLicense $driverLicense)
    {
        $this->authorize('delete', $driverLicense);
        $old = $driverLicense->getOriginal();
        $driverLicense->delete();
        AuditLogger::log('deleted', $driverLicense, $old, []);
        return redirect()->route('driver-licenses.index')->with('success', 'CNH removida!');
    }
}
