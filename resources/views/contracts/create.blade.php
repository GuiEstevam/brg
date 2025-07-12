@extends('layouts.app')
@section('title', 'Novo Contrato')

@section('content')
  <nav aria-label="breadcrumb" class="mb-3">
    <ol class="breadcrumb bg-transparent p-0">
      <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
      <li class="breadcrumb-item"><a href="{{ route('contracts.index') }}">Contratos</a></li>
      <li class="breadcrumb-item active" aria-current="page">Novo Contrato</li>
    </ol>
  </nav>

  <div class="d-flex justify-content-center">
    <div class="enterprise-form-card w-100">
      <h1 class="mb-4 text-center">Novo Contrato</h1>
      <form method="POST" action="{{ route('contracts.store') }}" enctype="multipart/form-data">
        @csrf
        @include('contracts._form')
      </form>
    </div>
  </div>
@endsection
