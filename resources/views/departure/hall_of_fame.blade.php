@extends('layouts.app')

@section('content')
<div class="container py-5">
  <h1 class="text-center">🏆 Hall of Fame</h1>
  <div class="row mt-4">
    @foreach($pages as $i => $p)
      <div class="col-md-6 mb-3">
        <div class="card h-100 shadow-sm">
          <div class="card-body">
            <h5 class="card-title">#{{ $i+1 }} - {{ ucfirst($p->tone) }}</h5>
            <p>{{ Str::limit($p->message,100) }}</p>
            <p><strong>Votes:</strong> {{ $p->votes_count }}</p>
            <a href="{{ route('departure.show',$p->slug) }}" class="btn btn-sm btn-primary">Voir la fin</a>
          </div>
        </div>
      </div>
    @endforeach
  </div>
</div>
@endsection
