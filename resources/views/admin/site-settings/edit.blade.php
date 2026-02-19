@extends('layouts.admin')

@section('title', 'Site Settings')

@section('content')
<div class="d-flex align-items-center justify-content-between mb-3">
    <h3 class="mb-0">Site Settings</h3>
</div>

<div class="card shadow-sm">
    <div class="card-body">
        <form method="post" action="{{ route('admin.site-settings.update') }}" class="row g-3">
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

            <div class="col-12">
                <button class="btn btn-primary" type="submit">Save Settings</button>
            </div>
        </form>
    </div>
</div>
@endsection
