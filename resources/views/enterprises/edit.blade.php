@extends('layouts.app')
@section('title', 'Editar Empresa')

@section('content')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb bg-transparent p-0">
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('enterprises.index') }}">Empresas</a></li>
        <li class="breadcrumb-item active" aria-current="page">Editar Empresa</li>
    </ol>
</nav>

<div class="d-flex justify-content-center">
    <div class="enterprise-form-card p-md-3 shadow-sm rounded-4 w-100">
        <h1 class="mb-4 text-center">Editar Empresa</h1>
        <form method="POST" action="{{ route('enterprises.update', $enterprise) }}">
            @csrf
            @method('PUT')
            @include('enterprises._form')
        </form>
    </div>
</div>
@endsection
