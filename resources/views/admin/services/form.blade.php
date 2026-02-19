@extends('layouts.admin')

@section('title', $service->exists ? __('messages.edit_service') : __('messages.add_service'))

@section('content')
@php
    $imagePreview = $service->image_path
        ? (str_starts_with($service->image_path, 'http') ? $service->image_path : asset('storage/'.$service->image_path))
        : null;
@endphp
<div class="d-flex align-items-center justify-content-between mb-3">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">{{ __('messages.admin_dashboard') }}</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.services.index') }}">{{ __('messages.manage_services') }}</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ $service->exists ? __('messages.edit_service') : __('messages.add_service') }}</li>
        </ol>
    </nav>
    <a class="btn btn-outline-dark btn-sm" href="{{ route('admin.services.index') }}">{{ __('messages.back_to_services') }}</a>
</div>
<div class="card shadow-sm p-4">
    <h3 class="mb-3">{{ $service->exists ? __('messages.edit_service') : __('messages.add_service') }}</h3>
    <form method="post" enctype="multipart/form-data" action="{{ $service->exists ? route('admin.services.update', $service) : route('admin.services.store') }}">
        @csrf
        @if($service->exists)
            @method('put')
        @endif
        <div class="mb-3">
            <label class="form-label">{{ __('messages.title') }}</label>
            <input class="form-control" name="title" value="{{ old('title', $service->title) }}" required>
        </div>
        <div class="mb-3">
            <label class="form-label">{{ __('messages.slug') }}</label>
            <input class="form-control" name="slug" value="{{ old('slug', $service->slug) }}" placeholder="{{ __('messages.slug_hint') }}">
        </div>
        <div class="mb-3">
            <label class="form-label">{{ __('messages.excerpt') }}</label>
            <textarea class="form-control js-summernote" name="excerpt" rows="3">{{ old('excerpt', $service->excerpt) }}</textarea>
        </div>
        <div class="mb-3">
            <label class="form-label">{{ __('messages.content') }}</label>
            <textarea class="form-control js-summernote" name="body" rows="10">{{ old('body', $service->body) }}</textarea>
        </div>
        <div class="mb-3">
            <label class="form-label">{{ __('messages.image_url') }}</label>
            <input class="form-control" name="image_path" value="{{ old('image_path', $service->image_path) }}" placeholder="https://">
        </div>
        <div class="mb-3">
            <label class="form-label">{{ __('messages.image_upload') }}</label>
            <input class="form-control" type="file" name="image_file" accept="image/*">
            @if($imagePreview)
                <img class="img-thumbnail mt-2 service-image-thumb" src="{{ $imagePreview }}" alt="{{ $service->title }}">
            @endif
        </div>
        <div class="form-check mb-3">
            <input class="form-check-input" type="checkbox" name="is_published" value="1" id="is-published" {{ old('is_published', $service->is_published) ? 'checked' : '' }}>
            <label class="form-check-label" for="is-published">{{ __('messages.published') }}</label>
        </div>
        <button class="btn btn-brand" type="submit">{{ __('messages.save') }}</button>
    </form>
</div>
@endsection

@push('styles')
<style>
    .service-image-thumb {
        max-width: 240px;
        width: 100%;
        height: auto;
        object-fit: cover;
    }
</style>
@endpush
