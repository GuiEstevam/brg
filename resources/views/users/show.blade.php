@extends('layouts.app')
@section('title', 'Detalhes do Veículo')

@section('content')
  <div class="container px-2 px-md-0">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-3">
      <ol class="breadcrumb bg-transparent p-0">
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('vehicles.index') }}">Veículos</a></li>
        <li class="breadcrumb-item active" aria-current="page">{{ $vehicle->plate }}</li>
      </ol>
    </nav>

    <div class="enterprise-form-card p-4 p-md-5 shadow-sm rounded-4 w-100 mx-auto">
      <div class="d-flex justify-content-between align-items-center mb-2">
        <div class="d-flex align-items-center gap-3">
          <span style="font-size:2.2rem;color:#8ee4af;">
            <ion-icon name="car-outline"></ion-icon>
          </span>
          <div>
            <h1 class="mb-0" id="plate-show">{{ $vehicle->plate }}</h1>
            <span class="badge {{ status_badge_class($vehicle->status) }}">
              {{ translate_status($vehicle->status) }}
            </span>
          </div>
        </div>
        <a href="{{ route('vehicles.index') }}"
          class="btn btn-secondary btn-lg d-none d-md-inline-flex align-items-center gap-2">
          <ion-icon name="arrow-back-outline"></ion-icon> Voltar
        </a>
      </div>
      <div class="mb-3">
        <small class="text-muted">
          Modelo: {{ $vehicle->model ?? '-' }} | Marca: {{ $vehicle->brand ?? '-' }} | Cor: {{ $vehicle->color ?? '-' }}
        </small>
      </div>

      <ul class="nav nav-tabs mb-4" id="vehicleTabs" role="tablist">
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
                <ion-icon name="card-outline" class="me-2" style="font-size:1.2rem;color:#8ee4af;"></ion-icon>
                <span class="text-muted">Placa:</span>
                <span class="ms-2" id="plate-show-2">{{ $vehicle->plate }}</span>
              </div>
              <div class="d-flex align-items-center mb-2">
                <ion-icon name="barcode-outline" class="me-2" style="font-size:1.2rem;color:#8ee4af;"></ion-icon>
                <span class="text-muted">RENAVAM:</span>
                <span class="ms-2">{{ $vehicle->renavam ?? '-' }}</span>
              </div>
              <div class="d-flex align-items-center mb-2">
                <ion-icon name="id-card-outline" class="me-2" style="font-size:1.2rem;color:#8ee4af;"></ion-icon>
                <span class="text-muted">Chassi:</span>
                <span class="ms-2">{{ $vehicle->chassi ?? '-' }}</span>
              </div>
              <div class="d-flex align-items-center mb-2">
                <ion-icon name="calendar-outline" class="me-2" style="font-size:1.2rem;color:#8ee4af;"></ion-icon>
                <span class="text-muted">Ano Fab./Mod.:</span>
                <span class="ms-2">{{ $vehicle->manufacture_year ?? '-' }}/{{ $vehicle->model_year ?? '-' }}</span>
              </div>
              <div class="d-flex align-items-center mb-2">
                <ion-icon name="color-palette-outline" class="me-2" style="font-size:1.2rem;color:#8ee4af;"></ion-icon>
                <span class="text-muted">Cor:</span>
                <span class="ms-2">{{ $vehicle->color ?? '-' }}</span>
              </div>
              <div class="d-flex align-items-center mb-2">
                <ion-icon name="water-outline" class="me-2" style="font-size:1.2rem;color:#8ee4af;"></ion-icon>
                <span class="text-muted">Combustível:</span>
                <span class="ms-2">{{ $vehicle->fuel ?? '-' }}</span>
              </div>
              <div class="d-flex align-items-center mb-2">
                <ion-icon name="car-sport-outline" class="me-2" style="font-size:1.2rem;color:#8ee4af;"></ion-icon>
                <span class="text-muted">Tipo/Espécie:</span>
                <span class="ms-2">{{ $vehicle->vehicle_type ?? '-' }}/{{ $vehicle->vehicle_specie ?? '-' }}</span>
              </div>
              <div class="d-flex align-items-center mb-2">
                <ion-icon name="calendar-number-outline" class="me-2"
                  style="font-size:1.2rem;color:#8ee4af;"></ion-icon>
                <span class="text-muted">Licenciamento:</span>
                <span class="ms-2">
                  {{ $vehicle->licensing_date ? \Carbon\Carbon::parse($vehicle->licensing_date)->format('d/m/Y') : '-' }}
                  ({{ $vehicle->licensing_status ?? '-' }})
                </span>
              </div>
              <div class="d-flex align-items-center mb-2">
                <ion-icon name="document-outline" class="me-2" style="font-size:1.2rem;color:#8ee4af;"></ion-icon>
                <span class="text-muted">Situação ANTT:</span>
                <span class="ms-2">{{ $vehicle->antt_situation ?? '-' }}</span>
              </div>
            </div>
            <div class="col-md-6">
              <div class="d-flex align-items-center mb-2">
                <ion-icon name="person-outline" class="me-2" style="font-size:1.2rem;color:#8ee4af;"></ion-icon>
                <span class="text-muted">Proprietário:</span>
                <span class="ms-2">{{ $vehicle->owner_name ?? '-' }}</span>
              </div>
              <div class="d-flex align-items-center mb-2">
                <ion-icon name="card-outline" class="me-2" style="font-size:1.2rem;color:#8ee4af;"></ion-icon>
                <span class="text-muted">Doc. Proprietário:</span>
                <span class="ms-2" id="owner-document-show">{{ $vehicle->owner_document ?? '-' }}</span>
              </div>
              <div class="d-flex align-items-center mb-2">
                <ion-icon name="person-add-outline" class="me-2" style="font-size:1.2rem;color:#8ee4af;"></ion-icon>
                <span class="text-muted">Locatário:</span>
                <span class="ms-2">{{ $vehicle->lessee_name ?? '-' }}</span>
              </div>
              <div class="d-flex align-items-center mb-2">
                <ion-icon name="card-outline" class="me-2" style="font-size:1.2rem;color:#8ee4af;"></ion-icon>
                <span class="text-muted">Doc. Locatário:</span>
                <span class="ms-2" id="lessee-document-show">{{ $vehicle->lessee_document ?? '-' }}</span>
              </div>
              <div class="d-flex align-items-center mb-2">
                <ion-icon name="checkmark-circle-outline" class="me-2"
                  style="font-size:1.2rem;color:#8ee4af;"></ion-icon>
                <span class="text-muted">Status:</span>
                <span class="ms-2 badge {{ status_badge_class($vehicle->status) }}">
                  {{ translate_status($vehicle->status) }}
                </span>
              </div>
            </div>
          </div>
          <div class="d-flex gap-2 justify-content-end mt-3">
            <a href="{{ route('vehicles.edit', $vehicle) }}" class="btn btn-primary btn-lg px-4">
              <ion-icon name="create-outline"></ion-icon> Editar
            </a>
            <form method="POST" action="{{ route('vehicles.destroy', $vehicle) }}" class="d-inline">
              @csrf
              @method('DELETE')
              <button type="submit" class="btn btn-danger btn-lg px-4"
                onclick="return confirm('Deseja realmente excluir este veículo?')">
                <ion-icon name="trash-outline"></ion-icon> Excluir
              </button>
            </form>
          </div>
        </div>
      </div>
      <!-- Botão Voltar para mobile -->
      <a href="{{ route('vehicles.index') }}" class="btn btn-secondary btn-lg d-md-none w-100 mt-4">
        <ion-icon name="arrow-back-outline"></ion-icon> Voltar
      </a>
    </div>
  </div>

  @push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
    <script>
      $(function() {
        // Máscara para placa (formato antigo e Mercosul)
        $('#plate-show, #plate-show-2').text(function(_, old) {
          if (!old) return '-';
          // Exemplo simples: ABC1D23 ou ABC1234
          return old.toUpperCase();
        });
        // Máscara para documentos (CPF/CNPJ)
        $('#owner-document-show, #lessee-document-show').text(function(_, old) {
          if (!old) return '-';
          if (old.length === 11) {
            return old.replace(/^(\d{3})(\d{3})(\d{3})(\d{2})$/, "$1.$2.$3-$4");
          } else if (old.length === 14) {
            return old.replace(/^(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})$/, "$1.$2.$3/$4-$5");
          }
          return old;
        });
      });
    </script>
  @endpush
@endsection
