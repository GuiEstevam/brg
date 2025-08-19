<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Enterprise;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class BranchController extends Controller
{
    public function index(Request $request)
    {
        $this->authorize('viewAny', Branch::class);
        $query = Branch::with('enterprise');

        // Contexto: superadmin vê tudo, admin vê apenas da empresa em contexto (ou suas empresas)
        $user = Auth::user();
        if ($user->hasRole('admin')) {
            $enterpriseIds = current_enterprise_id()
                ? [current_enterprise_id()]
                : $user->enterprises->pluck('id');
            $query->whereIn('enterprise_id', $enterpriseIds);
        }

        // Filtro de busca
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('city', 'like', "%{$search}%");
            });
        }

        // Filtro de status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $branches = $query->paginate(15)->withQueryString();
        $canCreateBranch = Gate::allows('create', Branch::class);

        return view('branches.index', compact('branches', 'canCreateBranch'));
    }

    public function create()
    {
        $this->authorize('create', Branch::class);
        $user = Auth::user();
        $enterprises = $user->hasRole('superadmin')
            ? Enterprise::orderBy('name')->get()
            : Enterprise::whereIn('id', $user->enterprises->pluck('id'))->orderBy('name')->get();
        return view('branches.create', compact('enterprises'));
    }

    public function store(Request $request)
    {
        $this->authorize('create', Branch::class);
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

        // Admin só cria para empresa do contexto (ou vinculadas)
        $user = Auth::user();
        if ($user->hasRole('admin')) {
            $allowed = current_enterprise_id()
                ? current_enterprise_id() == $validated['enterprise_id']
                : $user->enterprises->pluck('id')->contains($validated['enterprise_id']);
            abort_unless($allowed, 403, 'Você não pode criar filial para esta empresa.');
        }

        $branch = Branch::create($validated);

        return redirect()->route('branches.show', $branch)->with('success', 'Filial criada com sucesso!');
    }

    public function show(Branch $branch)
    {
        $this->authorize('view', $branch);
        $branch->load('enterprise');
        return view('branches.show', compact('branch'));
    }

    public function edit(Branch $branch)
    {
        $this->authorize('update', $branch);
        $user = Auth::user();
        $enterprises = $user->hasRole('superadmin')
            ? Enterprise::orderBy('name')->get()
            : Enterprise::whereIn('id', $user->enterprises->pluck('id'))->orderBy('name')->get();
        return view('branches.edit', compact('branch', 'enterprises'));
    }

    public function update(Request $request, Branch $branch)
    {
        $this->authorize('update', $branch);
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

        $user = Auth::user();
        if ($user->hasRole('admin')) {
            $allowed = current_enterprise_id()
                ? current_enterprise_id() == $validated['enterprise_id']
                : $user->enterprises->pluck('id')->contains($validated['enterprise_id']);
            abort_unless($allowed, 403, 'Você não pode mover/alterar a filial para outra empresa.');
        }

        $branch->update($validated);

        return redirect()->route('branches.show', $branch)->with('success', 'Filial atualizada com sucesso!');
    }

    public function destroy(Branch $branch)
    {
        $this->authorize('delete', $branch);
        $branch->delete();
        return redirect()->route('branches.index')->with('success', 'Filial removida com sucesso!');
    }
}
