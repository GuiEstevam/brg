@extends('layouts.app')
@section('title', 'Usuários')

@section('content')
  <h1 class="mb-3">Usuários</h1>

  <div class="mb-3">
    <form method="GET" action="{{ route('users.index') }}" class="row g-2 align-items-center">
      <div class="col-md-4">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Buscar por nome ou e-mail"
          class="form-control">
      </div>
      <div class="col-md-3">
        <select name="role" class="form-select">
          <option value="">-- Perfil --</option>
          @foreach ($roles as $role)
            <option value="{{ $role->name }}" @selected(request('role') == $role->name)>{{ ucfirst($role->name) }}</option>
          @endforeach
        </select>
      </div>
      <div class="col-md-5 text-end">
        <button type="submit" class="btn btn-primary">Filtrar</button>
        <a href="{{ route('users.create') }}" class="btn btn-success ms-2">Novo Usuário</a>
      </div>
    </form>
  </div>

  <div class="table-responsive">
    <table class="table table-bordered table-hover align-middle">
      <thead class="table-light">
        <tr>
          <th>#</th>
          <th>Nome</th>
          <th>E-mail</th>
          <th>Perfil</th>
          <th class="text-center">Ações</th>
        </tr>
      </thead>
      <tbody>
        @forelse($users as $user)
          <tr>
            <td>{{ $user->id }}</td>
            <td>
              <a href="{{ route('users.show', $user) }}">
                {{ $user->name }}
              </a>
            </td>
            <td>{{ $user->email }}</td>
            <td>
              <span class="badge bg-info text-dark">
                {{ $user->getRoleNames()->implode(', ') }}
              </span>
            </td>
            <td class="text-center">
              <a href="{{ route('users.edit', $user) }}" class="btn btn-sm btn-warning">Editar</a>
              <button class="btn btn-sm btn-danger" data-bs-toggle="modal"
                data-bs-target="#deleteModal{{ $user->id }}">Excluir</button>
              @include('users._delete_modal', ['user' => $user])
            </td>
          </tr>
        @empty
          <tr>
            <td colspan="5" class="text-center">Nenhum usuário encontrado.</td>
          </tr>
        @endforelse
      </tbody>
    </table>
  </div>

  {{ $users->withQueryString()->links() }}
@endsection
