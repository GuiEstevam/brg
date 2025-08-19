@extends('layouts.app')
@section('title', 'Solicitações')

@section('content')
  <div class="container-fluid">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
      <div>
        <nav aria-label="breadcrumb" class="mb-2">
          <ol class="breadcrumb bg-transparent p-0">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" class="text-decoration-none">
                <i class="fas fa-home me-1"></i>Dashboard
              </a></li>
            <li class="breadcrumb-item active" aria-current="page">
              <i class="fas fa-search me-1"></i>Solicitações
            </li>
          </ol>
        </nav>
        <h1 class="h3 mb-0 fw-bold">Solicitações</h1>
        <p class="text-muted mb-0">Gerencie suas solicitações de pesquisa</p>
      </div>

      @if ($canCreateSolicitation)
        <a href="{{ route('solicitations.create') }}" class="btn btn-primary">
          <i class="fas fa-plus me-2"></i>Nova Solicitação
        </a>
      @endif
    </div>

    <!-- Filtros Avançados -->
    <div class="card filters-card mb-4">
      <div class="card-header filters-header">
        <h5 class="mb-0">
          <i class="fas fa-filter me-2"></i>Filtros
        </h5>
      </div>
      <div class="card-body">
        <form method="GET" action="{{ route('solicitations.index') }}" class="row g-3">
          <div class="col-md-3">
            <label class="form-label">Buscar</label>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="CPF, placa, empresa..."
              class="form-control">
          </div>
          <div class="col-md-2">
            <label class="form-label">Tipo</label>
            <select name="entity_type" class="form-select">
              <option value="">Todos</option>
              <option value="driver" @selected(request('entity_type') == 'driver')>Motorista</option>
              <option value="vehicle" @selected(request('entity_type') == 'vehicle')>Veículo</option>
              <option value="composed" @selected(request('entity_type') == 'composed')>Composta</option>
            </select>
          </div>
          <div class="col-md-2">
            <label class="form-label">Status</label>
            <select name="status" class="form-select">
              <option value="">Todos</option>
              <option value="pending" @selected(request('status') == 'pending')>Pendente</option>
              <option value="processing" @selected(request('status') == 'processing')>Processando</option>
              <option value="finished" @selected(request('status') == 'finished')>Finalizada</option>
              <option value="error" @selected(request('status') == 'error')>Erro</option>
            </select>
          </div>
          <div class="col-md-2">
            <label class="form-label">Pesquisa</label>
            <select name="research_type" class="form-select">
              <option value="">Todas</option>
              <option value="basic" @selected(request('research_type') == 'basic')>Básica</option>
              <option value="complete" @selected(request('research_type') == 'complete')>Completa</option>
              <option value="express" @selected(request('research_type') == 'express')>Expressa</option>
            </select>
          </div>
          <div class="col-md-3 d-flex align-items-end">
            <div class="d-flex gap-2 w-100">
              <button type="submit" class="btn btn-primary flex-fill">
                <i class="fas fa-search me-1"></i>Filtrar
              </button>
              <a href="{{ route('solicitations.index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-times me-1"></i>Limpar
              </a>
            </div>
          </div>
        </form>
      </div>
    </div>

    <!-- Estatísticas Rápidas -->
    <div class="row mb-4">
      <div class="col-md-3">
        <div class="card stats-card stats-card-primary">
          <div class="card-body">
            <div class="d-flex justify-content-between">
              <div>
                <h6 class="card-title">Total</h6>
                <h3 class="mb-0">{{ $solicitations->total() }}</h3>
              </div>
              <div class="align-self-center">
                <i class="fas fa-search fa-2x opacity-75"></i>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-3">
        <div class="card stats-card stats-card-warning">
          <div class="card-body">
            <div class="d-flex justify-content-between">
              <div>
                <h6 class="card-title">Pendentes</h6>
                <h3 class="mb-0">{{ $solicitations->where('status', 'pending')->count() }}</h3>
              </div>
              <div class="align-self-center">
                <i class="fas fa-clock fa-2x opacity-75"></i>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-3">
        <div class="card stats-card stats-card-success">
          <div class="card-body">
            <div class="d-flex justify-content-between">
              <div>
                <h6 class="card-title">Finalizadas</h6>
                <h3 class="mb-0">{{ $solicitations->where('status', 'finished')->count() }}</h3>
              </div>
              <div class="align-self-center">
                <i class="fas fa-check-circle fa-2x opacity-75"></i>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-3">
        <div class="card stats-card stats-card-danger">
          <div class="card-body">
            <div class="d-flex justify-content-between">
              <div>
                <h6 class="card-title">Com Erro</h6>
                <h3 class="mb-0">{{ $solicitations->where('status', 'error')->count() }}</h3>
              </div>
              <div class="align-self-center">
                <i class="fas fa-exclamation-triangle fa-2x opacity-75"></i>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Lista de Solicitações -->
    <div class="card solicitations-list-card">
      <div class="card-header solicitations-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">
          <i class="fas fa-list me-2"></i>Lista de Solicitações
        </h5>
        <div class="d-flex gap-2">
          <button class="btn btn-outline-secondary btn-sm" onclick="toggleView('grid')" title="Vista em Grid">
            <ion-icon name="grid-outline"></ion-icon>
          </button>
          <button class="btn btn-outline-secondary btn-sm" onclick="toggleView('table')" title="Vista em Tabela">
            <ion-icon name="list-outline"></ion-icon>
          </button>
        </div>
      </div>
      <div class="card-body p-0">
        @if ($solicitations->count() > 0)
          <!-- Vista em Grid -->
          <div id="grid-view" class="row g-3 p-3">
            @foreach ($solicitations as $solicitation)
              <div class="col-12 col-md-6 col-lg-4 col-xl-3">
                <div class="card h-100 solicitation-card"
                  onclick="window.location='{{ route('solicitations.show', $solicitation) }}'">
                  <div class="card-header solicitation-card-header d-flex justify-content-between align-items-center">
                    <span class="status-badge status-badge-{{ $solicitation->status }}">
                      {{ get_status_label($solicitation->status) }}
                    </span>
                    <small class="text-muted">{{ $solicitation->created_at->format('d/m/Y H:i') }}</small>
                  </div>
                  <div class="card-body d-flex flex-column">
                    <div class="d-flex align-items-center mb-3">
                      <div class="solicitation-type-icon me-3">
                        @if ($solicitation->entity_type === 'driver')
                          <ion-icon name="person-outline"></ion-icon>
                        @elseif($solicitation->entity_type === 'vehicle')
                          <ion-icon name="car-outline"></ion-icon>
                        @else
                          <ion-icon name="layers-outline"></ion-icon>
                        @endif
                      </div>
                      <div>
                        <h6 class="mb-1">{{ get_entity_type_label($solicitation->entity_type) }}</h6>
                        <small class="text-muted">{{ get_research_type_label($solicitation->research_type) }}</small>
                      </div>
                    </div>

                    <div class="solicitation-details flex-grow-1">
                      @if ($solicitation->entity_type === 'driver')
                        <p class="mb-2"><strong>Motorista:</strong> {{ $solicitation->driver->name ?? 'N/A' }}</p>
                        <p class="mb-2"><strong>CPF:</strong> {{ $solicitation->entity_value }}</p>
                      @elseif($solicitation->entity_type === 'vehicle')
                        <p class="mb-2"><strong>Veículo:</strong> {{ $solicitation->vehicle->plate ?? 'N/A' }}</p>
                        <p class="mb-2"><strong>Placa:</strong> {{ $solicitation->entity_value }}</p>
                      @else
                        <p class="mb-2"><strong>Motorista:</strong> {{ $solicitation->driver->name ?? 'N/A' }}</p>
                        <p class="mb-2"><strong>Veículos:</strong> {{ $solicitation->vehicles->count() }} veículo(s)
                        </p>
                      @endif

                      <p class="mb-2"><strong>Vínculo:</strong>
                        {{ get_vincle_type_label($solicitation->vincle_type) }}</p>
                      <p class="mb-2"><strong>Preço:</strong> R$
                        {{ number_format($solicitation->calculated_price, 2, ',', '.') }}</p>
                    </div>

                    @if ($solicitation->researches->count() > 0)
                      @php $latestResearch = $solicitation->researches->sortByDesc('created_at')->first(); @endphp
                      <div class="mt-3 p-2 bg-light rounded">
                        <small class="text-muted">
                          <strong>Última pesquisa:</strong>
                          {{ get_validation_status_label($latestResearch->validation_status) }}
                          @if ($latestResearch->validity_date)
                            <br><strong>Válido até:</strong>
                            {{ \Carbon\Carbon::parse($latestResearch->validity_date)->format('d/m/Y') }}
                          @endif
                        </small>
                      </div>
                    @endif
                  </div>
                  <div class="card-footer solicitation-card-footer mt-auto">
                    <div class="d-flex justify-content-between align-items-center">
                      <small class="text-muted">{{ $solicitation->enterprise->name ?? 'N/A' }}</small>
                      <div class="btn-group btn-group-sm">
                        @if (auth()->user()->hasRole('superadmin') ||
                                in_array($solicitation->status, ['error', 'rejected', 'pending_correction']))
                          @can('update', $solicitation)
                            <a href="{{ route('solicitations.edit', $solicitation) }}"
                              class="btn btn-outline-secondary btn-sm" title="Editar">
                              <ion-icon name="create-outline"></ion-icon>
                            </a>
                          @endcan
                        @endif
                        @can('delete', $solicitation)
                          <button class="btn btn-outline-danger btn-sm"
                            onclick="event.stopPropagation(); deleteSolicitation({{ $solicitation->id }})"
                            title="Excluir">
                            <ion-icon name="trash-outline"></ion-icon>
                          </button>
                        @endcan
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            @endforeach
          </div>

          <!-- Vista em Tabela -->
          <div id="table-view" class="table-responsive" style="display: none;">
            <table class="table table-hover mb-0">
              <thead class="table-light">
                <tr>
                  <th>ID</th>
                  <th>Tipo</th>
                  <th>Entidade</th>
                  <th>Status</th>
                  <th>Preço</th>
                  <th>Data</th>
                  <th>Empresa</th>
                  <th>Ações</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($solicitations as $solicitation)
                  <tr>
                    <td>#{{ $solicitation->id }}</td>
                    <td>
                      <span class="entity-badge entity-badge-{{ $solicitation->entity_type }}">
                        {{ get_entity_type_label($solicitation->entity_type) }}
                      </span>
                    </td>
                    <td>
                      @if ($solicitation->entity_type === 'driver')
                        {{ $solicitation->driver->name ?? 'N/A' }}
                      @elseif($solicitation->entity_type === 'vehicle')
                        {{ $solicitation->vehicle->plate ?? 'N/A' }}
                      @else
                        {{ $solicitation->driver->name ?? 'N/A' }} + {{ $solicitation->vehicles->count() }} veículo(s)
                      @endif
                    </td>
                    <td>
                      <span class="status-badge status-badge-{{ $solicitation->status }}">
                        {{ get_status_label($solicitation->status) }}
                      </span>
                    </td>
                    <td>R$ {{ number_format($solicitation->calculated_price, 2, ',', '.') }}</td>
                    <td>{{ $solicitation->created_at->format('d/m/Y H:i') }}</td>
                    <td>{{ $solicitation->enterprise->name ?? 'N/A' }}</td>
                    <td>
                      <div class="btn-group btn-group-sm">
                        @if (auth()->user()->hasRole('superadmin') ||
                                in_array($solicitation->status, ['error', 'rejected', 'pending_correction']))
                          @can('update', $solicitation)
                            <a href="{{ route('solicitations.edit', $solicitation) }}"
                              class="btn btn-outline-secondary btn-sm" title="Editar">
                              <ion-icon name="create-outline"></ion-icon>
                            </a>
                          @endcan
                        @endif
                        @can('delete', $solicitation)
                          <button class="btn btn-outline-danger btn-sm"
                            onclick="deleteSolicitation({{ $solicitation->id }})" title="Excluir">
                            <ion-icon name="trash-outline"></ion-icon>
                          </button>
                        @endcan
                      </div>
                    </td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>

          <!-- Paginação -->
          <div class="card-footer bg-light">
            {{ $solicitations->withQueryString()->links('pagination::bootstrap-5') }}
          </div>
        @else
          <div class="empty-state">
            <i class="fas fa-search empty-state-icon"></i>
            <h5 class="empty-state-title">Nenhuma solicitação encontrada</h5>
            <p class="empty-state-text">Comece criando sua primeira solicitação de pesquisa.</p>
            @if ($canCreateSolicitation)
              <a href="{{ route('solicitations.create') }}" class="btn btn-primary">
                <i class="fas fa-plus me-2"></i>Criar Primeira Solicitação
              </a>
            @endif
          </div>
        @endif
      </div>
    </div>
  </div>

  <!-- Modal de Confirmação de Exclusão -->
  <div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Confirmar Exclusão</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <p>Tem certeza que deseja excluir esta solicitação?</p>
          <p class="text-muted">Esta ação não pode ser desfeita.</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
          <form id="deleteForm" method="POST" style="display: inline;">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger">Excluir</button>
          </form>
        </div>
      </div>
    </div>
  </div>
@endsection

@push('scripts')
  <script>
    function toggleView(view) {
      if (view === 'grid') {
        document.getElementById('grid-view').style.display = 'flex';
        document.getElementById('table-view').style.display = 'none';
      } else {
        document.getElementById('grid-view').style.display = 'none';
        document.getElementById('table-view').style.display = 'block';
      }
    }

    function deleteSolicitation(id) {
      if (confirm('Tem certeza que deseja excluir esta solicitação?')) {
        const form = document.getElementById('deleteForm');
        form.action = `/solicitations/${id}`;
        form.submit();
      }
    }
  </script>
@endpush
