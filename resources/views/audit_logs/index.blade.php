@extends('layouts.app')
@section('title', 'Auditoria')

@section('content')
  <nav aria-label="breadcrumb" class="mb-3">
    <ol class="breadcrumb bg-transparent p-0">
      <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
      <li class="breadcrumb-item active" aria-current="page">Auditoria</li>
    </ol>
  </nav>

  <h1 class="mb-4 fw-bold enterprise-title">Auditoria</h1>

  <div class="mb-3">
    <form method="GET" action="{{ route('audit-logs.index') }}" class="row g-2 align-items-center">
      <div class="col-md-2">
        <input type="date" name="from" value="{{ request('from') }}" class="form-control" placeholder="De">
      </div>
      <div class="col-md-2">
        <input type="date" name="to" value="{{ request('to') }}" class="form-control" placeholder="Até">
      </div>
      <div class="col-md-2">
        <select name="action" class="form-select">
          <option value="">-- Ação --</option>
          @foreach ($distinctActions as $action)
            <option value="{{ $action }}" @selected(request('action') == $action)>{{ translate_action($action) }}</option>
          @endforeach
        </select>
      </div>
      <div class="col-md-3">
        <select name="model" class="form-select">
          <option value="">-- Modelo --</option>
          @foreach ($distinctModels as $model)
            <option value="{{ $model }}" @selected(request('model') == $model)>{{ translate_model($model) }}</option>
          @endforeach
        </select>
      </div>
      <div class="col-md-3 text-end">
        <button type="submit" class="btn btn-primary">Filtrar</button>
        <a href="{{ route('audit-logs.index') }}" class="btn btn-outline-secondary ms-2">Limpar</a>
        <a href="{{ route('audit-logs.export.excel', request()->query()) }}" class="btn btn-success ms-2">Exportar
          Excel</a>
      </div>
    </form>
  </div>

  <div class="table-responsive">
    <table class="table align-middle">
      <thead>
        <tr>
          <th>#</th>
          <th>Data</th>
          <th>Usuário</th>
          <th>Empresa</th>
          <th>Filial</th>
          <th>Ação</th>
          <th>Modelo</th>
          <th>Referência</th>
          <th>IP</th>
        </tr>
      </thead>
      <tbody>
        @forelse ($logs as $log)
          <tr>
            <td>{{ $log->id }}</td>
            <td>{{ $log->created_at->format('d/m/Y H:i:s') }}</td>
            <td>{{ $log->user_name ?? (optional($log->user)->name ?? '-') }}</td>
            <td title="{{ $log->display_enterprise }}">{{ truncate_middle($log->display_enterprise, 24) }}</td>
            <td title="{{ $log->display_branch }}">{{ truncate_middle($log->display_branch, 24) }}</td>
            <td><span class="badge bg-secondary">{{ translate_action($log->action) }}</span></td>
            <td>{{ translate_model($log->auditable_type) }}</td>
            <td title="{{ $log->display_label }}">{{ truncate_middle($log->display_label, 28) }}</td>
            <td>{{ $log->ip_address ?? '-' }}</td>
          </tr>
        @empty
          <tr>
            <td colspan="8" class="text-center">Nenhum registro encontrado.</td>
          </tr>
        @endforelse
      </tbody>
    </table>
  </div>

  {{ $logs->withQueryString()->links('pagination::bootstrap-5') }}
@endsection
