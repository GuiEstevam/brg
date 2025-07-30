@extends('layouts.app')
@section('title', 'Detalhes do Papel/Papel e Permissões')

@section('content')
  <div class="container px-2 px-md-0">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-3">
      <ol class="breadcrumb bg-transparent p-0">
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('permissions.index') }}">Permissões</a></li>
        <li class="breadcrumb-item active" aria-current="page">{{ $role->name }}</li>
      </ol>
    </nav>

    <div class="enterprise-form-card p-4 p-md-5 shadow-sm rounded-4 w-100 mx-auto" style="max-width: 1100px;">
      <div class="d-flex justify-content-between align-items-center mb-2">
        <div class="d-flex align-items-center gap-3">
          <span style="font-size:2.2rem;color:#8ee4af;">
            <ion-icon name="shield-checkmark-outline"></ion-icon>
          </span>
          <div>
            <h1 class="mb-0">{{ ucfirst($role->name) }}</h1>
            <span class="badge {{ $role->team_id ? 'badge-primary' : 'badge-secondary' }}">
              {{ $role->team_id ? optional($enterprises->firstWhere('id', $role->team_id))->name ?? 'Empresa' : 'Global' }}
            </span>
          </div>
        </div>
        <a href="{{ route('permissions.index') }}"
          class="btn btn-secondary btn-lg d-none d-md-inline-flex align-items-center gap-2">
          <ion-icon name="arrow-back-outline"></ion-icon> Voltar
        </a>
      </div>
      <div class="mb-3">
        <small class="text-muted">
          Crud: {{ $role->created_at->format('d/m/Y H:i') }}
          @if ($role->updated_at != $role->created_at)
            &nbsp;|&nbsp; Alterado: {{ $role->updated_at->format('d/m/Y H:i') }}
          @endif
          &nbsp;|&nbsp; Guard: <span class="badge text-bg-light">{{ $role->guard_name }}</span>
        </small>
      </div>

      <ul class="nav nav-tabs mb-4" id="permissionTabs" role="tablist">
        <li class="nav-item" role="presentation">
          <button class="nav-link active" id="dados-tab" data-bs-toggle="tab" data-bs-target="#dados" type="button"
            role="tab">
            <ion-icon name="information-circle-outline"></ion-icon> Dados do Papel
          </button>
        </li>
        <li class="nav-item" role="presentation">
          <button class="nav-link" id="permissoes-tab" data-bs-toggle="tab" data-bs-target="#permissoes" type="button"
            role="tab">
            <ion-icon name="key-outline"></ion-icon> Permissões
          </button>
        </li>
        <li class="nav-item" role="presentation">
          <button class="nav-link" id="usuarios-tab" data-bs-toggle="tab" data-bs-target="#usuarios" type="button"
            role="tab">
            <ion-icon name="people-outline"></ion-icon> Usuários com esse Papel
          </button>
        </li>
      </ul>

      <div class="tab-content">
        <!-- Aba Dados -->
        <div class="tab-pane fade show active" id="dados" role="tabpanel">
          <div class="row g-3 mb-4">
            <div class="col-md-6">
              <div class="d-flex align-items-center mb-2">
                <ion-icon name="shield-checkmark-outline" class="me-2"
                  style="font-size:1.2rem;color:#8ee4af;"></ion-icon>
                <span class="text-muted">Nome:</span>
                <span class="ms-2 fw-semibold">{{ ucfirst($role->name) }}</span>
              </div>
              <div class="d-flex align-items-center mb-2">
                <ion-icon name="business-outline" class="me-2" style="font-size:1.2rem;color:#8ee4af;"></ion-icon>
                <span class="text-muted">Empresa:</span>
                <span class="ms-2 fw-semibold">
                  {{ $role->team_id ? optional($enterprises->firstWhere('id', $role->team_id))->name ?? 'Empresa' : 'Global' }}
                </span>
              </div>
              <div class="d-flex align-items-center mb-2">
                <ion-icon name="lock-open-outline" class="me-2" style="font-size:1.2rem;color:#8ee4af;"></ion-icon>
                <span class="text-muted">Atribuição:</span>
                <span class="ms-2">{{ $role->guard_name }}</span>
              </div>
            </div>
          </div>
          <div class="d-flex gap-2 justify-content-end mt-3">
            <a href="{{ route('permissions.edit', $role) }}" class="btn btn-primary btn-lg px-4">
              <ion-icon name="create-outline"></ion-icon> Editar
            </a>
            <form method="POST" action="{{ route('permissions.destroy', $role) }}" class="d-inline">
              @csrf
              @method('DELETE')
              <button type="submit" class="btn btn-danger btn-lg px-4"
                onclick="return confirm('Deseja realmente excluir este papel?')">
                <ion-icon name="trash-outline"></ion-icon> Excluir
              </button>
            </form>
          </div>
        </div>

        <!-- Aba Permissões -->
        <div class="tab-pane fade" id="permissoes" role="tabpanel">
          <div class="mb-3">
            <h5 class="fw-semibold"><ion-icon name="key-outline"></ion-icon> Permissões deste papel</h5>
            @if ($role->permissions->count())
              <div class="row g-2">
                @foreach ($role->permissions as $perm)
                  <div class="col-12 col-sm-6 col-md-4">
                    <span class="badge bg-info text-dark d-block px-3 py-2 mb-2">
                      <ion-icon name="checkmark-outline"></ion-icon>
                      {{ $perm->name }}
                    </span>
                  </div>
                @endforeach
              </div>
            @else
              <p class="text-muted">Nenhuma permissão atribuída a este papel.</p>
            @endif
          </div>
        </div>

        <!-- Aba Usuários -->
        <div class="tab-pane fade" id="usuarios" role="tabpanel">
          <div class="mb-3">
            <h5 class="fw-semibold"><ion-icon name="people-outline"></ion-icon> Usuários com este papel</h5>
            @php
              // Para mostrar usuários do papel: pode via relationship do Spatie ou query
              $usuarios = $role->users()->with('enterprises')->get();
            @endphp
            @if ($usuarios->count())
              <div class="table-responsive">
                <table class="table align-middle">
                  <thead>
                    <tr>
                      <th>Nome</th>
                      <th>Email</th>
                      <th>Empresa</th>
                      <th>Status</th>
                      <th>Ações</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($usuarios as $user)
                      <tr>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>
                          @foreach ($user->enterprises as $e)
                            <span class="badge bg-secondary me-1">{{ $e->name }}</span>
                          @endforeach
                        </td>
                        <td>
                          <span class="badge {{ $user->status === 'active' ? 'badge-success' : 'badge-secondary' }}">
                            {{ $user->status === 'active' ? 'Ativo' : 'Inativo' }}
                          </span>
                        </td>
                        <td>
                          <a href="{{ route('users.show', $user) }}" class="btn btn-sm btn-primary">Ver</a>
                        </td>
                      </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
            @else
              <p class="text-muted">Nenhum usuário possui este papel.</p>
            @endif
          </div>
        </div>
      </div>

      <!-- Botão Voltar para mobile -->
      <a href="{{ route('permissions.index') }}" class="btn btn-secondary btn-lg d-md-none w-100 mt-4">
        <ion-icon name="arrow-back-outline"></ion-icon> Voltar
      </a>
    </div>
  </div>
@endsection
