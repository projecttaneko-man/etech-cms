@extends('layouts.auth')

@section('title', 'Masuk | ETECH Admin')

@section('content')
  <h1 class="auth-title">Masuk</h1>
  <p class="auth-sub">Silakan masuk untuk mengelola konten.</p>

  @if (session('status'))
    <div class="alert-success">{{ session('status') }}</div>
  @endif

  <form method="POST" action="{{ route('login') }}">
    @csrf

    <div class="auth-field">
      <label class="f-label" for="email">Email</label>
      <input id="email" type="email" name="email" class="f-input @error('email') is-invalid @enderror"
             value="{{ old('email') }}" placeholder="nama@email.com" required autofocus autocomplete="username">
      @error('email')<small class="auth-error">{{ $message }}</small>@enderror
    </div>

    <div class="auth-field">
      <label class="f-label" for="password">Kata sandi</label>
      <div class="auth-pass">
        <input id="password" type="password" name="password" class="f-input @error('password') is-invalid @enderror"
               placeholder="Masukkan kata sandi" required autocomplete="current-password">
        <button type="button" class="auth-eye" data-toggle-pass="password" aria-label="Tampilkan kata sandi">Lihat</button>
      </div>
      @error('password')<small class="auth-error">{{ $message }}</small>@enderror
    </div>

    <div class="auth-row">
      <label class="auth-check">
        <input type="checkbox" name="remember"> <span>Ingat saya</span>
      </label>
      @if (Route::has('password.request'))
        <a class="auth-link" href="{{ route('password.request') }}">Lupa kata sandi?</a>
      @endif
    </div>

    <button type="submit" class="btn-primary">Masuk</button>
  </form>

  @if (Route::has('register'))
    <p class="auth-switch">Belum punya akun? <a class="auth-link" href="{{ route('register') }}">Daftar</a></p>
  @endif
@endsection

@section('js')
<script>
  document.querySelectorAll('[data-toggle-pass]').forEach(function (btn) {
    btn.addEventListener('click', function () {
      var input = document.getElementById(btn.getAttribute('data-toggle-pass'));
      var show = input.type === 'password';
      input.type = show ? 'text' : 'password';
      btn.textContent = show ? 'Sembunyi' : 'Lihat';
    });
  });
</script>
@endsection