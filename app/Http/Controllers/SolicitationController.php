<?php

namespace App\Http\Controllers;

use App\Models\Solicitation;
use App\Models\Enterprise;
use App\Models\User;
use App\Models\Branch;
use App\Models\Driver;
use App\Models\Vehicle;
use Illuminate\Http\Request;

class SolicitationController extends Controller
{
    public function index()
    {
        $solicitations = Solicitation::with('enterprise', 'user', 'branch', 'driver', 'vehicle')->paginate(20);
        return view('solicitations.index', compact('solicitations'));
    }

    public function create()
    {
        return view('solicitations.create', [
            'enterprises' => Enterprise::all(),
            'users' => User::all(),
            'branches' => Branch::all(),
            'drivers' => Driver::all(),
            'vehicles' => Vehicle::all(),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'enterprise_id' => 'required|exists:enterprises,id',
            'user_id' => 'required|exists:users,id',
            'branch_id' => 'nullable|exists:branches,id',
            'driver_id' => 'nullable|exists:drivers,id',
            'vehicle_id' => 'nullable|exists:vehicles,id',
            'type' => 'required|string|max:50',
            'subtype' => 'required|string|max:50',
            'value' => 'required|string|max:100',
            'status' => 'required|string|max:30',
            'vincle_type' => 'nullable|string|max:30',
            'research_type' => 'nullable|string|max:30',
            'original_solicitation_id' => 'nullable|exists:solicitations,id',
            'api_request_data' => 'nullable|array',
        ]);

        $solicitation = Solicitation::create($validated);

        return redirect()->route('solicitations.show', $solicitation)->with('success', 'Solicitação criada!');
    }

    public function show(Solicitation $solicitation)
    {
        $solicitation->load('enterprise', 'user', 'branch', 'driver', 'vehicle', 'vehicles', 'researches');
        return view('solicitations.show', compact('solicitation'));
    }

    public function edit(Solicitation $solicitation)
    {
        return view('solicitations.edit', [
            'solicitation' => $solicitation,
            'enterprises' => Enterprise::all(),
            'users' => User::all(),
            'branches' => Branch::all(),
            'drivers' => Driver::all(),
            'vehicles' => Vehicle::all(),
        ]);
    }

    public function update(Request $request, Solicitation $solicitation)
    {
        $validated = $request->validate([
            'enterprise_id' => 'required|exists:enterprises,id',
            'user_id' => 'required|exists:users,id',
            // ... mesmas regras do store
        ]);

        $solicitation->update($validated);

        return redirect()->route('solicitations.show', $solicitation)->with('success', 'Solicitação atualizada!');
    }

    public function destroy(Solicitation $solicitation)
    {
        $solicitation->delete();
        return redirect()->route('solicitations.index')->with('success', 'Solicitação removida!');
    }
}
