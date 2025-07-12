<?php

namespace App\Http\Controllers;

use App\Models\SolicitationPricing;
use App\Models\Enterprise;
use Illuminate\Http\Request;

class SolicitationPricingController extends Controller
{
    public function index(Request $request)
    {
        $enterprises = Enterprise::orderBy('name')->get();

        $query = SolicitationPricing::with('enterprise');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('description', 'like', "%{$search}%")
                    ->orWhereHas('enterprise', function ($q2) use ($search) {
                        $q2->where('name', 'like', "%{$search}%");
                    });
            });
        }
        if ($request->filled('enterprise_id')) {
            $query->where('enterprise_id', $request->enterprise_id);
        }

        $solicitationPricings = $query->paginate(15)->withQueryString();

        $enterprisesCount = $solicitationPricings->pluck('enterprise_id')->unique()->count();
        $activeRulesCount = $solicitationPricings->filter(function ($item) {
            return $item->status === 'active';
        })->count();

        return view('solicitation_pricings.index', compact(
            'solicitationPricings',
            'enterprises',
            'enterprisesCount',
            'activeRulesCount'
        ));
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
            'description' => 'required|string|max:255',
            'individual_driver_price' => 'required|string',
            'individual_vehicle_price' => 'required|string',
            'unified_price' => 'required|string',
            'unified_additional_vehicle_2' => 'nullable|string',
            'unified_additional_vehicle_3' => 'nullable|string',
            'unified_additional_vehicle_4' => 'nullable|string',
            'recurrence_autonomo' => 'nullable|boolean',
            'recurrence_agregado' => 'nullable|boolean',
            'recurrence_frota' => 'nullable|boolean',
            'validity_days' => 'nullable|integer',
            'validity_autonomo_days' => 'nullable|integer',
            'validity_agregado_days' => 'nullable|integer',
            'validity_funcionario_days' => 'nullable|integer',
            'status' => 'required|string|max:20',
        ]);

        // Converte valores mascarados para float
        $validated['individual_driver_price'] = $this->moneyToFloat($validated['individual_driver_price']);
        $validated['individual_vehicle_price'] = $this->moneyToFloat($validated['individual_vehicle_price']);
        $validated['unified_price'] = $this->moneyToFloat($validated['unified_price']);
        $validated['unified_additional_vehicle_2'] = $this->moneyToFloat($validated['unified_additional_vehicle_2'] ?? null);
        $validated['unified_additional_vehicle_3'] = $this->moneyToFloat($validated['unified_additional_vehicle_3'] ?? null);
        $validated['unified_additional_vehicle_4'] = $this->moneyToFloat($validated['unified_additional_vehicle_4'] ?? null);

        // Garante booleanos para checkboxes
        $validated['recurrence_autonomo'] = $request->has('recurrence_autonomo');
        $validated['recurrence_agregado'] = $request->has('recurrence_agregado');
        $validated['recurrence_frota'] = $request->has('recurrence_frota');

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
            'description' => 'required|string|max:255',
            'individual_driver_price' => 'required|string',
            'individual_vehicle_price' => 'required|string',
            'unified_price' => 'required|string',
            'unified_additional_vehicle_2' => 'nullable|string',
            'unified_additional_vehicle_3' => 'nullable|string',
            'unified_additional_vehicle_4' => 'nullable|string',
            'recurrence_autonomo' => 'nullable|boolean',
            'recurrence_agregado' => 'nullable|boolean',
            'recurrence_frota' => 'nullable|boolean',
            'validity_days' => 'nullable|integer',
            'validity_autonomo_days' => 'nullable|integer',
            'validity_agregado_days' => 'nullable|integer',
            'validity_funcionario_days' => 'nullable|integer',
            'status' => 'required|string|max:20',
        ]);

        $validated['individual_driver_price'] = $this->moneyToFloat($validated['individual_driver_price']);
        $validated['individual_vehicle_price'] = $this->moneyToFloat($validated['individual_vehicle_price']);
        $validated['unified_price'] = $this->moneyToFloat($validated['unified_price']);
        $validated['unified_additional_vehicle_2'] = $this->moneyToFloat($validated['unified_additional_vehicle_2'] ?? null);
        $validated['unified_additional_vehicle_3'] = $this->moneyToFloat($validated['unified_additional_vehicle_3'] ?? null);
        $validated['unified_additional_vehicle_4'] = $this->moneyToFloat($validated['unified_additional_vehicle_4'] ?? null);

        $validated['recurrence_autonomo'] = $request->has('recurrence_autonomo');
        $validated['recurrence_agregado'] = $request->has('recurrence_agregado');
        $validated['recurrence_frota'] = $request->has('recurrence_frota');

        $solicitationPricing->update($validated);

        return redirect()->route('solicitation-pricings.show', $solicitationPricing)->with('success', 'Tabela de preços atualizada!');
    }

    public function destroy(SolicitationPricing $solicitationPricing)
    {
        $solicitationPricing->delete();
        return redirect()->route('solicitation-pricings.index')->with('success', 'Tabela de preços removida!');
    }

    /**
     * Converte valor monetário mascarado (ex: "1.234,56") em float (1234.56)
     */
    private function moneyToFloat($value)
    {
        if (is_null($value) || $value === '') return null;
        // Remove pontos de milhar e troca vírgula por ponto
        return floatval(str_replace(['.', ','], ['', '.'], preg_replace('/\./', '', $value, -1, $count)));
    }
}
