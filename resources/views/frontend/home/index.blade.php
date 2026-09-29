@extends('frontend.layouts.app')

@section('meta_title', 'Wawasan - Etech')

@section('content')

    <div class="hero-wawasan text-center">
        <div class="container">
            <small class="text-uppercase">Etech / Wawasan</small>
            <h1 class="fw-bold mt-2">Wawasan Seputar Solusi Energi</h1>
            <p class="mb-0">Tips teknis, studi kasus, dan panduan dari tim Etech.</p>
        </div>
    </div>

    <div class="container my-4">

        <div class="d-flex flex-wrap justify-content-between align-items-center mb-4">
            <div>
                <a href="{{ route('blog.index') }}"
                   class="btn category-pill {{ !request('category') ? 'btn-primary' : 'btn-outline-secondary' }}">
                    Semua Artikel
                </a>
                @foreach($categories as $cat)
                    <a href="{{ route('blog.category', $cat->slug) }}"
                       class="btn category-pill {{ request()->is('category/'.$cat->slug) ? 'btn-primary' : 'btn-outline-secondary' }}">
                        {{ $cat->name }}
                    </a>
                @endforeach
            </div>

            <form method="GET" class="mt-2 mt-md-0">
                <div class="input-group">
                    <input type="text" name="search" class="form-control" placeholder="Cari artikel..."
                           value="{{ request('search') }}">
                    <button class="btn btn-outline-secondary"><i class="fas fa-search"></i></button>
                </div>
            </form>
        </div>

        <div class="row g-4">
            @forelse($articles as $article)
                <div class="col-md-4">
                    <div class="card article-card h-100">
                        @if($article->thumbnail)
                            <img src="{{ Storage::url($article->thumbnail) }}" class="card-img-top" style="height: 190px; object-fit: cover;">
                        @else
                            <div style="height: 190px; background: #eee;"></div>
                        @endif
                        <div class="card-body">
                            @if($article->category)
                                <small class="text-primary fw-bold text-uppercase">{{ $article->category->name }}</small>
                            @endif
                            <h5 class="card-title mt-1">
                                <a href="{{ route('blog.show', $article->slug) }}" class="text-dark text-decoration-none">
                                    {{ $article->title }}
                                </a>
                            </h5>
                            <p class="text-muted small">{{ Str::limit($article->excerpt, 90) }}</p>
                        </div>
                        <div class="card-footer bg-white border-0 d-flex justify-content-between text-muted small">
                            <span><i class="far fa-calendar"></i> {{ $article->published_at?->format('d M Y') }}</span>
                            <span><i class="far fa-eye"></i> {{ $article->views_count }}</span>
                        </div>
                    </div>
                </div>
            @empty
                <p class="text-center text-muted">Belum ada artikel yang dipublikasikan.</p>
            @endforelse
        </div>

        <div class="mt-4 d-flex justify-content-center">
            {{ $articles->links() }}
        </div>

    </div>

@endsection