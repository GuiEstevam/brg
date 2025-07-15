@extends('layouts.app')
@section('title', 'Status da Solicitação')

@section('content')
  <nav aria-label="breadcrumb" class="mb-3">
    <ol class="breadcrumb bg-transparent p-0">
      <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Início</a></li>
      <li class="breadcrumb-item"><a href="{{ route('solicitations.index') }}">Minhas Solicitações</a></li>
      <li class="breadcrumb-item active" aria-current="page">Status</li>
    </ol>
  </nav>

  <div class="status-hero mb-4">
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
    <div class="mt-3 d-flex justify-content-center gap-2">
      <a href="{{ route('solicitations.index') }}" class="btn btn-secondary btn-lg px-4">
        <ion-icon name="arrow-back-outline"></ion-icon> Minhas Solicitações
      </a>
      <a href="#" class="btn btn-primary btn-lg px-4"
        onclick="event.preventDefault(); alert('Funcionalidade em breve!')">
        <ion-icon name="download-outline"></ion-icon> Emitir PDF
      </a>
    </div>
  </div>

  <div class="status-card mb-4">
    <div class="row g-3">
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

  <div class="status-card mb-4">
    <h5 class="mb-3" style="color:#5e6472;">Linha do Tempo</h5>
    <div class="timeline-chat">
      @php
        $timeline = [
            [
                'side' => 'left',
                'icon' => 'send-outline',
                'label' => 'Solicitação enviada',
                'date' => $solicitation->created_at,
                'user' => true,
                'status' => 'success',
            ],
            [
                'side' => 'right',
                'icon' => 'cloud-upload-outline',
                'label' => 'Recebida pela API',
                'date' => $solicitation->api_received_at ?? $solicitation->created_at,
                'user' => false,
                'status' => 'info',
            ],
            [
                'side' => 'left',
                'icon' => 'flask-outline',
                'label' => 'Pesquisa criada',
                'date' => $solicitation->research_created_at ?? null,
                'user' => true,
                'status' => 'success',
            ],
            [
                'side' => 'right',
                'icon' =>
                    $solicitation->status === 'finished'
                        ? 'checkmark-circle-outline'
                        : ($solicitation->status === 'error'
                            ? 'close-circle-outline'
                            : 'hourglass-outline'),
                'label' =>
                    $solicitation->status === 'finished'
                        ? 'Pesquisa concluída'
                        : ($solicitation->status === 'error'
                            ? 'Erro na pesquisa'
                            : 'Aguardando resultado'),
                'date' => $solicitation->updated_at,
                'user' => false,
                'status' =>
                    $solicitation->status === 'finished'
                        ? 'success'
                        : ($solicitation->status === 'error'
                            ? 'danger'
                            : 'warning'),
            ],
        ];
      @endphp

      @foreach ($timeline as $event)
        @if ($event['date'])
          <div class="timeline-msg timeline-{{ $event['side'] }}">
            <div class="timeline-bubble timeline-{{ $event['status'] }}">
              <span class="timeline-icon">
                <ion-icon name="{{ $event['icon'] }}"></ion-icon>
              </span>
              <span class="timeline-label">{{ $event['label'] }}</span>
              <span class="timeline-date">{{ \Carbon\Carbon::parse($event['date'])->format('d/m/Y H:i') }}</span>
            </div>
          </div>
        @endif
      @endforeach
    </div>
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
@endsection
