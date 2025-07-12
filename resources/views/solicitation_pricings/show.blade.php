@extends('layouts.app')
@section('title', 'Detalhes da Regra de Preço')

@section('content')
  <div class="container px-2 px-md-0">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-3">
      <ol class="breadcrumb bg-transparent p-0">
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('solicitation-pricings.index') }}">Regras de Preço</a></li>
        <li class="breadcrumb-item active" aria-current="page">{{ $solicitationPricing->description }}</li>
      </ol>
    </nav>

    <div class="enterprise-form-card p-4 p-md-5 shadow-sm rounded-4 w-100 mx-auto" style="max-width: 1100px;">
      <div class="d-flex justify-content-between align-items-center mb-2">
        <div class="d-flex align-items-center gap-3">
          <span style="font-size:2.2rem;color:#8ee4af;">
            <ion-icon name="pricetag-outline"></ion-icon>
          </span>
          <div>
            <h1 class="mb-0">{{ $solicitationPricing->description }}</h1>
            <span class="badge {{ $solicitationPricing->status === 'active' ? 'badge-success' : 'badge-secondary' }}">
              {{ translate_status($solicitationPricing->status) }}
            </span>
          </div>
        </div>
        <a href="{{ route('solicitation-pricings.index') }}"
          class="btn btn-secondary btn-lg d-none d-md-inline-flex align-items-center gap-2">
          <ion-icon name="arrow-back-outline"></ion-icon> Voltar
        </a>
      </div>
      <div class="mb-3">
        <small class="text-muted">
          Empresa: {{ $solicitationPricing->enterprise->name ?? '-' }}
        </small>
      </div>

      <ul class="nav nav-tabs mb-4" id="pricingTabs" role="tablist">
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
                <span class="ms-2 fw-semibold">{{ $solicitationPricing->enterprise->name ?? '-' }}</span>
              </div>
              <div class="d-flex align-items-center mb-2">
                <ion-icon name="card-outline" class="me-2" style="font-size:1.2rem;color:#8ee4af;"></ion-icon>
                <span class="text-muted">Preço Motorista Individual:</span>
                <span class="ms-2">R$
                  {{ number_format($solicitationPricing->individual_driver_price, 2, ',', '.') }}</span>
              </div>
              <div class="d-flex align-items-center mb-2">
                <ion-icon name="car-outline" class="me-2" style="font-size:1.2rem;color:#8ee4af;"></ion-icon>
                <span class="text-muted">Preço Veículo Individual:</span>
                <span class="ms-2">R$
                  {{ number_format($solicitationPricing->individual_vehicle_price, 2, ',', '.') }}</span>
              </div>
              <div class="d-flex align-items-center mb-2">
                <ion-icon name="cash-outline" class="me-2" style="font-size:1.2rem;color:#8ee4af;"></ion-icon>
                <span class="text-muted">Preço Unificado:</span>
                <span class="ms-2">R$ {{ number_format($solicitationPricing->unified_price, 2, ',', '.') }}</span>
              </div>
              <div class="d-flex align-items-center mb-2">
                <ion-icon name="add-circle-outline" class="me-2" style="font-size:1.2rem;color:#8ee4af;"></ion-icon>
                <span class="text-muted">Adicional 2º Veículo:</span>
                <span class="ms-2">R$
                  {{ number_format($solicitationPricing->unified_additional_vehicle_2, 2, ',', '.') }}</span>
              </div>
              <div class="d-flex align-items-center mb-2">
                <ion-icon name="add-circle-outline" class="me-2" style="font-size:1.2rem;color:#8ee4af;"></ion-icon>
                <span class="text-muted">Adicional 3º Veículo:</span>
                <span class="ms-2">R$
                  {{ number_format($solicitationPricing->unified_additional_vehicle_3, 2, ',', '.') }}</span>
              </div>
              <div class="d-flex align-items-center mb-2">
                <ion-icon name="add-circle-outline" class="me-2" style="font-size:1.2rem;color:#8ee4af;"></ion-icon>
                <span class="text-muted">Adicional 4º Veículo:</span>
                <span class="ms-2">R$
                  {{ number_format($solicitationPricing->unified_additional_vehicle_4, 2, ',', '.') }}</span>
              </div>
            </div>
            <div class="col-md-6">
              <div class="d-flex align-items-center mb-2">
                <ion-icon name="repeat-outline" class="me-2" style="font-size:1.2rem;color:#8ee4af;"></ion-icon>
                <span class="text-muted">Recorrência Automática:</span>
                <span class="ms-2">
                  @php
                    $rec = [];
                    if ($solicitationPricing->recurrence_autonomo) {
                        $rec[] = 'Autônomo';
                    }
                    if ($solicitationPricing->recurrence_agregado) {
                        $rec[] = 'Agregado';
                    }
                    if ($solicitationPricing->recurrence_frota) {
                        $rec[] = 'Frota';
                    }
                  @endphp
                  {{ count($rec) ? implode(', ', $rec) : 'Nenhuma' }}
                </span>
              </div>
              <div class="d-flex align-items-center mb-2">
                <ion-icon name="calendar-outline" class="me-2" style="font-size:1.2rem;color:#8ee4af;"></ion-icon>
                <span class="text-muted">Vigência Geral:</span>
                <span
                  class="ms-2">{{ $solicitationPricing->validity_days ? $solicitationPricing->validity_days . ' dias' : '-' }}</span>
              </div>
              <div class="d-flex align-items-center mb-2">
                <ion-icon name="person-outline" class="me-2" style="font-size:1.2rem;color:#8ee4af;"></ion-icon>
                <span class="text-muted">Vigência Autônomo:</span>
                <span
                  class="ms-2">{{ $solicitationPricing->validity_autonomo_days ? $solicitationPricing->validity_autonomo_days . ' dias' : '-' }}</span>
              </div>
              <div class="d-flex align-items-center mb-2">
                <ion-icon name="person-outline" class="me-2" style="font-size:1.2rem;color:#8ee4af;"></ion-icon>
                <span class="text-muted">Vigência Agregado:</span>
                <span
                  class="ms-2">{{ $solicitationPricing->validity_agregado_days ? $solicitationPricing->validity_agregado_days . ' dias' : '-' }}</span>
              </div>
              <div class="d-flex align-items-center mb-2">
                <ion-icon name="person-outline" class="me-2" style="font-size:1.2rem;color:#8ee4af;"></ion-icon>
                <span class="text-muted">Vigência Funcionário:</span>
                <span
                  class="ms-2">{{ $solicitationPricing->validity_funcionario_days ? $solicitationPricing->validity_funcionario_days . ' dias' : '-' }}</span>
              </div>
            </div>
          </div>
          <div class="d-flex gap-2 justify-content-end mt-3">
            <a href="{{ route('solicitation-pricings.edit', $solicitationPricing) }}"
              class="btn btn-primary btn-lg px-4">
              <ion-icon name="create-outline"></ion-icon> Editar
            </a>
            <form method="POST" action="{{ route('solicitation-pricings.destroy', $solicitationPricing) }}"
              class="d-inline">
              @csrf
              @method('DELETE')
              <button type="submit" class="btn btn-danger btn-lg px-4"
                onclick="return confirm('Deseja realmente excluir esta regra de preço?')">
                <ion-icon name="trash-outline"></ion-icon> Excluir
              </button>
            </form>
          </div>
        </div>
      </div>
      <!-- Botão Voltar para mobile -->
      <a href="{{ route('solicitation-pricings.index') }}" class="btn btn-secondary btn-lg d-md-none w-100 mt-4">
        <ion-icon name="arrow-back-outline"></ion-icon> Voltar
      </a>
    </div>
  </div>
@endsection
