<nav class="navbar navbar-expand-lg mb-4" id="mainNavbar">
    <div class="container-fluid">
        <a class="navbar-brand d-flex align-items-center" href="{{ route('dashboard') }}">
            <img src="{{ asset('img/logo.png') }}" alt="Logo" id="logo-light" class="logo-switch" style="height: 40px;">
            <img src="{{ asset('img/logo-dark.png') }}" alt="Logo" id="logo-dark" class="logo-switch d-none" style="height: 40px;">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto">
                <li class="nav-item"><a class="nav-link" href="{{ route('enterprises.index') }}">Empresas</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('branches.index') }}">Filiais</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('contracts.index') }}">Contratos</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('drivers.index') }}">Motoristas</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('vehicles.index') }}">Veículos</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('documents.index') }}">Documentos</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('solicitations.index') }}">Solicitações</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('researches.index') }}">Pesquisas</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('solicitation-pricings.index') }}">Precificação</a></li>
            </ul>
            <ul class="navbar-nav align-items-center">
                @auth
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown">
                            {{ Auth::user()->name }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="{{ route('profile.show') }}">Perfil</a></li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button class="dropdown-item" type="submit">Sair</button>
                                </form>
                            </li>
                        </ul>
                    </li>
                @endauth
                <li class="nav-item ms-3">
                    <div class="form-check form-switch mb-0">
                        <input class="form-check-input" type="checkbox" id="darkModeSwitch">
                        <label class="form-check-label" for="darkModeSwitch" style="cursor:pointer;">
                            <span class="d-none d-lg-inline">Modo escuro</span>
                            <span class="d-inline d-lg-none">🌙</span>
                        </label>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</nav>
