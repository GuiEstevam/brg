<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\Enterprise;
use App\Models\User;
use Illuminate\Validation\Rule;

class RoleController extends Controller
{
    public function index(Request $request)
    {
        $enterprises = Enterprise::orderBy('name')->get();

        // Busca apenas roles, sem team_id/contexto empresarial
        $query = Role::query()->with('permissions');

        $search = trim($request->input('search', ''));
        if ($search) {
            $query->where('name', 'like', "%$search%");
        }

        $order = $request->input('order', 'id');
        if ($order === 'name') {
            $query->orderBy('name');
        } else {
            $query->orderBy('id');
        }

        $roles = $query->paginate(15);

        return view('roles.index', compact('roles', 'enterprises', 'search'));
    }

    public function create()
    {
        $permissions = Permission::orderBy('name')->get();
        return view('roles.create', compact('permissions'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'        => [
                'required',
                'string',
                'max:64',
                Rule::unique('roles')->where(
                    fn($q) =>
                    $q->where('guard_name', $request->guard_name ?? 'web')
                ),
            ],
            'guard_name'  => 'sometimes|string|default:web',
            'permissions' => 'nullable|array',
            'permissions.*' => 'string|exists:permissions,name',
        ]);

        $role = Role::create([
            'name'       => $data['name'],
            'guard_name' => $data['guard_name'] ?? 'web',
        ]);
        $role->syncPermissions($data['permissions'] ?? []);

        return redirect()->route('roles.index')->with('success', 'Papel criado com sucesso!');
    }

    public function edit(Role $role)
    {
        $permissions = Permission::orderBy('name')->get();
        $role->load('permissions');
        return view('roles.edit', compact('role', 'permissions'));
    }

    public function update(Request $request, Role $role)
    {
        $data = $request->validate([
            'name' => [
                'required',
                'string',
                'max:64',
                Rule::unique('roles')->ignore($role->id)->where(
                    fn($q) =>
                    $q->where('guard_name', $request->guard_name ?? $role->guard_name ?? 'web')
                ),
            ],
            'permissions' => 'nullable|array',
            'permissions.*' => 'string|exists:permissions,name',
        ]);

        $role->update([
            'name'    => $data['name'],
        ]);

        $role->syncPermissions($data['permissions'] ?? []);

        return redirect()->route('roles.index')->with('success', 'Papel atualizado!');
    }

    public function destroy(Role $role)
    {
        $role->delete();
        return back()->with('success', 'Papel removido!');
    }

    public function show(Role $role)
    {
        $role->load('permissions');
        $usersWithRole = $role->users()->with('enterprises')->get();
        return view('roles.show', compact('role', 'usersWithRole'));
    }

    /**
     * Associa usuário ao papel global.
     */
    public function attachUser(Request $request, Role $role)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
        ]);

        $user = User::findOrFail($request->user_id);

        $user->assignRole($role);

        return redirect()->route('roles.show', $role)->with('success', 'Usuário associado ao papel com sucesso!');
    }

    /**
     * Remove papel de um usuário.
     */
    public function detachUser(Role $role, User $user)
    {
        $user->removeRole($role);

        return back()->with('success', 'Papel removido do usuário com sucesso!');
    }
}
