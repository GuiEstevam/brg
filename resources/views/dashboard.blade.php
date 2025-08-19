@extends('layouts.app')
@section('title', 'Dashboard')

@push('styles')
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
  <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
  <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
@endpush

@section('content')
  @php
    $empresaNome = session('empresa_nome');
    $filialNome = session('filial_nome');
  @endphp
  @if ($empresaNome || $filialNome)
    <div class="alert alert-secondary d-flex align-items-center" role="alert">
      <i class="bi bi-geo-alt me-2"></i>
      <div>
        <strong>Contexto atual</strong>:
        @if ($empresaNome)
          <span class="ms-1">Empresa: <strong>{{ $empresaNome }}</strong></span>
        @endif
        @if ($filialNome)
          <span class="ms-3">Filial: <strong>{{ $filialNome }}</strong></span>
        @endif
      </div>
      <form method="POST" action="{{ route('context.trocar') }}" class="ms-auto">
        @csrf
        <button type="submit" class="btn btn-sm btn-outline-primary">
          <i class="bi bi-arrow-repeat me-1"></i> Trocar contexto
        </button>
      </form>
    </div>
  @endif
  <h1 class="mb-4 fw-bold" style="color:#0f2239;">Dashboard</h1>

  <div class="mb-3">
    <span class="badge bg-info">Perfil: {{ strtoupper($user->getRoleNames()->first()) }}</span>
  </div>

  <div class="row mb-4">
    @if ($user->hasRole('master'))
      <div class="col-md-3 col-6">
        <div class="dashboard-metric-card">
          <span class="dashboard-icon"><ion-icon name="people-outline"></ion-icon></span>
          <div>
            <div class="dashboard-metric">{{ $totalUsers ?? 0 }}</div>
            <div class="dashboard-label">Usuários</div>
          </div>
        </div>
      </div>
      <div class="col-md-3 col-6">
        <div class="dashboard-metric-card">
          <span class="dashboard-icon"><ion-icon name="business-outline"></ion-icon></span>
          <div>
            <div class="dashboard-metric">{{ $totalEnterprises ?? 0 }}</div>
            <div class="dashboard-label">Empresas</div>
          </div>
        </div>
      </div>
      <div class="col-md-3 col-6">
        <div class="dashboard-metric-card">
          <span class="dashboard-icon"><ion-icon name="document-text-outline"></ion-icon></span>
          <div>
            <div class="dashboard-metric">{{ $totalSolicitations ?? 0 }}</div>
            <div class="dashboard-label">Solicitações</div>
          </div>
        </div>
      </div>
      <div class="col-md-3 col-6">
        <div class="dashboard-metric-card">
          <span class="dashboard-icon"><ion-icon name="settings-outline"></ion-icon></span>
          <div>
            <div class="dashboard-metric">{{ $totalConfigs ?? 0 }}</div>
            <div class="dashboard-label">Configurações</div>
          </div>
        </div>
      </div>
    @endif

    @if ($user->hasRole('admin'))
      <div class="col-md-4 col-6">
        <div class="dashboard-metric-card">
          <span class="dashboard-icon"><ion-icon name="people-outline"></ion-icon></span>
          <div>
            <div class="dashboard-metric">{{ $totalEnterpriseUsers ?? 0 }}</div>
            <div class="dashboard-label">Usuários da Empresa</div>
          </div>
        </div>
      </div>
      <div class="col-md-4 col-6">
        <div class="dashboard-metric-card">
          <span class="dashboard-icon"><ion-icon name="person-outline"></ion-icon></span>
          <div>
            <div class="dashboard-metric">{{ $totalDrivers ?? 0 }}</div>
            <div class="dashboard-label">Motoristas</div>
          </div>
        </div>
      </div>
      <div class="col-md-4 col-6">
        <div class="dashboard-metric-card">
          <span class="dashboard-icon"><ion-icon name="car-outline"></ion-icon></span>
          <div>
            <div class="dashboard-metric">{{ $totalVehicles ?? 0 }}</div>
            <div class="dashboard-label">Veículos</div>
          </div>
        </div>
      </div>
    @endif

    @if ($user->hasRole('operador'))
      <div class="col-md-6 col-12">
        <div class="dashboard-metric-card">
          <span class="dashboard-icon"><ion-icon name="document-text-outline"></ion-icon></span>
          <div>
            <div class="dashboard-metric">{{ $pendingSolicitations ?? 0 }}</div>
            <div class="dashboard-label">Solicitações Pendentes</div>
          </div>
        </div>
      </div>
      <div class="col-md-6 col-12">
        <div class="dashboard-metric-card">
          <span class="dashboard-icon" style="color: #4cd137;">
            <ion-icon name="checkmark-circle-outline"></ion-icon>
          </span>
          <div>
            <div class="dashboard-metric">{{ $completedSolicitations ?? 0 }}</div>
            <div class="dashboard-label">Solicitações Concluídas</div>
          </div>
        </div>
      </div>
    @endif

    @if ($user->hasRole('motorista'))
      <div class="col-md-6 col-12">
        <div class="dashboard-metric-card">
          <span class="dashboard-icon"><ion-icon name="person-outline"></ion-icon></span>
          <div>
            <div class="dashboard-metric">{{ $user->name }}</div>
            <div class="dashboard-label">Bem-vindo, Motorista</div>
          </div>
        </div>
      </div>
      <div class="col-md-6 col-12">
        <div class="dashboard-metric-card">
          <span class="dashboard-icon"><ion-icon name="document-text-outline"></ion-icon></span>
          <div>
            <div class="dashboard-metric">{{ $mySolicitations ?? 0 }}</div>
            <div class="dashboard-label">Minhas Solicitações</div>
          </div>
        </div>
      </div>
    @endif

    @if ($user->hasRole('veiculo'))
      <div class="col-12">
        <div class="dashboard-metric-card">
          <span class="dashboard-icon"><ion-icon name="car-outline"></ion-icon></span>
          <div>
            <div class="dashboard-metric">Acesso de Veículo</div>
            <div class="dashboard-label">Visualize seus dados e status</div>
          </div>
        </div>
      </div>
    @endif
  </div>

  <div class="row mb-4">
    <div class="col-lg-8">
      <div class="card shadow-sm" style="border-radius:18px;">
        <div class="card-body">
          <h5 class="card-title mb-3" style="color:#0f2239;">Atividades Recentes</h5>
          <canvas id="dashboardChart" height="120"></canvas>
        </div>
      </div>
    </div>
    <div class="col-lg-4">
      <div class="card shadow-sm quick-links" style="border-radius:18px;">
        <div class="card-body">
          <h5 class="card-title mb-3" style="color:#0f2239;">Acessos Rápidos</h5>
          @if ($user->hasAnyRole(['master', 'admin']))
            <a href="{{ route('enterprises.index') }}" class="btn btn-primary w-100 mb-2"><i
                class="bi bi-building me-2"></i>Empresas</a>
          @endif
          @if ($user->hasAnyRole(['admin', 'operador']))
            <a href="{{ route('drivers.index') }}" class="btn btn-primary w-100 mb-2"><i
                class="bi bi-person-badge me-2"></i>Motoristas</a>
            <a href="{{ route('vehicles.index') }}" class="btn btn-primary w-100 mb-2"><i
                class="bi bi-truck me-2"></i>Veículos</a>
          @endif
          <a href="{{ route('solicitations.index') }}" class="btn btn-primary w-100 mb-2"><i
              class="bi bi-file-earmark-text me-2"></i>Solicitações</a>
        </div>
      </div>
    </div>
  </div>
@endsection

@push('scripts')
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const ctx = document.getElementById('dashboardChart').getContext('2d');
      new Chart(ctx, {
        type: 'line',
        data: {
          labels: {!! json_encode($chartLabels ?? ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun']) !!},
          datasets: [{
            label: 'Solicitações',
            data: {!! json_encode($chartData ?? [10, 20, 18, 25, 22, 30]) !!},
            fill: true,
            backgroundColor: 'rgba(142, 228, 175, 0.2)',
            borderColor: '#8e2636',
            tension: 0.3,
            pointBackgroundColor: '#0f2239',
            pointBorderColor: '#fff',
            pointRadius: 5
          }]
        },
        options: {
          plugins: {
            legend: {
              display: false
            }
          },
          scales: {
            x: {
              grid: {
                color: '#bfc5ce'
              }
            },
            y: {
              beginAtZero: true,
              grid: {
                color: '#bfc5ce'
              }
            }
          }
        }
      });
    });
  </script>
@endpush
