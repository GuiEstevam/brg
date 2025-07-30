@extends('layouts.app')
@section('title', 'Editar Usuário')

@section('content')
  <nav aria-label="breadcrumb" class="mb-3">
    <ol class="breadcrumb bg-transparent p-0">
      <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
      <li class="breadcrumb-item"><a href="{{ route('users.index') }}">Usuários</a></li>
      <li class="breadcrumb-item active" aria-current="page">Editar Usuário</li>
    </ol>
  </nav>

  <div class="d-flex justify-content-center">
    <div class="enterprise-form-card w-100">
      <h1 class="mb-4 text-center">Editar Usuário</h1>
      <form method="POST" action="{{ route('users.update', $user) }}">
        @csrf
        @method('PUT')
        @include('users._form')
      </form>
    </div>
  </div>
@endsection
