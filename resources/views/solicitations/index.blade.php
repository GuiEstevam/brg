@extends('layouts.app')
@section('title', 'Solicitações')

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
        <div class="solicitation-card h-100 d-flex flex-column card-clickable"
          onclick="window.location='{{ route('solicitations.show', $solicitation) }}';">
          <div class="card-status-top {{ status_badge_class($solicitation->status) }}">
            {{ translate_status($solicitation->status) }}
          </div>
          <div class="d-flex align-items-center mb-2 mt-2">
            <span class="solicitation-icon">
              <ion-icon name="search-circle-outline"></ion-icon>
            </span>
            <span class="card-title">
              {{ $solicitation->type }}{{ $solicitation->subtype ? ' — ' . $solicitation->subtype : '' }}
            </span>
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
          @hasanyrole('master|admin|operador')
            <div class="card-actions mt-auto d-flex gap-2">
              <a href="{{ route('solicitations.edit', $solicitation) }}" class="btn btn-edit btn-sm"
                onclick="event.stopPropagation();">
                <ion-icon name="create-outline"></ion-icon> Editar
              </a>
              <button class="btn btn-danger btn-sm" data-bs-toggle="modal"
                data-bs-target="#deleteModal{{ $solicitation->id }}" onclick="event.stopPropagation();">
                <ion-icon name="trash-outline"></ion-icon> Excluir
              </button>
              @include('solicitations._delete_modal', ['solicitation' => $solicitation])
            </div>
          @endhasanyrole
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
