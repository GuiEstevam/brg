@extends('layouts.app')
@section('title', 'Detalhes da Filial')

@section('content')
  <div class="container px-2 px-md-0">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-3">
      <ol class="breadcrumb bg-transparent p-0">
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('branches.index') }}">Filiais</a></li>
        <li class="breadcrumb-item active" aria-current="page">{{ $branch->name }}</li>
      </ol>
    </nav>

    <div class="enterprise-form-card p-4 p-md-5 shadow-sm rounded-4 w-100 mx-auto" style="max-width: 1100px;">
      <div class="d-flex justify-content-between align-items-center mb-2">
        <div class="d-flex align-items-center gap-3">
          <span style="font-size:2.2rem;color:#8ee4af;">
            <ion-icon name="git-branch-outline"></ion-icon>
          </span>
          <div>
            <h1 class="mb-0">{{ $branch->name }}</h1>
            <span class="badge {{ $branch->status === 'active' ? 'badge-success' : 'badge-secondary' }}">
              {{ translate_status($branch->status) }}
            </span>
          </div>
        </div>
        <a href="{{ route('branches.index') }}"
          class="btn btn-secondary btn-lg d-none d-md-inline-flex align-items-center gap-2">
          <ion-icon name="arrow-back-outline"></ion-icon> Voltar
        </a>
      </div>
      <div class="mb-3">
        <small class="text-muted">
          Empresa: {{ $branch->enterprise->name ?? '-' }} &nbsp;|&nbsp;
          Cidade/UF: {{ $branch->city }}/{{ $branch->uf }} &nbsp;|&nbsp;
          Status: {{ ucfirst($branch->status) }}
        </small>
      </div>

      <ul class="nav nav-tabs mb-4" id="branchTabs" role="tablist">
        <li class="nav-item" role="presentation">
          <button class="nav-link active" id="dados-tab" data-bs-toggle="tab" data-bs-target="#dados" type="button"
            role="tab">
            <ion-icon name="information-circle-outline"></ion-icon> Dados
          </button>
        </li>
        <!-- Adicione outras abas se necessário, ex: Usuários, Solicitações -->
      </ul>

      <div class="tab-content">
        <!-- Aba Dados -->
        <div class="tab-pane fade show active" id="dados" role="tabpanel">
          <div class="row g-3 mb-4">
            <div class="col-md-6">
              <div class="d-flex align-items-center mb-2">
                <ion-icon name="business-outline" class="me-2" style="font-size:1.2rem;color:#8ee4af;"></ion-icon>
                <span class="text-muted">Empresa:</span>
                <span class="ms-2 fw-semibold">{{ $branch->enterprise->name ?? '-' }}</span>
              </div>
              <div class="d-flex align-items-center mb-2">
                <ion-icon name="location-outline" class="me-2" style="font-size:1.2rem;color:#8ee4af;"></ion-icon>
                <span class="text-muted">Endereço:</span>
                <span class="ms-2">{{ $branch->address }}, {{ $branch->number }} {{ $branch->complement }}</span>
              </div>
              <div class="d-flex align-items-center mb-2">
                <ion-icon name="home-outline" class="me-2" style="font-size:1.2rem;color:#8ee4af;"></ion-icon>
                <span class="text-muted">Bairro:</span>
                <span class="ms-2">{{ $branch->district }}</span>
              </div>
              <div class="d-flex align-items-center mb-2">
                <ion-icon name="business-outline" class="me-2" style="font-size:1.2rem;color:#8ee4af;"></ion-icon>
                <span class="text-muted">Cidade/UF:</span>
                <span class="ms-2">{{ $branch->city }}/{{ $branch->uf }}</span>
              </div>
              <div class="d-flex align-items-center mb-2">
                <ion-icon name="mail-outline" class="me-2" style="font-size:1.2rem;color:#8ee4af;"></ion-icon>
                <span class="text-muted">CEP:</span>
                <span class="ms-2">{{ $branch->cep }}</span>
              </div>
            </div>
            <div class="col-md-6">
              <div class="d-flex align-items-center mb-2">
                <ion-icon name="card-outline" class="me-2" style="font-size:1.2rem;color:#8ee4af;"></ion-icon>
                <span class="text-muted">CNPJ:</span>
                <span class="ms-2">{{ $branch->cnpj ?: '---' }}</span>
              </div>
              <div class="d-flex align-items-center mb-2">
                <ion-icon name="call-outline" class="me-2" style="font-size:1.2rem;color:#8ee4af;"></ion-icon>
                <span class="text-muted">Telefone:</span>
                <span class="ms-2">{{ $branch->phone ?: '---' }}</span>
              </div>
              <div class="d-flex align-items-center mb-2">
                <ion-icon name="mail-outline" class="me-2" style="font-size:1.2rem;color:#8ee4af;"></ion-icon>
                <span class="text-muted">Email:</span>
                <span class="ms-2">{{ $branch->email ?: '---' }}</span>
              </div>
            </div>
          </div>
          <div class="d-flex gap-2 justify-content-end mt-3">
            <a href="{{ route('branches.edit', $branch) }}" class="btn btn-primary btn-lg px-4">
              <ion-icon name="create-outline"></ion-icon> Editar
            </a>
            <form method="POST" action="{{ route('branches.destroy', $branch) }}" class="d-inline">
              @csrf
              @method('DELETE')
              <button type="submit" class="btn btn-danger btn-lg px-4"
                onclick="return confirm('Deseja realmente excluir esta filial?')">
                <ion-icon name="trash-outline"></ion-icon> Excluir
              </button>
            </form>
          </div>
        </div>
        <!-- Outras abas podem ser adicionadas aqui -->
      </div>
      <!-- Botão Voltar para mobile -->
      <a href="{{ route('branches.index') }}" class="btn btn-secondary btn-lg d-md-none w-100 mt-4">
        <ion-icon name="arrow-back-outline"></ion-icon> Voltar
      </a>
    </div>
  </div>
@endsection
