@extends('layouts.guest')
@section('title', 'Cadastro')

@push('styles')
  <link rel="stylesheet" href="{{ asset('css/login.css') }}">
@endpush

@section('content')
  <div class="container d-flex flex-column justify-content-center align-items-center">
    <div class="text-center mb-4">
      <!-- Logo clara -->
      <img src="{{ asset('img/logo.png') }}" alt="Logo BRG" id="logo-light" class="logo-switch login-logo">
      <!-- Logo escura -->
      <img src="{{ asset('img/logo-dark.png') }}" alt="Logo BRG Dark" id="logo-dark" class="logo-switch login-logo d-none">
    </div>

    <div class="card login-card shadow-sm p-4">
      <h2 class="login-title mb-3 fw-bold text-center">Criar Conta</h2>

      <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Nome -->
        <div class="mb-3">
          <label for="name" class="form-label">Nome</label>
          <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name"
            value="{{ old('name') }}" required autocomplete="name" autofocus>
          @error('name')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>

        <!-- Email -->
        <div class="mb-3">
          <label for="email" class="form-label">E-mail</label>
          <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email"
            value="{{ old('email') }}" required autocomplete="email">
          @error('email')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>

        <!-- Senha -->
        <div class="mb-3">
          <label for="password" class="form-label">Senha</label>
          <input id="password" type="password" class="form-control @error('password') is-invalid @enderror"
            name="password" required autocomplete="new-password">
          @error('password')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>

        <!-- Confirmação de senha -->
        <div class="mb-3">
          <label for="password_confirmation" class="form-label">Confirmar Senha</label>
          <input id="password_confirmation" type="password" class="form-control" name="password_confirmation" required
            autocomplete="new-password">
        </div>

        <!-- Botão -->
        <button type="submit" class="btn btn-primary w-100 fw-bold login-btn">
          Cadastrar
        </button>

        <!-- Link para login -->
        <div class="text-center mt-3">
          <a href="{{ route('login') }}" class="login-link">Já tem uma conta? Entrar</a>
        </div>
      </form>
    </div>
  </div>
@endsection
