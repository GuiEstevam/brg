@extends('layouts.app')
@section('title', 'Contratos')

@section('content')
  <nav aria-label="breadcrumb" class="mb-3">
    <ol class="breadcrumb bg-transparent p-0">
      <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
      <li class="breadcrumb-item active" aria-current="page">Contratos</li>
    </ol>
  </nav>

  <h1 class="mb-4 fw-bold enterprise-title">Contratos</h1>

  <!-- Dashboard Cards -->
  <div class="row mb-4">
    <div class="col-md-4">
      <div class="dashboard-metric-card">
        <span class="dashboard-icon">
          <ion-icon name="document-text-outline"></ion-icon>
        </span>
        <div>
          <div class="dashboard-metric">{{ $contracts->total() }}</div>
          <div class="dashboard-label">Total de Contratos</div>
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
            {{ $contracts->where('status', 'active')->count() }}
          </div>
          <div class="dashboard-label">Contratos Ativos</div>
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
            {{ $contracts->where('status', 'inactive')->count() }}
          </div>
          <div class="dashboard-label">Contratos Inativos</div>
        </div>
      </div>
    </div>
  </div>

  <!-- Filtros e Busca -->
  <div class="mb-3">
    <form method="GET" action="{{ route('contracts.index') }}" class="row g-2 align-items-center">
      <div class="col-md-4">
        <input type="text" name="search" value="{{ request('search') }}"
          placeholder="Buscar por título, empresa ou filial" class="form-control"
          aria-label="Buscar por título, empresa ou filial">
      </div>
      <div class="col-md-3">
        <select name="enterprise_id" class="form-select" aria-label="Filtrar por empresa">
          <option value="">-- Empresa --</option>
          @foreach ($enterprises as $enterprise)
            <option value="{{ $enterprise->id }}" @selected(request('enterprise_id') == $enterprise->id)>
              {{ $enterprise->name }}
            </option>
          @endforeach
        </select>
      </div>
      <div class="col-md-2">
        <select name="status" class="form-select" aria-label="Filtrar por status">
          <option value="">-- Status --</option>
          <option value="active" @selected(request('status') == 'active')>Ativo</option>
          <option value="inactive" @selected(request('status') == 'inactive')>Inativo</option>
          <option value="canceled" @selected(request('status') == 'canceled')>Cancelado</option>
        </select>
      </div>
      <div class="col-md-3 text-end">
        <button type="submit" class="btn btn-primary">Filtrar</button>
        <a href="{{ route('contracts.create') }}" class="btn btn-success ms-2">Novo Contrato</a>
      </div>
    </form>
  </div>

  <!-- Tabela de Contratos -->
  <div class="table-responsive">
    <table class="table align-middle">
      <thead>
        <tr>
          <th>#</th>
          <th>Título</th>
          <th>Empresa</th>
          <th>Filial</th>
          <th>Vigência</th>
          <th>Status</th>
          <th class="text-center">Ações</th>
        </tr>
      </thead>
      <tbody>
        @forelse($contracts as $contract)
          <tr class="table-row-clickable" onclick="window.location='{{ route('contracts.show', $contract) }}';"
            style="cursor:pointer;">
            <td>{{ $contract->id }}</td>
            <td>{{ $contract->title }}</td>
            <td>{{ $contract->enterprise->name ?? '-' }}</td>
            <td>{{ $contract->branch->name ?? '-' }}</td>
            <td>
              {{ \Carbon\Carbon::parse($contract->start_date)->format('d/m/Y') }}
              @if ($contract->end_date)
                - {{ \Carbon\Carbon::parse($contract->end_date)->format('d/m/Y') }}
              @else
                - Indeterminado
              @endif
            </td>
            <td>
              <span class="badge {{ status_badge_class($contract->status) }}">
                {{ translate_status($contract->status) }}
              </span>
            </td>
            <td class="text-center">
              <a href="{{ route('contracts.edit', $contract) }}" class="btn btn-edit me-1" title="Editar"
                onclick="event.stopPropagation();">
                <ion-icon name="create-outline"></ion-icon>
              </a>
              <button class="btn btn-danger btn-sm" data-bs-toggle="modal"
                data-bs-target="#deleteModal{{ $contract->id }}" title="Excluir" onclick="event.stopPropagation();">
                <ion-icon name="trash-outline"></ion-icon>
              </button>
              @include('contracts._delete_modal', ['contract' => $contract])
            </td>
          </tr>
        @empty
          <tr>
            <td colspan="7" class="text-center">Nenhum contrato encontrado.</td>
          </tr>
        @endforelse
      </tbody>
    </table>
  </div>

  {{ $contracts->withQueryString()->links('pagination::bootstrap-5') }}
@endsection

@push('scripts')
  <script>
    // Realce de hover para linhas clicáveis
    document.querySelectorAll('.table-row-clickable').forEach(row => {
      row.addEventListener('mouseover', () => row.classList.add('table-row-hover'));
      row.addEventListener('mouseout', () => row.classList.remove('table-row-hover'));
    });
  </script>
@endpush
