@extends('layouts.admin')

@section('title', 'Site Settings')

@section('content')
<div class="d-flex align-items-center justify-content-between mb-3">
    <h3 class="mb-0">Site Settings</h3>
</div>

<div class="card shadow-sm">
    <div class="card-body">
        <form method="post" action="{{ route('admin.site-settings.update') }}" class="row g-3" enctype="multipart/form-data">
            @csrf
            @method('put')

            <div class="col-md-6">
                <label class="form-label">Site Name</label>
                <input type="text" name="site_name" class="form-control" value="{{ old('site_name', $settings->site_name) }}" required>
            </div>

            <div class="col-md-6">
                <label class="form-label">Contact Email</label>
                <input type="email" name="contact_email" class="form-control" value="{{ old('contact_email', $settings->contact_email) }}">
            </div>

            <div class="col-md-6">
                <label class="form-label">Contact Phone</label>
                <input type="text" name="contact_phone" class="form-control" value="{{ old('contact_phone', $settings->contact_phone) }}">
            </div>

            <div class="col-md-12">
                <label class="form-label">Hero Title</label>
                <input type="text" name="hero_title" class="form-control" value="{{ old('hero_title', $settings->hero_title) }}">
            </div>

            <div class="col-md-12">
                <label class="form-label">Hero Subtitle</label>
                <textarea name="hero_subtitle" class="form-control" rows="3">{{ old('hero_subtitle', $settings->hero_subtitle) }}</textarea>
            </div>

            <div class="col-md-6">
                <label class="form-label">Hero Primary Button Text</label>
                <input type="text" name="hero_primary_text" class="form-control" value="{{ old('hero_primary_text', $settings->hero_primary_text) }}">
            </div>

            <div class="col-md-6">
                <label class="form-label">Hero Primary Button URL</label>
                <input type="text" name="hero_primary_url" class="form-control" value="{{ old('hero_primary_url', $settings->hero_primary_url) }}">
            </div>

            <div class="col-md-6">
                <label class="form-label">Hero Secondary Button Text</label>
                <input type="text" name="hero_secondary_text" class="form-control" value="{{ old('hero_secondary_text', $settings->hero_secondary_text) }}">
            </div>

            <div class="col-md-6">
                <label class="form-label">Hero Secondary Button URL</label>
                <input type="text" name="hero_secondary_url" class="form-control" value="{{ old('hero_secondary_url', $settings->hero_secondary_url) }}">
            </div>

            {{-- Hero Image --}}
            <div class="col-12">
                <h5 class="mt-2 mb-1">Hero Şəkli</h5>
                <p class="text-muted small mb-2">Əsas səhifənin sağ tərəfindəki şəkil. Hero Slide şəkli varsa, o üstünlük qazanır.</p>
            </div>

            <div class="col-md-12">
                <label class="form-label">Şəkli yüklə</label>
                <div class="dropzone" id="hero-dropzone">
                    <div class="dropzone-content">
                        <i class="bi bi-cloud-arrow-up"></i>
                        <span>{{ __('messages.drag_drop_upload') }}</span>
                        <small class="text-muted">{{ __('messages.or_choose_file') }}</small>
                    </div>
                    <input class="form-control d-none" type="file" name="hero_image_file" id="hero-image-input" accept="image/*">
                </div>
                @php
                    $heroImgPreview = $settings->hero_image
                        ? (str_starts_with($settings->hero_image, 'http') ? $settings->hero_image : asset('storage/' . $settings->hero_image))
                        : null;
                @endphp
                @if($heroImgPreview)
                    <div class="mt-2 d-flex align-items-center gap-3">
                        <img src="{{ $heroImgPreview }}" alt="Hero" style="max-height:120px; max-width:220px; object-fit:contain; border-radius:8px; border:1px solid #dee2e6;">
                        <small class="text-muted">{{ $settings->hero_image }}</small>
                    </div>
                @endif
            </div>

            <div class="col-md-12">
                <label class="form-label">Şəkil URL (yükləmə əvəzinə)</label>
                <input type="text" name="hero_image" class="form-control" value="{{ old('hero_image', $settings->hero_image) }}" placeholder="https://... və ya boş buraxın">
            </div>

            <div class="col-12">
                <h5 class="mt-2 mb-2">Hero Statistics</h5>
            </div>

            <div class="col-md-4">
                <label class="form-label">Users Value</label>
                <input type="text" name="hero_stat_users_value" class="form-control" value="{{ old('hero_stat_users_value', $settings->hero_stat_users_value) }}">
            </div>

            <div class="col-md-8">
                <label class="form-label">Users Label</label>
                <input type="text" name="hero_stat_users_label" class="form-control" value="{{ old('hero_stat_users_label', $settings->hero_stat_users_label) }}">
            </div>

            <div class="col-md-4">
                <label class="form-label">Partners Value</label>
                <input type="text" name="hero_stat_partners_value" class="form-control" value="{{ old('hero_stat_partners_value', $settings->hero_stat_partners_value) }}">
            </div>

            <div class="col-md-8">
                <label class="form-label">Partners Label</label>
                <input type="text" name="hero_stat_partners_label" class="form-control" value="{{ old('hero_stat_partners_label', $settings->hero_stat_partners_label) }}">
            </div>

            <div class="col-md-4">
                <label class="form-label">Average Saving Value</label>
                <input type="text" name="hero_stat_savings_value" class="form-control" value="{{ old('hero_stat_savings_value', $settings->hero_stat_savings_value) }}">
            </div>

            <div class="col-md-8">
                <label class="form-label">Average Saving Label</label>
                <input type="text" name="hero_stat_savings_label" class="form-control" value="{{ old('hero_stat_savings_label', $settings->hero_stat_savings_label) }}">
            </div>

            <div class="col-md-4">
                <label class="form-label">Facebook URL</label>
                <input type="url" name="facebook_url" class="form-control" value="{{ old('facebook_url', $settings->facebook_url) }}">
            </div>

            <div class="col-md-4">
                <label class="form-label">Instagram URL</label>
                <input type="url" name="instagram_url" class="form-control" value="{{ old('instagram_url', $settings->instagram_url) }}">
            </div>

            <div class="col-md-4">
                <label class="form-label">YouTube URL</label>
                <input type="url" name="youtube_url" class="form-control" value="{{ old('youtube_url', $settings->youtube_url) }}">
            </div>

            <div class="col-md-12">
                <label class="form-label">Footer Text</label>
                <textarea name="footer_text" class="form-control" rows="3">{{ old('footer_text', $settings->footer_text) }}</textarea>
            </div>

            {{-- Legal Content --}}
            <div class="col-12 mt-2">
                <h5 class="mb-1">{{ __('messages.terms_title') }}</h5>
                <p class="text-muted small mb-2">{{ __('messages.terms_hint') }}</p>
            </div>

            <div class="col-12">
                <label class="form-label">{{ __('messages.terms_title') }}</label>
                <textarea name="terms_content" id="terms-editor" class="form-control summernote-editor">{{ old('terms_content', $settings->terms_content) }}</textarea>
            </div>

            <div class="col-12 mt-2">
                <h5 class="mb-1">{{ __('messages.privacy_title') }}</h5>
                <p class="text-muted small mb-2">{{ __('messages.privacy_hint') }}</p>
            </div>

            <div class="col-12">
                <label class="form-label">{{ __('messages.privacy_title') }}</label>
                <textarea name="privacy_content" id="privacy-editor" class="form-control summernote-editor">{{ old('privacy_content', $settings->privacy_content) }}</textarea>
            </div>

            <div class="col-12">
                <button class="btn btn-primary" type="submit"><i class="bi bi-floppy"></i> {{ __('messages.save') }}</button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/summernote@0.9.0/dist/summernote-bs5.min.css" rel="stylesheet">
