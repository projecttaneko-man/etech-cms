@extends('admin.layouts.app')

@section('title', 'Kelola Artikel Blog — ETECH Admin')

@section('content')
    <div class="page-head">
        <h1>Kelola Artikel Blog</h1>
        <a href="{{ route('admin.articles.create') }}" class="btn-primary">+ Tambah Artikel</a>
    </div>

    @if(session('success'))
        <div class="alert-success">{{ session('success') }}</div>
    @endif

    <div class="panel">
        <form method="GET" action="{{ route('admin.articles.index') }}" class="filters">
            <div class="filters-grid">
                <div>
                    <label class="f-label">Cari judul</label>
                    <input class="f-input" type="text" name="search" value="{{ request('search') }}" placeholder="Cari judul artikel...">
                </div>
                <div>
                    <label class="f-label">Kategori</label>
                    <select class="f-select" name="category_id">
                        <option value="">Semua Kategori</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" @selected(request('category_id') == $category->id)>{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="f-label">Status</label>
                    <select class="f-select" name="status">
                        <option value="">Semua Status</option>
                        <option value="published" @selected(request('status') == 'published')>Published</option>
                        <option value="draft" @selected(request('status') == 'draft')>Draft</option>
                    </select>
                </div>
                <button type="submit" class="btn-filter">Filter</button>
            </div>
        </form>

        <table>
            <thead>
                <tr>
                    <th style="width:80px">Thumbnail</th><th>Artikel</th><th style="width:130px">Kategori</th>
                    <th style="width:90px">Dilihat</th><th style="width:150px">Status</th><th style="width:150px">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($articles as $article)
                    <tr>
                        <td>
                            @if($article->thumbnail)
                                <img class="thumb" src="{{ Storage::url($article->thumbnail) }}" alt="">
                            @else
                                <div class="thumb">IMG</div>
                            @endif
                        </td>
                        <td>
                            <p class="art-title">{{ Str::limit($article->title, 50) }}</p>
                            <span class="art-slug">/insight/{{ Str::limit($article->slug, 30) }}</span>
                        </td>
                        <td>{{ $article->category->name ?? '—' }}</td>
                        <td>{{ $article->views_count }}</td>
                        <td>
                            <span class="status-badge {{ $article->status }}">{{ $article->status === 'published' ? 'Published' : 'Draft' }}</span>
                            <span class="date-sub">{{ $article->created_at->format('d M Y') }}</span>
                        </td>
                        <td>
                            <div class="aksi">
                                <a class="preview" title="Preview" href="{{ route('admin.articles.preview', $article) }}" target="_blank" rel="noopener">
                                    <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-7 11-7 11 7 11 7-4 7-11 7-11-7-11-7Z"/><circle cx="12" cy="12" r="3"/></svg>
                                </a>
                                @if($article->status === 'published')
                                    <a class="view" title="Lihat" href="{{ route('blog.show', $article->slug) }}" target="_blank" rel="noopener">
                                        <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 3h7v7"/><path d="M10 14 21 3"/><path d="M21 14v6a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V4a1 1 0 0 1 1-1h6"/></svg>
                                    </a>
                                @endif
                                <a class="edit" title="Edit" href="{{ route('admin.articles.edit', $article) }}">
                                    <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 20h9"/><path d="M16.5 3.5a2.1 2.1 0 0 1 3 3L7 19l-4 1 1-4Z"/></svg>
                                </a>
                                <form action="{{ route('admin.articles.destroy', $article) }}" method="POST" onsubmit="return confirm('Hapus artikel ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="del" title="Hapus">
                                        <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="empty-state">Belum ada artikel. Klik "Tambah Artikel" untuk membuat yang pertama.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="pager">
            <form method="GET" style="display:flex;align-items:center;gap:6px;">
                @foreach(request()->except('per_page') as $key => $value)
                    <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                @endforeach
                Tampilkan
                <select name="per_page" onchange="this.form.submit()">
                    @foreach([10,25,50] as $n)
                        <option value="{{ $n }}" @selected($perPage == $n)>{{ $n }}</option>
                    @endforeach
                </select>
                per halaman &middot; Menampilkan {{ $articles->firstItem() ?? 0 }}–{{ $articles->lastItem() ?? 0 }} dari {{ $articles->total() }} artikel
            </form>
            <div class="pagination">
                {!! $articles->appends(request()->query())->links('pagination::simple-bootstrap-4') !!}
            </div>
        </div>
    </div>
@endsection