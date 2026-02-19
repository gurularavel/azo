@extends('layouts.admin')

@section('title', __('messages.manage_translations'))

@section('content')
<div class="d-flex align-items-center justify-content-between mb-3">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">{{ __('messages.admin_dashboard') }}</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ __('messages.manage_translations') }}</li>
        </ol>
    </nav>
    <a class="btn btn-outline-dark btn-sm" href="{{ route('admin.dashboard') }}">{{ __('messages.back_to_dashboard') }}</a>
</div>

<div class="d-flex align-items-center justify-content-between mb-3">
    <h3 class="mb-0">{{ __('messages.manage_translations') }}</h3>
    <div class="d-flex align-items-center gap-2">
        <input type="text" id="key-search" class="form-control form-control-sm" style="width:220px"
               placeholder="🔍 Filter keys…">
        <button form="translations-form" class="btn btn-brand" type="submit">
            <i class="bi bi-floppy"></i> {{ __('messages.save') }}
        </button>
    </div>
</div>

<form id="translations-form" method="post" action="{{ route('admin.translations.update') }}">
    @csrf
    @method('put')

    <div class="card shadow-sm">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0" id="trans-table">
                <thead class="table-light">
                    <tr>
                        <th style="width:220px" class="text-muted small fw-semibold">KEY</th>
                        @foreach($locales as $locale)
                        <th class="text-muted small fw-semibold text-uppercase">{{ $locale }}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                @foreach($keys as $key)
                <tr class="trans-row" data-key="{{ $key }}">
                    <td>
                        <code class="text-secondary" style="font-size:.78rem">{{ $key }}</code>
                    </td>
                    @foreach($locales as $locale)
                    <td>
                        <input type="text"
                               class="form-control form-control-sm"
                               name="translations[{{ $locale }}][{{ $key }}]"
                               value="{{ $translations[$locale][$key] ?? '' }}">
                    </td>
                    @endforeach
                </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-3 text-end">
        <button class="btn btn-brand" type="submit">
            <i class="bi bi-floppy"></i> {{ __('messages.save') }}
        </button>
    </div>
</form>
@endsection

@push('scripts')
<script>
    document.getElementById('key-search').addEventListener('input', function () {
        const q = this.value.toLowerCase();
        document.querySelectorAll('#trans-table .trans-row').forEach(row => {
            row.style.display = row.dataset.key.toLowerCase().includes(q) ? '' : 'none';
        });
    });
</script>
@endpush
