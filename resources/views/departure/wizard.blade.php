@extends('layouts.app')
@section('content')
<div class="container py-5">
  <h1 class="mb-4 text-center">Créer ma page de départ</h1>

  <!-- Progress bar -->
  <div class="progress mb-4">
    <div id="progress-bar" class="progress-bar" role="progressbar" style="width: 25%;">
      Étape 1 sur 4
    </div>
  </div>

  <!-- Wizard Form -->
  <form id="msform">
    <!-- STEP 1 -->
    <fieldset>
      <h3>1. Choisis ton ton</h3>
      <select name="tone" id="tone" class="form-select mb-3">
        <option value="dramatique">Dramatique</option>
        <option value="ironique">Ironique</option>
        <option value="absurde">Absurde</option>
        <option value="classe">Classe</option>
        <option value="touchant">Touchant</option>
        <option value="passif-agressif">Passif-Agressif</option>
        <option value="ultra_cringe">Ultra Cringe</option>
        <option value="honnête">Honnête</option>
      </select>
      <button type="button" class="next action-button">Suivant</button>
    </fieldset>

    <!-- STEP 2 -->
    <fieldset style="display:none;">
      <h3>2. Rédige ton message</h3>
      <textarea name="message" id="message" class="form-control mb-3" rows="5" placeholder="Ton dernier mot..."></textarea>
      <button type="button" class="previous action-button">Précédent</button>
      <button type="button" class="next action-button">Suivant</button>
    </fieldset>

    <!-- STEP 3 -->
    <fieldset style="display:none;">
      <h3>3. Ajoute un GIF et un son (optionnel)</h3>
      <input type="url" name="gif" id="gif" class="form-control mb-3" placeholder="URL du GIF">
      <input type="url" name="sound" id="sound" class="form-control mb-3" placeholder="URL du son">
      <button type="button" class="previous action-button">Précédent</button>
      <button type="button" class="next action-button">Suivant</button>
    </fieldset>

    <!-- STEP 4 -->
    <fieldset style="display:none;">
      <h3>4. Options finales</h3>
      <div class="form-check mb-3">
        <input class="form-check-input" type="checkbox" name="anonymous" id="anonymous">
        <label class="form-check-label" for="anonymous">Anonyme</label>
      </div>
      <div class="mb-3">
        <label for="release_at" class="form-label">Date de publication différée</label>
        <input type="datetime-local" name="release_at" id="release_at" class="form-control">
      </div>
      <button type="button" class="previous action-button">Précédent</button>
      <button type="submit" class="submit action-button">Créer ma page</button>
    </fieldset>
  </form>

  <!-- Live Preview -->
  <div class="mt-5">
    <h2>Aperçu</h2>
    <div class="card">
      <div class="card-header">Ton : <span id="previewTone">Dramatique</span></div>
      <div class="card-body">
        <p id="previewMessage">Ton message s’affichera ici...</p>
        <div id="previewGif"></div>
        <audio id="previewSound" controls style="display:none;"></audio>
      </div>
    </div>
  </div>
</div>
@endsection