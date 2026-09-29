@extends('frontend.layouts.app')

@section('meta_title', $category->name . ' - Etech Blog')

@section('content')

    <h1 class="mb-4">Kategori: {{ $category->name }}</h1>

    <div class="row g-4">
        @forelse($articles as $article)
            <div class="col-md-4">
                <div class="card h-100">
                    @if($article->thumbnail)
                        <img src="{{ Storage::url($article->thumbnail) }}" class="card-img-top" style="height: 200px; object-fit: cover;">
                    @endif
                    <div class="card-body">
                        <h5 class="card-title">{{ $article->title }}</h5>
                        <p class="card-text text-muted">{{ $article->excerpt }}</p>
                    </div>
                    <div class="card-footer bg-white border-0">
                        <a href="{{ route('blog.show', $article->slug) }}" class="btn btn-outline-primary btn-sm">
                            Baca Selengkapnya
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <p class="text-center text-muted">Belum ada artikel di kategori ini.</p>
        @endforelse
    </div>

    <div class="mt-4">
        {{ $articles->links() }}
    </div>

@endsection