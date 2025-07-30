@extends('layouts.app')
@section('title', 'Editar Papel')

@section('content')
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb bg-transparent p-0">
      <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
      <li class="breadcrumb-item"><a href="{{ route('roles.index') }}">Papéis</a></li>
      <li class="breadcrumb-item active" aria-current="page">Editar Papel</li>
    </ol>
  </nav>

  <div class="d-flex justify-content-center">
    <div class="enterprise-form-card p-md-3 shadow-sm rounded-4 w-100">
      <h1 class="mb-4 text-center">Editar Papel</h1>
      <form method="POST" action="{{ route('roles.update', $role) }}">
        @csrf
        @method('PUT')
        @include('roles._form')
      </form>
    </div>
  </div>
@endsection
