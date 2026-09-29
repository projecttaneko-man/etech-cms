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
      <div class="auth-brand">
        <div class="auth-logo">E</div>
        <span>ETECH Admin</span>
      </div>
      <div class="auth-side-copy">
        <h2>Kelola konten Wawasan dengan mudah.</h2>
        <p>Tulis, atur, dan terbitkan artikel untuk website Etech dari satu tempat.</p>
      </div>
      <small>&copy; {{ date('Y') }} Etech</small>
    </aside>

    <main class="auth-main">
      <div class="auth-card">
        <div class="auth-brand auth-brand-mobile">
          <div class="auth-logo">E</div>
          <span>ETECH Admin</span>
        </div>
        @yield('content')
      </div>
    </main>

  </div>
  @yield('js')
</body>
</html>