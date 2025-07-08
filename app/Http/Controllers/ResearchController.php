<?php

namespace App\Http\Controllers;

use App\Models\Research;
use App\Models\Solicitation;
use App\Models\Driver;
use App\Models\Vehicle;
use Illuminate\Http\Request;

class ResearchController extends Controller
{
    public function index()
    {
        $researches = Research::with('solicitation', 'driver', 'vehicle')->paginate(20);
        return view('researches.index', compact('researches'));
    }

    public function create()
    {
        return view('researches.create', [
            'solicitations' => Solicitation::all(),
            'drivers' => Driver::all(),
            'vehicles' => Vehicle::all(),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'solicitation_id' => 'required|exists:solicitations,id',
            'driver_id' => 'nullable|exists:drivers,id',
            'vehicle_id' => 'nullable|exists:vehicles,id',
            'api_response' => 'nullable|array',
            'status_api' => 'nullable|string|max:50',
            'validity_date' => 'nullable|date',
            'rejection_reasons' => 'nullable|array',
            'total_points' => 'nullable|integer',
        ]);

        $research = Research::create($validated);

        return redirect()->route('researches.show', $research)->with('success', 'Pesquisa registrada!');
    }

    public function show(Research $research)
    {
        $research->load('solicitation', 'driver', 'vehicle');
        return view('researches.show', compact('research'));
    }

    public function edit(Research $research)
    {
        return view('researches.edit', [
            'research' => $research,
            'solicitations' => Solicitation::all(),
            'drivers' => Driver::all(),
            'vehicles' => Vehicle::all(),
        ]);
    }

    public function update(Request $request, Research $research)
    {
        $validated = $request->validate([
            'solicitation_id' => 'required|exists:solicitations,id',
            // ... mesmas regras do store
        ]);

        $research->update($validated);

        return redirect()->route('researches.show', $research)->with('success', 'Pesquisa atualizada!');
    }

    public function destroy(Research $research)
    {
        $research->delete();
        return redirect()->route('researches.index')->with('success', 'Pesquisa removida!');
    }
}
