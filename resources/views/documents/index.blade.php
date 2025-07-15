@extends('layouts.app')
@section('title', 'Documentos')

@section('content')
  <nav aria-label="breadcrumb" class="mb-3">
    <ol class="breadcrumb bg-transparent p-0">
      <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
      <li class="breadcrumb-item active" aria-current="page">Documentos</li>
    </ol>
  </nav>

  <h1 class="mb-4 fw-bold enterprise-title">Documentos</h1>

  <!-- Dashboard Cards -->
  <div class="row mb-4">
    <div class="col-md-4">
      <div class="dashboard-metric-card">
        <span class="dashboard-icon">
          <ion-icon name="document-outline"></ion-icon>
        </span>
        <div>
          <div class="dashboard-metric">{{ $documents->total() }}</div>
          <div class="dashboard-label">Total de Documentos</div>
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
            {{ $documents->where('status', 'valid')->count() }}
          </div>
          <div class="dashboard-label">Válidos</div>
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
            {{ $documents->where('status', 'expired')->count() }}
          </div>
          <div class="dashboard-label">Expirados</div>
        </div>
      </div>
    </div>
  </div>

  <!-- Filtros e Busca -->
  <div class="mb-3">
    <form method="GET" action="{{ route('documents.index') }}" class="row g-2 align-items-center">
      <div class="col-md-4">
        <input type="text" name="search" value="{{ request('search') }}"
          placeholder="Buscar por nome, tipo ou proprietário" class="form-control"
          aria-label="Buscar por nome, tipo ou proprietário">
      </div>
      <div class="col-md-3">
        <select name="document_type" class="form-select" aria-label="Filtrar por tipo">
          <option value="">-- Tipo --</option>
          @foreach ($documentTypes as $type)
            <option value="{{ $type }}" @selected(request('document_type') == $type)>{{ ucfirst($type) }}</option>
          @endforeach
        </select>
      </div>
      <div class="col-md-2">
        <select name="status" class="form-select" aria-label="Filtrar por status">
          <option value="">-- Status --</option>
          <option value="valid" @selected(request('status') == 'valid')>Válido</option>
          <option value="expired" @selected(request('status') == 'expired')>Expirado</option>
          <option value="pending" @selected(request('status') == 'pending')>Pendente</option>
          <option value="invalid" @selected(request('status') == 'invalid')>Inválido</option>
        </select>
      </div>
      <div class="col-md-3 text-end">
        <button type="submit" class="btn btn-primary">Filtrar</button>
        <a href="{{ route('documents.create') }}" class="btn btn-success ms-2">Novo Documento</a>
      </div>
    </form>
  </div>

  <!-- Tabela de Documentos -->
  <div class="table-responsive">
    <table class="table align-middle">
      <thead>
        <tr>
          <th>#</th>
          <th>Nome Original</th>
          <th>Tipo</th>
          <th>Proprietário</th>
          <th>Expira em</th>
          <th>Status</th>
          <th class="text-center">Ações</th>
        </tr>
      </thead>
      <tbody>
        @forelse($documents as $doc)
          <tr class="table-row-clickable" onclick="window.location='{{ route('documents.show', $doc) }}';"
            style="cursor:pointer;">
            <td>{{ $doc->id }}</td>
            <td>{{ $doc->original_name }}</td>
            <td>{{ ucfirst($doc->document_type) }}</td>
            <td>
              @if ($doc->owner)
                {{ $doc->owner->name ?? ($doc->owner->title ?? '-') }}
              @else
                -
              @endif
            </td>
            <td>
              {{ $doc->expiration_date ? \Carbon\Carbon::parse($doc->expiration_date)->format('d/m/Y') : '-' }}
            </td>
            <td>
              <span class="badge {{ status_badge_class($doc->status) }}">
                {{ translate_status($doc->status) }}
              </span>
            </td>
            <td class="text-center">
              <a href="{{ route('documents.edit', $doc) }}" class="btn btn-edit me-1" title="Editar"
                onclick="event.stopPropagation();">
                <ion-icon name="create-outline"></ion-icon>
              </a>
              <button class="btn btn-danger btn-sm" data-bs-toggle="modal"
                data-bs-target="#deleteModal{{ $doc->id }}" title="Excluir" onclick="event.stopPropagation();">
                <ion-icon name="trash-outline"></ion-icon>
              </button>
              @include('documents._delete_modal', ['document' => $doc])
            </td>
          </tr>
        @empty
          <tr>
            <td colspan="7" class="text-center">Nenhum documento encontrado.</td>
          </tr>
        @endforelse
      </tbody>
    </table>
  </div>
  {{ $documents->withQueryString()->links('pagination::bootstrap-5') }}
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
