@extends('layouts.app')
@section('title', 'Editar Veículo')

@section('content')
  <nav aria-label="breadcrumb" class="mb-3">
    <ol class="breadcrumb bg-transparent p-0">
      <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
      <li class="breadcrumb-item"><a href="{{ route('vehicles.index') }}">Veículos</a></li>
      <li class="breadcrumb-item active" aria-current="page">Editar Veículo</li>
    </ol>
  </nav>

  <div class="d-flex justify-content-center">
    <div class="enterprise-form-card w-100">
      <h1 class="mb-4 text-center">Editar Veículo</h1>
      <form method="POST" action="{{ route('vehicles.update', $vehicle) }}">
        @csrf
        @method('PUT')
        @include('vehicles._form')
      </form>
    </div>
  </div>
@endsection
