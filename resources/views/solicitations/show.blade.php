@extends('layouts.app')
@section('title', 'Status da Solicitação')

@push('styles')
  <style>
    .status-hero {
      background: linear-gradient(135deg, #eafaf1 80%, #f8fafc 100%);
      border-radius: 32px;
      box-shadow: 0 2px 16px 0 #b0b4c466;
      padding: 2.5rem 2rem 2rem 2rem;
      margin-bottom: 2rem;
      text-align: center;
      position: relative;
    }

    .status-hero .icon-main {
      font-size: 3.5rem;
      color: #8ee4af;
      margin-bottom: 1rem;
    }

    .status-hero .badge {
      font-size: 1.2em;
      padding: 0.5em 1.1em;
      border-radius: 1.5em;
      margin-left: 0.5em;
    }

    .status-step {
      display: flex;
      align-items: center;
      gap: 1rem;
      margin-bottom: 1.2rem;
      font-size: 1.1rem;
    }

    .status-step .step-icon {
      font-size: 1.8rem;
      color: #8ee4af;
    }

    .status-step.completed .step-icon {
      color: #41ff6a;
    }

    .status-step.error .step-icon {
      color: #ff7675;
    }

    .status-step .step-label {
      font-weight: 600;
    }

    .status-step .step-date {
      font-size: 0.98rem;
      color: #5e6472;
      margin-left: auto;
    }

    .status-card {
      background: #fff;
      border-radius: 18px;
      box-shadow: 0 2px 12px 0 #b0b4c433;
      padding: 2rem 1.5rem;
      margin-bottom: 2rem;
    }

    .status-summary {
      font-size: 1.15rem;
      color: #222;
      margin-bottom: 1rem;
    }

    @media (max-width: 767px) {
      .status-hero {
        padding: 1.5rem 0.7rem;
      }

      .status-card {
        padding: 1.2rem 0.7rem;
      }
    }
  </style>
@endpush

@section('content')
  <nav aria-label="breadcrumb" class="mb-3">
    <ol class="breadcrumb bg-transparent p-0">
      <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Início</a></li>
      <li class="breadcrumb-item"><a href="{{ route('solicitations.index') }}">Minhas Solicitações</a></li>
      <li class="breadcrumb-item active" aria-current="page">Status</li>
    </ol>
  </nav>

  <div class="status-hero">
    <div class="icon-main mb-2">
      <ion-icon name="search-circle-outline"></ion-icon>
    </div>
    <h2 class="mb-2">Status da Solicitação #{{ $solicitation->id }}</h2>
    <div>
      <span class="badge {{ status_badge_class($solicitation->status) }}">
        {{ translate_status($solicitation->status) }}
      </span>
    </div>
    <div class="mt-2 status-summary">
      <strong>{{ $solicitation->type }}</strong>
      @if ($solicitation->subtype)
        — {{ $solicitation->subtype }}
      @endif
      <br>
      <span style="color:#5e6472;">
        {{ $solicitation->created_at ? $solicitation->created_at->format('d/m/Y H:i') : '-' }}
      </span>
    </div>
  </div>

  <div class="status-card">
    <div class="row g-3 mb-3">
      <div class="col-md-6">
        <div class="mb-2"><strong>Empresa:</strong> {{ $solicitation->enterprise->name ?? '-' }}</div>
        <div class="mb-2"><strong>Filial:</strong> {{ $solicitation->branch->name ?? '-' }}</div>
        <div class="mb-2"><strong>Motorista:</strong> {{ $solicitation->driver->name ?? '-' }}</div>
        <div class="mb-2"><strong>Veículo:</strong> {{ $solicitation->vehicle->plate ?? '-' }}</div>
      </div>
      <div class="col-md-6">
        <div class="mb-2"><strong>Valor:</strong> R$ {{ number_format($solicitation->value, 2, ',', '.') }}</div>
        <div class="mb-2"><strong>Tipo de Vínculo:</strong> {{ $solicitation->vincle_type ?? '-' }}</div>
        <div class="mb-2"><strong>Tipo de Pesquisa:</strong> {{ $solicitation->research_type ?? '-' }}</div>
        <div class="mb-2"><strong>Status:</strong>
          <span class="badge {{ status_badge_class($solicitation->status) }}">
            {{ translate_status($solicitation->status) }}
          </span>
        </div>
      </div>
    </div>
  </div>

  <div class="status-card">
    <h5 class="mb-3" style="color:#5e6472;">Andamento da Solicitação</h5>
    @php
      $steps = [
          [
              'label' => 'Solicitação enviada',
              'icon' => 'send-outline',
              'completed' => true,
              'date' => $solicitation->created_at ? $solicitation->created_at->format('d/m/Y H:i') : null,
          ],
          [
              'label' => 'Processando',
              'icon' => 'hourglass-outline',
              'completed' => in_array($solicitation->status, ['processing', 'finished', 'error']),
              'date' =>
                  $solicitation->status === 'processing' && $solicitation->updated_at
                      ? $solicitation->updated_at->format('d/m/Y H:i')
                      : null,
          ],
          [
              'label' => 'Resultado',
              'icon' =>
                  $solicitation->status === 'finished'
                      ? 'checkmark-circle-outline'
                      : ($solicitation->status === 'error'
                          ? 'close-circle-outline'
                          : 'flask-outline'),
              'completed' => in_array($solicitation->status, ['finished', 'error']),
              'error' => $solicitation->status === 'error',
              'date' =>
                  $solicitation->status === 'finished' && $solicitation->updated_at
                      ? $solicitation->updated_at->format('d/m/Y H:i')
                      : null,
          ],
      ];
    @endphp
    @foreach ($steps as $step)
      <div class="status-step {{ $step['completed'] ? 'completed' : '' }} {{ $step['error'] ?? false ? 'error' : '' }}">
        <span class="step-icon">
          <ion-icon name="{{ $step['icon'] }}"></ion-icon>
        </span>
        <span class="step-label">{{ $step['label'] }}</span>
        @if ($step['date'])
          <span class="step-date">{{ $step['date'] }}</span>
        @endif
      </div>
    @endforeach
  </div>

  <div class="status-card">
    <h5 class="mb-3" style="color:#5e6472;">Resultado da Pesquisa</h5>
    @php
      $research = $solicitation->researches->first() ?? null;
    @endphp
    @if ($research)
      <div class="mb-2">
        <strong>Status API:</strong>
        <span class="badge {{ status_badge_class($research->status_api) }}">
          {{ translate_status($research->status_api) }}
        </span>
      </div>
      <div class="mb-2"><strong>Pontuação:</strong> {{ $research->total_points ?? '-' }}</div>
      <div class="mb-2"><strong>Válido até:</strong>
        {{ $research->validity_date ? \Carbon\Carbon::parse($research->validity_date)->format('d/m/Y') : '-' }}
      </div>
      <div class="mb-2"><strong>Motivos de Reprovação:</strong>
        @if ($research->rejection_reasons && is_array($research->rejection_reasons) && count($research->rejection_reasons))
          <ul>
            @foreach ($research->rejection_reasons as $reason)
              <li>{{ $reason }}</li>
            @endforeach
          </ul>
        @else
          <span>-</span>
        @endif
      </div>
      <div class="mb-2">
        <strong>Resposta da API:</strong>
        <pre class="bg-light p-2 rounded" style="font-size:0.95em;white-space:pre-wrap;word-break:break-all;">
{{ json_encode($research->api_response, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}
            </pre>
      </div>
    @else
      <div class="alert alert-info mb-0">Ainda não há resultado para esta solicitação.</div>
    @endif
  </div>

  <div class="d-flex gap-2 justify-content-end mt-3">
    <a href="{{ route('solicitations.index') }}" class="btn btn-secondary btn-lg px-4">
      <ion-icon name="arrow-back-outline"></ion-icon> Voltar para minhas solicitações
    </a>
  </div>
@endsection
