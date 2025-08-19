@extends('layouts.guest')
@section('title', 'Selecionar Empresa')

@section('content')
  <div class="container d-flex flex-column justify-content-center align-items-center">
    <div class="text-center mb-4">
      <img src="{{ asset('img/logo.png') }}" alt="Logo BRG" id="logo-light" class="logo-switch login-logo">
      <img src="{{ asset('img/logo-dark.png') }}" alt="Logo BRG Dark" id="logo-dark" class="logo-switch login-logo d-none">
    </div>
    <div class="card login-card shadow-sm p-4" style="min-width: 360px; max-width: 440px;">
      <h2 class="login-title mb-3 fw-bold text-center">Selecione a empresa</h2>
      <form method="POST" action="{{ route('context.set-empresa') }}">
        @csrf
        <div class="mb-3">
          <label class="form-label">Empresa</label>
          <select name="empresa_id" class="form-select" required>
            <option value="" disabled selected>Escolha uma empresa</option>
            @foreach ($empresas as $empresa)
              <option value="{{ $empresa->id }}">{{ $empresa->name }}</option>
            @endforeach
          </select>
        </div>
        <button type="submit" class="btn btn-primary w-100 fw-bold">Continuar</button>
      </form>
      <form method="POST" action="{{ route('logout') }}" class="mt-3 text-center">
        @csrf
        <button class="btn btn-link">Sair</button>
      </form>
    </div>
  </div>
@endsection
