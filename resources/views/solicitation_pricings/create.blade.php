@extends('layouts.app')
@section('title', 'Nova Regra de Preço')

@section('content')
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb bg-transparent p-0">
      <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
      <li class="breadcrumb-item"><a href="{{ route('solicitation-pricings.index') }}">Regras de Preço</a></li>
      <li class="breadcrumb-item active" aria-current="page">Nova Regra</li>
    </ol>
  </nav>

  <div class="d-flex justify-content-center">
    <div class="enterprise-form-card p-md-5 rounded-4 w-100">
      <h1 class="mb-3 text-center">Nova Regra de Preço</h1>
      <form method="POST" action="{{ route('solicitation-pricings.store') }}">
        @csrf
        @include('solicitation_pricings._form')
      </form>
    </div>
  </div>
@endsection
