@extends('layouts.admin')

@section('title', __('messages.manage_partners'))

@section('content')
<div class="d-flex align-items-center justify-content-between mb-3">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">{{ __('messages.admin_dashboard') }}</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ __('messages.manage_partners') }}</li>
        </ol>
    </nav>
    <a class="btn btn-outline-dark btn-sm" href="{{ route('admin.dashboard') }}">{{ __('messages.back_to_dashboard') }}</a>
</div>

<div class="d-flex align-items-center justify-content-between mb-3">
    <div>
        <h3 class="mb-1">{{ __('messages.manage_partners') }}</h3>
        <div class="text-muted small">{{ __('messages.drag_to_reorder') }}</div>
    </div>
    <div class="d-flex gap-2">
        <form method="post" action="{{ route('admin.partners.order') }}" id="partner-order-form">
            @csrf
            <input type="hidden" name="order_list" id="partner-order-list" value="">
            <button class="btn btn-outline-dark" type="submit"><i class="bi bi-arrow-down-up"></i> {{ __('messages.save_order') }}</button>
        </form>
        <a class="btn btn-brand" href="{{ route('admin.partners.create') }}"><i class="bi bi-plus-lg"></i> {{ __('messages.add_partner') }}</a>
    </div>
</div>

<div id="partners-sortable" class="row g-3">
    @forelse($partners as $partner)
        @php
            $logoUrl = $partner->logo_path
                ? (str_starts_with($partner->logo_path, 'http') ? $partner->logo_path : asset('storage/' . $partner->logo_path))
                : null;
        @endphp
        <div class="col-md-6 col-lg-4 col-xl-3 partner-item" data-id="{{ $partner->id }}">
            <div class="card shadow-sm h-100">
                <div class="partner-thumb">
                    @if($logoUrl)
                        <img src="{{ $logoUrl }}" alt="{{ $partner->name }}">
                    @else
                        <div class="d-flex align-items-center justify-content-center h-100 text-muted">
                            <i class="bi bi-image fs-1"></i>
                        </div>
                    @endif
                    <button class="btn btn-link p-0 drag-handle" type="button" draggable="true" aria-label="{{ __('messages.drag') }}">
                        <i class="bi bi-grip-vertical"></i>
                    </button>
                    <span class="badge {{ $partner->is_active ? 'bg-success' : 'bg-secondary' }}">
                        {{ $partner->is_active ? __('messages.active') : __('messages.inactive') }}
                    </span>
                </div>
                <div class="card-body">
                    <h5 class="card-title mb-1">{{ $partner->name }}</h5>
                    @if($partner->website_url)
                        <a href="{{ $partner->website_url }}" target="_blank" class="text-muted small text-truncate d-block">{{ $partner->website_url }}</a>
                    @endif
                    <div class="d-flex align-items-center gap-2 mt-2">
                        <a class="btn btn-sm btn-outline-dark" href="{{ route('admin.partners.edit', $partner) }}">{{ __('messages.edit') }}</a>
                        <form method="post" action="{{ route('admin.partners.destroy', $partner) }}" class="m-0">
                            @csrf
                            @method('delete')
                            <button class="btn btn-sm btn-outline-danger" type="submit">{{ __('messages.delete') }}</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @empty
        <div class="col-12">
            <div class="text-muted">{{ __('messages.no_partners') }}</div>
        </div>
    @endforelse
</div>
@endsection

@push('styles')
<style>
    .partner-thumb {
        position: relative;
        height: 160px;
        background: #f8f9fa;
        overflow: hidden;
        border-bottom: 1px solid #e9ecef;
    }
    .partner-thumb img {
        width: 100%;
        height: 100%;
        object-fit: contain;
        padding: 12px;
        display: block;
    }
    .drag-handle {
        position: absolute;
        top: 8px;
        left: 8px;
        color: #1f3b53;
        background: rgba(255,255,255,.85);
        border-radius: 8px;
        width: 30px;
        height: 30px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        cursor: grab;
    }
    .partner-thumb .badge {
        position: absolute;
        top: 8px;
        right: 8px;
    }
    .partner-item.is-dragging { opacity: 0.5; }
</style>
@endpush

@push('scripts')
<script>
    const sortable  = document.getElementById('partners-sortable');
    const orderInput = document.getElementById('partner-order-list');
    let draggingItem = null;

    function syncOrder() {
        if (!sortable || !orderInput) return;
        orderInput.value = Array.from(sortable.querySelectorAll('.partner-item'))
            .map(el => el.dataset.id).filter(Boolean).join(',');
    }

    function getAfterElement(container, y) {
        return [...container.querySelectorAll('.partner-item:not(.is-dragging)')]
            .reduce((closest, child) => {
                const box = child.getBoundingClientRect();
                const offset = y - box.top - box.height / 2;
                if (offset < 0 && offset > closest.offset) return { offset, element: child };
                return closest;
            }, { offset: Number.NEGATIVE_INFINITY, element: null }).element;
    }

    if (sortable) {
        sortable.addEventListener('dragstart', e => {
            const handle = e.target.closest('.drag-handle');
            if (!handle) { e.preventDefault(); return; }
            draggingItem = handle.closest('.partner-item');
            if (!draggingItem) { e.preventDefault(); return; }
            draggingItem.classList.add('is-dragging');
            e.dataTransfer.effectAllowed = 'move';
        });
        sortable.addEventListener('dragend', () => {
            if (!draggingItem) return;
            draggingItem.classList.remove('is-dragging');
            draggingItem = null;
            syncOrder();
        });
        sortable.addEventListener('dragover', e => {
            if (!draggingItem) return;
            e.preventDefault();
            const after = getAfterElement(sortable, e.clientY);
            if (!after) sortable.appendChild(draggingItem);
            else sortable.insertBefore(draggingItem, after);
        });
        syncOrder();
    }
</script>
@endpush
