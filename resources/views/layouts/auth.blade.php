<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>@yield('title', 'ETECH Admin')</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Fraunces:opsz,wght@9..144,500;9..144,600;9..144,700&family=Work+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('css/etech-admin.css') }}">
</head>
<body class="auth-body">
  <div class="auth-wrap">

    <aside class="auth-side">
      <a href="/" class="auth-brand">
        <img src="{{ asset('images/logo.jpeg') }}" alt="Etech Power Generator" class="auth-logo-img auth-logo-img--side">
      </a>
      <div class="auth-side-copy">
        <h2>Kelola konten Wawasan dengan mudah.</h2>
      </div>
      <small>&copy; {{ date('Y') }} Etech</small>
    </aside>

    <main class="auth-main">
      <div class="auth-card">
        <div class="auth-brand auth-brand-mobile">
          <img src="{{ asset('images/logo.jpeg') }}" alt="Etech Power Generator" class="auth-logo-img">
        </div>
        @yield('content')
      </div>
    </main>

  </div>
  @yield('js')
</body>
</html>