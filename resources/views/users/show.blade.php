@extends('layouts.app')
@section('title', 'Detalhes do Usuário')

@section('content')
  <nav aria-label="breadcrumb" class="mb-3">
    <ol class="breadcrumb bg-transparent p-0">
      <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
      <li class="breadcrumb-item"><a href="{{ route('users.index') }}">Usuários</a></li>
      <li class="breadcrumb-item active" aria-current="page">Exibir Usuário</li>
    </ol>
  </nav>

  <div class="enterprise-form-card p-4 p-md-5 shadow-sm rounded-4 w-100 mx-auto" style="max-width: 1050px;">
    <div class="mb-3 d-flex flex-wrap align-items-center justify-content-between gap-2">
      <h1 class="mb-0 fw-bold">
        <ion-icon name="person-circle-outline" style="color: #8e2636; font-size:1.7em; vertical-align:middle"></ion-icon>
        {{ $user->name }}
      </h1>
      <span class="badge rounded-pill {{ status_badge_class($user->status) }} px-4 py-2 fs-6">
        {{ translate_status($user->status) }}
      </span>
    </div>
    <div class="row mb-4">
      <div class="col-md-6">
        <div class="text-muted mb-1">
          <ion-icon name="mail-outline"></ion-icon> {{ $user->email }}
        </div>
      </div>
      <div class="col-md-6 text-md-end">
        <small class="text-muted">Criado em {{ $user->created_at->format('d/m/Y H:i') }}</small>
        <span class="mx-2">|</span>
        <small class="text-muted">Atualizado em {{ $user->updated_at->format('d/m/Y H:i') }}</small>
      </div>
    </div>

    {{-- ABAS --}}
    <ul class="nav nav-tabs mb-4" role="tablist">
      <li class="nav-item" role="presentation">
        <button class="nav-link active" id="tab-perfil" data-bs-toggle="tab" data-bs-target="#perfil" type="button"
          role="tab">
          <ion-icon name="person-outline"></ion-icon> Perfil
        </button>
      </li>
      <li class="nav-item" role="presentation">
        <button class="nav-link" id="tab-entidades" data-bs-toggle="tab" data-bs-target="#entidades" type="button"
          role="tab">
          <ion-icon name="business-outline"></ion-icon> Empresas & Filiais
        </button>
      </li>
      <li class="nav-item" role="presentation">
        <button class="nav-link" id="tab-roles" data-bs-toggle="tab" data-bs-target="#roles" type="button"
          role="tab">
          <ion-icon name="person-badge-outline"></ion-icon> Papéis
        </button>
      </li>
    </ul>
    <div class="tab-content">

      <!-- Aba Perfil -->
      <div class="tab-pane fade show active" id="perfil" role="tabpanel">
        <div class="row mb-3">
          <div class="col-md-6">
            <label class="fw-semibold text-muted mb-0">Nome</label><br>
            <span class="fs-5">{{ $user->name }}</span>
          </div>
          <div class="col-md-6">
            <label class="fw-semibold text-muted mb-0">E-mail</label><br>
            <span class="fs-6">{{ $user->email }}</span>
          </div>
        </div>
        <div class="row mb-3">
          <div class="col-md-6 mb-2">
          </div>
        </div>
      </div>

      <!-- Aba Empresas & Filiais -->
      <div class="tab-pane fade" id="entidades" role="tabpanel">
        <div class="row g-4">
          <div class="col-md-6">
            <h6 class="fw-semibold mb-2">
              <ion-icon name="business-outline"></ion-icon> Empresas Associadas
            </h6>
            @forelse ($user->enterprises as $enterprise)
              <div class="mb-1">
                <ion-icon name="chevron-forward-outline" class="me-1"></ion-icon> {{ $enterprise->name }}
              </div>
            @empty
              <div class="text-muted">Nenhuma empresa vinculada</div>
            @endforelse
          </div>
          <div class="col-md-6">
            <h6 class="fw-semibold mb-2">
              <ion-icon name="git-branch-outline"></ion-icon> Filiais Associadas
            </h6>
            @if ($user->branches->count())
              @foreach ($user->branches->groupBy('enterprise_id') as $enterpriseId => $branches)
                <span class="fw-semibold text-primary">{{ $branches->first()->enterprise->name ?? 'Empresa' }}</span>
                <ul class="mb-2 ps-3">
                  @foreach ($branches as $branch)
                    <li><ion-icon name="ellipse-outline" style="font-size:0.9em;"
                        class="me-1"></ion-icon>{{ $branch->name }}</li>
                  @endforeach
                </ul>
              @endforeach
            @else
              <div class="text-muted">Nenhuma filial vinculada</div>
            @endif
          </div>
        </div>
      </div>

      <!-- Aba Papéis -->
      <div class="tab-pane fade" id="roles" role="tabpanel">
        <h6 class="fw-semibold mb-2"><ion-icon name="person-badge-outline"></ion-icon> Papéis/Vínculos Globais</h6>
        @php
          $roleNames = $user->getRoleNames();
        @endphp
        @if ($roleNames->count())
          @foreach ($roleNames as $role)
            <span class="badge badge-permission me-1">{{ ucfirst($role) }}</span>
          @endforeach
        @else
          <div class="text-muted">Nenhum papel atribuído</div>
        @endif
      </div>

    </div>

    <div class="d-flex gap-2 justify-content-end mt-4">
      <a href="{{ route('users.edit', $user) }}" class="btn btn-primary px-4" title="Editar">
        <ion-icon name="create-outline"></ion-icon>
      </a>
      <a href="{{ route('users.index') }}" class="btn btn-secondary px-4" title="Voltar à lista">
        <ion-icon name="arrow-back-outline"></ion-icon>
      </a>
    </div>
  </div>
@endsection
