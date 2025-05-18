<!DOCTYPE html>
<html lang="fr" class="light">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>TheEnd.page</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
  @stack('styles')
  <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-light shadow-sm" style="background-color: var(--bg);">
  <div class="container-fluid">
    <a class="navbar-brand fw-bold" href="{{ route('departure.wizard') }}">TheEndPage</a>

    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent"
            aria-controls="navbarContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse justify-content-end" id="navbarContent">
      <ul class="navbar-nav align-items-lg-center">
        <li class="nav-item">
          <a class="nav-link" href="{{ route('departure.histories') }}">Nos histoires</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="{{ route('departure.hallOfFame') }}">🏆 Hall of Fame</a>
        </li>

        @guest
          <li class="nav-item">
            <a class="btn btn-outline-primary ms-lg-3" href="{{ route('login.form') }}">Connexion</a>
          </li>
          <li class="nav-item">
            <a class="btn btn-primary ms-lg-2" href="{{ route('register.form') }}">Inscription</a>
          </li>
        @else
          <li class="nav-item dropdown ms-lg-3">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              Bonjour, {{ auth()->user()->name }}
            </a>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
              <li><a class="dropdown-item" href="{{ route('dashboard') }}">Dashboard</a></li>
              <li>
                <form method="POST" action="{{ route('logout') }}">
                  @csrf
                  <button class="dropdown-item" type="submit">Déconnexion</button>
                </form>
              </li>
            </ul>
          </li>
        @endguest
      </ul>
    </div>
  </div>
</nav>

@yield('content')

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="/js/wizard.js"></script>
</body>
</html>
