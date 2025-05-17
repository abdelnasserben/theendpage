@extends('layouts.app')
@section('content')
<div class="container py-5">
    <h1 class="text-center mb-4">Créer votre page de départ</h1>
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form action="{{ route('departure.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="tone" class="form-label">Choisissez votre ton</label>
            <select name="tone" id="tone" class="form-select">
                <option value="dramatique">Dramatique</option>
                <option value="ironique">Ironique</option>
                <option value="absurde">Absurde</option>
                <option value="honnête">Honnête</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="message" class="form-label">Votre message final</label>
            <textarea name="message" id="message" rows="6" class="form-control"></textarea>
        </div>
        <div class="mb-3">
            <label for="gif" class="form-label">GIF (optionnel)</label>
            <input type="url" name="gif" id="gif" class="form-control">
        </div>
        <div class="mb-3">
            <label for="sound" class="form-label">Son (optionnel)</label>
            <input type="url" name="sound" id="sound" class="form-control">
        </div>
        <button type="submit" class="btn btn-primary">Créer ma page</button>
    </form>
</div>
@endsection