@extends('layouts.app')
@section('title', 'Editar Documento')

@section('content')
  <nav aria-label="breadcrumb" class="mb-3">
    <ol class="breadcrumb bg-transparent p-0">
      <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
      <li class="breadcrumb-item"><a href="{{ route('documents.index') }}">Documentos</a></li>
      <li class="breadcrumb-item active" aria-current="page">Editar Documento</li>
    </ol>
  </nav>

  <div class="d-flex justify-content-center">
    <div class="enterprise-form-card w-100">
      <h1 class="mb-4 text-center">Editar Documento</h1>
      <form method="POST" action="{{ route('documents.update', $document) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        @include('documents._form')
      </form>
    </div>
  </div>
@endsection
