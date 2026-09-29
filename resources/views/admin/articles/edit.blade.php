@extends('admin.layouts.app')

@section('title', 'Edit Artikel')

@section('content')
    <div class="page-head">
        <h1>Edit Artikel</h1>
        <a href="{{ route('admin.articles.index') }}" class="btn-secondary">
            Kembali
        </a>
    </div>

    @if ($errors->any())
        <div class="alert-success" style="background:var(--draft-bg);color:var(--danger);">
            <strong>Ups!</strong> Periksa kembali isian formulir di bawah.
        </div>
    @endif

    <form action="{{ route('admin.articles.update', $article) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
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
        const title = document.getElementById('meta_title').value || document.querySelector('[name="title"]').value || 'Judul artikel akan tampil di sini';
        const desc = document.getElementById('meta_description').value || 'Deskripsi artikel akan tampil di sini.';

        document.getElementById('seo_preview_title').innerText = title;
        document.getElementById('seo_preview_desc').innerText = desc;
        document.getElementById('meta_title_count').innerText = document.getElementById('meta_title').value.length;
        document.getElementById('meta_description_count').innerText = document.getElementById('meta_description').value.length;
        document.getElementById('seo_preview_slug').innerText = document.getElementById('slug').value || 'slug-artikel';
        document.getElementById('seo_preview_slug_2').innerText = document.getElementById('slug').value || 'slug-artikel';
    }
    document.addEventListener('DOMContentLoaded', updateSeoPreview);

    document.querySelector('[name="title"]').addEventListener('input', updateSeoPreview);
    document.getElementById('meta_title').addEventListener('input', updateSeoPreview);
    document.getElementById('meta_description').addEventListener('input', updateSeoPreview);
    document.getElementById('slug').addEventListener('input', updateSeoPreview);
    </script>
@endsection