@extends('layouts.app')

@section('content')
  <!-- Hero Section -->
  <div class="bg-dark text-light position-relative" 
       style="background: url('{{ $page->gif }}') center/cover; min-height:60vh;">
    <div class="position-absolute top-0 start-0 w-100 h-100 bg-dark bg-opacity-50"></div>
    <div class="container position-relative d-flex flex-column justify-content-center align-items-center text-center py-5" style="min-height:60vh;">
      <h1 class="display-4 fw-bold mb-3">{{ Str::limit($page->message, 50, '…') }}</h1>
      <h2 class="h5 text-secondary mb-2"><span class="text-white">{{ ucfirst($page->tone) }}</span></h2>
      @if(!$page->anonymous && $page->author_name)
        <p class="mb-2"><i class="fas fa-user me-2"></i>{{ $page->author_name }}</p>
      @endif
      <a href="#story-content" class="btn btn-outline-light btn-lg mt-3">
        <i class="fas fa-book-open me-1"></i>Lire l’intégralité
      </a>
    </div>
  </div>

  <!-- Full Story Content -->
  <div id="story-content" class="container py-5">
    <div class="row justify-content-center">
      <div class="col-lg-8">
        <article class="mb-4">
          <div class="p-4 border rounded bg-light">
            <p class="mb-0">{{ $page->message }}</p>
          </div>

          @if($page->sound)
            <div class="mt-4">
              <audio controls autoplay loop class="w-100">
                <source src="{{ $page->sound }}" type="audio/mpeg">
                Votre navigateur ne supporte pas l’audio.
              </audio>
            </div>
          @endif
        </article>
      </div>
    </div>
  </div>

  <!-- Comment & Vote Section -->
  <div class="container mb-5">
    <div class="row gx-4 gy-5">
      <!-- Comment Form -->
      <div class="col-lg-6">
        <div class="card shadow-sm">
          <div class="card-header bg-light">
            <i class="fas fa-comments me-2"></i>Laisser un commentaire
          </div>
          <div class="card-body">
            <form action="{{ route('departure.comment', $page->slug) }}" method="POST">
              @csrf
              <div class="mb-3">
                <label for="author" class="form-label">Nom</label>
                <input type="text"
                       id="author"
                       name="author"
                       class="form-control @error('author') is-invalid @enderror"
                       value="{{ auth()->check() ? auth()->user()->name : old('author') }}"
                       {{ auth()->check() ? 'readonly' : '' }}
                       placeholder="Votre nom (optionnel)">
                @error('author')<div class="invalid-feedback">{{ $message }}</div>@enderror
              </div>
              <div class="mb-3">
                <label for="content" class="form-label">Commentaire</label>
                <textarea id="content"
                          name="content"
                          rows="4"
                          class="form-control @error('content') is-invalid @enderror"
                          required>{{ old('content') }}</textarea>
                @error('content')<div class="invalid-feedback">{{ $message }}</div>@enderror
              </div>
              <button type="submit" class="btn btn-primary w-100">
                <i class="fas fa-paper-plane me-1"></i>Envoyer
              </button>
            </form>
          </div>
        </div>
      </div>

      <!-- Comments List & Vote Button -->
      <div class="col-lg-6">
        <div class="d-flex justify-content-between align-items-center mb-3">
          <h5 class="mb-0">
            <i class="fas fa-comments me-1"></i>{{ $page->comments()->count() }} Commentaire{{ $page->comments()->count()>1?'s':'' }}
          </h5>
          <form action="{{ route('departure.vote', $page->slug) }}" method="POST">
            @csrf
            <button class="btn btn-warning">
              <i class="fas fa-thumbs-up me-1"></i>Voter ({{ $page->votes()->count() }})
            </button>
          </form>
        </div>
        <ul class="list-group">
          @foreach($page->comments()->latest()->get() as $c)
            <li class="list-group-item">
              <div class="d-flex justify-content-between">
                <div>
                  <strong>{{ $c->author }}</strong>
                  <small class="text-muted ms-2">{{ $c->created_at->diffForHumans() }}</small>
                </div>
              </div>
              <p class="mb-0 mt-2">{{ $c->content }}</p>
            </li>
          @endforeach
        </ul>
      </div>
    </div>
  </div>
@endsection
