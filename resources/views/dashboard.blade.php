@extends('layouts.app')

@section('content')
<div class="container py-5">

  <h1 class="mb-4">Bonjour, {{ auth()->user()->name }}</h1>

  {{-- Section 1: Mes pages --}}
  <div class="mb-5">
    <h3>Mes créations ({{ $user->pages->count() }})</h3>
    @if($user->pages->isEmpty())
      <p class="text-muted">Vous n'avez pas encore créé de page.</p>
    @else
      <ul class="list-group">
        @foreach($user->pages as $page)
          <li class="list-group-item d-flex justify-content-between align-items-center">
            <a href="{{ route('departure.show', $page->slug) }}">
              {{ Str::limit($page->message, 50) }}
            </a>
            <small class="text-muted">{{ $page->created_at->format('d/m/Y') }}</small>
          </li>
        @endforeach
      </ul>
    @endif
  </div>

  {{-- Section 2: Mes commentaires --}}
  <div class="mb-5">
    <h3>Mes commentaires ({{ $user->comments->count() }})</h3>
    @if($user->comments->isEmpty())
      <p class="text-muted">Vous n'avez pas encore commenté de page.</p>
    @else
      <ul class="list-group">
        @foreach($user->comments as $comment)
          @if($comment->page) {{-- Ne traiter que si la page existe --}}
            <li class="list-group-item">
              <div class="d-flex justify-content-between">
                <a href="{{ route('departure.show', $comment->page->slug) }}">
                  {{ ucfirst($comment->page->tone) }} – {{ Str::limit($comment->page->message, 30) }}
                </a>
                <small class="text-muted">{{ $comment->created_at->format('d/m/Y H:i') }}</small>
              </div>
              <p class="mb-0">{{ Str::limit($comment->content, 100) }}</p>
            </li>
          @endif
        @endforeach
      </ul>
    @endif
  </div>

  {{-- Section 3: Mes votes --}}
  <div class="mb-5">
    <h3>Mes votes ({{ $user->votes->count() }})</h3>
    @if($user->votes->isEmpty())
      <p class="text-muted">Vous n'avez pas encore voté pour une page.</p>
    @else
      <ul class="list-group">
        @foreach($user->votes as $vote)
          @if($vote->page) {{-- Ne traiter que si la page existe --}}
            <li class="list-group-item d-flex justify-content-between align-items-center">
              <a href="{{ route('departure.show', $vote->page->slug) }}">
                {{ ucfirst($vote->page->tone) }} – {{ Str::limit($vote->page->message, 50) }}
              </a>
              <small class="text-muted">{{ $vote->created_at->format('d/m/Y') }}</small>
            </li>
          @endif
        @endforeach
      </ul>
    @endif
  </div>

  {{-- Section 4: Suppression de compte --}}
  <div class="pt-4 border-top">
    <h3 class="text-danger">Supprimer mon compte</h3>
    <p class="text-muted">
      Cette action est irréversible : toutes vos pages, commentaires et votes seront supprimés.
    </p>
    <form method="POST" action="{{ route('account.destroy') }}"
          onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer votre compte ?');">
      @csrf
      @method('DELETE')
      <button type="submit" class="btn btn-outline-danger">
        Supprimer mon compte
      </button>
    </form>
  </div>

</div>
@endsection
