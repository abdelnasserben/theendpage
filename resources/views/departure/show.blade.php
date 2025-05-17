@extends('layouts.app')

@section('content')
<!-- Hero Section -->
<div class="vh-100 d-flex flex-column justify-content-center align-items-center text-center p-4"
     style="background: var(--bg) url('/images/bg-{{ $page->tone }}.jpg') center/cover no-repeat;">
  <div class="bg-dark bg-opacity-75 p-5 rounded-3 shadow-lg">
    <h1 class="display-4 fw-bold text-light mb-3 animate__animated animate__fadeInDown">Le Dernier Mot</h1>
    <h2 class="text-uppercase mb-4 text-light animate__animated animate__fadeInUp">{{ ucfirst($page->tone) }}</h2>
    <p id="typed-final" class="lead text-light animate__animated animate__fadeIn" style="min-height:4rem;"></p>

    @if(!$page->anonymous)
      <div class="mt-4 animate__animated animate__fadeInUp">
        @if($page->author_name)
          <p class="text-light">— {{ $page->author_name }}</p>
        @endif
        @if($page->author_email)
          <p><a href="mailto:{{ $page->author_email }}" class="text-info text-decoration-none">{{ $page->author_email }}</a></p>
        @endif
      </div>
    @endif

    @if($page->gif)
      <div class="mt-4 animate__animated animate__zoomIn">
        <img src="{{ $page->gif }}" alt="GIF" class="img-fluid rounded">
      </div>
    @endif

    @if($page->sound)
      <div class="mt-3 animate__animated animate__fadeIn">
        <audio controls autoplay loop>
          <source src="{{ $page->sound }}" type="audio/mpeg">
          Votre navigateur ne supporte pas la balise audio.
        </audio>
      </div>
    @endif

    <div class="mt-4 animate__animated animate__fadeInUp">
      <a href="{{ route('departure.show', $page->slug) }}" class="btn btn-outline-light btn-lg">Partager ce lien</a>
    </div>
  </div>
</div>

@if(session('success'))
  <div class="alert alert-success">{{ session('success') }}</div>
@endif

@guest
  <div class="alert alert-info d-flex justify-content-between align-items-center">
    <div>
      <strong>Astuce :</strong> Connectez‑vous pour garder vos votes et commentaires dans votre profil.
    </div>
    <div>
      <a href="{{ route('login.form') }}" class="btn btn-outline-primary btn-sm me-2">Connexion</a>
      <a href="{{ route('register.form') }}" class="btn btn-primary btn-sm">Inscription</a>
    </div>
  </div>
@endguest

<div class="mt-5 container">
  <h3>Commentaires ({{ $page->comments->count() }})</h3>

  <form action="{{ route('departure.comment', $page->slug) }}" method="POST" class="mb-4">
    @csrf

    <div class="mb-3">
      <label for="author" class="form-label">Votre nom</label>
      <input type="text"
             name="author"
             id="author"
             class="form-control"
             value="{{ auth()->check() ? auth()->user()->name : old('author') }}"
             {{ auth()->check() ? 'readonly' : '' }}
             placeholder="Votre nom (optionnel)">
    </div>

    <div class="mb-3">
      <label for="content" class="form-label">Votre commentaire</label>
      <textarea name="content"
                id="content"
                class="form-control"
                rows="3"
                required>{{ old('content') }}</textarea>
      @error('content')<div class="text-danger">{{ $message }}</div>@enderror
    </div>

    <button class="btn btn-primary">Envoyer</button>
  </form>

  <ul class="list-group mb-4">
    @foreach($page->comments()->latest()->get() as $c)
      <li class="list-group-item">
        <strong>{{ $c->author }}</strong>
        <small class="text-muted">— {{ $c->created_at->format('d/m/Y H:i') }}</small>
        <p class="mb-0">{{ $c->content }}</p>
      </li>
    @endforeach
  </ul>

  <form action="{{ route('departure.vote', $page->slug) }}" method="POST">
    @csrf
    <button class="btn btn-warning">
      👍 Voter ({{ $page->votes()->count() }})
    </button>
  </form>
</div>

<!-- Typed.js pour effet machine à écrire final -->
<script src="https://cdn.jsdelivr.net/npm/typed.js@2.0.12"></script>
<script>
  document.addEventListener('DOMContentLoaded', () => {
    new Typed('#typed-final', {
      strings: ["{!! addslashes($page->message) !!}"],
      typeSpeed: 40,
      showCursor: false,
      startDelay: 500
    });
  });
</script>
@endsection
