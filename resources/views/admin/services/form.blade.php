@extends('layouts.admin')

@section('title', $service->exists ? __('messages.edit_service') : __('messages.add_service'))

@section('content')
@php
    $imageUrl = $service->image_path
        ? (str_starts_with($service->image_path, 'http') ? $service->image_path : asset('storage/'.$service->image_path))
        : null;
@endphp

<div class="d-flex align-items-center justify-content-between mb-3">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">{{ __('messages.admin_dashboard') }}</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.services.index') }}">{{ __('messages.manage_services') }}</a></li>
            <li class="breadcrumb-item active">{{ $service->exists ? __('messages.edit_service') : __('messages.add_service') }}</li>
        </ol>
    </nav>
    <a class="btn btn-outline-dark btn-sm" href="{{ route('admin.services.index') }}">{{ __('messages.back_to_services') }}</a>
</div>

<form method="post" enctype="multipart/form-data"
      action="{{ $service->exists ? route('admin.services.update', $service) : route('admin.services.store') }}">
    @csrf
    @if($service->exists) @method('put') @endif

    <div class="row g-4">

        {{-- Left column --}}
        <div class="col-lg-8">

            <div class="card shadow-sm mb-4">
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">{{ __('messages.title') }} <span class="text-danger">*</span></label>
                        <input class="form-control @error('title') is-invalid @enderror"
                               name="title" value="{{ old('title', $service->title) }}" required>
                        @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">{{ __('messages.slug') }}</label>
                        <input class="form-control" name="slug"
                               value="{{ old('slug', $service->slug) }}"
                               placeholder="{{ __('messages.slug_hint') }}">
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">{{ __('messages.excerpt') }}</label>
                        <textarea class="form-control" name="excerpt" rows="3"
                                  placeholder="Xidmətin qısa təsviri...">{{ old('excerpt', $service->excerpt) }}</textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">{{ __('messages.content') }}</label>
                        <textarea id="service-body" name="body" rows="14">{{ old('body', $service->body) }}</textarea>
                    </div>
                </div>
            </div>

        </div>

        {{-- Right column --}}
        <div class="col-lg-4">

            {{-- Publish settings --}}
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-white fw-semibold">{{ __('messages.status') }}</div>
                <div class="card-body">
                    <div class="form-check form-switch mb-3">
                        <input class="form-check-input" type="checkbox" name="is_published" value="1"
                               id="is-published"
                               {{ old('is_published', $service->is_published) ? 'checked' : '' }}>
                        <label class="form-check-label" for="is-published">{{ __('messages.published') }}</label>
                    </div>
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" name="show_on_home" value="1"
                               id="show-on-home"
                               {{ old('show_on_home', $service->show_on_home) ? 'checked' : '' }}>
                        <label class="form-check-label" for="show-on-home">{{ __('messages.show_on_home') }}</label>
                    </div>
                </div>
                <div class="card-footer bg-white d-flex justify-content-end">
                    <button class="btn btn-brand" type="submit">
                        <i class="bi bi-floppy"></i> {{ __('messages.save') }}
                    </button>
                </div>
            </div>

            {{-- Image --}}
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-white fw-semibold">{{ __('messages.image') }}</div>
                <div class="card-body">
                    {{-- Dropzone --}}
                    <div id="image-dropzone"
                         class="border border-dashed rounded-3 text-center p-4 mb-3 position-relative"
                         style="cursor:pointer; border-color:#ced4da; min-height:140px; display:flex; flex-direction:column; align-items:center; justify-content:center;">
                        <input type="file" name="image_file" id="image-file-input"
                               accept="image/*" class="position-absolute top-0 start-0 w-100 h-100 opacity-0"
                               style="cursor:pointer">
                        <div id="dropzone-placeholder">
                            <i class="bi bi-cloud-arrow-up fs-2 text-muted d-block mb-2"></i>
                            <span class="text-muted small">{{ __('messages.drag_drop_upload') }}</span><br>
                            <span class="text-muted small">{{ __('messages.or_choose_file') }}</span>
                        </div>
                        <img id="image-preview" src="{{ $imageUrl }}"
                             class="img-fluid rounded-2 {{ $imageUrl ? '' : 'd-none' }}"
                             style="max-height:180px; object-fit:cover" alt="">
                    </div>

                    <label class="form-label small text-muted">{{ __('messages.image_url') }}</label>
                    <input class="form-control form-control-sm" name="image_path"
                           value="{{ old('image_path', !str_starts_with($service->image_path ?? '', 'services/') ? $service->image_path : '') }}"
                           placeholder="https://">
                </div>
            </div>

        </div>
    </div>
</form>
@endsection

@push('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/summernote@0.9.0/dist/summernote-bs5.min.css">
<style>
    #image-dropzone:hover { border-color: #213b67 !important; background: #f8f9ff; }
    .note-editor.note-frame { border-radius: .5rem; overflow: hidden; }
</style>
@endpush

@push('scripts')
{{-- jQuery must load before Summernote; Bootstrap JS is already on the page --}}
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/summernote@0.9.0/dist/summernote-bs5.min.js"></script>
<script>
$(document).ready(function () {

    $('#service-body').summernote({
        height: 400,
        toolbar: [
            ['style',  ['style']],
            ['font',   ['bold', 'italic', 'underline', 'strikethrough', 'clear']],
            ['color',  ['color']],
            ['para',   ['ul', 'ol', 'paragraph']],
            ['table',  ['table']],
            ['insert', ['link', 'picture', 'hr']],
            ['view',   ['fullscreen', 'codeview']],
        ],
        callbacks: {
            onImageUpload: function (files) {
                var reader = new FileReader();
                reader.onloadend = function () {
                    var img = document.createElement('img');
                    img.src = reader.result;
                    img.style.maxWidth = '100%';
                    $('#service-body').summernote('insertNode', img);
                };
                reader.readAsDataURL(files[0]);
            }
        }
    });

    // Dropzone file preview
    $('#image-file-input').on('change', function () {
        var file = this.files[0];
        if (!file) return;
        var reader = new FileReader();
        reader.onload = function (e) {
            $('#image-preview').attr('src', e.target.result).removeClass('d-none');
            $('#dropzone-placeholder').addClass('d-none');
        };
        reader.readAsDataURL(file);
    });

});
</script>
@endpush
