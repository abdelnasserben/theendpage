@extends('layouts.app')

@section('content')
<style>
  .card-hover {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
  }

  .card-hover:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
    z-index: 2;
  }

  .card-text-clamp {
    display: -webkit-box;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
    overflow: hidden;
  }

  .badge-tone {
    position: absolute;
    top: 10px;
    right: 10px;
    z-index: 1;
    background-color: rgba(0, 0, 0, 0.7);
    color: #fff;
    font-size: 0.75rem;
    padding: 0.35em 0.6em;
    border-radius: 0.5rem;
    text-transform: capitalize;
  }

  .card-img-top {
    object-fit: cover;
    height: 200px;
  }
</style>

<div class="container py-5">
  <h2 class="mb-5 text-center fw-bold">Toutes les Histoires</h2>

  <div class="row g-4">
    @foreach ($pages as $page)
      <div class="col-md-6 col-lg-4">
        <div class="card h-100 shadow-sm card-hover border-0">
          <div class="position-relative">
            <img src="{{ $page->gif }}" class="card-img-top rounded-top" alt="Image de l'histoire">
            <span class="badge badge-tone">{{ $page->tone }}</span>
          </div>
          <div class="card-body d-flex flex-column">
            <p class="card-text text-muted card-text-clamp mb-3">
              {{ strip_tags($page->message) }}
            </p>

            @if(!$page->anonymous && $page->author_name)
              <p class="text-secondary mb-2">
                <i class="bi bi-person-circle me-1"></i>{{ $page->author_name }}
              </p>
            @endif

            <a href="{{ route('departure.show', $page->slug) }}" class="btn btn-primary mt-auto">
              Lire l’histoire
            </a>
          </div>
        </div>
      </div>
    @endforeach
  </div>

  <div class="mt-5 d-flex justify-content-center">
    {{ $pages->links('pagination::bootstrap-5') }}
  </div>
</div>
@endsection
