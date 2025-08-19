<?php

namespace App\Http\Controllers;

use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Services\AuditLogger;

class VehicleController extends Controller
{
    public function index()
    {
        $this->authorize('viewAny', Vehicle::class);
        $vehicles = Vehicle::paginate(10);
        $canCreateVehicle = Gate::allows('create', Vehicle::class);
        return view('vehicles.index', compact('vehicles', 'canCreateVehicle'));
    }

    public function create()
    {
        $this->authorize('create', Vehicle::class);
        return view('vehicles.create');
    }

    public function store(Request $request)
    {
        $this->authorize('create', Vehicle::class);
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
        AuditLogger::log('created', $vehicle, [], $vehicle->toArray());

        return redirect()->route('vehicles.show', $vehicle)->with('success', 'Veículo cadastrado!');
    }

    public function show(Vehicle $vehicle)
    {
        $this->authorize('view', $vehicle);
        return view('vehicles.show', compact('vehicle'));
    }

    public function edit(Vehicle $vehicle)
    {
        $this->authorize('update', $vehicle);
        return view('vehicles.edit', compact('vehicle'));
    }

    public function update(Request $request, Vehicle $vehicle)
    {
        $this->authorize('update', $vehicle);
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

        $old = $vehicle->getOriginal();
        $vehicle->update($validated);
        AuditLogger::log('updated', $vehicle, $old, $vehicle->toArray());

        return redirect()->route('vehicles.show', $vehicle)->with('success', 'Veículo atualizado!');
    }

    public function destroy(Vehicle $vehicle)
    {
        $this->authorize('delete', $vehicle);
        $old = $vehicle->getOriginal();
        $vehicle->delete();
        AuditLogger::log('deleted', $vehicle, $old, []);
        return redirect()->route('vehicles.index')->with('success', 'Veículo removido!');
    }
}
