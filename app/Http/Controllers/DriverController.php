<?php

namespace App\Http\Controllers;

use App\Models\Driver;
use Illuminate\Http\Request;

class DriverController extends Controller
{
    public function index()
    {
        $drivers = Driver::with('driverLicense', 'documents')->paginate(20);
        return view('drivers.index', compact('drivers'));
    }

    public function create()
    {
        return view('drivers.create');
    }

    public function store(Request $request)
    {
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

        return redirect()->route('drivers.show', $driver)->with('success', 'Motorista cadastrado!');
    }

    public function show(Driver $driver)
    {
        $driver->load('driverLicense', 'documents');
        return view('drivers.show', compact('driver'));
    }

    public function edit(Driver $driver)
    {
        return view('drivers.edit', compact('driver'));
    }

    public function update(Request $request, Driver $driver)
    {
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

        $driver->update($validated);

        return redirect()->route('drivers.show', $driver)->with('success', 'Motorista atualizado!');
    }

    public function destroy(Driver $driver)
    {
        $driver->delete();
        return redirect()->route('drivers.index')->with('success', 'Motorista removido!');
    }
}
