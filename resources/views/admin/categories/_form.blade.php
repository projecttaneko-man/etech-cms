@csrf

<div style="margin-bottom:16px;">
    <label class="f-label">Nama Kategori <span style="color:var(--rust);">*</span></label>
    <input type="text" name="name" id="cat_name" maxlength="100" class="f-input"
           value="{{ old('name', $category->name ?? '') }}" oninput="updateCatSlug()" required>
    @error('name')<div style="color:var(--danger);font-size:12.5px;margin-top:4px;">{{ $message }}</div>@enderror
    <small style="color:var(--muted);display:block;text-align:right;margin-top:4px;"><span id="cat_name_count">0</span>/100</small>
</div>

<div style="margin-bottom:18px;">
    <label class="f-label">Slug (Opsional)</label>
    <div style="display:flex;">
        <span style="display:flex;align-items:center;padding:0 12px;background:#F1E7D4;border:1px solid var(--border);border-right:none;border-radius:9px 0 0 9px;color:var(--muted);font-size:13.5px;">/cat/</span>
        <input type="text" name="slug" id="cat_slug" class="f-input" style="border-radius:0 9px 9px 0;"
               value="{{ old('slug', $category->slug ?? '') }}">
    </div>
    <small style="color:var(--muted);">Otomatis dari nama jika kosong.</small>
    @error('slug')<div style="color:var(--danger);font-size:12.5px;margin-top:4px;">{{ $message }}</div>@enderror
</div>

<button type="submit" class="btn-primary">{{ isset($category) ? 'Update Kategori' : 'Simpan Kategori' }}</button>
<a href="{{ route('admin.categories.index') }}" class="btn-secondary">Batal</a>

<script>
function updateCatSlug() {
    const nameInput = document.getElementById('cat_name');
    const slugInput = document.getElementById('cat_slug');
    document.getElementById('cat_name_count').innerText = nameInput.value.length;
    if (slugInput.dataset.autoSync === 'true') {
        slugInput.value = nameInput.value.toString().toLowerCase().trim()
            .replace(/[^a-z0-9\s-]/g, '').replace(/\s+/g, '-').replace(/-+/g, '-');
    }
}
document.addEventListener('DOMContentLoaded', function () {
    const slugInput = document.getElementById('cat_slug');
    slugInput.dataset.autoSync = slugInput.value.trim() === '' ? 'true' : 'false';
    slugInput.addEventListener('input', function () { slugInput.dataset.autoSync = 'false'; });
    document.getElementById('cat_name_count').innerText = document.getElementById('cat_name').value.length;
});
</script>