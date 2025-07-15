@extends('layouts.app')
@section('title', 'Novo Veículo')

@section('content')
  <nav aria-label="breadcrumb" class="mb-3">
    <ol class="breadcrumb bg-transparent p-0">
      <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
      <li class="breadcrumb-item"><a href="{{ route('vehicles.index') }}">Veículos</a></li>
      <li class="breadcrumb-item active" aria-current="page">Novo Veículo</li>
    </ol>
  </nav>

  <div class="d-flex justify-content-center">
    <div class="enterprise-form-card w-100">
      <h1 class="mb-4 text-center">Novo Veículo</h1>
      <form method="POST" action="{{ route('vehicles.store') }}">
        @csrf
        @include('vehicles._form')
      </form>
    </div>
  </div>
@endsection
