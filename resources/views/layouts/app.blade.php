<!DOCTYPE html>
<html lang="pt-br" data-bs-theme="light">

<head>
  <meta charset="UTF-8">
  <title>@yield('title', config('app.name', 'Sistema'))</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Bootstrap 5 CSS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
  <!-- Bootstrap Icons (global) -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
  <!-- Custom CSS -->
  <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
  <link rel="stylesheet" href="{{ asset('css/navbar.css') }}">
  @stack('styles')
</head>

<body>
  @include('partials.navbar')

  <main class="container py-4">
    @include('partials.alerts')
    @yield('content')
  </main>

  <!-- Bootstrap 5 JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <!-- Ionicons (global) -->
  <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
  <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
  @stack('scripts')

  <!-- Script para alternância de tema e logo -->
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const html = document.documentElement;
      const navbar = document.getElementById('mainNavbar');
      const switchEl = document.getElementById('darkModeSwitch');
      let currentTheme = localStorage.getItem('bsTheme');
      if (!currentTheme) {
        currentTheme = window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light';
      }
      html.setAttribute('data-bs-theme', currentTheme);
      if (navbar) navbar.setAttribute('data-bs-theme', currentTheme);
      if (switchEl) switchEl.checked = currentTheme === 'dark';

      function updateLogoAndNavbar() {
        const theme = html.getAttribute('data-bs-theme');

        if (navbar) navbar.setAttribute('data-bs-theme', theme);

        // Navbar logo
        const logoLight = document.getElementById('logo-light');
        const logoDark = document.getElementById('logo-dark');
        if (logoLight && logoDark) {
          logoLight.classList.toggle('d-none', theme === 'dark');
          logoDark.classList.toggle('d-none', theme !== 'dark');
        }

        // Login logo
        const logoLightLogin = document.getElementById('logo-light-login');
        const logoDarkLogin = document.getElementById('logo-dark-login');
        if (logoLightLogin && logoDarkLogin) {
          logoLightLogin.classList.toggle('d-none', theme === 'dark');
          logoDarkLogin.classList.toggle('d-none', theme !== 'dark');
        }

        // Welcome logo (caso use na tela inicial)
        const logoLightWelcome = document.getElementById('logo-light-welcome');
        const logoDarkWelcome = document.getElementById('logo-dark-welcome');
        if (logoLightWelcome && logoDarkWelcome) {
          logoLightWelcome.classList.toggle('d-none', theme === 'dark');
          logoDarkWelcome.classList.toggle('d-none', theme !== 'dark');
        }
      }

      updateLogoAndNavbar();

      if (switchEl) {
        switchEl.addEventListener('change', function() {
          if (this.checked) {
            html.setAttribute('data-bs-theme', 'dark');
            localStorage.setItem('bsTheme', 'dark');
          } else {
            html.setAttribute('data-bs-theme', 'light');
            localStorage.setItem('bsTheme', 'light');
          }
          updateLogoAndNavbar();
        });
      }

      const observer = new MutationObserver(updateLogoAndNavbar);
      observer.observe(html, {
        attributes: true,
        attributeFilter: ['data-bs-theme']
      });
    });
  </script>
</body>

</html>
