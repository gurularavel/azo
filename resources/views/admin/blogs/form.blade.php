@extends('layouts.admin')

@section('title', $blog->exists ? __('messages.edit_blog') : __('messages.add_blog'))

@section('content')
@php
    $coverPreview = $blog->cover_image_path
        ? (str_starts_with($blog->cover_image_path, 'http') ? $blog->cover_image_path : asset('storage/'.$blog->cover_image_path))
        : null;
@endphp
<div class="d-flex align-items-center justify-content-between mb-3">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">{{ __('messages.admin_dashboard') }}</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.blogs.index') }}">{{ __('messages.manage_blogs') }}</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ $blog->exists ? __('messages.edit_blog') : __('messages.add_blog') }}</li>
        </ol>
    </nav>
    <a class="btn btn-outline-dark btn-sm" href="{{ route('admin.blogs.index') }}">{{ __('messages.back_to_blogs') }}</a>
</div>
<div class="card shadow-sm p-4">
    <h3 class="mb-3">{{ $blog->exists ? __('messages.edit_blog') : __('messages.add_blog') }}</h3>
    <form method="post" enctype="multipart/form-data" action="{{ $blog->exists ? route('admin.blogs.update', $blog) : route('admin.blogs.store') }}">
        @csrf
        @if($blog->exists)
            @method('put')
        @endif
        <div class="mb-3">
            <label class="form-label">{{ __('messages.title') }}</label>
            <input class="form-control" name="title" value="{{ old('title', $blog->title) }}" required>
        </div>
        <div class="mb-3">
            <label class="form-label">{{ __('messages.slug') }}</label>
            <input class="form-control" name="slug" value="{{ old('slug', $blog->slug) }}" placeholder="{{ __('messages.slug_hint') }}">
        </div>
        <div class="mb-3">
            <label class="form-label">{{ __('messages.excerpt') }}</label>
            <textarea class="form-control js-summernote" name="excerpt" rows="3">{{ old('excerpt', $blog->excerpt) }}</textarea>
        </div>
        <div class="mb-3">
            <label class="form-label">{{ __('messages.content') }}</label>
            <textarea class="form-control js-summernote" name="body" rows="10">{{ old('body', $blog->body) }}</textarea>
        </div>
        <div class="mb-3">
            <label class="form-label">{{ __('messages.cover_image') }}</label>
            <input class="form-control" name="cover_image_path" value="{{ old('cover_image_path', $blog->cover_image_path) }}" placeholder="https://">
        </div>
        <div class="mb-3">
            <label class="form-label">{{ __('messages.cover_upload') }}</label>
            <input class="form-control" type="file" name="cover_image_file" accept="image/*">
            @if($coverPreview)
                <img class="img-thumbnail mt-2 blog-cover-thumb" src="{{ $coverPreview }}" alt="{{ $blog->title }}">
            @endif
        </div>
        <div class="form-check mb-2">
            <input class="form-check-input" type="checkbox" name="is_published" value="1" id="is-published" {{ old('is_published', $blog->is_published) ? 'checked' : '' }}>
            <label class="form-check-label" for="is-published">{{ __('messages.published') }}</label>
        </div>
        <div class="form-check mb-3">
            <input class="form-check-input" type="checkbox" name="show_on_home" value="1" id="show-on-home" {{ old('show_on_home', $blog->show_on_home) ? 'checked' : '' }}>
            <label class="form-check-label" for="show-on-home">{{ __('messages.show_on_home') }}</label>
        </div>
        <button class="btn btn-brand" type="submit">{{ __('messages.save') }}</button>
    </form>
</div>
@endsection

@push('styles')
<style>
    .blog-cover-thumb {
        max-width: 240px;
        width: 100%;
        height: auto;
        object-fit: cover;
    }
</style>
@endpush
