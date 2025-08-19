@extends('layouts.app')
@section('title', 'Regras de Preço')

@push('styles')
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
@endpush

@section('content')
  <nav aria-label="breadcrumb" class="mb-3">
    <ol class="breadcrumb bg-transparent p-0">
      <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
      <li class="breadcrumb-item active" aria-current="page">Regras de Preço</li>
    </ol>
  </nav>

  <h1 class="mb-4 fw-bold enterprise-title">Regras de Preço</h1>

  <!-- Dashboard Cards -->
  <div class="row mb-4">
    <div class="col-md-4">
      <div class="dashboard-card pastel-box" style="background: var(--bs-body-bg); color: var(--bs-body-color);">
        <span class="dashboard-icon pastel-icon">
          <ion-icon name="pricetag-outline"></ion-icon>
        </span>
        <div>
          <div class="dashboard-metric">{{ $solicitationPricings->total() }}</div>
          <div class="dashboard-label">Total de Regras</div>
        </div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="dashboard-card pastel-box" style="background: var(--bs-body-bg); color: var(--bs-body-color);">
        <span class="dashboard-icon pastel-icon-green">
          <ion-icon name="business-outline"></ion-icon>
        </span>
        <div>
          <div class="dashboard-metric">
            {{ $enterprisesCount ?? '-' }}
          </div>
          <div class="dashboard-label">Empresas com Regras</div>
        </div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="dashboard-card pastel-box" style="background: var(--bs-body-bg); color: var(--bs-body-color);">
        <span class="dashboard-icon pastel-icon-red">
          <ion-icon name="calendar-outline"></ion-icon>
        </span>
        <div>
          <div class="dashboard-metric">
            {{ $activeRulesCount ?? '-' }}
          </div>
          <div class="dashboard-label">Regras Vigentes</div>
        </div>
      </div>
    </div>
  </div>

  <!-- Filtros e Busca -->
  <div class="mb-3">
    <form method="GET" action="{{ route('solicitation-pricings.index') }}" class="row g-2 align-items-center">
      <div class="col-md-4">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Buscar por descrição ou empresa"
          class="form-control" aria-label="Buscar por descrição ou empresa">
      </div>
      <div class="col-md-3">
        <select name="enterprise_id" class="form-select" aria-label="Filtrar por empresa">
          <option value="">-- Empresa --</option>
          @foreach ($enterprises as $enterprise)
            <option value="{{ $enterprise->id }}" @selected(request('enterprise_id') == $enterprise->id)>
              {{ $enterprise->name }}
            </option>
          @endforeach
        </select>
      </div>
      <div class="col-md-5 text-end">
        <button type="submit" class="btn btn-primary">Filtrar</button>
        @if ($canCreateSolicitationPricing)
          <a href="{{ route('solicitation-pricings.create') }}" class="btn btn-success ms-2">Nova Regra</a>
        @endif
      </div>
    </form>
  </div>

  <!-- Tabela de Regras de Preço -->
  <div class="table-responsive">
    <table class="table align-middle pastel-table">
      <thead>
        <tr>
          <th>#</th>
          <th>Empresa</th>
          <th>Descrição</th>
          <th>Vigência</th>
          <th class="text-center">Ações</th>
        </tr>
      </thead>
      <tbody>
        @forelse($solicitationPricings as $pricing)
          <tr>
            <td>{{ $pricing->id }}</td>
            <td>
              <a href="{{ route('solicitation-pricings.show', $pricing) }}" class="fw-semibold enterprise-link">
                {{ $pricing->enterprise->name }}
              </a>
            </td>
            <td>{{ $pricing->description }}</td>
            <td>
              {{ \Carbon\Carbon::parse($pricing->start_date)->format('d/m/Y') }}
              @if ($pricing->end_date)
                - {{ \Carbon\Carbon::parse($pricing->end_date)->format('d/m/Y') }}
              @else
                - Atual
              @endif
            </td>
            <td class="text-center">
              @can('update', $pricing)
                <a href="{{ route('solicitation-pricings.edit', $pricing) }}" class="btn btn-edit me-1" title="Editar">
                  <ion-icon name="create-outline"></ion-icon>
                </a>
              @endcan
              @can('delete', $pricing)
                <button class="btn btn-danger btn-sm" data-bs-toggle="modal"
                  data-bs-target="#deleteModal{{ $pricing->id }}" title="Excluir">
                  <ion-icon name="trash-outline"></ion-icon>
                </button>
                @include('solicitation_pricings._delete_modal', ['solicitationPricing' => $pricing])
              @endcan
            </td>
          </tr>
        @empty
          <tr>
            <td colspan="6" class="text-center">Nenhuma regra de preço encontrada.</td>
          </tr>
        @endforelse
      </tbody>
    </table>
  </div>

  {{ $solicitationPricings->withQueryString()->links('pagination::bootstrap-5') }}
@endsection
