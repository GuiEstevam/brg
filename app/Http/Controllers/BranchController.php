<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Enterprise;
use Illuminate\Http\Request;

class BranchController extends Controller
{
    public function index(Request $request)
    {
    $query = Branch::with('enterprise');

    // Filtro de busca
    if ($request->filled('search')) {
        $search = $request->search;
        $query->where(function($q) use ($search) {
            $q->where('name', 'like', "%{$search}%")
              ->orWhere('city', 'like', "%{$search}%");
        });
    }

    // Filtro de status
    if ($request->filled('status')) {
        $query->where('status', $request->status);
    }

    $branches = $query->paginate(15)->withQueryString();

    return view('branches.index', compact('branches'));
    }

    public function create()
    {
        $enterprises = Enterprise::orderBy('name')->get();
        return view('branches.create', compact('enterprises'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'enterprise_id' => 'required|exists:enterprises,id',
            'name' => 'required|string|max:255',
            'cnpj' => 'nullable|string|max:20|unique:branches,cnpj',
            'address' => 'required|string|max:255',
            'number' => 'required|string|max:20',
            'uf' => 'required|string|max:2',
            'cep' => 'required|string|max:20',
            'district' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'status' => 'required|string|max:20',
        ]);

        $branch = Branch::create($validated);

        return redirect()->route('branches.show', $branch)->with('success', 'Filial criada com sucesso!');
    }

    public function show(Branch $branch)
    {
        $branch->load('enterprise');
        return view('branches.show', compact('branch'));
    }

    public function edit(Branch $branch)
    {
        $enterprises = Enterprise::orderBy('name')->get();
        return view('branches.edit', compact('branch', 'enterprises'));
    }

    public function update(Request $request, Branch $branch)
    {
        $validated = $request->validate([
            'enterprise_id' => 'required|exists:enterprises,id',
            'name' => 'required|string|max:255',
            'cnpj' => 'nullable|string|max:20|unique:branches,cnpj,' . $branch->id,
            'address' => 'required|string|max:255',
            'number' => 'required|string|max:20',
            'uf' => 'required|string|max:2',
            'cep' => 'required|string|max:20',
            'district' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'status' => 'required|string|max:20',
        ]);

        $branch->update($validated);

        return redirect()->route('branches.show', $branch)->with('success', 'Filial atualizada com sucesso!');
    }

    public function destroy(Branch $branch)
    {
        $branch->delete();
        return redirect()->route('branches.index')->with('success', 'Filial removida com sucesso!');
    }
}
