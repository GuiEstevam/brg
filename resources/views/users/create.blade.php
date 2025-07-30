@extends('layouts.app')
@section('title', 'Novo Usuário')

@section('content')
  <nav aria-label="breadcrumb" class="mb-3">
    <ol class="breadcrumb bg-transparent p-0">
      <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
      <li class="breadcrumb-item active" aria-current="page">Novo Usuário</li>
    </ol>
  </nav>

  <div class="d-flex justify-content-center">
    <div class="enterprise-form-card w-100">
      <h1 class="mb-4 text-center">Novo Usuário</h1>
      <form method="POST" action="{{ route('users.store') }}">
        @csrf
        @include('users._form')
      </form>
    </div>
  </div>
@endsection
