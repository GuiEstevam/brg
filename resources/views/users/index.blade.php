@extends('layouts.app')
@section('title', 'Usuários')

@section('content')
  <nav aria-label="breadcrumb" class="mb-3">
    <ol class="breadcrumb bg-transparent p-0">
      <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
      <li class="breadcrumb-item active" aria-current="page">Usuários</li>
    </ol>
  </nav>

  <h1 class="mb-4 fw-bold enterprise-title">Usuários</h1>

  <!-- Dashboard Cards -->
  <div class="row mb-4">
    <div class="col-md-4">
      <div class="dashboard-metric-card d-flex align-items-center">
        <span class="dashboard-icon me-3">
          <ion-icon name="people-outline"></ion-icon>
        </span>
        <div>
          <div class="dashboard-metric">{{ $totalUsers }}</div>
          <div class="dashboard-label">Total de Usuários</div>
        </div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="dashboard-metric-card d-flex align-items-center">
        <span class="dashboard-icon me-3" style="color: #4cd137;">
          <ion-icon name="checkmark-circle-outline"></ion-icon>
        </span>
        <div>
          <div class="dashboard-metric">{{ $totalActiveUsers }}</div>
          <div class="dashboard-label">Usuários Ativos</div>
        </div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="dashboard-metric-card d-flex align-items-center">
        <span class="dashboard-icon me-3" style="color: #8e2636;">
          <ion-icon name="close-circle-outline"></ion-icon>
        </span>
        <div>
          <div class="dashboard-metric">{{ $totalInactiveUsers }}</div>
          <div class="dashboard-label">Usuários Inativos</div>
        </div>
      </div>
    </div>
  </div>

  <!-- Filtros e Busca -->
  <div class="mb-3">
    <form method="GET" action="{{ route('users.index') }}" class="row g-2 align-items-center">
      <div class="col-md-4">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Buscar por nome ou e-mail"
          class="form-control" aria-label="Buscar por nome ou e-mail">
      </div>
      <div class="col-md-3">
        <select name="role" class="form-select">
          <option value="">-- Perfil --</option>
          @foreach (\Spatie\Permission\Models\Role::orderBy('name')->get() as $role)
            <option value="{{ $role->name }}" @selected(request('role') == $role->name)>
              {{ ucfirst($role->name) }}
            </option>
          @endforeach
        </select>
      </div>
      <div class="col-md-5 text-end">
        <button type="submit" class="btn btn-primary">Filtrar</button>
        <a href="{{ route('users.index') }}" class="btn btn-outline-secondary ms-2">Limpar</a>
        <a href="{{ route('users.create') }}" class="btn btn-success ms-2">Novo Usuário</a>
      </div>
    </form>
  </div>

  <div class="table-responsive">
    <table class="table align-middle table-hover mb-0">
      <thead class="table-light">
        <tr>
          <th>#</th>
          <th>Nome</th>
          <th>E-mail</th>
          <th>Empresas</th>
          <th>Perfil</th>
          <th>Status</th>
          <th class="text-center">Ações</th>
        </tr>
      </thead>
      <tbody>
        @forelse($users as $user)
          <tr class="table-row-clickable" onclick="window.location='{{ route('users.show', $user) }}';">
            <td class="text-center text-muted">{{ $user->id }}</td>
            <td class="fw-semibold">
              <a href="{{ route('users.show', $user) }}" class="enterprise-link">{{ $user->name }}</a>
            </td>
            <td>{{ $user->email }}</td>
            <td>
              @foreach ($user->enterprises as $enterprise)
                <span class="badge bg-secondary me-1">{{ $enterprise->name }}</span>
              @endforeach
              @if ($user->enterprises->isEmpty())
                <span class="text-muted small">Nenhuma</span>
              @endif
            </td>
            <td>
              @foreach ($user->getRoleNames() as $roleName)
                <span class="badge badge-permission">{{ ucfirst($roleName) }}</span>
              @endforeach
            </td>
            <td>
              <span class="badge {{ status_badge_class($user->status) }}">
                {{ translate_status($user->status) }}
              </span>
            </td>
            <td class="text-center">
              <a href="{{ route('users.edit', $user) }}" class="btn btn-edit btn-action-square me-1" title="Editar"
                onclick="event.stopPropagation();">
                <ion-icon name="create-outline"></ion-icon>
              </a>
              <button class="btn btn-danger btn-action-square" data-bs-toggle="modal"
                data-bs-target="#deleteModal{{ $user->id }}" title="Excluir" onclick="event.stopPropagation();">
                <ion-icon name="trash-outline"></ion-icon>
              </button>
              @include('users._delete_modal', ['user' => $user])
            </td>
          </tr>
        @empty
          <tr>
            <td colspan="7" class="text-center">
              <ion-icon name="alert-circle-outline" class="me-1"></ion-icon>
              Nenhum usuário encontrado.
              <br>
              <a href="{{ route('users.create') }}" class="btn btn-outline-success btn-sm mt-2">
                <ion-icon name="add-outline"></ion-icon> Cadastrar novo usuário
              </a>
            </td>
          </tr>
        @endforelse
      </tbody>
    </table>
  </div>

  {{ $users->withQueryString()->links('pagination::bootstrap-5') }}
@endsection

@push('scripts')
  <script>
    document.querySelectorAll('.table-row-clickable').forEach(row => {
      row.addEventListener('mouseover', () => row.classList.add('table-row-hover'));
      row.addEventListener('mouseout', () => row.classList.remove('table-row-hover'));
    });
    document.addEventListener('DOMContentLoaded', function() {
      var popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'));
      popoverTriggerList.map(function(popoverTriggerEl) {
        new bootstrap.Popover(popoverTriggerEl, {
          trigger: 'focus',
          placement: 'bottom'
        });
      });
    });
  </script>
@endpush
