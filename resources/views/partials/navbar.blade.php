<nav class="navbar navbar-expand-lg mb-4" id="mainNavbar">
  <div class="container-fluid">
    <a class="navbar-brand d-flex align-items-center" href="{{ route('dashboard') }}">
      <img src="{{ asset('img/logo-dark.png') }}" alt="Logo" id="logo-light" class="logo-switch" style="height: 40px;">
      <img src="{{ asset('img/logo-dark.png') }}" alt="Logo" id="logo-dark" class="logo-switch d-none"
        style="height: 40px;">
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav me-auto">

        {{-- Cadastros --}}
        @hasanyrole('master|admin|operador')
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="cadastrosDropdown" role="button"
              data-bs-toggle="dropdown">
              Cadastros
            </a>
            <ul class="dropdown-menu">
              <li><a class="dropdown-item" href="{{ route('enterprises.index') }}">Empresas</a></li>
              <li><a class="dropdown-item" href="{{ route('branches.index') }}">Filiais</a></li>
              <li><a class="dropdown-item" href="{{ route('drivers.index') }}">Motoristas</a></li>
              <li><a class="dropdown-item" href="{{ route('vehicles.index') }}">Veículos</a></li>
              <li><a class="dropdown-item" href="{{ route('documents.index') }}">Documentos</a></li>
              <li><a class="dropdown-item" href="{{ route('driver-licenses.index') }}">CNHs</a></li>
            </ul>
          </li>
        @endhasanyrole

        {{-- Operações --}}
        @hasanyrole('master|admin|operador')
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="operacoesDropdown" role="button"
              data-bs-toggle="dropdown">
              Operações
            </a>
            <ul class="dropdown-menu">
              <li><a class="dropdown-item" href="{{ route('contracts.index') }}">Contratos</a></li>
              <li><a class="dropdown-item" href="{{ route('solicitations.index') }}">Solicitações</a></li>
              <li><a class="dropdown-item" href="{{ route('researches.index') }}">Pesquisas</a></li>
              <li><a class="dropdown-item" href="{{ route('solicitation-pricings.index') }}">Precificação</a></li>
            </ul>
          </li>
        @endhasanyrole

        {{-- Menus exclusivos para perfis específicos --}}
        @role('motorista')
          <li class="nav-item">
            <a class="nav-link" href="{{ route('solicitations.index') }}">Minhas Solicitações</a>
          </li>
        @endrole

        @role('veiculo')
          <li class="nav-item">
            <a class="nav-link" href="{{ route('vehicles.index') }}">Meus Dados</a>
          </li>
        @endrole

      </ul>
      <ul class="navbar-nav align-items-center">
        @auth
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="userDropdown" role="button"
              data-bs-toggle="dropdown">
              {{ Auth::user()->name }}
            </a>
            <ul class="dropdown-menu dropdown-menu-end">
              <li class="dropdown-header text-center">
                <span class="badge bg-info mb-2">
                  {{ strtoupper(Auth::user()->getRoleNames()->first()) }}
                </span>
              </li>
              <li>
                <hr class="dropdown-divider">
              </li>
              <li><a class="dropdown-item" href="{{ route('profile.show') }}">Perfil</a></li>
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
              <li>
                <form method="POST" action="{{ route('logout') }}">
                  @csrf
                  <button class="dropdown-item" type="submit">Sair</button>
                </form>
              </li>
            </ul>
          </li>
        @endauth
      </ul>
    </div>
  </div>
</nav>
