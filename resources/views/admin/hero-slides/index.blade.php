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
            <button class="btn btn-outline-dark" type="submit">{{ __('messages.save_order') }}</button>
        </form>
        <a class="btn btn-brand" href="{{ route('admin.hero-slides.create') }}">{{ __('messages.add_slide') }}</a>
    </div>
</div>

<div id="slides-sortable" class="row g-3">
    @forelse($slides as $slide)
        @php
            $imageUrl = $slide->image_path
                ? (str_starts_with($slide->image_path, 'http') ? $slide->image_path : asset('storage/'.$slide->image_path))
                : null;
        @endphp
        <div class="col-md-6 col-lg-4 slide-item" data-id="{{ $slide->id }}">
            <div class="card shadow-sm h-100">
                <div class="slide-thumb">
                    @if($imageUrl)
                        <img src="{{ $imageUrl }}" alt="{{ $slide->title }}">
                    @endif
                    <button class="btn btn-link p-0 drag-handle" type="button" draggable="true" aria-label="{{ __('messages.drag') }}">
                        <i class="bi bi-grip-vertical"></i>
                    </button>
                    <span class="badge {{ $slide->is_active ? 'bg-success' : 'bg-secondary' }}">
                        {{ $slide->is_active ? __('messages.active') : __('messages.inactive') }}
                    </span>
                </div>
                <div class="card-body">
                    <h5 class="card-title mb-1">{{ $slide->title }}</h5>
                    <p class="card-text text-muted">{{ $slide->subtitle }}</p>
                    <div class="d-flex align-items-center gap-2">
                        <a class="btn btn-sm btn-outline-dark" href="{{ route('admin.hero-slides.edit', $slide) }}">{{ __('messages.edit') }}</a>
                        <form method="post" action="{{ route('admin.hero-slides.destroy', $slide) }}" class="m-0">
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
            <div class="text-muted">{{ __('messages.no_slides') }}</div>
        </div>
    @endforelse
</div>
@endsection

@push('styles')
<style>
    .slide-thumb {
        position: relative;
        height: 200px;
        background: #f1f3f5;
        overflow: hidden;
    }
    .slide-thumb img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
    }
    .drag-handle {
        position: absolute;
        top: 12px;
        left: 12px;
        color: #1f3b53;
        background: rgba(255, 255, 255, 0.85);
        border-radius: 10px;
        width: 32px;
        height: 32px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        cursor: grab;
    }
    .slide-thumb .badge {
        position: absolute;
        top: 12px;
        right: 12px;
    }
    .slide-item.is-dragging {
        opacity: 0.6;
    }
</style>
@endpush

@push('scripts')
<script>
    const slidesSortable = document.getElementById('slides-sortable');
    const orderInput = document.getElementById('slide-order-list');
    let draggingItem = null;

    function syncSlideOrder() {
        if (!slidesSortable || !orderInput) {
            return;
        }
        const ids = Array.from(slidesSortable.querySelectorAll('.slide-item'))
            .map((item) => item.dataset.id)
            .filter(Boolean);
        orderInput.value = ids.join(',');
    }

    function getDragAfterElement(container, y) {
        const items = [...container.querySelectorAll('.slide-item:not(.is-dragging)')];
        return items.reduce(
            (closest, child) => {
                const box = child.getBoundingClientRect();
                const offset = y - box.top - box.height / 2;
                if (offset < 0 && offset > closest.offset) {
                    return { offset, element: child };
                }
                return closest;
            },
            { offset: Number.NEGATIVE_INFINITY, element: null }
        ).element;
    }

    if (slidesSortable) {
        slidesSortable.addEventListener('dragstart', (event) => {
            const handle = event.target.closest('.drag-handle');
            if (!handle) {
                event.preventDefault();
                return;
            }
            const item = handle.closest('.slide-item');
            if (!item) {
                event.preventDefault();
                return;
            }
            draggingItem = item;
            draggingItem.classList.add('is-dragging');
            event.dataTransfer.effectAllowed = 'move';
        });

        slidesSortable.addEventListener('dragend', () => {
            if (!draggingItem) {
                return;
            }
            draggingItem.classList.remove('is-dragging');
            draggingItem = null;
            syncSlideOrder();
        });

        slidesSortable.addEventListener('dragover', (event) => {
            if (!draggingItem) {
                return;
            }
            event.preventDefault();
            const afterElement = getDragAfterElement(slidesSortable, event.clientY);
            if (!afterElement) {
                slidesSortable.appendChild(draggingItem);
            } else {
                slidesSortable.insertBefore(draggingItem, afterElement);
            }
        });

        syncSlideOrder();
    }
</script>
@endpush
