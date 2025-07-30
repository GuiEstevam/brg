@extends('layouts.app')
@section('title', 'Detalhes do Papel')

@section('content')
  <nav aria-label="breadcrumb" class="mb-3">
    <ol class="breadcrumb bg-transparent p-0">
      <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
      <li class="breadcrumb-item"><a href="{{ route('roles.index') }}">Papéis</a></li>
      <li class="breadcrumb-item active" aria-current="page">{{ $role->name }}</li>
    </ol>
  </nav>
  <div class="enterprise-form-card p-4 p-md-5 shadow-sm rounded-4 w-100 mx-auto" style="max-width: 1100px;">
    <div class="mb-2">
      <h1 class="mb-0">{{ ucfirst($role->name) }}</h1>
      <span class="badge badge-secondary">Global</span>
    </div>
    <div class="mb-3">
      <small class="text-muted">
        Criado: {{ $role->created_at->format('d/m/Y H:i') }}
        @if ($role->updated_at != $role->created_at)
          &nbsp;|&nbsp; Alterado: {{ $role->updated_at->format('d/m/Y H:i') }}
        @endif
      </small>
    </div>

    {{-- Abas --}}
    <ul class="nav nav-tabs mb-4" role="tablist">
      <li class="nav-item" role="presentation">
        <button class="nav-link active" id="permissions-tab" data-bs-toggle="tab" data-bs-target="#permissions"
          type="button" role="tab">
          <ion-icon name="key-outline"></ion-icon> Permissões
        </button>
      </li>
      <li class="nav-item" role="presentation">
        <button class="nav-link" id="users-tab" data-bs-toggle="tab" data-bs-target="#users" type="button"
          role="tab">
          <ion-icon name="people-outline"></ion-icon> Usuários
        </button>
      </li>
    </ul>
    <div class="tab-content">

      <!-- Aba Permissões -->
      <div class="tab-pane fade show active" id="permissions" role="tabpanel">
        @php
          $grouped = group_permissions_by_entity($role->permissions);
          $groupFilter = request('perm_group', '');
        @endphp

        <div class="d-flex flex-wrap justify-content-between align-items-center mb-3">
          <form method="GET" class="d-flex gap-2 align-items-center w-100 flex-wrap">
            <input type="hidden" name="tab" value="permissions">
            <label for="perm_group" class="me-1 mb-0">Filtrar por módulo:</label>
            <select name="perm_group" id="perm_group" class="form-select form-select-sm"
              style="width: 200px; min-width:120px;" onchange="this.form.submit()">
              <option value="">Todos</option>
              @foreach ($grouped as $group => $perms)
                <option value="{{ $group }}" @selected($group === $groupFilter)>
                  {{ entity_label($group) }}
                </option>
              @endforeach
            </select>
          </form>
        </div>
        <div class="row g-4">
          @forelse($grouped as $group => $perms)
            @if (!$groupFilter || $group == $groupFilter)
              <div class="col-12 col-md-6 col-lg-4">
                <div class="border rounded-2 py-3 px-3 h-100 bg-light">
                  <div class="fw-bold mb-2 d-flex align-items-center">
                    <ion-icon name="{{ entity_icon($group) }}" class="me-2" style="color: #8e2636;"></ion-icon>
                    {{ entity_label($group) }}
                  </div>
                  <ul class="list-unstyled small mb-0 ps-2">
                    @foreach ($perms as $perm)
                      <li class="mb-1 d-flex align-items-center">
                        <ion-icon name="checkmark-circle-outline" class="me-1 text-success"
                          style="font-size:1.05em;"></ion-icon>
                        <span>{{ format_permission($perm->name) }}</span>
                      </li>
                    @endforeach
                  </ul>
                </div>
              </div>
            @endif
          @empty
            <div class="col-12 text-muted">Nenhuma permissão atribuída.</div>
          @endforelse
        </div>
      </div>

      <!-- Aba Usuários -->
      <div class="tab-pane fade" id="users" role="tabpanel">
        <div class="d-flex justify-content-between align-items-center mb-3">
          <h5 class="fw-semibold mb-0"><ion-icon name="people-outline"></ion-icon> Usuários com este papel</h5>
          <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#attachUserModal"
            title="Associar usuário">
            <ion-icon name="person-add-outline"></ion-icon>
          </button>
        </div>
        @if ($usersWithRole->count())
          <div class="table-responsive rounded-3">
            <table class="table align-middle pastel-table">
              <thead>
                <tr>
                  <th>Nome</th>
                  <th>Email</th>
                  <th>Empresas</th>
                  <th>Status</th>
                  <th class="text-end">Ações</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($usersWithRole as $user)
                  <tr>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>
                      @foreach ($user->enterprises as $ent)
                        <span class="badge bg-secondary me-1">{{ $ent->name }}</span>
                      @endforeach
                      @if ($user->enterprises->isEmpty())
                        <span class="text-muted small">Nenhuma</span>
                      @endif
                    </td>
                    <td>
                      <span class="badge {{ status_badge_class($user->status) }}">
                        {{ translate_status($user->status) }}
                      </span>
                    </td>
                    <td class="text-end">
                      <a href="{{ route('users.edit', $user) }}" class="btn btn-edit btn-action-square me-1"
                        title="Editar" onclick="event.stopPropagation();">
                        <ion-icon name="create-outline"></ion-icon>
                      </a>
                      @role('superadmin|admin')
                        <form method="POST" action="{{ route('roles.detach-user', [$role, $user]) }}" class="d-inline">
                          @csrf
                          @method('DELETE')
                          <button type="submit" class="btn btn-danger btn-action-square" title="Remover"
                            onclick="return confirm('Remover este papel do usuário?');">
                            <ion-icon name="person-remove-outline"></ion-icon>
                          </button>
                        </form>
                      @endrole
                    </td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        @else
          <p class="text-muted">Nenhum usuário possui este papel.</p>
        @endif

        <!-- Modal para associar usuário ao papel -->
        <div class="modal fade" id="attachUserModal" tabindex="-1" aria-labelledby="attachUserModalLabel"
          aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered">
            <form method="POST" action="{{ route('roles.attach-user.submit', $role) }}">
              @csrf
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="attachUserModalLabel">
                    <ion-icon name="person-add-outline"></ion-icon>
                    Adicionar Usuário ao Papel "{{ ucfirst($role->name) }}"
                  </h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
                </div>
                <div class="modal-body">
                  @php
                    $potentialUsers = \App\Models\User::whereDoesntHave('roles', function ($q) use ($role) {
                        $q->where('id', $role->id);
                    })->get();
                  @endphp
                  @if ($potentialUsers->count())
                    <div class="form-group">
                      <label for="user_id" class="form-label">Selecione um usuário</label>
                      <select class="form-select" name="user_id" id="user_id" required>
                        @foreach ($potentialUsers as $u)
                          <option value="{{ $u->id }}">{{ $u->name }} ({{ $u->email }})</option>
                        @endforeach
                      </select>
                    </div>
                  @else
                    <span class="text-muted">Todos os usuários já possuem este papel!</span>
                  @endif
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancelar</button>
                  @if ($potentialUsers->count())
                    <button type="submit" class="btn btn-primary">
                      <ion-icon name="person-add-outline"></ion-icon>
                    </button>
                  @endif
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>

    <div class="d-flex gap-2 justify-content-end mt-4">
      <a href="{{ route('roles.edit', $role) }}" class="btn btn-primary px-4" title="Editar">
        <ion-icon name="create-outline"></ion-icon>
      </a>
      <form method="POST" action="{{ route('roles.destroy', $role) }}" class="d-inline">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-danger px-4" title="Excluir"
          onclick="return confirm('Deseja realmente excluir este papel?')">
          <ion-icon name="trash-outline"></ion-icon>
        </button>
      </form>
    </div>
    <a href="{{ route('roles.index') }}" class="btn btn-secondary btn-lg d-md-none w-100 mt-4">
      <ion-icon name="arrow-back-outline"></ion-icon>
    </a>
  </div>
@endsection
