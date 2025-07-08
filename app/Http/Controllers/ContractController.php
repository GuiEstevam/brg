<?php

namespace App\Http\Controllers;

use App\Models\Contract;
use App\Models\Enterprise;
use Illuminate\Http\Request;

class ContractController extends Controller
{
    public function index()
    {
        $contracts = Contract::with('enterprise')->paginate(20);
        return view('contracts.index', compact('contracts'));
    }

    public function create()
    {
        $enterprises = Enterprise::all();
        return view('contracts.create', compact('enterprises'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'enterprise_id' => 'required|exists:enterprises,id',
            'plan_name' => 'required|string|max:100',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'status' => 'required|string|max:20',
            'max_users' => 'nullable|integer',
            'max_queries' => 'nullable|integer',
            'unlimited_queries' => 'required|boolean',
            'total_queries_used' => 'nullable|integer',
        ]);

        $contract = Contract::create($validated);

        return redirect()->route('contracts.show', $contract)->with('success', 'Contrato cadastrado!');
    }

    public function show(Contract $contract)
    {
        $contract->load('enterprise');
        return view('contracts.show', compact('contract'));
    }

    public function edit(Contract $contract)
    {
        $enterprises = Enterprise::all();
        return view('contracts.edit', compact('contract', 'enterprises'));
    }

    public function update(Request $request, Contract $contract)
    {
        $validated = $request->validate([
            'enterprise_id' => 'required|exists:enterprises,id',
            // ... mesmas regras do store
        ]);

        $contract->update($validated);

        return redirect()->route('contracts.show', $contract)->with('success', 'Contrato atualizado!');
    }

    public function destroy(Contract $contract)
    {
        $contract->delete();
        return redirect()->route('contracts.index')->with('success', 'Contrato removido!');
    }
}
