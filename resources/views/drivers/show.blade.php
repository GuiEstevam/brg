@extends('layouts.app')
@section('title', 'Detalhes do Motorista')

@section('content')
  <div class="container px-2 px-md-0">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-3">
      <ol class="breadcrumb bg-transparent p-0">
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('drivers.index') }}">Motoristas</a></li>
        <li class="breadcrumb-item active" aria-current="page">{{ $driver->name }}</li>
      </ol>
    </nav>

    <div class="enterprise-form-card p-4 p-md-5 shadow-sm rounded-4 w-100 mx-auto">
      <div class="d-flex justify-content-between align-items-center mb-2">
        <div class="d-flex align-items-center gap-3">
          <span style="font-size:2.2rem;color:#8ee4af;">
            <ion-icon name="person-outline"></ion-icon>
          </span>
          <div>
            <h1 class="mb-0">{{ $driver->name }}</h1>
            <span class="badge {{ status_badge_class($driver->status) }}">
              {{ translate_status($driver->status) }}
            </span>
          </div>
        </div>
        <a href="{{ route('drivers.index') }}"
          class="btn btn-secondary btn-lg d-none d-md-inline-flex align-items-center gap-2">
          <ion-icon name="arrow-back-outline"></ion-icon> Voltar
        </a>
      </div>
      <div class="mb-3">
        <small class="text-muted">
          CPF: <span id="cpf-show">{{ $driver->cpf }}</span>
          &nbsp;|&nbsp; E-mail: {{ $driver->email ?? '-' }}
          &nbsp;|&nbsp; Telefone: <span id="phone-show">{{ $driver->phone ?? '-' }}</span>
        </small>
      </div>

      <ul class="nav nav-tabs mb-4" id="driverTabs" role="tablist">
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
                <span class="text-muted">CPF:</span>
                <span class="ms-2" id="cpf-show-2">{{ $driver->cpf }}</span>
              </div>
              <div class="d-flex align-items-center mb-2">
                <ion-icon name="mail-outline" class="me-2" style="font-size:1.2rem;color:#8ee4af;"></ion-icon>
                <span class="text-muted">E-mail:</span>
                <span class="ms-2">{{ $driver->email ?? '-' }}</span>
              </div>
              <div class="d-flex align-items-center mb-2">
                <ion-icon name="call-outline" class="me-2" style="font-size:1.2rem;color:#8ee4af;"></ion-icon>
                <span class="text-muted">Telefone:</span>
                <span class="ms-2" id="phone-show-2">{{ $driver->phone ?? '-' }}</span>
              </div>
              <div class="d-flex align-items-center mb-2">
                <ion-icon name="calendar-outline" class="me-2" style="font-size:1.2rem;color:#8ee4af;"></ion-icon>
                <span class="text-muted">Data de Nascimento:</span>
                <span class="ms-2">
                  {{ $driver->birth_date ? \Carbon\Carbon::parse($driver->birth_date)->format('d/m/Y') : '-' }}
                </span>
              </div>
              <div class="d-flex align-items-center mb-2">
                <ion-icon name="female-outline" class="me-2" style="font-size:1.2rem;color:#8ee4af;"></ion-icon>
                <span class="text-muted">Nome da Mãe:</span>
                <span class="ms-2">{{ $driver->mother_name ?? '-' }}</span>
              </div>
            </div>
            <div class="col-md-6">
              <div class="d-flex align-items-center mb-2">
                <ion-icon name="id-card-outline" class="me-2" style="font-size:1.2rem;color:#8ee4af;"></ion-icon>
                <span class="text-muted">RG:</span>
                <span class="ms-2">{{ $driver->rg_number ?? '-' }}</span>
              </div>
              <div class="d-flex align-items-center mb-2">
                <ion-icon name="flag-outline" class="me-2" style="font-size:1.2rem;color:#8ee4af;"></ion-icon>
                <span class="text-muted">UF do RG:</span>
                <span class="ms-2">{{ $driver->rg_uf ?? '-' }}</span>
              </div>
              <div class="d-flex align-items-center mb-2">
                <ion-icon name="checkmark-circle-outline" class="me-2"
                  style="font-size:1.2rem;color:#8ee4af;"></ion-icon>
                <span class="text-muted">Status:</span>
                <span class="ms-2 badge {{ status_badge_class($driver->status) }}">
                  {{ translate_status($driver->status) }}
                </span>
              </div>
            </div>
          </div>
          <div class="d-flex gap-2 justify-content-end mt-3">
            <a href="{{ route('drivers.edit', $driver) }}" class="btn btn-primary btn-lg px-4">
              <ion-icon name="create-outline"></ion-icon> Editar
            </a>
            <form method="POST" action="{{ route('drivers.destroy', $driver) }}" class="d-inline">
              @csrf
              @method('DELETE')
              <button type="submit" class="btn btn-danger btn-lg px-4"
                onclick="return confirm('Deseja realmente excluir este motorista?')">
                <ion-icon name="trash-outline"></ion-icon> Excluir
              </button>
            </form>
          </div>
        </div>
      </div>
      <!-- Botão Voltar para mobile -->
      <a href="{{ route('drivers.index') }}" class="btn btn-secondary btn-lg d-md-none w-100 mt-4">
        <ion-icon name="arrow-back-outline"></ion-icon> Voltar
      </a>
    </div>
  </div>

  @push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
    <script>
      $(function() {
        // Máscara para CPF
        $('#cpf-show, #cpf-show-2').text(function(_, old) {
          if (!old) return '-';
          return old.replace(/^(\d{3})(\d{3})(\d{3})(\d{2})$/, "$1.$2.$3-$4");
        });
        // Máscara para telefone
        $('#phone-show, #phone-show-2').text(function(_, old) {
          if (!old) return '-';
          if (old.length === 11) {
            return old.replace(/^(\d{2})(\d{5})(\d{4})$/, "($1) $2-$3");
          } else if (old.length === 10) {
            return old.replace(/^(\d{2})(\d{4})(\d{4})$/, "($1) $2-$3");
          }
          return old;
        });
      });
    </script>
  @endpush
@endsection
