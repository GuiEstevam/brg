<?php

namespace App\Http\Controllers;

use App\Models\Driver;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Services\AuditLogger;

class DriverController extends Controller
{
    public function index()
    {
        $this->authorize('viewAny', Driver::class);
        $drivers = Driver::with('driverLicense', 'documents')->paginate(20);
        $canCreateDriver = Gate::allows('create', Driver::class);
        return view('drivers.index', compact('drivers', 'canCreateDriver'));
    }

    public function create()
    {
        $this->authorize('create', Driver::class);
        return view('drivers.create');
    }

    public function store(Request $request)
    {
        $this->authorize('create', Driver::class);
        $validated = $request->validate([
            'cpf' => 'required|unique:drivers,cpf',
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|unique:drivers,email',
            'phone' => 'nullable|string|max:20',
            'birth_date' => 'nullable|date',
            'mother_name' => 'nullable|string|max:255',
            'rg_number' => 'nullable|string|max:20',
            'rg_uf' => 'nullable|string|max:2',
            'status' => 'required|string|max:20',
        ]);

        $driver = Driver::create($validated);
        AuditLogger::log('created', $driver, [], $driver->toArray());

        return redirect()->route('drivers.show', $driver)->with('success', 'Motorista cadastrado!');
    }

    public function show(Driver $driver)
    {
        $this->authorize('view', $driver);
        $driver->load('driverLicense', 'documents');
        return view('drivers.show', compact('driver'));
    }

    public function edit(Driver $driver)
    {
        $this->authorize('update', $driver);
        return view('drivers.edit', compact('driver'));
    }

    public function update(Request $request, Driver $driver)
    {
        $this->authorize('update', $driver);
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|unique:drivers,email,' . $driver->id,
            'phone' => 'nullable|string|max:20',
            'birth_date' => 'nullable|date',
            'mother_name' => 'nullable|string|max:255',
            'rg_number' => 'nullable|string|max:20',
            'rg_uf' => 'nullable|string|max:2',
            'status' => 'required|string|max:20',
        ]);

        $old = $driver->getOriginal();
        $driver->update($validated);
        AuditLogger::log('updated', $driver, $old, $driver->toArray());

        return redirect()->route('drivers.show', $driver)->with('success', 'Motorista atualizado!');
    }

    public function destroy(Driver $driver)
    {
        $this->authorize('delete', $driver);
        $old = $driver->getOriginal();
        $driver->delete();
        AuditLogger::log('deleted', $driver, $old, []);
        return redirect()->route('drivers.index')->with('success', 'Motorista removido!');
    }
}
