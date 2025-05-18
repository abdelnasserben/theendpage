<!DOCTYPE html>
<html lang="fr" class="light">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>TheEnd.page</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  @stack('styles')
  <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>
  <nav class="navbar navbar-expand-lg shadow-sm" style="background-color: var(--bg) !important;">
  <div class="container-fluid">
    <a class="navbar-brand" href="{{ route('departure.wizard') }}">TheEnd.page</a>

    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarAuth"
            aria-controls="navbarAuth" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <ul class="navbar-nav me-auto">
      <li class="nav-item">
        <a class="nav-link" href="{{ route('departure.hallOfFame') }}">🏆 Hall of Fame</a>
      </li>
    </ul>


    <div class="collapse navbar-collapse" id="navbarAuth">
      <ul class="navbar-nav me-auto"></ul>

      <div class="d-flex align-items-center">
        @guest
          <a href="{{ route('login.form') }}" class="btn btn-outline-primary me-2">Connexion</a>
          <a href="{{ route('register.form') }}" class="btn btn-primary me-3">Inscription</a>
        @else
          <span class="me-3">Bonjour, {{ auth()->user()->name }}</span>

          <div class="dropdown me-3">
            <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton"
                    data-bs-toggle="dropdown" aria-expanded="false">
              Mon compte
            </button>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton">
              <li><a class="dropdown-item" href="{{ route('dashboard') }}">Dashboard</a></li>
              <li>
                <form method="POST" action="{{ route('logout') }}">
                  @csrf
                  <button class="dropdown-item" type="submit">Déconnexion</button>
                </form>
              </li>
            </ul>
          </div>
        @endguest
      </div>
    </div>
  </div>
</nav>

  @yield('content')
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script src="/js/wizard.js"></script>
</body>
</html>