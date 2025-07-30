<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\Enterprise; // Caso deseje vincular roles/perms à empresa

class PermissionController extends Controller
{
    public function index(Request $request)
    {
        $enterprises = Enterprise::orderBy('name')->get();
        $roles = Role::with('permissions')->orderBy('name')->get();
        $permissions = Permission::orderBy('name')->get();

        return view('permissions.index', compact('roles', 'permissions', 'enterprises'));
    }

    public function create()
    {
        $enterprises = Enterprise::orderBy('name')->get();
        $permissions = Permission::orderBy('name')->get();

        return view('permissions.create', compact('enterprises', 'permissions'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'      => 'required|string|max:64|unique:roles,name',
            'guard_name' => 'sometimes|string|default:web',
            'team_id'   => 'nullable|integer|exists:enterprises,id',
            'permissions' => 'array',
            'permissions.*' => 'string|exists:permissions,name',
        ]);

        $role = Role::create([
            'name'       => $data['name'],
            'guard_name' => $data['guard_name'] ?? 'web',
            'team_id'    => $data['team_id'] ?? null,
        ]);

        $role->givePermissionTo($data['permissions'] ?? []);

        return redirect()->route('permissions.index')
            ->with('success', 'Papel criado com sucesso!');
    }

    public function edit(Role $role)
    {
        $enterprises = Enterprise::orderBy('name')->get();
        $permissions = Permission::orderBy('name')->get();

        // Carrega enterprise (se houver) do role para seleção no form
        return view('permissions.edit', compact('role', 'enterprises', 'permissions'));
    }

    public function update(Request $request, Role $role)
    {
        $data = $request->validate([
            'name'        => 'required|string|max:64|unique:roles,name,' . $role->id,
            'team_id'     => 'nullable|integer|exists:enterprises,id',
            'permissions' => 'array',
            'permissions.*' => 'string|exists:permissions,name',
        ]);

        $role->update([
            'name'       => $data['name'],
            'team_id'    => $data['team_id'] ?? null,
        ]);

        $role->syncPermissions($data['permissions'] ?? []);

        return redirect()->route('permissions.index')
            ->with('success', 'Papel atualizado com sucesso!');
    }

    public function destroy(Role $role)
    {
        $role->delete();
        return redirect()->route('permissions.index')
            ->with('success', 'Papel removido com sucesso!');
    }
}
