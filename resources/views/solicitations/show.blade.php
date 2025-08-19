@extends('layouts.app')
@section('title', 'Detalhes da Solicitação')

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
            <li class="breadcrumb-item"><a href="{{ route('solicitations.index') }}" class="text-decoration-none">
                <i class="fas fa-search me-1"></i>Solicitações
              </a></li>
            <li class="breadcrumb-item active" aria-current="page">
              <i class="fas fa-eye me-1"></i>Detalhes
            </li>
          </ol>
        </nav>
        <h1 class="h3 mb-0 fw-bold">Solicitação #{{ $solicitation->id }}</h1>
        <p class="text-muted mb-0">{{ get_entity_type_label($solicitation->entity_type) }} -
          {{ get_research_type_label($solicitation->research_type) }}</p>
      </div>

      <div class="d-flex gap-2">
        @can('update', $solicitation)
          <a href="{{ route('solicitations.edit', $solicitation) }}" class="btn btn-outline-primary">
            <i class="fas fa-edit me-2"></i>Editar
          </a>
        @endcan
        <a href="{{ route('solicitations.index') }}" class="btn btn-secondary">
          <i class="fas fa-arrow-left me-2"></i>Voltar
        </a>
      </div>
    </div>

    <!-- Status Banner -->
    <div class="status-hero mb-4">
      <div class="icon-main">
        @if ($solicitation->entity_type === 'driver')
          <i class="fas fa-user"></i>
        @elseif($solicitation->entity_type === 'vehicle')
          <i class="fas fa-car"></i>
        @else
          <i class="fas fa-users"></i>
        @endif
      </div>
      <h2 class="mb-2">Solicitação #{{ $solicitation->id }}</h2>
      <div class="status-summary">
        {{ get_entity_type_label($solicitation->entity_type) }} -
        {{ get_research_type_label($solicitation->research_type) }}
      </div>
      <span class="status-badge status-badge-{{ $solicitation->status }}">
        {{ get_status_label($solicitation->status) }}
      </span>
    </div>

    <div class="row">
      <!-- Detalhes Principais -->
      <div class="col-lg-8">
        <div class="status-card">
          <h5 class="mb-3">
            <i class="fas fa-info-circle me-2"></i>Detalhes da Solicitação
          </h5>
          <div class="row">
            <div class="col-md-6">
              <div class="d-flex align-items-center">
                <div class="solicitation-type-icon me-3">
                  @if ($solicitation->entity_type === 'driver')
                    <i class="fas fa-user"></i>
                  @elseif($solicitation->entity_type === 'vehicle')
                    <i class="fas fa-car"></i>
                  @else
                    <i class="fas fa-users"></i>
                  @endif
                </div>
                <div>
                  <h6 class="mb-1">{{ get_entity_type_label($solicitation->entity_type) }}</h6>
                  <p class="text-muted mb-0">{{ get_research_type_label($solicitation->research_type) }}</p>
                </div>
              </div>

              @if ($solicitation->entity_type === 'driver')
                <label class="form-label fw-bold">Motorista</label>
                <p class="mb-3">{{ $solicitation->driver->name ?? 'N/A' }}</p>

                <label class="form-label fw-bold">CPF</label>
                <p class="mb-3">{{ $solicitation->entity_value }}</p>
              @elseif($solicitation->entity_type === 'vehicle')
                <label class="form-label fw-bold">Veículo</label>
                <p class="mb-3">{{ $solicitation->vehicle->plate ?? 'N/A' }}</p>

                <label class="form-label fw-bold">Placa</label>
                <p class="mb-3">{{ $solicitation->entity_value }}</p>
              @else
                <label class="form-label fw-bold">Motorista</label>
                <p class="mb-3">{{ $solicitation->driver->name ?? 'N/A' }}</p>

                <label class="form-label fw-bold">Veículos</label>
                <div class="mb-3">
                  @if ($solicitation->vehicles->count() > 0)
                    @foreach ($solicitation->vehicles as $vehicle)
                      <span class="badge bg-light text-dark me-2 mb-1">
                        {{ $vehicle->plate }} ({{ $vehicle->model }})
                      </span>
                    @endforeach
                  @else
                    <span class="text-muted">Nenhum veículo associado</span>
                  @endif
                </div>
              @endif
            </div>

            <div class="col-md-6">
              <label class="form-label fw-bold">Tipo de Pesquisa</label>
              <p class="mb-3">{{ get_research_type_label($solicitation->research_type) }}</p>

              <label class="form-label fw-bold">Tipo de Vínculo</label>
              <p class="mb-3">{{ get_vincle_type_label($solicitation->vincle_type) }}</p>

              <label class="form-label fw-bold">Preço Calculado</label>
              <p class="mb-3">R$ {{ number_format($solicitation->calculated_price, 2, ',', '.') }}</p>

              <label class="form-label fw-bold">Renovação Automática</label>
              <p class="mb-3">
                @if ($solicitation->auto_renewal)
                  <span class="badge bg-success">Sim</span>
                @else
                  <span class="badge bg-secondary">Não</span>
                @endif
              </p>
            </div>
          </div>

          @if ($solicitation->notes)
            <div class="mt-3">
              <label class="form-label fw-bold">Observações</label>
              <p class="mb-0">{{ $solicitation->notes }}</p>
            </div>
          @endif
        </div>

        <!-- Resultados das Pesquisas -->
        <div class="status-card">
          <h5 class="mb-3">
            <i class="fas fa-chart-line me-2"></i>Resultados das Pesquisas
          </h5>
          <div class="card-body">
            @if ($solicitation->researches->count() > 0)
              @foreach ($solicitation->researches->sortByDesc('created_at') as $research)
                <div class="research-item border rounded p-3 mb-3">
                  <div class="d-flex justify-content-between align-items-start mb-2">
                    <h6 class="mb-1">Pesquisa #{{ $research->id }}</h6>
                    <span class="status-badge status-badge-{{ $research->validation_status }}">
                      {{ get_validation_status_label($research->validation_status) }}
                    </span>
                  </div>

                  <div class="row g-2">
                    @if ($research->document_number)
                      <div class="col-md-6">
                        <small class="text-muted">Documento:</small>
                        <p class="mb-1">{{ $research->document_number }}</p>
                      </div>
                    @endif

                    @if ($research->person_name)
                      <div class="col-md-6">
                        <small class="text-muted">Nome:</small>
                        <p class="mb-1">{{ $research->person_name }}</p>
                      </div>
                    @endif

                    @if ($research->validity_date)
                      <div class="col-md-6">
                        <small class="text-muted">Válido até:</small>
                        <p class="mb-1">{{ \Carbon\Carbon::parse($research->validity_date)->format('d/m/Y') }}</p>
                      </div>
                    @endif

                    @if ($research->score)
                      <div class="col-md-6">
                        <small class="text-muted">Pontuação:</small>
                        <p class="mb-1">{{ $research->score }}</p>
                      </div>
                    @endif
                  </div>

                  @if ($research->notes)
                    <div class="mt-2">
                      <small class="text-muted">Observações:</small>
                      <p class="mb-1">{{ $research->notes }}</p>
                    </div>
                  @endif

                  <div class="mt-2">
                    <small class="text-muted">
                      <i class="fas fa-calendar me-1"></i>
                      {{ $research->created_at->format('d/m/Y H:i') }}
                    </small>
                  </div>
                </div>
              @endforeach
            @else
              <div class="empty-state">
                <i class="fas fa-chart-line empty-state-icon"></i>
                <h6 class="empty-state-title">Nenhum resultado disponível</h6>
                <p class="empty-state-text">Os resultados das pesquisas aparecerão aqui quando estiverem disponíveis.</p>
              </div>
            @endif
          </div>
        </div>
      </div>

      <!-- Sidebar -->
      <div class="col-lg-4">
        <!-- Informações da Empresa -->
        <div class="status-card">
          <h6 class="mb-3">
            <i class="fas fa-building me-2"></i>Informações da Empresa
          </h6>
          <p class="mb-2"><strong>Empresa:</strong> {{ $solicitation->enterprise->name ?? 'N/A' }}</p>
          <p class="mb-2"><strong>Filial:</strong> {{ $solicitation->branch->name ?? 'N/A' }}</p>
          <p class="mb-0"><strong>Solicitante:</strong> {{ $solicitation->user->name ?? 'N/A' }}</p>
        </div>

        <!-- Ações Rápidas -->
        <div class="status-card">
          <h6 class="mb-3">
            <i class="fas fa-bolt me-2"></i>Ações Rápidas
          </h6>
          <div class="d-grid gap-2">
            @can('update', $solicitation)
              <a href="{{ route('solicitations.edit', $solicitation) }}" class="btn btn-primary btn-sm">
                <i class="fas fa-edit me-2"></i>Editar Solicitação
              </a>
            @endcan

            <button class="btn btn-outline-secondary btn-sm" onclick="alert('Funcionalidade em desenvolvimento')">
              <i class="fas fa-download me-2"></i>Exportar PDF
            </button>

            <button class="btn btn-outline-info btn-sm" onclick="alert('Funcionalidade em desenvolvimento')">
              <i class="fas fa-share me-2"></i>Compartilhar
            </button>

            @can('delete', $solicitation)
              <button class="btn btn-outline-danger btn-sm" onclick="deleteSolicitation({{ $solicitation->id }})">
                <i class="fas fa-trash me-2"></i>Excluir Solicitação
              </button>
            @endcan
          </div>
        </div>

        <!-- Timeline de Status -->
        <div class="status-card">
          <h6 class="mb-3">
            <i class="fas fa-history me-2"></i>Timeline
          </h6>
          <div class="timeline-chat">
            <div class="timeline-msg timeline-left">
              <div class="timeline-bubble timeline-success">
                <i class="fas fa-plus timeline-icon"></i>
                <span>Solicitação criada</span>
                <span class="timeline-date">{{ $solicitation->created_at->format('d/m/Y H:i') }}</span>
              </div>
            </div>

            @if ($solicitation->status !== 'pending')
              <div class="timeline-msg timeline-right">
                <div class="timeline-bubble timeline-info">
                  <i class="fas fa-cog timeline-icon"></i>
                  <span>Processamento iniciado</span>
                  <span class="timeline-date">{{ $solicitation->updated_at->format('d/m/Y H:i') }}</span>
                </div>
              </div>
            @endif

            @if ($solicitation->status === 'finished')
              <div class="timeline-msg timeline-right">
                <div class="timeline-bubble timeline-success">
                  <i class="fas fa-check timeline-icon"></i>
                  <span>Pesquisa finalizada</span>
                  <span class="timeline-date">{{ $solicitation->updated_at->format('d/m/Y H:i') }}</span>
                </div>
              </div>
            @endif

            @if ($solicitation->status === 'error')
              <div class="timeline-msg timeline-right">
                <div class="timeline-bubble timeline-danger">
                  <i class="fas fa-exclamation-triangle timeline-icon"></i>
                  <span>Erro na pesquisa</span>
                  <span class="timeline-date">{{ $solicitation->updated_at->format('d/m/Y H:i') }}</span>
                </div>
              </div>
            @endif
          </div>
        </div>
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
    function deleteSolicitation(id) {
      if (confirm('Tem certeza que deseja excluir esta solicitação?')) {
        const form = document.getElementById('deleteForm');
        form.action = `/solicitations/${id}`;
        form.submit();
      }
    }
  </script>
@endpush
