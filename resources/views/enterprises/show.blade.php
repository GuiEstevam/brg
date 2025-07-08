@extends('layouts.app')
@section('title', 'Detalhes da Empresa')

@section('content')
  <div class="container px-2 px-md-0">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-3">
      <ol class="breadcrumb bg-transparent p-0">
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('enterprises.index') }}">Empresas</a></li>
        <li class="breadcrumb-item active" aria-current="page">{{ $enterprise->name }}</li>
      </ol>
    </nav>

    <div class="enterprise-form-card p-4 p-md-5 shadow-sm rounded-4 w-100 mx-auto" style="max-width: 1100px;">
      <div class="d-flex justify-content-between align-items-center mb-2">
        <div class="d-flex align-items-center gap-3">
          <span style="font-size:2.2rem;color:#8ee4af;">
            <ion-icon name="business-outline"></ion-icon>
          </span>
          <div>
            <h1 class="mb-0">{{ $enterprise->name }}</h1>
            <span class="badge {{ $enterprise->status === 'active' ? 'badge-success' : 'badge-secondary' }}">
              {{ translate_status($enterprise->status) }}
            </span>
          </div>
        </div>
        <a href="{{ route('enterprises.index') }}"
          class="btn btn-secondary btn-lg d-none d-md-inline-flex align-items-center gap-2">
          <ion-icon name="arrow-back-outline"></ion-icon> Voltar
        </a>
      </div>
      <div class="mb-3">
        <small class="text-muted">
          CNPJ: {{ $enterprise->cnpj }} &nbsp;|&nbsp;
          {{ $enterprise->city }}/{{ $enterprise->uf }} &nbsp;|&nbsp;
          Responsável: {{ $enterprise->responsible_name ?? '-' }}
        </small>
      </div>

      <ul class="nav nav-tabs mb-4" id="empresaTabs" role="tablist">
        <li class="nav-item" role="presentation">
          <button class="nav-link active" id="dados-tab" data-bs-toggle="tab" data-bs-target="#dados" type="button"
            role="tab">
            <ion-icon name="information-circle-outline"></ion-icon> Dados
          </button>
        </li>
        <li class="nav-item" role="presentation">
          <button class="nav-link" id="filiais-tab" data-bs-toggle="tab" data-bs-target="#filiais" type="button"
            role="tab">
            <ion-icon name="git-branch-outline"></ion-icon> Filiais
          </button>
        </li>
        <li class="nav-item" role="presentation">
          <button class="nav-link" id="precos-tab" data-bs-toggle="tab" data-bs-target="#precos" type="button"
            role="tab">
            <ion-icon name="pricetag-outline"></ion-icon> Preços
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
                <span class="text-muted">CNPJ:</span>
                <span class="ms-2 fw-semibold">{{ $enterprise->cnpj }}</span>
              </div>
              <div class="d-flex align-items-center mb-2">
                <ion-icon name="document-outline" class="me-2" style="font-size:1.2rem;color:#8ee4af;"></ion-icon>
                <span class="text-muted">Inscrição Estadual:</span>
                <span class="ms-2">{{ $enterprise->state_registration ?: '---' }}</span>
              </div>
              <div class="d-flex align-items-center mb-2">
                <ion-icon name="location-outline" class="me-2" style="font-size:1.2rem;color:#8ee4af;"></ion-icon>
                <span class="text-muted">Endereço:</span>
                <span class="ms-2">{{ $enterprise->address }}, {{ $enterprise->number }}
                  {{ $enterprise->complement }}</span>
              </div>
              <div class="d-flex align-items-center mb-2">
                <ion-icon name="home-outline" class="me-2" style="font-size:1.2rem;color:#8ee4af;"></ion-icon>
                <span class="text-muted">Bairro:</span>
                <span class="ms-2">{{ $enterprise->district }}</span>
              </div>
              <div class="d-flex align-items-center mb-2">
                <ion-icon name="business-outline" class="me-2" style="font-size:1.2rem;color:#8ee4af;"></ion-icon>
                <span class="text-muted">Cidade/UF:</span>
                <span class="ms-2">{{ $enterprise->city }}/{{ $enterprise->uf }}</span>
              </div>
              <div class="d-flex align-items-center mb-2">
                <ion-icon name="mail-outline" class="me-2" style="font-size:1.2rem;color:#8ee4af;"></ion-icon>
                <span class="text-muted">CEP:</span>
                <span class="ms-2">{{ $enterprise->cep }}</span>
              </div>
            </div>
            <div class="col-md-6">
              <div class="d-flex align-items-center mb-2">
                <ion-icon name="person-outline" class="me-2" style="font-size:1.2rem;color:#8ee4af;"></ion-icon>
                <span class="text-muted">Responsável:</span>
                <span class="ms-2">{{ $enterprise->responsible_name ?: '---' }}</span>
              </div>
              <div class="d-flex align-items-center mb-2">
                <ion-icon name="mail-outline" class="me-2" style="font-size:1.2rem;color:#8ee4af;"></ion-icon>
                <span class="text-muted">Email:</span>
                <span class="ms-2">{{ $enterprise->responsible_email ?: '---' }}</span>
              </div>
              <div class="d-flex align-items-center mb-2">
                <ion-icon name="call-outline" class="me-2" style="font-size:1.2rem;color:#8ee4af;"></ion-icon>
                <span class="text-muted">Telefone:</span>
                <span class="ms-2">{{ $enterprise->responsible_phone ?: '---' }}</span>
              </div>
              <div class="d-flex align-items-center mb-2">
                <ion-icon name="person-circle-outline" class="me-2"
                  style="font-size:1.2rem;color:#8ee4af;"></ion-icon>
                <span class="text-muted">Usuário Responsável:</span>
                <span class="ms-2">{{ $enterprise->user?->name ?? '-' }}</span>
              </div>
            </div>
          </div>
          <div class="d-flex gap-2 justify-content-end mt-3">
            <a href="{{ route('enterprises.edit', $enterprise) }}" class="btn btn-primary btn-lg px-4">
              <ion-icon name="create-outline"></ion-icon> Editar
            </a>
            <form method="POST" action="{{ route('enterprises.destroy', $enterprise) }}" class="d-inline">
              @csrf
              @method('DELETE')
              <button type="submit" class="btn btn-danger btn-lg px-4"
                onclick="return confirm('Deseja realmente excluir esta empresa?')">
                <ion-icon name="trash-outline"></ion-icon> Excluir
              </button>
            </form>
          </div>
        </div>

        <!-- Aba Filiais -->
        <div class="tab-pane fade" id="filiais" role="tabpanel">
          <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="mb-0">Filiais</h5>
            <a href="{{ route('branches.create', ['enterprise_id' => $enterprise->id]) }}"
              class="btn btn-success btn-sm">
              <ion-icon name="add-outline"></ion-icon> Nova Filial
            </a>
          </div>
          <div class="table-responsive">
            <table class="table align-middle pastel-table">
              <thead>
                <tr>
                  <th>Nome</th>
                  <th>Cidade</th>
                  <th>Status</th>
                  <th class="text-end">Ações</th>
                </tr>
              </thead>
              <tbody>
                @forelse($enterprise->branches as $branch)
                  <tr>
                    <td>{{ $branch->name }}</td>
                    <td>{{ $branch->city }}</td>
                    <td>
                      <span class="badge {{ $branch->status === 'active' ? 'badge-success' : 'badge-secondary' }}">
                        {{ translate_status($branch->status) }}
                      </span>
                    </td>
                    <td class="text-end">
                      <a href="{{ route('branches.edit', $branch) }}" class="btn btn-edit btn-sm">
                        <ion-icon name="create-outline"></ion-icon>
                      </a>
                      <form action="{{ route('branches.destroy', $branch) }}" method="POST" class="d-inline">
                        @csrf @method('DELETE')
                        <button class="btn btn-danger btn-sm" onclick="return confirm('Excluir filial?')">
                          <ion-icon name="trash-outline"></ion-icon>
                        </button>
                      </form>
                    </td>
                  </tr>
                @empty
                  <tr>
                    <td colspan="4" class="text-center">Nenhuma filial cadastrada.</td>
                  </tr>
                @endforelse
              </tbody>
            </table>
          </div>
        </div>

        <!-- Aba Preços (SolicitationPricing) -->
        <div class="tab-pane fade" id="precos" role="tabpanel">
          <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="mb-0">Preços</h5>
            <a href="{{ route('solicitation-pricings.create', ['enterprise_id' => $enterprise->id]) }}"
              class="btn btn-success btn-sm">
              <ion-icon name="add-outline"></ion-icon> Nova Regra de Preço
            </a>
          </div>
          <div class="table-responsive">
            <table class="table align-middle pastel-table">
              <thead>
                <tr>
                  <th>Descrição</th>
                  <th>Valor</th>
                  <th>Vigência</th>
                  <th class="text-end">Ações</th>
                </tr>
              </thead>
              <tbody>
                @forelse($enterprise->solicitationPricings as $pricing)
                  <tr>
                    <td>{{ $pricing->description }}</td>
                    <td>R$ {{ number_format($pricing->value, 2, ',', '.') }}</td>
                    <td>
                      {{ $pricing->start_date }}
                      @if ($pricing->end_date)
                        - {{ $pricing->end_date }}
                      @else
                        - Atual
                      @endif
                    </td>
                    <td class="text-end">
                      <a href="{{ route('solicitation-pricings.edit', $pricing) }}" class="btn btn-edit btn-sm">
                        <ion-icon name="create-outline"></ion-icon>
                      </a>
                      <form action="{{ route('solicitation-pricings.destroy', $pricing) }}" method="POST"
                        class="d-inline">
                        @csrf @method('DELETE')
                        <button class="btn btn-danger btn-sm" onclick="return confirm('Excluir regra de preço?')">
                          <ion-icon name="trash-outline"></ion-icon>
                        </button>
                      </form>
                    </td>
                  </tr>
                @empty
                  <tr>
                    <td colspan="4" class="text-center">Nenhuma regra de preço cadastrada.</td>
                  </tr>
                @endforelse
              </tbody>
            </table>
          </div>
        </div>
      </div>
      <!-- Botão Voltar para mobile -->
      <a href="{{ route('enterprises.index') }}" class="btn btn-secondary btn-lg d-md-none w-100 mt-4">
        <ion-icon name="arrow-back-outline"></ion-icon> Voltar
      </a>
    </div>
  </div>
@endsection
