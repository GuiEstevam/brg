@extends('layouts.guest')
@section('title', 'Selecionar Filial')

@section('content')
  <div class="container d-flex flex-column justify-content-center align-items-center">
    <div class="text-center mb-4">
      <img src="{{ asset('img/logo.png') }}" alt="Logo BRG" id="logo-light" class="logo-switch login-logo">
      <img src="{{ asset('img/logo-dark.png') }}" alt="Logo BRG Dark" id="logo-dark" class="logo-switch login-logo d-none">
    </div>
    <div class="card login-card shadow-sm p-4" style="min-width: 360px; max-width: 440px;">
      <h2 class="login-title mb-1 fw-bold text-center">Selecione a filial</h2>
      <p class="text-center text-muted mb-3">Empresa: <strong>{{ $empresa->name }}</strong></p>
      <form method="POST" action="{{ route('context.set-filial') }}">
        @csrf
        <div class="mb-3">
          <label class="form-label">Filial</label>
          <select name="filial_id" class="form-select" required>
            <option value="" disabled selected>Escolha uma filial</option>
            @foreach ($filiais as $filial)
              <option value="{{ $filial->id }}">{{ $filial->name }}</option>
            @endforeach
          </select>
        </div>
        <button type="submit" class="btn btn-primary w-100 fw-bold">Entrar</button>
      </form>
      <form method="POST" action="{{ route('context.trocar') }}" class="mt-3 text-center">
        @csrf
        <button class="btn btn-link">Trocar empresa</button>
      </form>
      <form method="POST" action="{{ route('logout') }}" class="mt-2 text-center">
        @csrf
        <button class="btn btn-link btn-sm">Sair</button>
      </form>
    </div>
  </div>
@endsection
