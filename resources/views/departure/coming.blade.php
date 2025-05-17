@extends('layouts.app')
@section('content')
<div class="container text-center py-5">
    <h1 class="mb-4">Patientez...</h1>
    <p>Cette page sera disponible le <strong>{{ 
        \Carbon\Carbon::parse($release)->translatedFormat('d F Y \à H:i')
    }}</strong>.</p>
    <p>Revenez plus tard pour découvrir le mot final.</p>
</div>
@endsection