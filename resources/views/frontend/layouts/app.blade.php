<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>@yield('meta_title', 'Wawasan - Etech')</title>
<meta name="description" content="@yield('meta_description', 'Wawasan seputar solusi genset dan kelistrikan dari Etech')">
<meta name="keywords" content="@yield('meta_keywords', '')">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Merriweather:wght@400;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
<link rel="stylesheet" href="{{ asset('css/etech-frontend.css') }}">
@stack('styles')
</head>
<body>

<div id="reading-progress"></div>

<div class="topbar">
    <div class="wrap">
        <span>Solusi Genset &amp; Kelistrikan Terpercaya</span>
        <span class="socials">
            <a href="#" class="social-dot"><i class="fab fa-facebook-f"></i></a>
            <a href="#" class="social-dot"><i class="fab fa-linkedin-in"></i></a>
            <a href="#" class="social-dot"><i class="fab fa-instagram"></i></a>
            <a href="#" class="social-dot"><i class="fab fa-x-twitter"></i></a>
        </span>
    </div>
</div>

<header class="mainnav" id="mainHeader">
    <div class="navwrap">
        <a href="{{ route('blog.index') }}" class="brandmark">
            <div class="glyph"><div class="tri"></div><div class="ring"></div></div>
            <div>
                <div class="word">ETECH</div>
                <div class="sub">SOLUSI ENERGI ANDAL</div>
            </div>
        </a>

        <nav>
            <ul class="mainmenu">
                <li><a href="/">Home</a></li>
                <li><a href="/solusi-bisnis">Solusi Bisnis</a></li>
                <li><a href="/products">Produk</a></li>
                <li><a href="{{ route('blog.index') }}" class="active">Wawasan</a></li>
                <li><a href="/contact">Kontak</a></li>
            </ul>
        </nav>

        <button class="menu-toggle-m" onclick="document.getElementById('mobileMenu').classList.toggle('hidden')">
            <i class="fas fa-bars"></i>
        </button>
    </div>

    <div id="mobileMenu" class="hidden" style="border-top:1px solid var(--border);padding:14px 24px;">
        <a href="/" style="display:block;padding:8px 0;color:var(--ink);text-decoration:none;font-weight:600;font-size:13px;">Home</a>
        <a href="{{ route('blog.index') }}" style="display:block;padding:8px 0;color:var(--teal-dark);text-decoration:none;font-weight:700;font-size:13px;">Wawasan</a>
        <a href="/contact" style="display:block;padding:8px 0;color:var(--ink);text-decoration:none;font-weight:600;font-size:13px;">Kontak</a>
    </div>
</header>

@yield('content')

<footer>
    <div class="wrap">
        <div class="footer-grid">
            <div>
                <div class="brandmark">
                    <div class="glyph"><div class="tri"></div><div class="ring"></div></div>
                    <div>
                        <div class="word">ETECH</div>
                        <div class="sub" style="color:#8CA3BE;">SOLUSI ENERGI ANDAL</div>
                    </div>
                </div>
                <p class="footer-desc">Menyediakan solusi genset dan kelistrikan yang andal untuk kebutuhan industri, korporat, pemerintah, hingga rumah tangga di seluruh Indonesia.</p>
            </div>

            <div>
                <h4>Layanan</h4>
                <ul>
                    <li><a href="/solusi-bisnis">Solusi Bisnis</a></li>
                    <li><a href="/products">Katalog Produk</a></li>
                    <li><a href="{{ route('blog.index') }}">Wawasan</a></li>
                </ul>
            </div>

            <div>
                <h4>Perusahaan</h4>
                <ul>
                    <li><a href="/about">Tentang Etech</a></li>
                    <li><a href="/contact">Kontak</a></li>
                    <li><a href="https://wa.me/62xxxxxxxxxx" target="_blank" rel="noopener">Konsultasi WhatsApp</a></li>
                </ul>
            </div>
        </div>
    </div>

    <div class="footer-bottom">
        &copy; {{ date('Y') }} Etech.
    </div>
</footer>

<script>
window.addEventListener('scroll', function () {
    document.getElementById('mainHeader').classList.toggle('scrolled', window.scrollY > 10);

    const progress = document.getElementById('reading-progress');
    const article = document.querySelector('.article-prose');
    if (article) {
        const top = article.offsetTop, height = article.offsetHeight;
        const scrollY = window.scrollY + window.innerHeight / 2;
        const percent = Math.min(Math.max((scrollY - top) / height, 0), 1);
        progress.style.transform = 'scaleX(' + percent + ')';
    }
});
</script>
@stack('scripts')
</body>
</html>