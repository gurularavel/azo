@extends('layouts.admin')

@section('title', __('messages.manage_slides'))

@section('content')
<div class="d-flex align-items-center justify-content-between mb-3">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">{{ __('messages.admin_dashboard') }}</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ __('messages.manage_slides') }}</li>
        </ol>
    </nav>
    <a class="btn btn-outline-dark btn-sm" href="{{ route('admin.dashboard') }}">{{ __('messages.back_to_dashboard') }}</a>
</div>

<div class="d-flex align-items-center justify-content-between mb-3">
    <div>
        <h3 class="mb-1">{{ __('messages.manage_slides') }}</h3>
        <div class="text-muted small">{{ __('messages.drag_to_reorder') }}</div>
    </div>
    <div class="d-flex gap-2">
        <form method="post" action="{{ route('admin.hero-slides.order') }}" id="slide-order-form">
            @csrf
            <input type="hidden" name="order_list" id="slide-order-list" value="">
            <button class="btn btn-outline-dark btn-sm" type="submit">
                <i class="bi bi-arrow-down-up"></i> {{ __('messages.save_order') }}
            </button>
        </form>
        <a class="btn btn-brand" href="{{ route('admin.hero-slides.create') }}">
            <i class="bi bi-plus-lg"></i> {{ __('messages.add_slide') }}
        </a>
    </div>
</div>

<div class="card shadow-sm">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0" id="slides-sortable">
            <thead class="table-light">
                <tr>
                    <th style="width:36px"></th>
                    <th style="width:72px">{{ __('messages.image') }}</th>
                    <th>{{ __('messages.title') }}</th>
                    <th class="d-none d-md-table-cell">{{ __('messages.subtitle') }}</th>
                    <th style="width:100px">{{ __('messages.status') }}</th>
                    <th style="width:120px">{{ __('messages.actions') }}</th>
                </tr>
            </thead>
            <tbody>
            @forelse($slides as $slide)
                @php
                    $imageUrl = $slide->image_path
                        ? (str_starts_with($slide->image_path, 'http') ? $slide->image_path : asset('storage/'.$slide->image_path))
                        : null;
                @endphp
                <tr class="slide-item" data-id="{{ $slide->id }}">
                    <td>
                        <button class="drag-handle btn btn-link p-0 text-muted" type="button"
                                draggable="true" title="{{ __('messages.drag') }}">
                            <i class="bi bi-grip-vertical fs-5"></i>
                        </button>
                    </td>
                    <td>
                        @if($imageUrl)
                            <img src="{{ $imageUrl }}" alt="{{ $slide->title }}"
                                 class="slide-thumb-sm rounded">
                        @else
                            <div class="slide-thumb-sm rounded bg-light d-flex align-items-center justify-content-center text-muted">
                                <i class="bi bi-image"></i>
                            </div>
                        @endif
                    </td>
                    <td>
                        <span class="fw-semibold">{{ $slide->title }}</span>
                        @if($slide->button_text)
                            <div class="text-muted small mt-1">
                                <i class="bi bi-link-45deg"></i> {{ $slide->button_text }}
                            </div>
                        @endif
                    </td>
                    <td class="text-muted small d-none d-md-table-cell">
                        {{ Str::limit($slide->subtitle, 60) }}
                    </td>
                    <td>
                        <span class="badge {{ $slide->is_active ? 'bg-success-subtle text-success' : 'bg-secondary-subtle text-secondary' }} rounded-pill px-2 py-1">
                            <i class="bi {{ $slide->is_active ? 'bi-eye' : 'bi-eye-slash' }} me-1"></i>
                            {{ $slide->is_active ? __('messages.active') : __('messages.inactive') }}
                        </span>
                    </td>
                    <td>
                        <div class="d-flex gap-1">
                            <a class="btn btn-sm btn-outline-dark" href="{{ route('admin.hero-slides.edit', $slide) }}">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <form method="post" action="{{ route('admin.hero-slides.destroy', $slide) }}" class="m-0">
                                @csrf
                                @method('delete')
                                <button class="btn btn-sm btn-outline-danger" type="submit">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center text-muted py-4">
                        <i class="bi bi-images fs-3 d-block mb-2 opacity-50"></i>
                        {{ __('messages.no_slides') }}
                    </td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection

@push('styles')
<style>
    .slide-thumb-sm {
        width: 60px;
        height: 40px;
        object-fit: cover;
    }
    .drag-handle { cursor: grab; }
    .drag-handle:active { cursor: grabbing; }
    .slide-item.is-dragging { opacity: 0.45; background: #f8f9fa; }
</style>
@endpush

@push('scripts')
<script>
    const tbody      = document.querySelector('#slides-sortable tbody');
    const orderInput = document.getElementById('slide-order-list');
    let draggingRow  = null;

    function syncOrder() {
        if (!tbody || !orderInput) return;
        orderInput.value = [...tbody.querySelectorAll('.slide-item')]
            .map(r => r.dataset.id).filter(Boolean).join(',');
    }

    if (tbody) {
        tbody.addEventListener('dragstart', e => {
            const handle = e.target.closest('.drag-handle');
            if (!handle) { e.preventDefault(); return; }
            draggingRow = handle.closest('.slide-item');
            if (!draggingRow) { e.preventDefault(); return; }
            draggingRow.classList.add('is-dragging');
            e.dataTransfer.effectAllowed = 'move';
        });

        tbody.addEventListener('dragend', () => {
            if (!draggingRow) return;
            draggingRow.classList.remove('is-dragging');
            draggingRow = null;
            syncOrder();
        });

        tbody.addEventListener('dragover', e => {
            if (!draggingRow) return;
            e.preventDefault();
            const target = e.target.closest('.slide-item');
            if (target && target !== draggingRow) {
                const rect = target.getBoundingClientRect();
                const after = e.clientY > rect.top + rect.height / 2;
                tbody.insertBefore(draggingRow, after ? target.nextSibling : target);
            }
        });

        syncOrder();
    }
</script>
@endpush
