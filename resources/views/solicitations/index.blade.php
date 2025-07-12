@extends('layouts.app')
@section('title', 'Solicitações')

@push('styles')
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
  <style>
    .solicitation-card {
      border-radius: 18px;
      background: linear-gradient(135deg, #f8fafc 80%, #eafaf1 100%);
      box-shadow: 0 2px 8px 0 #b0b4c466, 0 8px 24px 0 #b0b4c422;
      padding: 2rem 1.5rem 1.5rem 1.5rem;
      margin-bottom: 2rem;
      transition: box-shadow 0.3s, background 0.3s;
    }

    .solicitation-card .icon {
      font-size: 2.2rem;
      color: #8ee4af;
      margin-right: 1rem;
    }

    .solicitation-card .card-title {
      font-size: 1.3rem;
      font-weight: 600;
    }

    .solicitation-card .card-meta {
      font-size: 0.98rem;
      color: #5e6472;
    }

    .solicitation-card .badge {
      font-size: 1em;
      margin-left: 0.5rem;
    }

    .solicitation-card .card-actions {
      margin-top: 1.2rem;
    }

    @media (max-width: 767px) {
      .solicitation-card {
        padding: 1.2rem 0.7rem;
      }
    }
  </style>
@endpush

@section('content')
  <nav aria-label="breadcrumb" class="mb-3">
    <ol class="breadcrumb bg-transparent p-0">
      <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
      <li class="breadcrumb-item active" aria-current="page">Solicitações</li>
    </ol>
  </nav>

  <h1 class="mb-4 fw-bold enterprise-title">Solicitações</h1>

  <!-- Filtros e Busca -->
  <div class="mb-3">
    <form method="GET" action="{{ route('solicitations.index') }}" class="row g-2 align-items-center">
      <div class="col-md-4">
        <input type="text" name="search" value="{{ request('search') }}"
          placeholder="Buscar por empresa, motorista, placa, status..." class="form-control"
          aria-label="Buscar por empresa, motorista, placa, status">
      </div>
      <div class="col-md-3">
        <select name="status" class="form-select" aria-label="Filtrar por status">
          <option value="">-- Status --</option>
          <option value="pending" @selected(request('status') == 'pending')>Pendente</option>
          <option value="processing" @selected(request('status') == 'processing')>Processando</option>
          <option value="finished" @selected(request('status') == 'finished')>Finalizada</option>
          <option value="error" @selected(request('status') == 'error')>Erro</option>
        </select>
      </div>
      <div class="col-md-5 text-end">
        <button type="submit" class="btn btn-primary">Filtrar</button>
        <a href="{{ route('solicitations.create') }}" class="btn btn-success ms-2">Nova Solicitação</a>
      </div>
    </form>
  </div>

  <!-- Cards de Solicitações -->
  <div class="row mt-4">
    @forelse($solicitations as $solicitation)
      <div class="col-md-6 col-lg-4 mb-4">
        <div class="solicitation-card h-100 d-flex flex-column">
          <div class="d-flex align-items-center mb-2">
            <span class="icon">
              <ion-icon name="search-circle-outline"></ion-icon>
            </span>
            <div>
              <span class="card-title">
                {{ $solicitation->type }} {{ $solicitation->subtype ? '— ' . $solicitation->subtype : '' }}
              </span>
              <span class="badge {{ status_badge_class($solicitation->status) }}">
                {{ translate_status($solicitation->status) }}
              </span>
            </div>
          </div>
          <div class="card-meta mb-2">
            <strong>Empresa:</strong> {{ $solicitation->enterprise->name ?? '-' }}<br>
            <strong>Filial:</strong> {{ $solicitation->branch->name ?? '-' }}<br>
            <strong>Motorista:</strong> {{ $solicitation->driver->name ?? '-' }}<br>
            <strong>Veículo:</strong> {{ $solicitation->vehicle->plate ?? '-' }}
          </div>
          <div class="card-meta mb-2">
            <strong>Valor:</strong> R$ {{ number_format($solicitation->value, 2, ',', '.') }}<br>
            <strong>Data:</strong> {{ $solicitation->created_at ? $solicitation->created_at->format('d/m/Y H:i') : '-' }}
          </div>
          @php
            $research = $solicitation->researches->first() ?? null;
          @endphp
          @if ($research)
            <div class="card-meta mb-2">
              <strong>Resultado:</strong>
              <span class="badge {{ status_badge_class($research->status_api) }}">
                {{ translate_status($research->status_api) }}
              </span>
              @if ($research->total_points !== null)
                <span class="ms-2"><strong>Pontuação:</strong> {{ $research->total_points }}</span>
              @endif
              @if ($research->validity_date)
                <span class="ms-2"><strong>Válido até:</strong>
                  {{ \Carbon\Carbon::parse($research->validity_date)->format('d/m/Y') }}</span>
              @endif
            </div>
          @else
            <div class="card-meta mb-2">
              <span class="badge badge-secondary">Aguardando pesquisa...</span>
            </div>
          @endif
          <div class="card-actions mt-auto d-flex gap-2">
            <a href="{{ route('solicitations.show', $solicitation) }}" class="btn btn-info btn-sm">
              <ion-icon name="eye-outline"></ion-icon> Detalhes
            </a>
            <a href="{{ route('solicitations.edit', $solicitation) }}" class="btn btn-edit btn-sm">
              <ion-icon name="create-outline"></ion-icon> Editar
            </a>
            <button class="btn btn-danger btn-sm" data-bs-toggle="modal"
              data-bs-target="#deleteModal{{ $solicitation->id }}">
              <ion-icon name="trash-outline"></ion-icon> Excluir
            </button>
            @include('solicitations._delete_modal', ['solicitation' => $solicitation])
          </div>
        </div>
      </div>
    @empty
      <div class="col-12">
        <div class="alert alert-info text-center">Nenhuma solicitação encontrada.</div>
      </div>
    @endforelse
  </div>

  {{ $solicitations->withQueryString()->links('pagination::bootstrap-5') }}
@endsection
