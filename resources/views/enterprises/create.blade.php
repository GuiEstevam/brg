@extends('layouts.app')
@section('title', 'Nova Empresa')

@section('content')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb bg-transparent p-0">
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('enterprises.index') }}">Empresas</a></li>
        <li class="breadcrumb-item active" aria-current="page">Nova Empresa</li>
    </ol>
</nav>

<div class="d-flex justify-content-center">
    <div class="enterprise-form-card p-4 p-md-5 rounded-4 w-100">
        <h1 class="mb-4 text-center">Nova empresa</h1>
        <form method="POST" action="{{ route('enterprises.store') }}">
            @csrf
            @include('enterprises._form')
        </form>
    </div>
</div>
@endsection
