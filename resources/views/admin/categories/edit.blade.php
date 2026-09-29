@extends('admin.layouts.app')

@section('title', 'Edit Kategori — ETECH Admin')

@section('content')
    <div class="page-head">
        <h1>Edit Kategori</h1>
    </div>

    <div class="panel" style="max-width:480px;padding:26px 24px;">
        <form action="{{ route('admin.categories.update', $category) }}" method="POST">
            @method('PUT')
            @include('admin.categories._form')
        </form>
    </div>
@endsection