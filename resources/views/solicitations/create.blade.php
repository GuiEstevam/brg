@extends('layouts.app')
@section('title', 'Nova Solicitação')

@section('content')
  <nav aria-label="breadcrumb" class="mb-3">
    <ol class="breadcrumb bg-transparent p-0">
      <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
      <li class="breadcrumb-item"><a href="{{ route('solicitations.index') }}">Solicitações</a></li>
      <li class="breadcrumb-item active" aria-current="page">Nova Solicitação</li>
    </ol>
  </nav>

  <div class="d-flex justify-content-center">
    <div class="enterprise-form-card w-100">
      <h1 class="mb-4 text-center">Nova Solicitação</h1>
      <form method="POST" action="{{ route('solicitations.store') }}">
        @csrf
        @include('solicitations._form')
      </form>
    </div>
  </div>
@endsection
