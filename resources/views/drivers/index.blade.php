@extends('layouts.app')
@section('title', 'Motoristas')

@push('styles')
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
  <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
  <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
@endpush

@section('content')
  <nav aria-label="breadcrumb" class="mb-3">
    <ol class="breadcrumb bg-transparent p-0">
      <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
      <li class="breadcrumb-item active" aria-current="page">Motoristas</li>
    </ol>
  </nav>

  <h1 class="mb-4 fw-bold enterprise-title">Motoristas</h1>

  <!-- Dashboard Cards -->
  <div class="row mb-4">
    <div class="col-md-4">
      <div class="dashboard-metric-card">
        <span class="dashboard-icon">
          <ion-icon name="person-outline"></ion-icon>
        </span>
        <div>
          <div class="dashboard-metric">{{ $drivers->total() }}</div>
          <div class="dashboard-label">Total de Motoristas</div>
        </div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="dashboard-metric-card">
        <span class="dashboard-icon" style="color: #4cd137;">
          <ion-icon name="checkmark-circle-outline"></ion-icon>
        </span>
        <div>
          <div class="dashboard-metric">{{ $drivers->where('status', 'active')->count() }}</div>
          <div class="dashboard-label">Ativos</div>
        </div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="dashboard-metric-card">
        <span class="dashboard-icon" style="color: #8e2636;">
          <ion-icon name="close-circle-outline"></ion-icon>
        </span>
        <div>
          <div class="dashboard-metric">{{ $drivers->where('status', 'inactive')->count() }}</div>
          <div class="dashboard-label">Inativos</div>
        </div>
      </div>
    </div>
  </div>

  <!-- Filtros e Busca -->
  <div class="mb-3">
    <form method="GET" action="{{ route('drivers.index') }}" class="row g-2 align-items-center">
      <div class="col-md-4">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Buscar por nome, CPF ou e-mail"
          class="form-control" aria-label="Buscar por nome, CPF ou e-mail">
      </div>
      <div class="col-md-3">
        <select name="status" class="form-select" aria-label="Filtrar por status">
          <option value="">-- Status --</option>
          <option value="active" @selected(request('status') == 'active')>Ativo</option>
          <option value="inactive" @selected(request('status') == 'inactive')>Inativo</option>
        </select>
      </div>
      @if (user_is_admin())
        <div class="col-md-3">
          <select name="enterprise_id" class="form-select" aria-label="Filtrar por empresa">
            <option value="">-- Empresa --</option>
            @foreach (Auth::user()->enterprises as $enterprise)
              <option value="{{ $enterprise->id }}" @selected(request('enterprise_id') == $enterprise->id)>{{ $enterprise->name }}</option>
            @endforeach
          </select>
        </div>
      @endif
      <div class="col-md-{{ user_is_admin() ? '3' : '5' }} text-end">
        <button type="submit" class="btn btn-primary">Filtrar</button>
        @if ($canCreateDriver)
          <a href="{{ route('drivers.create') }}" class="btn btn-success ms-2">Novo Motorista</a>
        @endif
      </div>
    </form>
  </div>

  <!-- Tabela de Motoristas -->
  <div class="table-responsive">
    <table class="table align-middle">
      <thead>
        <tr>
          <th>#</th>
          <th>Nome</th>
          <th>CPF</th>
          <th>E-mail</th>
          <th>Telefone</th>
          <th>Status</th>
          <th class="text-center">Ações</th>
        </tr>
      </thead>
      <tbody>
        @forelse($drivers as $driver)
          <tr>
            <td>{{ $driver->id }}</td>
            <td>
              <a href="{{ route('drivers.show', $driver) }}" class="fw-semibold enterprise-link">
                {{ $driver->name }}
              </a>
            </td>
            <td>{{ $driver->cpf }}</td>
            <td>{{ $driver->email }}</td>
            <td>{{ $driver->phone }}</td>
            <td>
              <span class="badge {{ status_badge_class($driver->status) }}">
                {{ translate_status($driver->status) }}
              </span>
            </td>
            <td class="text-center">
              @can('update', $driver)
                <a href="{{ route('drivers.edit', $driver) }}" class="btn btn-edit me-1" title="Editar">
                  <ion-icon name="create-outline"></ion-icon>
                </a>
              @endcan
              @can('delete', $driver)
                <button class="btn btn-danger btn-sm" data-bs-toggle="modal"
                  data-bs-target="#deleteModal{{ $driver->id }}" title="Excluir">
                  <ion-icon name="trash-outline"></ion-icon>
                </button>
                @include('drivers._delete_modal', ['driver' => $driver])
              @endcan
            </td>
          </tr>
        @empty
          <tr>
            <td colspan="7" class="text-center">Nenhum motorista encontrado.</td>
          </tr>
        @endforelse
      </tbody>
    </table>
  </div>

  {{ $drivers->withQueryString()->links('pagination::bootstrap-5') }}
@endsection
