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
  <link rel="stylesheet" href="{{ asset('css/login.css') }}">
  @stack('styles')
</head>

<body>
  <main class="container d-flex flex-column justify-content-center align-items-center min-vh-100">
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
      const switchEl = document.getElementById('darkModeSwitch');
      let currentTheme = localStorage.getItem('bsTheme');
      if (!currentTheme) {
        currentTheme = window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light';
      }
      html.setAttribute('data-bs-theme', currentTheme);
      if (switchEl) switchEl.checked = currentTheme === 'dark';

      function updateLogoGuest() {
        const theme = html.getAttribute('data-bs-theme');
        // Login logo
        const logoLight = document.getElementById('logo-light');
        const logoDark = document.getElementById('logo-dark');
        if (logoLight && logoDark) {
          logoLight.classList.toggle('d-none', theme === 'dark');
          logoDark.classList.toggle('d-none', theme !== 'dark');
        }
      }

      updateLogoGuest();

      if (switchEl) {
        switchEl.addEventListener('change', function() {
          if (this.checked) {
            html.setAttribute('data-bs-theme', 'dark');
            localStorage.setItem('bsTheme', 'dark');
          } else {
            html.setAttribute('data-bs-theme', 'light');
            localStorage.setItem('bsTheme', 'light');
          }
          updateLogoGuest();
        });
      }

      const observer = new MutationObserver(updateLogoGuest);
      observer.observe(html, {
        attributes: true,
        attributeFilter: ['data-bs-theme']
      });
    });
  </script>
</body>

</html>
