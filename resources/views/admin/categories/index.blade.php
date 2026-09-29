@extends('admin.layouts.app')

@section('title', 'Kelola Kategori — ETECH Admin')

@section('content')
    <div class="page-head">
        <h1>Kelola Kategori</h1>
    </div>

    @if(session('success'))
        <div class="alert-success">{{ session('success') }}</div>
    @endif

    <div style="display:grid;grid-template-columns:360px 1fr;gap:20px;align-items:start;">

        <div class="panel" style="padding:26px 24px;">
            <h3 style="margin:0 0 18px;font-size:19px;">Tambah Kategori Baru</h3>

            <form action="{{ route('admin.categories.store') }}" method="POST">
                @csrf

                <div style="margin-bottom:16px;">
                    <label class="f-label">Nama Kategori <span style="color:var(--rust);">*</span></label>
                    <input type="text" name="name" id="cat_name" maxlength="100"
                           class="f-input" placeholder="Contoh: Genset Industri"
                           value="{{ old('name') }}" oninput="updateCatSlug()" required>
                    @error('name')<div style="color:var(--danger);font-size:12.5px;margin-top:4px;">{{ $message }}</div>@enderror
                    <small style="color:var(--muted);display:block;text-align:right;margin-top:4px;"><span id="cat_name_count">0</span>/100</small>
                </div>

                <div style="margin-bottom:18px;">
                    <label class="f-label">Slug (Opsional)</label>
                    <div style="display:flex;">
                        <span style="display:flex;align-items:center;padding:0 12px;background:#F1E7D4;border:1px solid var(--border);border-right:none;border-radius:9px 0 0 9px;color:var(--muted);font-size:13.5px;">/cat/</span>
                        <input type="text" name="slug" id="cat_slug" class="f-input" style="border-radius:0 9px 9px 0;"
                               value="{{ old('slug') }}">
                    </div>
                    <small style="color:var(--muted);">Otomatis dari nama jika kosong.</small>
                    @error('slug')<div style="color:var(--danger);font-size:12.5px;margin-top:4px;">{{ $message }}</div>@enderror
                </div>

                <button type="submit" class="btn-primary" style="width:100%;justify-content:center;">Simpan Kategori</button>
            </form>
        </div>

        <div class="panel">
            <div class="filters">
                <form method="GET" style="display:flex;gap:14px;">
                    <input type="text" name="search" class="f-input" placeholder="Cari judul kategori..." value="{{ request('search') }}">
                    <button type="submit" class="btn-filter" style="white-space:nowrap;">Filter</button>
                </form>
            </div>

            <table>
                <thead>
                    <tr>
                        <th>Nama Kategori</th>
                        <th style="width:170px">Slug</th>
                        <th style="width:130px">Artikel</th>
                        <th style="width:100px; text-align:right; padding-right:24px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($categories as $category)
                        <tr>
                            <td class="art-title" style="margin:0;">{{ $category->name }}</td>
                            <td><span class="slug-chip">{{ $category->slug }}</span></td>
                            <td>
                                <span class="count-badge {{ $category->articles_count == 0 ? 'zero' : '' }}">
                                    {{ $category->articles_count }} Artikel
                                </span>
                            </td>
                            <td style="padding-right:24px;">
                                <div class="aksi">
                                    <a class="edit" title="Edit" href="{{ route('admin.categories.edit', $category) }}">
                                        <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 20h9"/><path d="M16.5 3.5a2.1 2.1 0 0 1 3 3L7 19l-4 1 1-4Z"/></svg>
                                    </a>
                                    <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" onsubmit="return confirm('Yakin hapus kategori ini? Artikel di dalamnya tidak ikut terhapus.')">
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
                        <tr><td colspan="4" class="empty-state">Belum ada kategori.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>
@endsection

@section('js')
<script>
function updateCatSlug() {
    const nameInput = document.getElementById('cat_name');
    const slugInput = document.getElementById('cat_slug');
    document.getElementById('cat_name_count').innerText = nameInput.value.length;
    slugInput.value = nameInput.value.toString().toLowerCase().trim()
        .replace(/[^a-z0-9\s-]/g, '').replace(/\s+/g, '-').replace(/-+/g, '-');
}
</script>
@endsection