@extends('layouts.app')
@section('title', 'Detalhes do Contrato')

@section('content')
  <div class="container px-2 px-md-0">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-3">
      <ol class="breadcrumb bg-transparent p-0">
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('contracts.index') }}">Contratos</a></li>
        <li class="breadcrumb-item active" aria-current="page">{{ $contract->plan_name }}</li>
      </ol>
    </nav>

    <div class="enterprise-form-card p-4 p-md-5 shadow-sm rounded-4 w-100 mx-auto">
      <div class="d-flex justify-content-between align-items-center mb-2">
        <div class="d-flex align-items-center gap-3">
          <span style="font-size:2.2rem;color:#8ee4af;">
            <ion-icon name="document-text-outline"></ion-icon>
          </span>
          <div>
            <h1 class="mb-0">{{ $contract->plan_name }}</h1>
            <span class="badge {{ status_badge_class($contract->status) }}">
              {{ translate_status($contract->status) }}
            </span>
          </div>
        </div>
        <a href="{{ route('contracts.index') }}"
          class="btn btn-secondary btn-lg d-none d-md-inline-flex align-items-center gap-2">
          <ion-icon name="arrow-back-outline"></ion-icon> Voltar
        </a>
      </div>
      <div class="mb-3">
        <small class="text-muted">
          Empresa: {{ $contract->enterprise->name ?? '-' }}
          @if ($contract->branch)
            &nbsp;|&nbsp; Filial: {{ $contract->branch->name }}
          @endif
          &nbsp;|&nbsp; Vigência: {{ \Carbon\Carbon::parse($contract->start_date)->format('d/m/Y') }}
          @if ($contract->end_date)
            - {{ \Carbon\Carbon::parse($contract->end_date)->format('d/m/Y') }}
          @else
            - Indeterminado
          @endif
        </small>
      </div>

      <ul class="nav nav-tabs mb-4" id="contractTabs" role="tablist">
        <li class="nav-item" role="presentation">
          <button class="nav-link active" id="dados-tab" data-bs-toggle="tab" data-bs-target="#dados" type="button"
            role="tab">
            <ion-icon name="information-circle-outline"></ion-icon> Dados
          </button>
        </li>
      </ul>

      <div class="tab-content">
        <!-- Aba Dados -->
        <div class="tab-pane fade show active" id="dados" role="tabpanel">
          <div class="row g-3 mb-4">
            <div class="col-md-6">
              <div class="d-flex align-items-center mb-2">
                <ion-icon name="business-outline" class="me-2" style="font-size:1.2rem;color:#8ee4af;"></ion-icon>
                <span class="text-muted">Empresa:</span>
                <span class="ms-2 fw-semibold">{{ $contract->enterprise->name ?? '-' }}</span>
              </div>
              <div class="d-flex align-items-center mb-2">
                <ion-icon name="git-branch-outline" class="me-2" style="font-size:1.2rem;color:#8ee4af;"></ion-icon>
                <span class="text-muted">Filial:</span>
                <span class="ms-2">{{ $contract->branch->name ?? '-' }}</span>
              </div>
              <div class="d-flex align-items-center mb-2">
                <ion-icon name="calendar-outline" class="me-2" style="font-size:1.2rem;color:#8ee4af;"></ion-icon>
                <span class="text-muted">Vigência:</span>
                <span class="ms-2">
                  {{ \Carbon\Carbon::parse($contract->start_date)->format('d/m/Y') }}
                  @if ($contract->end_date)
                    - {{ \Carbon\Carbon::parse($contract->end_date)->format('d/m/Y') }}
                  @else
                    - Indeterminado
                  @endif
                </span>
              </div>
              <div class="d-flex align-items-center mb-2">
                <ion-icon name="people-outline" class="me-2" style="font-size:1.2rem;color:#8ee4af;"></ion-icon>
                <span class="text-muted">Máx. Usuários:</span>
                <span class="ms-2">{{ $contract->max_users ?? '-' }}</span>
              </div>
              <div class="d-flex align-items-center mb-2">
                <ion-icon name="analytics-outline" class="me-2" style="font-size:1.2rem;color:#8ee4af;"></ion-icon>
                <span class="text-muted">Máx. Consultas:</span>
                <span class="ms-2">
                  @if ($contract->unlimited_queries)
                    Ilimitadas
                  @else
                    {{ $contract->max_queries ?? '-' }}
                  @endif
                </span>
              </div>
              <div class="d-flex align-items-center mb-2">
                <ion-icon name="checkmark-done-outline" class="me-2" style="font-size:1.2rem;color:#8ee4af;"></ion-icon>
                <span class="text-muted">Consultas Realizadas:</span>
                <span class="ms-2">{{ $contract->total_queries_used ?? '-' }}</span>
              </div>
            </div>
            <div class="col-md-6">
              <div class="d-flex align-items-center mb-2">
                <ion-icon name="document-outline" class="me-2" style="font-size:1.2rem;color:#8ee4af;"></ion-icon>
                <span class="text-muted">Nome do Plano:</span>
                <span class="ms-2">{{ $contract->plan_name }}</span>
              </div>
              <div class="d-flex align-items-center mb-2">
                <ion-icon name="infinite-outline" class="me-2" style="font-size:1.2rem;color:#8ee4af;"></ion-icon>
                <span class="text-muted">Consultas Ilimitadas:</span>
                <span class="ms-2">{{ $contract->unlimited_queries ? 'Sim' : 'Não' }}</span>
              </div>
              {{-- Adicione outros campos extras aqui, se necessário --}}
            </div>
          </div>
          <div class="d-flex gap-2 justify-content-end mt-3">
            <a href="{{ route('contracts.edit', $contract) }}" class="btn btn-primary btn-lg px-4">
              <ion-icon name="create-outline"></ion-icon> Editar
            </a>
            <form method="POST" action="{{ route('contracts.destroy', $contract) }}" class="d-inline">
              @csrf
              @method('DELETE')
              <button type="submit" class="btn btn-danger btn-lg px-4"
                onclick="return confirm('Deseja realmente excluir este contrato?')">
                <ion-icon name="trash-outline"></ion-icon> Excluir
              </button>
            </form>
          </div>
        </div>
      </div>
      <!-- Botão Voltar para mobile -->
      <a href="{{ route('contracts.index') }}" class="btn btn-secondary btn-lg d-md-none w-100 mt-4">
        <ion-icon name="arrow-back-outline"></ion-icon> Voltar
      </a>
    </div>
  </div>
@endsection
