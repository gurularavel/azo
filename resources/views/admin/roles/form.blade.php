@extends('layouts.admin')

@section('title', $role ? __('messages.edit_role') : __('messages.add_role'))

@section('content')
<div class="d-flex align-items-center justify-content-between mb-3">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">{{ __('messages.admin_dashboard') }}</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.roles.index') }}">{{ __('messages.manage_roles') }}</a></li>
            <li class="breadcrumb-item active">{{ $role ? __('messages.edit_role') : __('messages.add_role') }}</li>
        </ol>
    </nav>
    <a class="btn btn-outline-dark btn-sm" href="{{ route('admin.roles.index') }}">{{ __('messages.back_to_roles') }}</a>
</div>

<div class="row justify-content-center">
<div class="col-lg-9">

<form method="post"
      action="{{ $role ? route('admin.roles.update', $role) : route('admin.roles.store') }}">
    @csrf
    @if($role) @method('put') @endif

    {{-- Basic info --}}
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-white fw-semibold">{{ __('messages.role_info') }}</div>
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">{{ __('messages.role') }} (slug) <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror"
                           name="name"
                           value="{{ old('name', $role?->name) }}"
                           placeholder="e.g. editor"
                           {{ $role?->is_system ? 'readonly' : '' }}>
                    @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    @if($role?->is_system)
                        <div class="form-text text-warning"><i class="bi bi-lock"></i> {{ __('messages.role_system_name_locked') }}</div>
                    @else
                        <div class="form-text">{{ __('messages.role_name_hint') }}</div>
                    @endif
                </div>
                <div class="col-md-6">
                    <label class="form-label">{{ __('messages.role_label') }} <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('label') is-invalid @enderror"
                           name="label"
                           value="{{ old('label', $role?->label) }}"
                           placeholder="e.g. Editor">
                    @error('label')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>
        </div>
    </div>

    {{-- Section permissions --}}
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-white d-flex align-items-center justify-content-between">
            <span class="fw-semibold">{{ __('messages.permissions') }}</span>
            <div class="d-flex gap-2">
                <button type="button" class="btn btn-sm btn-outline-secondary" id="check-all">
                    <i class="bi bi-check2-all"></i> {{ __('messages.select_all') }}
                </button>
                <button type="button" class="btn btn-sm btn-outline-secondary" id="uncheck-all">
                    <i class="bi bi-x-lg"></i> {{ __('messages.deselect_all') }}
                </button>
            </div>
        </div>
        <div class="card-body">
            @php $currentPerms = old('permissions', $role?->permissions ?? []); @endphp
            <div class="row g-3">
                @foreach($sections as $slug => $transKey)
                @php
                    $icons = [
                        'shops'           => 'bi-shop',
                        'shop-categories' => 'bi-tags',
                        'cities'          => 'bi-geo-alt',
                        'users'           => 'bi-people',
                        'roles'           => 'bi-shield-lock',
                        'plans'           => 'bi-credit-card',
                        'transactions'    => 'bi-receipt',
                        'reports'         => 'bi-bar-chart-line',
                        'blogs'           => 'bi-newspaper',
                        'services'        => 'bi-grid',
                        'hero-slides'     => 'bi-images',
                        'features'        => 'bi-grid-3x3-gap',
                        'partners'        => 'bi-building',
                        'site-settings'   => 'bi-sliders',
                        'translations'    => 'bi-translate',
                    ];
                    $icon = $icons[$slug] ?? 'bi-folder';
                @endphp
                <div class="col-sm-6 col-md-4">
                    <div class="form-check perm-card p-3 border rounded-3 {{ in_array($slug, $currentPerms) ? 'border-primary bg-primary-subtle' : '' }}"
                         style="transition:.15s">
                        <input class="form-check-input perm-check" type="checkbox"
                               name="permissions[]"
                               value="{{ $slug }}"
                               id="perm_{{ $slug }}"
                               {{ in_array($slug, $currentPerms) ? 'checked' : '' }}>
                        <label class="form-check-label d-flex align-items-center gap-2 w-100" for="perm_{{ $slug }}" style="cursor:pointer">
                            <i class="bi {{ $icon }} fs-5 text-secondary"></i>
                            <span class="fw-semibold small">{{ __($transKey) }}</span>
                        </label>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <div class="text-end">
        <a class="btn btn-outline-dark me-2" href="{{ route('admin.roles.index') }}">{{ __('messages.back_to_roles') }}</a>
        <button class="btn btn-brand" type="submit">
            <i class="bi bi-floppy"></i> {{ __('messages.save') }}
        </button>
    </div>
</form>

</div>
</div>
@endsection

@push('styles')
<style>
    .perm-card { cursor: default; }
    .perm-card:has(.perm-check:checked) {
        border-color: #213b67 !important;
        background: rgba(33,59,103,.07) !important;
    }
</style>
@endpush

@push('scripts')
<script>
    document.getElementById('check-all').addEventListener('click', () => {
        document.querySelectorAll('.perm-check').forEach(c => { c.checked = true; c.dispatchEvent(new Event('change')); });
    });
    document.getElementById('uncheck-all').addEventListener('click', () => {
        document.querySelectorAll('.perm-check').forEach(c => { c.checked = false; c.dispatchEvent(new Event('change')); });
    });
</script>
@endpush
