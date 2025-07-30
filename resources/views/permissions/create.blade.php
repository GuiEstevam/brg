@extends('layouts.app')
@section('title', 'Novo Papel')

@section('content')
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb bg-transparent p-0">
      <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
      <li class="breadcrumb-item"><a href="{{ route('permissions.index') }}">Permissões</a></li>
      <li class="breadcrumb-item active" aria-current="page">Novo Papel</li>
    </ol>
  </nav>

  <div class="d-flex justify-content-center">
    <div class="enterprise-form-card p-4 p-md-5 rounded-4 w-100">
      <h1 class="mb-4 text-center">Novo Papel</h1>
      <form method="POST" action="{{ route('permissions.store') }}">
        @csrf
        @include('permissions._form')
      </form>
    </div>
  </div>
@endsection
