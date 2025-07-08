@extends('layouts.app')

@section('title', 'Bem-vindo')

@section('content')
<div class="d-flex flex-column justify-content-center align-items-center py-5">
    <div class="mb-4">
        <img src="{{ asset('img/logo.png') }}" alt="Logo do Sistema" id="logo-light-welcome" class="logo-switch" style="max-width: 180px;">
        <img src="{{ asset('img/logo-dark.png') }}" alt="Logo do Sistema" id="logo-dark-welcome" class="logo-switch d-none" style="max-width: 180px;">
    </div>
    <h1 class="mb-3">Bem-vindo ao Sistema de Gestão</h1>
    <p class="lead mb-4 text-center">
        Gerencie empresas, motoristas, veículos, documentos e solicitações de forma simples, segura e eficiente.<br>
        Acesse o painel para começar.
    </p>
    @auth
        <a href="{{ route('dashboard') }}" class="btn btn-primary btn-lg">Acessar Dashboard</a>
    @else
        <div class="d-flex flex-column flex-md-row gap-2">
            <a href="{{ route('login') }}" class="btn btn-primary btn-lg">Entrar</a>
            @if (Route::has('register'))
                <a href="{{ route('register') }}" class="btn btn-outline-secondary btn-lg">Criar Conta</a>
            @endif
        </div>
    @endauth
</div>
@endsection
