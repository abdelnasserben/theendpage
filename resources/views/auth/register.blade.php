@extends('layouts.app')

@section('content')
<div class="container py-5" style="max-width:500px;">
  <h2 class="mb-4">Créer un compte</h2>

  @if ($errors->any())
    <div class="alert alert-danger">
      <ul class="mb-0">
        @foreach ($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  <form method="POST" action="{{ route('register') }}">
    @csrf

    <div class="mb-3">
      <label for="name" class="form-label">Nom</label>
      <input id="name" name="name" type="text"
             class="form-control @error('name') is-invalid @enderror"
             value="{{ old('name') }}" required autofocus>
      @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="mb-3">
      <label for="email" class="form-label">Email</label>
      <input id="email" name="email" type="email"
             class="form-control @error('email') is-invalid @enderror"
             value="{{ old('email') }}" required>
      @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="mb-3">
      <label for="password" class="form-label">Mot de passe</label>
      <input id="password" name="password" type="password"
             class="form-control @error('password') is-invalid @enderror"
             required>
      @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="mb-3">
      <label for="password_confirmation" class="form-label">Confirmez le mot de passe</label>
      <input id="password_confirmation" name="password_confirmation" type="password"
             class="form-control" required>
    </div>

    <button type="submit" class="btn btn-primary w-100">Créer le compte</button>
  </form>
</div>
@endsection
