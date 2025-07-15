@extends('layouts.app')
@section('title', 'Empresas')

@section('content')
  <nav aria-label="breadcrumb" class="mb-3">
    <ol class="breadcrumb bg-transparent p-0">
      <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
      <li class="breadcrumb-item active" aria-current="page">Empresas</li>
    </ol>
  </nav>

  <h1 class="mb-4 fw-bold enterprise-title">Empresas</h1>

  <!-- Dashboard Cards -->
  <div class="row mb-4">
    <div class="col-md-4">
      <div class="dashboard-metric-card">
        <span class="dashboard-icon">
          <ion-icon name="business-outline"></ion-icon>
        </span>
        <div>
          <div class="dashboard-metric">{{ $enterprises->total() }}</div>
          <div class="dashboard-label">Total de Empresas</div>
        </div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="dashboard-metric-card">
        <span class="dashboard-icon" style="color: #4cd137;">
          <ion-icon name="checkmark-circle-outline"></ion-icon>
        </span>
        <div>
          <div class="dashboard-metric">
            {{ $enterprises->where('status', 'active')->count() }}
          </div>
          <div class="dashboard-label">Empresas Ativas</div>
        </div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="dashboard-metric-card">
        <span class="dashboard-icon" style="color: #8e2636;">
          <ion-icon name="close-circle-outline"></ion-icon>
        </span>
        <div>
          <div class="dashboard-metric">
            {{ $enterprises->where('status', 'inactive')->count() }}
          </div>
          <div class="dashboard-label">Empresas Inativas</div>
        </div>
      </div>
    </div>
  </div>

  <!-- Filtros e Busca -->
  <div class="mb-3">
    <form method="GET" action="{{ route('enterprises.index') }}" class="row g-2 align-items-center">
      <div class="col-md-4">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Buscar por nome ou CNPJ"
          class="form-control" aria-label="Buscar por nome ou CNPJ">
      </div>
      <div class="col-md-3">
        <select name="status" class="form-select" aria-label="Filtrar por status">
          <option value="">-- Status --</option>
          <option value="active" @selected(request('status') == 'active')>Ativa</option>
          <option value="inactive" @selected(request('status') == 'inactive')>Inativa</option>
        </select>
      </div>
      <div class="col-md-5 text-end">
        <button type="submit" class="btn btn-primary">Filtrar</button>
        <a href="{{ route('enterprises.create') }}" class="btn btn-success ms-2">Nova Empresa</a>
      </div>
    </form>
  </div>

  <!-- Tabela de Empresas -->
  <div class="table-responsive">
    <table class="table align-middle">
      <thead>
        <tr>
          <th>#</th>
          <th>Nome</th>
          <th>CNPJ</th>
          <th>Status</th>
          <th class="text-center">Ações</th>
        </tr>
      </thead>
      <tbody>
        @forelse($enterprises as $enterprise)
          <tr class="table-row-clickable" onclick="window.location='{{ route('enterprises.show', $enterprise) }}';"
            style="cursor:pointer;">
            <td>{{ $enterprise->id }}</td>
            <td>{{ $enterprise->name }}</td>
            <td>{{ $enterprise->cnpj }}</td>
            <td>
              <span class="badge {{ $enterprise->status === 'active' ? 'badge-success' : 'badge-secondary' }}">
                {{ translate_status($enterprise->status) }}
              </span>
            </td>
            <td class="text-center">
              <a href="{{ route('enterprises.edit', $enterprise) }}" class="btn btn-edit me-1" title="Editar"
                onclick="event.stopPropagation();">
                <ion-icon name="create-outline"></ion-icon>
              </a>
              <button class="btn btn-danger btn-sm" data-bs-toggle="modal"
                data-bs-target="#deleteModal{{ $enterprise->id }}" title="Excluir" onclick="event.stopPropagation();">
                <ion-icon name="trash-outline"></ion-icon>
              </button>
              @include('enterprises._delete_modal', ['enterprise' => $enterprise])
            </td>
          </tr>
        @empty
          <tr>
            <td colspan="5" class="text-center">Nenhuma empresa encontrada.</td>
          </tr>
        @endforelse
      </tbody>
    </table>
  </div>

  {{ $enterprises->withQueryString()->links('pagination::bootstrap-5') }}
@endsection

@push('scripts')
  <script>
    // Opcional: realce de hover para linhas clicáveis
    document.querySelectorAll('.table-row-clickable').forEach(row => {
      row.addEventListener('mouseover', () => row.classList.add('table-row-hover'));
      row.addEventListener('mouseout', () => row.classList.remove('table-row-hover'));
    });
  </script>
@endpush
