@extends('layouts.app')
@section('title', 'Papéis e Permissões')

@section('content')
  <nav aria-label="breadcrumb" class="mb-3">
    <ol class="breadcrumb bg-transparent p-0">
      <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
      <li class="breadcrumb-item active" aria-current="page">Permissões</li>
    </ol>
  </nav>

  <h1 class="mb-4 text-center">Gerenciamento de Papéis e Permissões</h1>

  <div class="mb-4 text-end">
    <a href="{{ route('permissions.create') }}" class="btn btn-success">
      <i class="bi bi-plus-lg"></i> Novo Papel
    </a>
  </div>

  <div class="table-responsive">
    <table class="table align-middle">
      <thead>
        <tr>
          <th>#</th>
          <th>Papel</th>
          <th>Empresa/Global</th>
          <th>Permissões</th>
          <th class="text-center">Ações</th>
        </tr>
      </thead>
      <tbody>
        @forelse($roles as $role)
          <tr>
            <td>{{ $role->id }}</td>
            <td><strong>{{ ucfirst($role->name) }}</strong></td>
            <td>
              @if ($role->team_id)
                {{ optional($enterprises->firstWhere('id', $role->team_id))->name ?? '-' }}
              @else
                <span class="badge badge-secondary">Global</span>
              @endif
            </td>
            <td>
              @if ($role->permissions->count())
                @foreach ($role->permissions as $perm)
                  <span class="badge bg-info me-1">{{ $perm->name }}</span>
                @endforeach
              @else
                <span class="text-muted">Sem permissões</span>
              @endif
            </td>
            <td class="text-center">
              <a href="{{ route('permissions.edit', $role) }}" class="btn btn-edit me-1" title="Editar">
                <ion-icon name="create-outline"></ion-icon>
              </a>
              <button class="btn btn-danger btn-sm" data-bs-toggle="modal"
                data-bs-target="#deleteModal{{ $role->id }}" title="Excluir">
                <ion-icon name="trash-outline"></ion-icon>
              </button>
              @include('permissions._delete_modal', ['role' => $role])
            </td>
          </tr>
        @empty
          <tr>
            <td colspan="5" class="text-center">Nenhum papel encontrado.</td>
          </tr>
        @endforelse
      </tbody>
    </table>
  </div>
@endsection
