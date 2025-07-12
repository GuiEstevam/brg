@extends('layouts.app')
@section('title', 'Veículos')

@push('styles')
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
@endpush

@section('content')
  <nav aria-label="breadcrumb" class="mb-3">
    <ol class="breadcrumb bg-transparent p-0">
      <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
      <li class="breadcrumb-item active" aria-current="page">Veículos</li>
    </ol>
  </nav>

  <h1 class="mb-4 fw-bold enterprise-title">Veículos</h1>

  <!-- Dashboard Cards -->
  <div class="row mb-4">
    <div class="col-md-4">
      <div class="dashboard-card pastel-box">
        <span class="dashboard-icon pastel-icon">
          <ion-icon name="car-outline"></ion-icon>
        </span>
        <div>
          <div class="dashboard-metric">{{ $vehicles->total() }}</div>
          <div class="dashboard-label">Total de Veículos</div>
        </div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="dashboard-card pastel-box">
        <span class="dashboard-icon pastel-icon-green">
          <ion-icon name="checkmark-circle-outline"></ion-icon>
        </span>
        <div>
          <div class="dashboard-metric">
            {{ $vehicles->where('status', 'active')->count() }}
          </div>
          <div class="dashboard-label">Ativos</div>
        </div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="dashboard-card pastel-box">
        <span class="dashboard-icon pastel-icon-red">
          <ion-icon name="close-circle-outline"></ion-icon>
        </span>
        <div>
          <div class="dashboard-metric">
            {{ $vehicles->where('status', 'inactive')->count() }}
          </div>
          <div class="dashboard-label">Inativos</div>
        </div>
      </div>
    </div>
  </div>

  <!-- Filtros e Busca -->
  <div class="mb-3">
    <form method="GET" action="{{ route('vehicles.index') }}" class="row g-2 align-items-center">
      <div class="col-md-4">
        <input type="text" name="search" value="{{ request('search') }}"
          placeholder="Buscar por placa, modelo, proprietário ou locatário" class="form-control"
          aria-label="Buscar por placa, modelo, proprietário ou locatário">
      </div>
      <div class="col-md-3">
        <select name="status" class="form-select" aria-label="Filtrar por status">
          <option value="">-- Status --</option>
          <option value="active" @selected(request('status') == 'active')>Ativo</option>
          <option value="inactive" @selected(request('status') == 'inactive')>Inativo</option>
        </select>
      </div>
      <div class="col-md-5 text-end">
        <button type="submit" class="btn btn-primary">Filtrar</button>
        <a href="{{ route('vehicles.create') }}" class="btn btn-success ms-2">Novo Veículo</a>
      </div>
    </form>
  </div>

  <!-- Tabela de Veículos -->
  <div class="table-responsive">
    <table class="table align-middle pastel-table">
      <thead>
        <tr>
          <th>#</th>
          <th>Placa</th>
          <th>Modelo</th>
          <th>Marca</th>
          <th>Cor</th>
          <th>Ano Fab./Mod.</th>
          <th>Proprietário</th>
          <th>Locatário</th>
          <th>Status</th>
          <th class="text-center">Ações</th>
        </tr>
      </thead>
      <tbody>
        @forelse($vehicles as $vehicle)
          <tr>
            <td>{{ $vehicle->id }}</td>
            <td>
              <a href="{{ route('vehicles.show', $vehicle) }}" class="fw-semibold enterprise-link">
                {{ $vehicle->plate }}
              </a>
            </td>
            <td>{{ $vehicle->model }}</td>
            <td>{{ $vehicle->brand }}</td>
            <td>{{ $vehicle->color }}</td>
            <td>{{ $vehicle->manufacture_year }}/{{ $vehicle->model_year }}</td>
            <td>{{ $vehicle->owner_name ?? '-' }}</td>
            <td>{{ $vehicle->lessee_name ?? '-' }}</td>
            <td>
              <span class="badge {{ status_badge_class($vehicle->status) }}">
                {{ translate_status($vehicle->status) }}
              </span>
            </td>
            <td class="text-center">
              <a href="{{ route('vehicles.edit', $vehicle) }}" class="btn btn-edit me-1" title="Editar">
                <ion-icon name="create-outline"></ion-icon>
              </a>
              <button class="btn btn-danger btn-sm" data-bs-toggle="modal"
                data-bs-target="#deleteModal{{ $vehicle->id }}" title="Excluir">
                <ion-icon name="trash-outline"></ion-icon>
              </button>
              @include('vehicles._delete_modal', ['vehicle' => $vehicle])
            </td>
          </tr>
        @empty
          <tr>
            <td colspan="10" class="text-center">Nenhum veículo encontrado.</td>
          </tr>
        @endforelse
      </tbody>
    </table>
  </div>
  {{ $vehicles->withQueryString()->links('pagination::bootstrap-5') }}
@endsection
