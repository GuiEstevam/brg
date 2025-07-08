<?php

namespace App\Http\Controllers;

use App\Models\SolicitationPricing;
use App\Models\Enterprise;
use Illuminate\Http\Request;

class SolicitationPricingController extends Controller
{
    public function index()
    {
        $pricings = SolicitationPricing::with('enterprise')->paginate(20);
        return view('solicitation_pricings.index', compact('pricings'));
    }

    public function create()
    {
        $enterprises = Enterprise::all();
        return view('solicitation_pricings.create', compact('enterprises'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'enterprise_id' => 'required|exists:enterprises,id',
            'individual_driver_price' => 'required|numeric',
            'individual_vehicle_price' => 'required|numeric',
            'unified_price' => 'required|numeric',
            'individual_driver_recurring' => 'required|boolean',
            'individual_vehicle_recurring' => 'required|boolean',
            'unified_recurring' => 'required|boolean',
            'validity_days' => 'nullable|integer',
            'price_expressa_driver' => 'nullable|numeric',
            'price_normal_driver' => 'nullable|numeric',
            'price_plus_driver' => 'nullable|numeric',
            'price_expressa_vehicle' => 'nullable|numeric',
            'price_normal_vehicle' => 'nullable|numeric',
            'price_plus_vehicle' => 'nullable|numeric',
            'price_expressa_unified' => 'nullable|numeric',
            'price_normal_unified' => 'nullable|numeric',
            'price_plus_unified' => 'nullable|numeric',
            'unified_additional_per_vehicle_expressa' => 'nullable|numeric',
            'unified_additional_per_vehicle_normal' => 'nullable|numeric',
            'unified_additional_per_vehicle_plus' => 'nullable|numeric',
            'validity_autonomo_days' => 'nullable|integer',
            'validity_agregado_days' => 'nullable|integer',
            'validity_funcionario_days' => 'nullable|integer',
            'description' => 'nullable|string',
            'status' => 'required|string|max:20',
        ]);

        $pricing = SolicitationPricing::create($validated);

        return redirect()->route('solicitation-pricings.show', $pricing)->with('success', 'Tabela de preços cadastrada!');
    }

    public function show(SolicitationPricing $solicitationPricing)
    {
        $solicitationPricing->load('enterprise');
        return view('solicitation_pricings.show', compact('solicitationPricing'));
    }

    public function edit(SolicitationPricing $solicitationPricing)
    {
        $enterprises = Enterprise::all();
        return view('solicitation_pricings.edit', compact('solicitationPricing', 'enterprises'));
    }

    public function update(Request $request, SolicitationPricing $solicitationPricing)
    {
        $validated = $request->validate([
            'enterprise_id' => 'required|exists:enterprises,id',
            // ... mesmas regras do store
        ]);

        $solicitationPricing->update($validated);

        return redirect()->route('solicitation-pricings.show', $solicitationPricing)->with('success', 'Tabela de preços atualizada!');
    }

    public function destroy(SolicitationPricing $solicitationPricing)
    {
        $solicitationPricing->delete();
        return redirect()->route('solicitation-pricings.index')->with('success', 'Tabela de preços removida!');
    }
}
