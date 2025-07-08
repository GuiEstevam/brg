<?php

namespace App\Http\Controllers;

use App\Models\Enterprise;
use Illuminate\Http\Request;

class EnterpriseController extends Controller
{
    public function index()
    {
        $enterprises = Enterprise::with('branches', 'contracts')->paginate(15);
        return view('enterprises.index', compact('enterprises'));
    }

    public function create()
    {
        return view('enterprises.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'cnpj' => 'required|unique:enterprises,cnpj',
            'name' => 'required|string|max:255',
            'state_registration' => 'nullable|string|max:255',
            'address' => 'required|string|max:255',
            'number' => 'required|string|max:20',
            'uf' => 'required|string|max:2',
            'complement' => 'nullable|string|max:255',
            'cep' => 'required|string|max:20',
            'district' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'responsible_name' => 'nullable|string|max:255',
            'responsible_email' => 'nullable|email|max:255',
            'responsible_phone' => 'nullable|string|max:20',
            'status' => 'required|string|max:20',
        ]);

        $enterprise = Enterprise::create($validated);

        return redirect()->route('enterprises.show', $enterprise)->with('success', 'Empresa criada com sucesso!');
    }

    public function show(Enterprise $enterprise)
    {
        $enterprise->load('branches', 'contracts','solicitationPricings');
        return view('enterprises.show', compact('enterprise'));
    }

    public function edit(Enterprise $enterprise)
    {
        return view('enterprises.edit', compact('enterprise'));
    }

    public function update(Request $request, Enterprise $enterprise)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'state_registration' => 'nullable|string|max:255',
            'address' => 'required|string|max:255',
            'number' => 'required|string|max:20',
            'uf' => 'required|string|max:2',
            'complement' => 'nullable|string|max:255',
            'cep' => 'required|string|max:20',
            'district' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'responsible_name' => 'nullable|string|max:255',
            'responsible_email' => 'nullable|email|max:255',
            'responsible_phone' => 'nullable|string|max:20',
            'status' => 'required|string|max:20',
        ]);

        $enterprise->update($validated);

        return redirect()->route('enterprises.show', $enterprise)->with('success', 'Empresa atualizada com sucesso!');
    }

    public function destroy(Enterprise $enterprise)
    {
        $enterprise->delete();
        return redirect()->route('enterprises.index')->with('success', 'Empresa removida com sucesso!');
    }
}
