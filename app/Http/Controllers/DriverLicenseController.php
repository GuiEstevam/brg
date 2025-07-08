<?php

namespace App\Http\Controllers;

use App\Models\DriverLicense;
use App\Models\Driver;
use Illuminate\Http\Request;

class DriverLicenseController extends Controller
{
    public function index()
    {
        $licenses = DriverLicense::with('driver')->paginate(20);
        return view('driver_licenses.index', compact('licenses'));
    }

    public function create()
    {
        $drivers = Driver::all();
        return view('driver_licenses.create', compact('drivers'));
    }

    public function store(Request $request)
    {
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

        return redirect()->route('driver-licenses.show', $license)->with('success', 'CNH cadastrada!');
    }

    public function show(DriverLicense $driverLicense)
    {
        $driverLicense->load('driver');
        return view('driver_licenses.show', compact('driverLicense'));
    }

    public function edit(DriverLicense $driverLicense)
    {
        $drivers = Driver::all();
        return view('driver_licenses.edit', compact('driverLicense', 'drivers'));
    }

    public function update(Request $request, DriverLicense $driverLicense)
    {
        $validated = $request->validate([
            'driver_id' => 'required|exists:drivers,id',
            // ... mesmas regras do store
        ]);

        $driverLicense->update($validated);

        return redirect()->route('driver-licenses.show', $driverLicense)->with('success', 'CNH atualizada!');
    }

    public function destroy(DriverLicense $driverLicense)
    {
        $driverLicense->delete();
        return redirect()->route('driver-licenses.index')->with('success', 'CNH removida!');
    }
}
