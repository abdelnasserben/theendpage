@extends('layouts.app')
@section('content')
<div class="container py-5 position-relative" style="min-height:500px;">
  <h1 class="mb-4 text-center">Créer ma page de départ</h1>

  <!-- Progress bar -->
  <div class="progress mb-4">
    <div id="progress-bar" class="progress-bar" role="progressbar" style="width: 25%;">
      Étape 1 sur 4
    </div>
  </div>

  @guest
    <p class="text-muted small">
      <a href="{{ route('login.form') }}">Connectez‑vous</a> pour suivre vos créations, commentaires et votes,<br>
      ou restez <strong>anonyme</strong>.
    </p>
  @endguest

  <!-- Wizard Form -->
  <form id="msform" class="position-relative" action="{{ route('departure.store') }}" method="POST">
    @csrf

    <!-- STEP 1 -->
    <fieldset class="active">
      <h3>1. Choisis ton ton</h3>
      <select name="tone" id="tone" class="form-select mb-3">
        @foreach(['dramatique','ironique','absurde','classe','touchant','passif-agressif','ultra_cringe','honnête'] as $tone)
          <option value="{{ $tone }}" {{ old('tone')==$tone ? 'selected':'' }}>
            {{ ucfirst(str_replace('_',' ',$tone)) }}
          </option>
        @endforeach
      </select>
      <button type="button" class="next action-button">Suivant</button>
    </fieldset>

    <!-- STEP 2 -->
    <fieldset>
      <h3>2. Rédige ton message</h3>
      <textarea name="message" id="message"
                class="form-control mb-3"
                rows="5"
                placeholder="Ton dernier mot…"
      >{{ old('message') }}</textarea>
      <button type="button" class="previous action-button">Précédent</button>
      <button type="button" class="next action-button">Suivant</button>
    </fieldset>

    <!-- STEP 3 -->
    <fieldset>
      <h3>3. Ajoute un GIF et un son (optionnel)</h3>
      <input type="url" name="gif" id="gif"
             class="form-control mb-3"
             placeholder="URL du GIF"
             value="{{ old('gif') }}">
      <input type="url" name="sound" id="sound"
             class="form-control mb-3"
             placeholder="URL du son"
             value="{{ old('sound') }}">
      <button type="button" class="previous action-button">Précédent</button>
      <button type="button" class="next action-button">Suivant</button>
    </fieldset>

    <!-- STEP 4 -->
    <fieldset>
      <h3>4. Options finales</h3>

      {{-- Anonymat désactivé si connecté --}}
      <div class="form-check mb-3">
        <input class="form-check-input" type="checkbox"
               name="anonymous" id="anonymous"
               {{ old('anonymous')?'checked':'' }}
               {{ auth()->check() ? 'disabled':'' }}>
        <label class="form-check-label" for="anonymous">Anonyme</label>
      </div>

      {{-- Nom pré-rempli / editable --}}
      <div class="mb-3">
        <label for="author_name" class="form-label">Ton nom</label>
        <input type="text" name="author_name" id="author_name"
               class="form-control"
               value="{{ auth()->check() ? auth()->user()->name : old('author_name') }}"
               {{ auth()->check() ? 'readonly':'' }}>
      </div>

      {{-- Email pré-rempli / editable --}}
      <div class="mb-3">
        <label for="author_email" class="form-label">Ton e-mail</label>
        <input type="email" name="author_email" id="author_email"
               class="form-control"
               value="{{ auth()->check() ? auth()->user()->email : old('author_email') }}"
               {{ auth()->check() ? 'readonly':'' }}>
      </div>

      {{-- Date différée --}}
      <div class="mb-3">
        <label for="release_at" class="form-label">Date de publication différée</label>
        <input type="datetime-local" name="release_at" id="release_at"
               class="form-control"
               value="{{ old('release_at') }}">
      </div>

      <button type="button" class="previous action-button">Précédent</button>
      <button type="submit" class="submit action-button">Créer ma page</button>
    </fieldset>
  </form>

  <!-- Live Preview -->
  <div class="mt-5">
    <h2>Aperçu</h2>
    <div class="card">
      <div class="card-header">Ton : <span id="previewTone">{{ old('tone','Dramatique') }}</span></div>
      <div class="card-body">
        <p id="previewMessage">{{ old('message','Ton message s’affichera ici…') }}</p>
        <div id="previewGif">{!! old('gif')? "<img src='".old('gif')."' class='img-fluid mt-2'>" : '' !!}</div>
        <audio id="previewSound" controls style="display:{{ old('sound')?'block':'none' }};"></audio>
      </div>
    </div>
  </div>
</div>
@endsection
