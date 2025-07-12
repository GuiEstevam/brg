<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Contract;
use App\Models\Enterprise;
use Illuminate\Http\Request;

class ContractController extends Controller
{
    public function index(Request $request)
    {
        $contractsQuery = Contract::with('enterprise');

        if ($request->filled('enterprise_id')) {
            $contractsQuery->where('enterprise_id', $request->enterprise_id);
        }

        // Adicione outros filtros conforme necessário...

        $contracts = $contractsQuery->paginate(20)->withQueryString();
        $enterprises = Enterprise::orderBy('name')->get();

        return view('contracts.index', compact('contracts', 'enterprises'));
    }


    public function create()
    {
        $enterprises = Enterprise::all();
        $branches = Branch::all();
        return view('contracts.create', compact('enterprises', 'branches'));
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
        $branches = Branch::where('enterprise_id', $contract->enterprise_id)->get();
        return view('contracts.edit', compact('contract', 'enterprises', 'branches'));
    }


    public function update(Request $request, Contract $contract)
    {
        $validated = $request->validate([
            'enterprise_id' => 'required|exists:enterprises,id',
            'plan_name' => 'required|string|max:100',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'status' => 'required|string|max:20',
            'max_users' => 'nullable|integer',
            'max_queries' => 'nullable|integer',
            'total_queries_used' => 'nullable|integer',
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
