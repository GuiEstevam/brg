@extends('layouts.app')
@section('title', 'Papéis')

@section('content')
  <nav aria-label="breadcrumb" class="mb-3">
    <ol class="breadcrumb bg-transparent p-0">
      <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
      <li class="breadcrumb-item active" aria-current="page">Papéis</li>
    </ol>
  </nav>

  <h1 class="mb-4 fw-bold enterprise-title">Papéis</h1>

  <!-- Dashboard Cards -->
  <div class="row mb-4">
    <div class="col-md-4">
      <div class="dashboard-metric-card d-flex align-items-center">
        <span class="dashboard-icon me-3">
          <ion-icon name="person-badge-outline"></ion-icon>
        </span>
        <div>
          <div class="dashboard-metric">{{ $roles->total() }}</div>
          <div class="dashboard-label">Total de Papéis</div>
        </div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="dashboard-metric-card d-flex align-items-center">
        <span class="dashboard-icon me-3" style="color: #4cd137;">
          <ion-icon name="checkmark-circle-outline"></ion-icon>
        </span>
        <div>
          <div class="dashboard-metric">
            {{ $roles->filter(fn($r) => $r->permissions->count())->count() }}
          </div>
          <div class="dashboard-label">Papéis com Permissões</div>
        </div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="dashboard-metric-card d-flex align-items-center">
        <span class="dashboard-icon me-3" style="color: #8e2636;">
          <ion-icon name="close-circle-outline"></ion-icon>
        </span>
        <div>
          <div class="dashboard-metric">
            {{ $roles->filter(fn($r) => $r->permissions->isEmpty())->count() }}
          </div>
          <div class="dashboard-label">Papéis sem Permissões</div>
        </div>
      </div>
    </div>
  </div>

  <!-- Filtros e Busca -->
  <div class="mb-3">
    <form method="GET" action="{{ route('roles.index') }}" class="row g-2 align-items-center">
      <div class="col-md-4">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Buscar por nome do papel"
          class="form-control" aria-label="Buscar por nome do papel">
      </div>
      <div class="col-md-3">
        <select name="has_permissions" class="form-select" aria-label="Filtrar por permissões">
          <option value="">-- Permissões --</option>
          <option value="yes" @selected(request('has_permissions') == 'yes')>Com Permissões</option>
          <option value="no" @selected(request('has_permissions') == 'no')>Sem Permissões</option>
        </select>
      </div>
      <div class="col-md-5 text-end">
        <button type="submit" class="btn btn-primary">Filtrar</button>
        <a href="{{ route('roles.index') }}" class="btn btn-outline-secondary ms-2">Limpar</a>
        <a href="{{ route('roles.create') }}" class="btn btn-success ms-2">Novo Papel</a>
      </div>
    </form>
  </div>

  <!-- Tabela de Papéis -->
  <div class="table-responsive">
    <table class="table align-middle table-hover mb-0">
      <thead>
        <tr>
          <th style="width:40px;">#</th>
          <th>Papel</th>
          <th style="min-width:120px;">Permissões</th>
          <th class="text-center" style="width:110px;">Ações</th>
        </tr>
      </thead>
      <tbody>
        @forelse($roles as $role)
          <tr class="table-row-clickable" onclick="window.location='{{ route('roles.show', $role) }}';"
            style="cursor:pointer;">
            <td class="text-center text-muted">{{ $role->id }}</td>
            <td><span class="fw-semibold">{{ ucfirst($role->name) }}</span></td>
            <td>
              @php
                $max = 3;
                $permissions = $role->permissions;
                $total = $permissions->count();
                $permsToShow = $permissions->slice(0, $max);
                $permsRest = $permissions->slice($max);
              @endphp
              @if ($total)
                <div class="d-flex flex-wrap gap-1 align-items-center">
                  @foreach ($permsToShow as $perm)
                    <span class="badge badge-permission small">
                      {{ format_permission($perm->name) }}
                    </span>
                  @endforeach
                  @if ($permsRest->count())
                    <span class="badge badge-permission bg-light border text-body small" style="cursor:pointer;"
                      tabindex="0" data-bs-toggle="popover" data-bs-trigger="focus" title="Permissões adicionais"
                      data-bs-content="{{ $permsRest->map(fn($p) => format_permission($p->name))->implode(', ') }}">+{{ $permsRest->count() }}</span>
                  @endif
                </div>
              @else
                <span class="text-muted small">Sem permissões</span>
              @endif
            </td>
            <td class="text-center">
              <a href="{{ route('roles.edit', $role) }}" class="btn btn-edit btn-action-square me-1" title="Editar"
                onclick="event.stopPropagation();">
                <ion-icon name="create-outline"></ion-icon>
              </a>
              <button class="btn btn-danger btn-action-square" data-bs-toggle="modal"
                data-bs-target="#deleteModal{{ $role->id }}" title="Excluir" onclick="event.stopPropagation();">
                <ion-icon name="trash-outline"></ion-icon>
              </button>
              @include('roles._delete_modal', ['role' => $role])
            </td>
          </tr>
        @empty
          <tr>
            <td colspan="4" class="text-center">
              <ion-icon name="alert-circle-outline" class="me-1"></ion-icon>
              Nenhum papel encontrado.
              <br>
              <a href="{{ route('roles.create') }}" class="btn btn-outline-success btn-sm mt-2">
                <ion-icon name="add-outline"></ion-icon> Cadastrar novo papel
              </a>
            </td>
          </tr>
        @endforelse
      </tbody>
    </table>
  </div>

  {{ $roles->withQueryString()->links('pagination::bootstrap-5') }}
@endsection

@push('scripts')
  <script>
    // Realce de hover para linhas clicáveis
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
