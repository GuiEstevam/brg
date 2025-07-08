<?php

namespace App\Http\Controllers;

use App\Models\Vehicle;
use Illuminate\Http\Request;

class VehicleController extends Controller
{
    public function index()
    {
        $vehicles = Vehicle::paginate(20);
        return view('vehicles.index', compact('vehicles'));
    }

    public function create()
    {
        return view('vehicles.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'plate' => 'required|unique:vehicles,plate',
            'renavam' => 'nullable|unique:vehicles,renavam',
            'chassi' => 'nullable|unique:vehicles,chassi',
            'brand' => 'nullable|string|max:255',
            'model' => 'nullable|string|max:255',
            'manufacture_year' => 'nullable|string|max:4',
            'model_year' => 'nullable|string|max:4',
            'color' => 'nullable|string|max:50',
            'fuel' => 'nullable|string|max:50',
            'vehicle_type' => 'nullable|string|max:100',
            'vehicle_specie' => 'nullable|string|max:100',
            'licensing_date' => 'nullable|date',
            'licensing_status' => 'nullable|string|max:100',
            'owner_document' => 'nullable|string|max:50',
            'owner_name' => 'nullable|string|max:255',
            'lessee_document' => 'nullable|string|max:50',
            'lessee_name' => 'nullable|string|max:255',
            'antt_situation' => 'nullable|string|max:100',
            'status' => 'required|string|max:20',
        ]);

        $vehicle = Vehicle::create($validated);

        return redirect()->route('vehicles.show', $vehicle)->with('success', 'Veículo cadastrado!');
    }

    public function show(Vehicle $vehicle)
    {
        return view('vehicles.show', compact('vehicle'));
    }

    public function edit(Vehicle $vehicle)
    {
        return view('vehicles.edit', compact('vehicle'));
    }

    public function update(Request $request, Vehicle $vehicle)
    {
        $validated = $request->validate([
            'plate' => 'required|unique:vehicles,plate,' . $vehicle->id,
            'renavam' => 'nullable|unique:vehicles,renavam,' . $vehicle->id,
            'chassi' => 'nullable|unique:vehicles,chassi,' . $vehicle->id,
            'brand' => 'nullable|string|max:255',
            'model' => 'nullable|string|max:255',
            'manufacture_year' => 'nullable|string|max:4',
            'model_year' => 'nullable|string|max:4',
            'color' => 'nullable|string|max:50',
            'fuel' => 'nullable|string|max:50',
            'vehicle_type' => 'nullable|string|max:100',
            'vehicle_specie' => 'nullable|string|max:100',
            'licensing_date' => 'nullable|date',
            'licensing_status' => 'nullable|string|max:100',
            'owner_document' => 'nullable|string|max:50',
            'owner_name' => 'nullable|string|max:255',
            'lessee_document' => 'nullable|string|max:50',
            'lessee_name' => 'nullable|string|max:255',
            'antt_situation' => 'nullable|string|max:100',
            'status' => 'required|string|max:20',
        ]);

        $vehicle->update($validated);

        return redirect()->route('vehicles.show', $vehicle)->with('success', 'Veículo atualizado!');
    }

    public function destroy(Vehicle $vehicle)
    {
        $vehicle->delete();
        return redirect()->route('vehicles.index')->with('success', 'Veículo removido!');
    }
}