<style>
    .dropzone {
        border: 2px dashed #cbd3da;
        border-radius: 16px;
        padding: 24px;
        text-align: center;
        cursor: pointer;
        transition: border-color .2s, background .2s;
    }
    .dropzone.is-dragover { border-color: #1f3b53; background: rgba(31,59,83,.05); }
    .dropzone-content { display: flex; flex-direction: column; gap: 6px; color: #1f3b53; }
    .dropzone-content i { font-size: 1.6rem; }
</style>
@endpush

@push('scripts')
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/summernote@0.9.0/dist/summernote-bs5.min.js"></script>
<script>
    $(document).ready(function () {
        const summernoteConfig = {
            height: 320,
            toolbar: [
                ['style', ['style']],
                ['font', ['bold', 'italic', 'underline', 'strikethrough', 'clear']],
                ['fontsize', ['fontsize']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['table', ['table']],
                ['insert', ['link', 'hr']],
                ['view', ['fullscreen', 'codeview']],
            ],
        };
        $('#terms-editor').summernote(summernoteConfig);
        $('#privacy-editor').summernote(summernoteConfig);
    });

    const dropzone  = document.getElementById('hero-dropzone');
    const imgInput  = document.getElementById('hero-image-input');
    if (dropzone && imgInput) {
        dropzone.addEventListener('click', () => imgInput.click());
        dropzone.addEventListener('dragover', e => { e.preventDefault(); dropzone.classList.add('is-dragover'); });
        dropzone.addEventListener('dragleave', () => dropzone.classList.remove('is-dragover'));
        dropzone.addEventListener('drop', e => {
            e.preventDefault();
            dropzone.classList.remove('is-dragover');
            if (e.dataTransfer.files?.[0]) imgInput.files = e.dataTransfer.files;
        });
        imgInput.addEventListener('change', () => {
            const file = imgInput.files[0];
            if (!file) return;
            const reader = new FileReader();
            reader.onload = ev => {
                let preview = dropzone.querySelector('.upload-preview');
                if (!preview) {
                    preview = document.createElement('img');
                    preview.className = 'upload-preview mt-2';
                    preview.style.cssText = 'max-height:100px;max-width:200px;object-fit:contain;border-radius:8px;border:1px solid #dee2e6;';
                    dropzone.appendChild(preview);
                }
                preview.src = ev.target.result;
            };
            reader.readAsDataURL(file);
        });
    }
</script>
@endpush
