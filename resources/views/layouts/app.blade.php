<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('meta_title', 'Etech - Wawasan')</title>
    <meta name="description" content="@yield('meta_description', 'Wawasan dan artikel seputar solusi energi dari Etech')">
    <meta name="keywords" content="@yield('meta_keywords', '')">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        body { font-family: 'Segoe UI', sans-serif; background: #f7f8fa; }
        .navbar-brand-etech { font-weight: 800; letter-spacing: 1px; }
        .hero-wawasan {
            background: linear-gradient(rgba(10,20,40,.75), rgba(10,20,40,.75)),
                        url('https://images.unsplash.com/photo-1581092160607-ee22621dd758?w=1200') center/cover;
            color: #fff; padding: 60px 0;
        }
        .category-pill { border-radius: 30px; padding: 6px 18px; margin-right: 8px; font-size: 14px; }
        .article-card { border: none; box-shadow: 0 2px 10px rgba(0,0,0,.05); border-radius: 10px; overflow: hidden; }
    </style>
    @stack('styles')
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
        <div class="container">
            <a class="navbar-brand navbar-brand-etech" href="{{ route('blog.index') }}">ETECH</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navMenu">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link active" href="{{ route('blog.index') }}">Wawasan</a></li>
                </ul>
            </div>
        </div>
    </nav>

    @yield('content')

    <footer class="bg-dark text-white text-center py-4 mt-5">
        <div class="container">
            &copy; {{ date('Y') }} Etech. Semua hak dilindungi.
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>