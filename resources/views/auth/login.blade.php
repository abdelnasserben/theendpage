@extends('layouts.app')

@section('content')
<div class="container py-5" style="max-width:400px;">
  <h2 class="mb-4">Connexion</h2>

  @if ($errors->any())
    <div class="alert alert-danger">
      <ul class="mb-0">
        @foreach ($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  <form method="POST" action="{{ route('login') }}">
    @csrf

    <div class="mb-3">
      <label for="email" class="form-label">Email</label>
      <input id="email" name="email" type="email"
             class="form-control @error('email') is-invalid @enderror"
             value="{{ old('email') }}" required autofocus>
      @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="mb-3">
      <label for="password" class="form-label">Mot de passe</label>
      <input id="password" name="password" type="password"
             class="form-control @error('password') is-invalid @enderror"
             required>
      @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <button type="submit" class="btn btn-success w-100">Se connecter</button>
  </form>
</div>
@endsection
