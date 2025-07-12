@extends('layouts.app')
@section('title', 'Editar Contrato')

@section('content')
  <nav aria-label="breadcrumb" class="mb-3">
    <ol class="breadcrumb bg-transparent p-0">
      <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
      <li class="breadcrumb-item"><a href="{{ route('contracts.index') }}">Contratos</a></li>
      <li class="breadcrumb-item active" aria-current="page">Editar Contrato</li>
    </ol>
  </nav>

  <div class="d-flex justify-content-center">
    <div class="enterprise-form-card w-100">
      <h1 class="mb-4 text-center">Editar Contrato</h1>
      <form method="POST" action="{{ route('contracts.update', $contract) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        @include('contracts._form')
      </form>
    </div>
  </div>
@endsection
