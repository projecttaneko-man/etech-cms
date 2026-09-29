@extends('admin.layouts.app')

@section('title', 'Tambah Artikel — ETECH Admin')

@section('content')
    <div class="page-head">
        <h1>Tambah Artikel</h1>
        <a href="{{ route('admin.articles.index') }}" class="btn-secondary">&larr; Kembali</a>
    </div>

    @if($errors->any())
        <div class="alert-success" style="background:#F7E4DA;color:var(--danger);">
            Ada kesalahan pada input, silakan periksa kembali form di bawah.
        </div>
    @endif

    <form action="{{ route('admin.articles.store') }}" method="POST" enctype="multipart/form-data">
        @include('admin.articles._form')
    </form>
@endsection

@section('js')
    <script src="https://cdn.ckeditor.com/ckeditor5/41.3.1/classic/ckeditor.js"></script>
    <script>
        ClassicEditor.create(document.querySelector('#content'));
    </script>
    <script>
    function updateSeoPreview() {
        const title = document.getElementById('meta_title').value || document.getElementById('title').value || 'Judul artikel akan tampil di sini';
        const desc = document.getElementById('meta_description').value || 'Deskripsi artikel akan tampil di sini.';
        const slug = document.getElementById('slug').value || 'slug-artikel';

        document.getElementById('seo_preview_title').innerText = title;
        document.getElementById('seo_preview_desc').innerText = desc;
        document.getElementById('meta_title_count').innerText = document.getElementById('meta_title').value.length;
        document.getElementById('meta_description_count').innerText = document.getElementById('meta_description').value.length;
        document.getElementById('seo_preview_slug').innerText = slug;
        document.getElementById('seo_preview_slug_2').innerText = slug;
    }
    document.addEventListener('DOMContentLoaded', updateSeoPreview);
    document.getElementById('title').addEventListener('input', updateSeoPreview);
    document.getElementById('meta_title').addEventListener('input', updateSeoPreview);
    document.getElementById('meta_description').addEventListener('input', updateSeoPreview);
    </script>
    <script>
    document.addEventListener('DOMContentLoaded', function () {
        const titleInput = document.getElementById('title');
        const slugInput = document.getElementById('slug');
        let slugManuallyEdited = slugInput.value.trim() !== '';

        function slugify(text) {
            return text.toString().toLowerCase().trim()
                .replace(/[^a-z0-9\s-]/g, '')
                .replace(/\s+/g, '-')
                .replace(/-+/g, '-');
        }

        titleInput.addEventListener('input', function () {
            if (!slugManuallyEdited) {
                slugInput.value = slugify(titleInput.value);
                updateSeoPreview();
            }
        });

        slugInput.addEventListener('input', function () {
            slugManuallyEdited = true;
            updateSeoPreview();
        });
    });
    </script>
@endsection