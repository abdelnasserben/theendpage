@extends('layouts.app')
@section('content')
<div class="container text-center py-5">
    <div class="mb-4">
        <h1>Le Dernier Mot</h1>
        <h2 class="text-capitalize {{ 'tone-' . $page->tone }}">{{ $page->tone }}</h2>
    </div>
    <p class="lead mb-3">{{ $page->message }}</p>
    @if($page->gif)
        <img src="{{ $page->gif }}" class="img-fluid mb-3">
    @endif
    @if($page->sound)
        <audio controls class="mb-3"><source src="{{ $page->sound }}"></audio>
    @endif
    <div id="qrcode" class="mb-3"></div>
    <p>Partage ce lien : <a href="{{ route('departure.show',$page->slug) }}">{{ route('departure.show',$page->slug) }}</a></p>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
<script>
  new QRCode(document.getElementById("qrcode"), {
    text: "{{ route('departure.show',$page->slug) }}",
    width: 128, height: 128
  });
</script>
@endsection