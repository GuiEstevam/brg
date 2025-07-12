@extends('layouts.app')
@section('title', 'Editar Regra de Preço')

@section('content')
  <nav aria-label="breadcrumb" class="mb-3">
    <ol class="breadcrumb bg-transparent p-0">
      <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
      <li class="breadcrumb-item"><a href="{{ route('solicitation-pricings.index') }}">Regras de Preço</a></li>
      <li class="breadcrumb-item active" aria-current="page">Editar Regra</li>
    </ol>
  </nav>

  <div class="d-flex justify-content-center">
    <div class="enterprise-form-card p-4 p-md-5 rounded-4 w-100">
      <h1 class="mb-4 text-center">Editar Regra de Preço</h1>
      <form method="POST" action="{{ route('solicitation-pricings.update', $solicitationPricing) }}">
        @csrf
        @method('PUT')
        @include('solicitation_pricings._form')
      </form>
    </div>
  </div>
@endsection
