@extends('layouts.admin')

@section('title', $partner->exists ? __('messages.edit_partner') : __('messages.add_partner'))

@section('content')
@php
    $logoPreview = $partner->logo_path
        ? (str_starts_with($partner->logo_path, 'http') ? $partner->logo_path : asset('storage/' . $partner->logo_path))
        : null;
@endphp
<div class="d-flex align-items-center justify-content-between mb-3">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">{{ __('messages.admin_dashboard') }}</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.partners.index') }}">{{ __('messages.manage_partners') }}</a></li>
            <li class="breadcrumb-item active">{{ $partner->exists ? __('messages.edit_partner') : __('messages.add_partner') }}</li>
        </ol>
    </nav>
    <a class="btn btn-outline-dark btn-sm" href="{{ route('admin.partners.index') }}">{{ __('messages.back_to_partners') }}</a>
</div>

<div class="card shadow-sm p-4">
    <h3 class="mb-3">{{ $partner->exists ? __('messages.edit_partner') : __('messages.add_partner') }}</h3>
    <form method="post" enctype="multipart/form-data"
          action="{{ $partner->exists ? route('admin.partners.update', $partner) : route('admin.partners.store') }}">
        @csrf
        @if($partner->exists)
            @method('put')
        @endif

        <div class="mb-3">
            <label class="form-label">{{ __('messages.name') }}</label>
            <input class="form-control" name="name" value="{{ old('name', $partner->name) }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">{{ __('messages.logo') }}</label>
            <div class="dropzone" id="partner-dropzone">
                <div class="dropzone-content">
                    <i class="bi bi-cloud-arrow-up"></i>
                    <span>{{ __('messages.drag_drop_upload') }}</span>
                    <small class="text-muted">{{ __('messages.or_choose_file') }}</small>
                </div>
                <input class="form-control d-none" type="file" name="logo_file" id="partner-logo-input" accept="image/*">
            </div>
            @if($partner->logo_path)
                <small class="text-muted d-block mt-2">{{ __('messages.current_logo') }}: {{ $partner->logo_path }}</small>
                @if($logoPreview)
                    <img class="img-thumbnail mt-2" src="{{ $logoPreview }}" alt="{{ $partner->name }}" style="max-width:200px; max-height:120px; object-fit:contain;">
                @endif
            @endif
        </div>

        <div class="mb-3">
            <label class="form-label">{{ __('messages.logo_url') }}</label>
            <input class="form-control" name="logo_path" value="{{ old('logo_path', $partner->logo_path) }}" placeholder="https://...">
        </div>

        <div class="mb-3">
            <label class="form-label">{{ __('messages.website_url') }}</label>
            <input class="form-control" type="url" name="website_url" value="{{ old('website_url', $partner->website_url) }}" placeholder="https://...">
        </div>

        <div class="form-check mb-3">
            <input class="form-check-input" type="checkbox" name="is_active" id="is-active" value="1"
                   @checked(old('is_active', $partner->is_active ?? true))>
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
        transition: border-color .2s ease, background .2s ease;
    }
    .dropzone.is-dragover { border-color: #1f3b53; background: rgba(31,59,83,.05); }
    .dropzone-content { display: flex; flex-direction: column; gap: 6px; color: #1f3b53; }
    .dropzone-content i { font-size: 1.6rem; }
</style>
@endpush

@push('scripts')
<script>
    const dropzone = document.getElementById('partner-dropzone');
    const logoInput = document.getElementById('partner-logo-input');
    if (dropzone && logoInput) {
        dropzone.addEventListener('click', () => logoInput.click());
        dropzone.addEventListener('dragover', e => { e.preventDefault(); dropzone.classList.add('is-dragover'); });
        dropzone.addEventListener('dragleave', () => dropzone.classList.remove('is-dragover'));
        dropzone.addEventListener('drop', e => {
            e.preventDefault();
            dropzone.classList.remove('is-dragover');
            if (e.dataTransfer.files?.[0]) logoInput.files = e.dataTransfer.files;
        });
    }
</script>
@endpush
