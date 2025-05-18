@extends('layouts.app')

@section('content')
<style>
  .card-hover {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    cursor: pointer;
    position: relative;
  }

  .card-hover:hover {
    transform: translateY(-8px);
    box-shadow: 0 12px 24px rgba(0, 0, 0, 0.2);
    z-index: 10;
  }

  .card-text-clamp {
    display: -webkit-box;
    -webkit-line-clamp: 3; /* 3 lines max */
    -webkit-box-orient: vertical;
    overflow: hidden;
    text-overflow: ellipsis;
    min-height: 4.5em; /* approx 3 lines height */
  }

  .badge-tone {
    position: absolute;
    top: 12px;
    right: 12px;
    z-index: 20;
    background-color: rgba(0, 0, 0, 0.7);
    color: #fff;
    font-size: 0.75rem;
    padding: 0.35em 0.7em;
    border-radius: 0.5rem;
    text-transform: capitalize;
  }

  .card-img-top {
    object-fit: cover;
    height: 180px;
    border-top-left-radius: 0.375rem;
    border-top-right-radius: 0.375rem;
  }
</style>

<div class="container py-5">
  <h1 class="text-center mb-5">🏆 Hall of Fame</h1>

  <div class="row g-4">
    @foreach($pages as $i => $p)
      <div class="col-md-6 col-lg-4">
        <div class="card card-hover h-100 shadow-sm">
          @if($p->gif)
            <img src="{{ $p->gif }}" alt="Image page {{ $p->slug }}" class="card-img-top">
          @else
            <img src="https://via.placeholder.com/400x180?text=No+Image" alt="No image" class="card-img-top">
          @endif

          <div class="badge-tone">{{ ucfirst($p->tone) }}</div>

          <div class="card-body d-flex flex-column">
            <h5 class="card-title">#{{ $i+1 }} - {{ ucfirst($p->tone) }}</h5>
            <p class="card-text card-text-clamp">{{ $p->message }}</p>

            <div class="mt-auto d-flex justify-content-between align-items-center">
              <small class="text-muted">Votes: {{ $p->votes_count }}</small>
              <a href="{{ route('departure.show',$p->slug) }}" class="btn btn-sm btn-primary">Lire la suite</a>
            </div>
          </div>
        </div>
      </div>
    @endforeach
  </div>
</div>
@endsection
