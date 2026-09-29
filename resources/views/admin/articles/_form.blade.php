@csrf

<div style="display:grid;grid-template-columns:2fr 1fr;gap:24px;align-items:start;">

    {{-- ==================== KOLOM KIRI ==================== --}}
    <div style="display:flex;flex-direction:column;gap:20px;">

        <div class="panel" style="padding:24px;">
            <div style="margin-bottom:18px;">
                <label class="f-label" for="title">Judul Artikel</label>
                <input type="text" name="title" id="title" class="f-input"
                       value="{{ old('title', $article->title ?? '') }}"
                       placeholder="Judul artikel..." required>
                @error('title')<small style="color:var(--danger);">{{ $message }}</small>@enderror
            </div>

            <div>
                <label class="f-label" for="slug">Slug URL</label>
                <input type="text" name="slug" id="slug" class="f-input"
                       value="{{ old('slug', $article->slug ?? '') }}"
                       placeholder="slug-artikel">
                <small style="color:var(--muted);display:block;margin-top:6px;">
                    /insight/<span id="seo_preview_slug">slug-artikel</span>
                </small>
                @error('slug')<small style="color:var(--danger);">{{ $message }}</small>@enderror
            </div>
        </div>

        <div class="panel" style="padding:24px;">
            <label class="f-label" for="content">Konten Artikel</label>
            <textarea name="content" id="content" class="f-textarea" rows="14">{{ old('content', $article->content ?? '') }}</textarea>
            @error('content')<small style="color:var(--danger);">{{ $message }}</small>@enderror
        </div>

        <div class="panel" style="padding:24px;">
            <h3 style="font-family:'Fraunces',serif;font-size:18px;margin:0 0 16px;">SEO</h3>

            <div style="margin-bottom:16px;">
                <label class="f-label" for="meta_title">
                    Meta Title
                    <span style="float:right;font-weight:400;"><span id="meta_title_count">0</span>/60</span>
                </label>
                <input type="text" name="meta_title" id="meta_title" class="f-input"
                       value="{{ old('meta_title', $article->meta_title ?? '') }}"
                       maxlength="60" placeholder="Judul untuk mesin pencari...">
            </div>

            <div>
                <label class="f-label" for="meta_description">
                    Meta Description
                    <span style="float:right;font-weight:400;"><span id="meta_description_count">0</span>/160</span>
                </label>
                <textarea name="meta_description" id="meta_description" class="f-textarea" rows="3"
                          maxlength="160" placeholder="Deskripsi untuk mesin pencari...">{{ old('meta_description', $article->meta_description ?? '') }}</textarea>
            </div>

            {{-- Preview hasil pencarian Google --}}
            <div style="margin-top:18px;padding:16px;border:1px solid var(--border);border-radius:10px;background:#FFFDFA;">
                <p id="seo_preview_title" style="margin:0 0 4px;color:#1a0dab;font-size:16px;line-height:1.3;">Judul artikel akan tampil di sini</p>
                <p style="margin:0 0 4px;color:var(--sage);font-size:13px;">yoursite.com/insight/<span id="seo_preview_slug_2">slug-artikel</span></p>
                <p id="seo_preview_desc" style="margin:0;color:var(--muted);font-size:13.5px;line-height:1.4;">Deskripsi artikel akan tampil di sini.</p>
            </div>
        </div>
    </div>

    {{-- ==================== KOLOM KANAN ==================== --}}
    <div style="display:flex;flex-direction:column;gap:20px;">

        <div class="panel" style="padding:22px;">
            <h3 style="font-family:'Fraunces',serif;font-size:16px;margin:0 0 14px;">Publikasikan</h3>

            <div style="margin-bottom:16px;">
                <label class="f-label" for="status">Status</label>
                <select name="status" id="status" class="f-select">
                    <option value="draft" @selected(old('status', $article->status ?? 'draft') == 'draft')>Draft</option>
                    <option value="published" @selected(old('status', $article->status ?? '') == 'published')>Published</option>
                </select>
            </div>

            <div style="display:flex;gap:10px;">
                <button type="submit" class="btn-primary" style="width:100%;justify-content:center;">
                    {{ isset($article) ? 'Simpan Perubahan' : 'Simpan Artikel' }}
                </button>
            </div>
            <a href="{{ route('admin.articles.index') }}" class="btn-secondary" style="width:100%;justify-content:center;margin-top:10px;">
                Batal
            </a>
        </div>

        <div class="panel" style="padding:22px;">
            <h3 style="font-family:'Fraunces',serif;font-size:16px;margin:0 0 14px;">Kategori</h3>
            <select name="category_id" id="category_id" class="f-select">
                <option value="">Pilih Kategori</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" @selected(old('category_id', $article->category_id ?? '') == $category->id)>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
            @error('category_id')<small style="color:var(--danger);display:block;margin-top:6px;">{{ $message }}</small>@enderror
        </div>

        <div class="panel" style="padding:22px;">
            <h3 style="font-family:'Fraunces',serif;font-size:16px;margin:0 0 14px;">Thumbnail</h3>

            @if(!empty($article->thumbnail))
                <img src="{{ Storage::url($article->thumbnail) }}" alt=""
                     style="width:100%;border-radius:10px;margin-bottom:12px;object-fit:cover;max-height:160px;">
            @endif

            <input type="file" name="thumbnail" id="thumbnail" class="f-input" accept="image/*">
            <small style="color:var(--muted);display:block;margin-top:6px;">Format JPG/PNG, maks. 2MB.</small>
            @error('thumbnail')<small style="color:var(--danger);display:block;margin-top:4px;">{{ $message }}</small>@enderror
        </div>
    </div>
</div>