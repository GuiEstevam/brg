@extends('layouts.guest')
@section('title', 'Login')

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
      <h2 class="login-title mb-3 fw-bold text-center">Acesso ao Sistema</h2>

      <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email -->
        <div class="mb-3">
          <label for="email" class="form-label">E-mail</label>
          <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email"
            value="{{ old('email') }}" required autocomplete="email" autofocus>
          @error('email')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>

        <!-- Senha -->
        <div class="mb-3">
          <label for="password" class="form-label">Senha</label>
          <input id="password" type="password" class="form-control @error('password') is-invalid @enderror"
            name="password" required autocomplete="current-password">
          @error('password')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>

        <!-- Lembrar-me e link -->
        <div class="mb-3 d-flex justify-content-between align-items-center">
          <div class="form-check">
            <input class="form-check-input" type="checkbox" name="remember" id="remember"
              {{ old('remember') ? 'checked' : '' }}>
            <label class="form-check-label" for="remember">
              Lembrar-me
            </label>
          </div>
          <a href="{{ route('password.request') }}" class="login-link">
            Esqueceu a senha?
          </a>
        </div>

        <!-- Botão -->
        <button type="submit" class="btn btn-primary w-100 fw-bold login-btn">
          Entrar
        </button>
      </form>
    </div>
  </div>
@endsection
