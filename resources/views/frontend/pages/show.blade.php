@extends('frontend.layouts.app')

@section('meta_title', $article->meta_title ?: $article->title)
@section('meta_description', $article->meta_description ?: $article->excerpt)
@section('meta_keywords', $article->meta_keywords)

@section('content')
<div class="container" style="margin-top:10px;">

    <nav class="crumbs">
        <a href="{{ route('blog.index') }}">Wawasan</a>
        <span class="sep">/</span>
        @if($article->category)
            <a href="{{ route('blog.category', $article->category->slug) }}">{{ $article->category->name }}</a>
            <span class="sep">/</span>
        @endif
        <span class="current">{{ Str::limit($article->title, 60) }}</span>
    </nav>

    <div style="display:grid;grid-template-columns:1fr 320px;gap:36px;align-items:start;">

        <div>
            @if($article->category)
                <a href="{{ route('blog.category', $article->category->slug) }}" class="badge-cat">{{ $article->category->name }}</a>
            @endif

            <h1 style="font-size:28px;font-weight:800;color:var(--navy);line-height:1.3;margin:14px 0;">{{ $article->title }}</h1>

            <div style="display:flex;gap:18px;color:var(--muted);font-size:12.5px;border-top:1px solid var(--border);border-bottom:1px solid var(--border);padding:12px 0;margin-bottom:16px;">
                <span><i class="far fa-calendar"></i> {{ $article->published_at?->format('d F Y') }}</span>
                <span><i class="far fa-eye"></i> Dilihat {{ $article->views_count }} kali</span>
            </div>

            <div class="share-row">
                <span style="font-size:12.5px;font-weight:700;color:var(--ink);">Bagikan:</span>
                @php $shareUrl = urlencode(url()->current()); $shareTitle = urlencode($article->title); @endphp
                <a href="https://api.whatsapp.com/send?text={{ $shareTitle }}%20{{ $shareUrl }}" target="_blank" class="share-btn"><i class="fab fa-whatsapp"></i></a>
                <a href="https://www.facebook.com/sharer/sharer.php?u={{ $shareUrl }}" target="_blank" class="share-btn"><i class="fab fa-facebook-f"></i></a>
                <a href="https://www.linkedin.com/sharing/share-offsite/?url={{ $shareUrl }}" target="_blank" class="share-btn"><i class="fab fa-linkedin-in"></i></a>
                <button type="button" class="share-btn" id="copyLinkBtn" style="cursor:pointer;"><i class="fas fa-link"></i></button>
            </div>

            @if($article->thumbnail)
                <div style="border-radius:14px;overflow:hidden;margin-bottom:26px;">
                    <img src="{{ Storage::url($article->thumbnail) }}" style="width:100%;max-height:440px;object-fit:cover;">
                </div>
            @endif

            <div class="article-box">
                <div class="article-prose">
                    {!! $article->content !!}
                </div>
            </div>

            @if($article->meta_keywords)
                <div style="margin-top:20px;">
                    <span style="font-size:13px;font-weight:700;color:var(--ink);">#Tag:</span>
                    @foreach(explode(',', $article->meta_keywords) as $tag)
                        <a href="{{ route('blog.index', ['search' => trim($tag)]) }}" class="tag-chip">#{{ trim($tag) }}</a>
                    @endforeach
                </div>
            @endif

            <div style="margin-top:26px;display:flex;justify-content:space-between;flex-wrap:wrap;gap:12px;">
                <a href="{{ route('blog.index') }}" style="color:var(--muted);text-decoration:none;font-size:12.5px;font-weight:700;">
                    <i class="fas fa-arrow-left"></i> Kembali ke Daftar Artikel
                </a>
                @if($article->category)
                    <a href="{{ route('blog.category', $article->category->slug) }}" class="badge-cat">Lihat semua {{ $article->category->name }}</a>
                @endif
            </div>
        </div>

        <div>
            <div class="side-box">
                <h3>Category</h3>
                <ul class="cat-list">
                    @foreach($categories as $cat)
                        <li>
                            <a href="{{ route('blog.category', $cat->slug) }}">
                                {{ $cat->name }}
                                <span class="count">{{ $cat->articles_count }}</span>
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>

            <div class="side-box">
                <h3>Related Post</h3>
                @forelse($relatedArticles as $related)
                    <a href="{{ route('blog.show', $related->slug) }}" class="related-item">
                        @if($related->thumbnail)
                            <img src="{{ Storage::url($related->thumbnail) }}">
                        @else
                            <div style="width:64px;height:48px;background:#F1F5F9;border-radius:8px;"></div>
                        @endif
                        <p>{{ Str::limit($related->title, 55) }}</p>
                    </a>
                @empty
                    <p style="font-size:12.5px;color:var(--muted);">Belum ada artikel terkait.</p>
                @endforelse
            </div>
        </div>

    </div>
</div>
@endsection

@push('scripts')
<script>
document.getElementById('copyLinkBtn').addEventListener('click', function () {
    navigator.clipboard.writeText(window.location.href).then(() => {
        this.innerHTML = '<i class="fas fa-check"></i>';
        setTimeout(() => this.innerHTML = '<i class="fas fa-link"></i>', 2000);
    });
});
</script>
@endpush