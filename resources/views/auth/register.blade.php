@extends('layouts.auth')

@section('title', 'Daftar | ETECH Admin')

@section('content')
  <h1 class="auth-title">Buat akun</h1>
  <p class="auth-sub">Isi data di bawah untuk mendaftar.</p>

  <form method="POST" action="{{ route('register') }}">
    @csrf

    <div class="auth-field">
      <label class="f-label" for="name">Nama lengkap</label>
      <input id="name" type="text" name="name" class="f-input @error('name') is-invalid @enderror"
             value="{{ old('name') }}" placeholder="Nama Anda" required autofocus autocomplete="name">
      @error('name')<small class="auth-error">{{ $message }}</small>@enderror
    </div>

    <div class="auth-field">
      <label class="f-label" for="email">Email</label>
      <input id="email" type="email" name="email" class="f-input @error('email') is-invalid @enderror"
             value="{{ old('email') }}" placeholder="nama@email.com" required autocomplete="username">
      @error('email')<small class="auth-error">{{ $message }}</small>@enderror
    </div>

    <div class="auth-field">
      <label class="f-label" for="password">Kata sandi</label>
      <div class="auth-pass">
        <input id="password" type="password" name="password" class="f-input @error('password') is-invalid @enderror"
               placeholder="Minimal 8 karakter" required autocomplete="new-password">
        <button type="button" class="auth-eye" data-toggle-pass="password" aria-label="Tampilkan kata sandi">Lihat</button>
      </div>
      @error('password')<small class="auth-error">{{ $message }}</small>@enderror
    </div>

    <div class="auth-field">
      <label class="f-label" for="password_confirmation">Ulangi kata sandi</label>
      <div class="auth-pass">
        <input id="password_confirmation" type="password" name="password_confirmation" class="f-input"
               placeholder="Ketik ulang kata sandi" required autocomplete="new-password">
        <button type="button" class="auth-eye" data-toggle-pass="password_confirmation" aria-label="Tampilkan kata sandi">Lihat</button>
      </div>
    </div>

    <button type="submit" class="btn-primary">Daftar</button>
  </form>

  <p class="auth-switch">Sudah punya akun? <a class="auth-link" href="{{ route('login') }}">Masuk</a></p>
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