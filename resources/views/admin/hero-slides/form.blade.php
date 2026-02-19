@extends('layouts.admin')

@section('title', $slide->exists ? __('messages.edit_slide') : __('messages.add_slide'))

@section('content')
@php
    $imagePreview = $slide->image_path
        ? (str_starts_with($slide->image_path, 'http') ? $slide->image_path : asset('storage/'.$slide->image_path))
        : null;
@endphp
<div class="d-flex align-items-center justify-content-between mb-3">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">{{ __('messages.admin_dashboard') }}</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.hero-slides.index') }}">{{ __('messages.manage_slides') }}</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ $slide->exists ? __('messages.edit_slide') : __('messages.add_slide') }}</li>
        </ol>
    </nav>
    <a class="btn btn-outline-dark btn-sm" href="{{ route('admin.hero-slides.index') }}">{{ __('messages.back_to_slides') }}</a>
</div>

<div class="card shadow-sm p-4">
    <h3 class="mb-3">{{ $slide->exists ? __('messages.edit_slide') : __('messages.add_slide') }}</h3>
    <form method="post" enctype="multipart/form-data" action="{{ $slide->exists ? route('admin.hero-slides.update', $slide) : route('admin.hero-slides.store') }}">
        @csrf
        @if($slide->exists)
            @method('put')
        @endif
        <div class="mb-3">
            <label class="form-label">{{ __('messages.title') }}</label>
            <input class="form-control" name="title" value="{{ old('title', $slide->title) }}" required>
        </div>
        <div class="mb-3">
            <label class="form-label">{{ __('messages.subtitle') }}</label>
            <input class="form-control" name="subtitle" value="{{ old('subtitle', $slide->subtitle) }}">
        </div>
        <div class="mb-3">
            <label class="form-label">{{ __('messages.button_text') }}</label>
            <input class="form-control" name="button_text" value="{{ old('button_text', $slide->button_text) }}">
        </div>
        <div class="mb-3">
            <label class="form-label">{{ __('messages.button_url') }}</label>
            <input class="form-control" name="button_url" value="{{ old('button_url', $slide->button_url) }}">
        </div>
        <div class="mb-3">
            <label class="form-label">{{ __('messages.image') }}</label>
            <div class="dropzone" id="slide-dropzone">
                <div class="dropzone-content">
                    <i class="bi bi-cloud-arrow-up"></i>
                    <span>{{ __('messages.drag_drop_upload') }}</span>
                    <small class="text-muted">{{ __('messages.or_choose_file') }}</small>
                </div>
                <input class="form-control d-none" type="file" name="image_file" id="slide-image-input" accept="image/*">
            </div>
            @if($slide->image_path)
                <small class="text-muted d-block mt-2">{{ __('messages.current_image') }}: {{ $slide->image_path }}</small>
                @if($imagePreview)
                    <img class="img-thumbnail mt-2 slide-preview" src="{{ $imagePreview }}" alt="slide">
                @endif
            @endif
        </div>
        <div class="mb-3">
            <label class="form-label">{{ __('messages.image_url') }}</label>
            <input class="form-control" name="image_path" value="{{ old('image_path', $slide->image_path) }}">
        </div>
        <div class="form-check mb-3">
            <input class="form-check-input" type="checkbox" name="is_active" id="is-active" value="1" @checked(old('is_active', $slide->is_active))>
            <label class="form-check-label" for="is-active">{{ __('messages.active') }}</label>
        </div>
        <button class="btn btn-brand" type="submit"><i class="bi bi-floppy"></i> {{ __('messages.save') }}</button>
    </form>
</div>
@endsection

@push('styles')
<style>
    .dropzone {
        border: 2px dashed #cbd3da;
        border-radius: 16px;
        padding: 24px;
        text-align: center;
        cursor: pointer;
        transition: border-color 0.2s ease, background 0.2s ease;
    }
    .dropzone.is-dragover {
        border-color: #1f3b53;
        background: rgba(31, 59, 83, 0.05);
    }
    .dropzone-content {
        display: flex;
        flex-direction: column;
        gap: 6px;
        color: #1f3b53;
    }
    .dropzone-content i {
        font-size: 1.6rem;
    }
    .slide-preview {
        max-width: 280px;
        width: 100%;
        height: auto;
        object-fit: cover;
    }
</style>
@endpush

@push('scripts')
<script>
    const dropzone = document.getElementById('slide-dropzone');
    const imageInput = document.getElementById('slide-image-input');

    if (dropzone && imageInput) {
        dropzone.addEventListener('click', () => imageInput.click());

        dropzone.addEventListener('dragover', (event) => {
            event.preventDefault();
            dropzone.classList.add('is-dragover');
        });

        dropzone.addEventListener('dragleave', () => {
            dropzone.classList.remove('is-dragover');
        });

        dropzone.addEventListener('drop', (event) => {
            event.preventDefault();
            dropzone.classList.remove('is-dragover');
            if (event.dataTransfer.files && event.dataTransfer.files[0]) {
                imageInput.files = event.dataTransfer.files;
            }
        });
    }
</script>
@endpush
