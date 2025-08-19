<nav class="navbar navbar-expand-lg mb-4" id="mainNavbar">
  <div class="container-fluid">
    <a class="navbar-brand d-flex align-items-center" href="{{ route('dashboard') }}">
      <img src="{{ asset('img/logo-dark.png') }}" alt="Logo" id="logo-light" class="logo-switch" style="height: 40px;">
      <img src="{{ asset('img/logo-dark.png') }}" alt="Logo" id="logo-dark" class="logo-switch d-none"
        style="height: 40px;">
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
      aria-controls="navbarNav" aria-expanded="false" aria-label="Alternar navegação">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav me-auto">

        {{-- Cadastros --}}
        @hasanyrole('superadmin|admin|operador')
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="cadastrosDropdown" role="button"
              data-bs-toggle="dropdown" aria-expanded="false">
              Cadastros
            </a>
            <ul class="dropdown-menu" aria-labelledby="cadastrosDropdown">
              @hasanyrole('superadmin|admin')
                <li><a class="dropdown-item" href="{{ route('enterprises.index') }}">Empresas</a></li>
              @endhasanyrole
              @hasanyrole('superadmin|admin')
                <li><a class="dropdown-item" href="{{ route('branches.index') }}">Filiais</a></li>
              @endhasanyrole
              <li><a class="dropdown-item" href="{{ route('drivers.index') }}">Motoristas</a></li>
              <li><a class="dropdown-item" href="{{ route('vehicles.index') }}">Veículos</a></li>
              <li><a class="dropdown-item" href="{{ route('documents.index') }}">Documentos</a></li>
              <li><a class="dropdown-item" href="{{ route('driver-licenses.index') }}">CNHs</a></li>
            </ul>
          </li>
        @endhasanyrole

        {{-- Operações --}}
        @hasanyrole('superadmin|admin|operador')
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="operacoesDropdown" role="button"
              data-bs-toggle="dropdown" aria-expanded="false">
              Operações
            </a>
            <ul class="dropdown-menu" aria-labelledby="operacoesDropdown">
              @hasanyrole('superadmin|admin')
                <li><a class="dropdown-item" href="{{ route('contracts.index') }}">Contratos</a></li>
                <li><a class="dropdown-item" href="{{ route('solicitation-pricings.index') }}">Precificação</a></li>
              @endhasanyrole
              <li><a class="dropdown-item" href="{{ route('solicitations.index') }}">Solicitações</a></li>
            </ul>
          </li>
        @endhasanyrole

        {{-- Administração Global --}}
        @hasanyrole('superadmin|admin|operador')
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="administracaoDropdown" role="button"
              data-bs-toggle="dropdown" aria-expanded="false">
              Administração
            </a>
            <ul class="dropdown-menu" aria-labelledby="administracaoDropdown">
              @hasanyrole('superadmin|admin|operador')
                <li><a class="dropdown-item" href="{{ route('users.index') }}">Usuários</a></li>
              @endhasanyrole
              @role('superadmin')
                <li><a class="dropdown-item" href="{{ route('roles.index') }}">Papéis</a></li>
                <li><a class="dropdown-item" href="{{ route('permissions.index') }}">Permissões</a></li>
                <li>
                  <hr class="dropdown-divider">
                </li>
                <li><a class="dropdown-item" href="{{ route('audit-logs.index') }}">Logs</a></li>
              @endrole
            </ul>
          </li>
        @endhasanyrole

        {{-- Painel Motorista --}}
        @role('motorista')
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="motoristaMenu" role="button" data-bs-toggle="dropdown"
              aria-expanded="false">
              Área do Motorista
            </a>
            <ul class="dropdown-menu" aria-labelledby="motoristaMenu">
              <li><a class="dropdown-item" href="{{ route('solicitations.index') }}">Minhas Solicitações</a></li>
              <li><a class="dropdown-item" href="{{ route('profile.show') }}">Meu Perfil</a></li>
            </ul>
          </li>
        @endrole

        {{-- Painel Veículo --}}
        @role('veiculo')
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="veiculoMenu" role="button" data-bs-toggle="dropdown"
              aria-expanded="false">
              Área do Veículo
            </a>
            <ul class="dropdown-menu" aria-labelledby="veiculoMenu">
              <li><a class="dropdown-item" href="{{ route('vehicles.index') }}">Meus Dados</a></li>
              <li><a class="dropdown-item" href="{{ route('profile.show') }}">Perfil Veículo</a></li>
            </ul>
          </li>
        @endrole

      </ul>

      <ul class="navbar-nav align-items-center">
        @auth
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="userDropdown"
              role="button" data-bs-toggle="dropdown" aria-expanded="false">
              <i class="bi bi-person-circle me-2" style="font-size:1.3em"></i>
              {{ Auth::user()->name }}
              @php
                $empresaNome = session('empresa_nome');
                $filialNome = session('filial_nome');
              @endphp
              @if (!Auth::user()->hasRole('superadmin') && ($empresaNome || $filialNome))
                <span class="ms-2 context-badge">{{ $empresaNome }}@if ($filialNome)
                    / {{ $filialNome }}
                  @endif
                </span>
              @endif
            </a>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
              <li class="dropdown-header text-center">
                @foreach (Auth::user()->getRoleNames() as $role)
                  <span class="badge bg-info mb-2 me-1">
                    {{ strtoupper($role) }}
                  </span>
                @endforeach
              </li>
              <li>
                <hr class="dropdown-divider">
              </li>
              <li>
                <a class="dropdown-item" href="{{ route('profile.show') }}">
                  <i class="bi bi-person"></i> Perfil
                </a>
              </li>
              <li>
                <div class="dropdown-item px-0">
                  <div class="form-check form-switch d-flex align-items-center justify-content-between mb-0 px-3">
                    <label class="form-check-label" for="darkModeSwitch" style="cursor:pointer;">
                      <span>Modo escuro</span>
                    </label>
                    <input class="form-check-input" type="checkbox" id="darkModeSwitch">
                  </div>
                </div>
              </li>
              <li>
                <hr class="dropdown-divider">
              </li>
              @php
                $empresaNome = session('empresa_nome');
                $filialNome = session('filial_nome');
              @endphp
              @if (!Auth::user()->hasRole('superadmin'))
                <li class="px-3 pt-1 pb-2 context-section">
                  <div class="small mb-1 context-title">Contexto</div>
                  @if ($empresaNome)
                    <div class="small context-value"><i
                        class="bi bi-building me-1"></i><strong>{{ $empresaNome }}</strong></div>
                  @endif
                  @if ($filialNome)
                    <div class="small context-value"><i
                        class="bi bi-diagram-3 me-1"></i><strong>{{ $filialNome }}</strong></div>
                  @endif
                  <form method="POST" action="{{ route('context.trocar') }}" class="mt-2">
                    @csrf
                    <button class="btn btn-sm w-100 btn-context-switch" type="submit">
                      <i class="bi bi-arrow-repeat me-1"></i> Trocar contexto
                    </button>
                  </form>
                </li>
                <li>
                  <hr class="dropdown-divider">
                </li>
              @endif
              <li>
                <form method="POST" action="{{ route('logout') }}">
                  @csrf
                  <button class="dropdown-item" type="submit">
                    <i class="bi bi-box-arrow-right"></i> Sair
                  </button>
                </form>
              </li>
            </ul>
          </li>
        @endauth
      </ul>
    </div>
  </div>
</nav>
