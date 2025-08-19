<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Enterprise;
use App\Models\Branch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Role;
use App\Http\Requests\ChangeUserPasswordRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $this->authorize('viewAny', User::class);
        $query = User::with(['enterprises', 'branches', 'roles']);

        // Contexto: superadmin vê tudo; admin vê usuários da empresa/filiais do contexto
        $authUser = Auth::user();
        if ($authUser->hasRole('admin')) {
            $enterpriseId = current_enterprise_id();
            if ($enterpriseId) {
                $query->whereHas('enterprises', function ($q) use ($enterpriseId) {
                    $q->where('enterprises.id', $enterpriseId);
                });
            } else {
                $query->whereHas('enterprises', function ($q) use ($authUser) {
                    $q->whereIn('enterprises.id', $authUser->enterprises->pluck('id'));
                });
            }
        }

        // Filtro de pesquisa por nome ou e-mail
        $search = trim($request->input('search', ''));
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%$search%")
                    ->orWhere('email', 'like', "%$search%");
            });
        }

        // Filtro por papel (role)
        $role = $request->input('role');
        if ($role) {
            $query->whereHas('roles', function ($q) use ($role) {
                $q->where('name', $role);
            });
        }

        $users = $query->orderBy('name')->paginate(20);
        $canCreateUser = Gate::allows('create', User::class);
        $rolesForFilter = Role::orderBy('name')->get();

        // Contadores para cards das métricas
        $totalUsers         = User::count();
        $totalActiveUsers   = User::where('status', 'active')->count();
        $totalInactiveUsers = User::where('status', 'inactive')->count();

        return view('users.index', compact(
            'users',
            'totalUsers',
            'totalActiveUsers',
            'totalInactiveUsers',
            'search',
            'role',
            'canCreateUser',
            'rolesForFilter'
        ));
    }

    public function create()
    {
        $this->authorize('create', User::class);
        $authUser = Auth::user();
        $enterprises = $authUser->hasRole('superadmin')
            ? Enterprise::orderBy('name')->get()
            : Enterprise::whereIn('id', $authUser->enterprises->pluck('id'))->orderBy('name')->get();
        $branches = Branch::with('enterprise')
            ->when(!$authUser->hasRole('superadmin'), function ($q) use ($authUser) {
                $enterpriseIds = current_enterprise_id()
                    ? [current_enterprise_id()]
                    : $authUser->enterprises->pluck('id');
                $q->whereIn('enterprise_id', $enterpriseIds);
            })
            ->orderBy('name')
            ->get();
        $roles = Role::orderBy('name')->get();
        $branchesData = $branches->map(function ($b) {
            return [
                'id' => $b->id,
                'name' => $b->name,
                'enterprise_id' => $b->enterprise_id,
                'enterprise_name' => $b->enterprise->name ?? 'Empresa',
            ];
        })->values();

        return view('users.create', compact('enterprises', 'branches', 'roles', 'branchesData'));
    }

    public function store(Request $request)
    {
        $this->authorize('create', User::class);
        $data = $request->validate([
            'name'        => ['required', 'string', 'max:255'],
            'email'       => ['required', 'email', 'unique:users,email'],
            'password'    => ['required', 'string', 'min:8', 'confirmed'],
            'status'      => ['required', 'in:active,inactive'],
            'enterprises' => ['required', 'array'],
            'branches'    => ['nullable', 'array'],
            'roles'       => ['nullable', 'array'],
        ]);

        $user = User::create([
            'name'     => $data['name'],
            'email'    => $data['email'],
            'password' => Hash::make($data['password']),
            'status'   => $data['status'],
        ]);

        $user->enterprises()->sync($data['enterprises']);
        $user->branches()->sync($data['branches'] ?? []);

        // Atribuição de papéis globais
        $user->syncRoles($data['roles'] ?? []);

        return redirect()->route('users.index')->with('success', 'Usuário criado com sucesso!');
    }

    public function edit(User $user)
    {
        $this->authorize('update', $user);
        $authUser = Auth::user();
        $enterprises = $authUser->hasRole('superadmin')
            ? Enterprise::orderBy('name')->get()
            : Enterprise::whereIn('id', $authUser->enterprises->pluck('id'))->orderBy('name')->get();
        $branches = Branch::with('enterprise')
            ->when(!$authUser->hasRole('superadmin'), function ($q) use ($authUser) {
                $enterpriseIds = current_enterprise_id()
                    ? [current_enterprise_id()]
                    : $authUser->enterprises->pluck('id');
                $q->whereIn('enterprise_id', $enterpriseIds);
            })
            ->orderBy('name')
            ->get();
        $roles = Role::orderBy('name')->get();
        $branchesData = $branches->map(function ($b) {
            return [
                'id' => $b->id,
                'name' => $b->name,
                'enterprise_id' => $b->enterprise_id,
                'enterprise_name' => $b->enterprise->name ?? 'Empresa',
            ];
        })->values();

        $userEnterpriseIds = $user->enterprises->pluck('id')->map(fn($v) => (string) $v)->toArray();
        $userBranchIds     = $user->branches->pluck('id')->map(fn($v) => (string) $v)->toArray();
        $userRoleNames     = $user->roles->pluck('name')->toArray();

        return view('users.edit', compact(
            'user',
            'enterprises',
            'branches',
            'roles',
            'userEnterpriseIds',
            'userBranchIds',
            'userRoleNames',
            'branchesData'
        ));
    }

    public function update(Request $request, User $user)
    {
        $this->authorize('update', $user);
        $data = $request->validate([
            'name'        => ['required', 'string', 'max:255'],
            'email'       => ['required', 'email', 'unique:users,email,' . $user->id],
            'password'    => ['nullable', 'string', 'min:8', 'confirmed'],
            'status'      => ['required', 'in:active,inactive'],
            'enterprises' => ['required', 'array'],
            'branches'    => ['nullable', 'array'],
            'roles'       => ['nullable', 'array'],
        ]);

        $user->update([
            'name'   => $data['name'],
            'email'  => $data['email'],
            'status' => $data['status'],
        ]);

        if (!empty($data['password'])) {
            $user->password = Hash::make($data['password']);
            $user->save();
        }

        $user->enterprises()->sync($data['enterprises']);
        $user->branches()->sync($data['branches'] ?? []);

        // Atualiza os papéis globais
        $user->syncRoles($data['roles'] ?? []);

        return redirect()->route('users.index')->with('success', 'Usuário atualizado com sucesso!');
    }

    public function show(User $user)
    {
        $this->authorize('view', $user);
        // Nenhuma referência a team_id ou pivot custom - relações globais
        $user->load(['enterprises', 'branches', 'roles']);
        return view('users.show', compact('user'));
    }

    public function destroy(User $user)
    {
        $this->authorize('delete', $user);
        $user->delete();
        return redirect()->route('users.index')->with('success', 'Usuário removido com sucesso!');
    }

    public function changePassword(ChangeUserPasswordRequest $request, User $user)
    {
        $validated = $request->validated();
        $user->password = Hash::make($validated['new_password']);
        $user->save();

        return redirect()->route('users.edit', $user)->with('success', 'Senha atualizada com sucesso!');
    }
}
