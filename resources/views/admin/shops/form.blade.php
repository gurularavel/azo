@extends('layouts.admin')

@section('title', $shop->exists ? __('messages.edit_shop') : __('messages.add_shop'))

@section('content')
@php
    $logoPreview = $shop->logo_path
        ? (str_starts_with($shop->logo_path, 'http') ? $shop->logo_path : asset('storage/'.$shop->logo_path))
        : null;
    $headerPreview = $shop->header_image_path
        ? (str_starts_with($shop->header_image_path, 'http') ? $shop->header_image_path : asset('storage/'.$shop->header_image_path))
        : null;
@endphp
<div class="d-flex align-items-center justify-content-between mb-3">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">{{ __('messages.admin_dashboard') }}</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.shops.index') }}">{{ __('messages.manage_shops') }}</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ $shop->exists ? __('messages.edit_shop') : __('messages.add_shop') }}</li>
        </ol>
    </nav>
    <a class="btn btn-outline-dark btn-sm" href="{{ route('admin.shops.index') }}">{{ __('messages.back_to_shops') }}</a>
</div>
<div class="card shadow-sm p-4">
    <h3 class="mb-3">{{ $shop->exists ? __('messages.edit_shop') : __('messages.add_shop') }}</h3>
    <form method="post" enctype="multipart/form-data" action="{{ $shop->exists ? route('admin.shops.update', $shop) : route('admin.shops.store') }}">
        @csrf
        @if($shop->exists)
            @method('put')
        @endif
        <div class="mb-3">
            <label class="form-label">{{ __('messages.name') }}</label>
            <input class="form-control" name="name" value="{{ old('name', $shop->name) }}" required>
        </div>
        <div class="mb-3">
            <label class="form-label">{{ __('messages.category') }}</label>
            <select class="form-select" name="shop_category_id">
                <option value="">{{ __('messages.select_category') }}</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" @selected((int) old('shop_category_id', $shop->shop_category_id) === $category->id)>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label">{{ __('messages.city') }}</label>
            <select class="form-select" name="city_id" required>
                <option value="">{{ __('messages.select_city') }}</option>
                @foreach($cities as $city)
                    <option value="{{ $city->id }}" @selected((int) old('city_id', $shop->city_id) === $city->id)>
                        {{ $city->name }}@if(!$city->is_active) ({{ __('messages.inactive') }})@endif
                    </option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label">{{ __('messages.logo_url') }}</label>
            <input class="form-control" name="logo_path" value="{{ old('logo_path', $shop->logo_path) }}">
        </div>
        <div class="mb-3">
            <label class="form-label">{{ __('messages.header_url') }}</label>
            <input class="form-control" name="header_image_path" value="{{ old('header_image_path', $shop->header_image_path) }}">
        </div>
        <div class="mb-3">
            <label class="form-label">{{ __('messages.logo_upload') }}</label>
            <input class="form-control" type="file" name="logo_file" accept="image/*">
            @if($shop->logo_path)
                <small class="text-muted d-block mt-1">{{ __('messages.current_logo') }}: {{ $shop->logo_path }}</small>
                @if($logoPreview)
                    <img class="img-thumbnail mt-2 shop-thumb" src="{{ $logoPreview }}" alt="logo">
                @endif
            @endif
        </div>
        <div class="mb-3">
            <label class="form-label">{{ __('messages.header_upload') }}</label>
            <input class="form-control" type="file" name="header_image_file" accept="image/*">
            @if($shop->header_image_path)
                <small class="text-muted d-block mt-1">{{ __('messages.current_header') }}: {{ $shop->header_image_path }}</small>
                @if($headerPreview)
                    <img class="img-thumbnail mt-2 shop-thumb" src="{{ $headerPreview }}" alt="header">
                @endif
            @endif
        </div>
        <div class="mb-3">
            <label class="form-label">{{ __('messages.gallery_upload') }}</label>
            <input class="form-control" type="file" name="gallery_files[]" accept="image/*" multiple>
        </div>
        @if($shop->exists && $shop->images->count())
            <div class="mb-3">
                <label class="form-label">{{ __('messages.gallery') }}</label>
                <input type="hidden" name="image_order_list" id="image-order-list" value="">
                <input type="hidden" name="delete_images_list" id="delete-images-list" value="">
                <div id="gallery-sortable" class="gallery-grid">
                    @foreach($shop->images as $image)
                        <div class="gallery-item" data-id="{{ $image->id }}">
                            <div class="card h-100">
                                <img class="card-img-top" src="{{ asset('storage/'.$image->path) }}" alt="gallery">
                                <div class="card-body p-2 d-flex align-items-center justify-content-between gap-2">
                                    <button class="btn btn-link p-0 drag-handle" type="button" draggable="true" aria-label="Reorder">
                                        <svg class="icon" viewBox="0 0 20 20" aria-hidden="true">
                                            <path d="M3 5h14M3 10h14M3 15h14" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                                        </svg>
                                    </button>
                                    <button class="btn btn-link p-0 delete-icon" type="button" aria-label="{{ __('messages.delete_image') }}">
                                        <svg class="icon" viewBox="0 0 20 20" aria-hidden="true">
                                            <path d="M6 6h8M8 6v10m4-10v10M5 6l1 11a2 2 0 0 0 2 2h4a2 2 0 0 0 2-2l1-11M8 6l1-2h2l1 2" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
        <div class="mb-3">
            <label class="form-label">{{ __('messages.discount_percent') }}</label>
            <input class="form-control" type="number" name="discount_percent" value="{{ old('discount_percent', $shop->discount_percent) }}" required>
        </div>
        <div class="mb-3">
            <label class="form-label">{{ __('messages.description') }}</label>
            <textarea class="form-control js-summernote" name="description" rows="4">{{ old('description', $shop->description) }}</textarea>
        </div>
        <button class="btn btn-brand" type="submit">{{ __('messages.save') }}</button>
    </form>
</div>
@endsection

@push('styles')
<style>
    .shop-thumb {
        max-width: 220px;
        width: 100%;
        height: auto;
        object-fit: cover;
    }
    .gallery-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(160px, 1fr));
        gap: 1rem;
    }
    .gallery-item.is-dragging {
        opacity: 0.6;
    }
    .gallery-item.is-deleted {
        opacity: 0.4;
        filter: grayscale(1);
    }
    .drag-handle {
        color: #1f3b53;
        cursor: grab;
    }
    .delete-icon {
        color: #b02a37;
    }
    .icon {
        width: 20px;
        height: 20px;
        display: block;
    }
</style>
@endpush

@push('scripts')
<script>
    const gallerySortable = document.getElementById('gallery-sortable');
    const orderInput = document.getElementById('image-order-list');
    const deleteInput = document.getElementById('delete-images-list');
    let draggingItem = null;

    function syncGalleryInputs() {
        if (!gallerySortable || !orderInput || !deleteInput) {
            return;
        }
        const items = Array.from(gallerySortable.querySelectorAll('.gallery-item'));
        const orderIds = items
            .filter((item) => !item.classList.contains('is-deleted'))
            .map((item) => item.dataset.id)
            .filter(Boolean);
        const deletedIds = items
            .filter((item) => item.classList.contains('is-deleted'))
            .map((item) => item.dataset.id)
            .filter(Boolean);
        orderInput.value = orderIds.join(',');
        deleteInput.value = deletedIds.join(',');
    }

    function getDragAfterElement(container, y) {
        const items = [...container.querySelectorAll('.gallery-item:not(.is-dragging):not(.is-deleted)')];
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

    if (gallerySortable) {
        gallerySortable.addEventListener('click', (event) => {
            const deleteButton = event.target.closest('.delete-icon');
            if (!deleteButton) {
                return;
            }
            const item = deleteButton.closest('.gallery-item');
            if (!item) {
                return;
            }
            item.classList.toggle('is-deleted');
            syncGalleryInputs();
        });

        gallerySortable.addEventListener('dragstart', (event) => {
            const handle = event.target.closest('.drag-handle');
            if (!handle) {
                event.preventDefault();
                return;
            }
            const item = handle.closest('.gallery-item');
            if (!item || item.classList.contains('is-deleted')) {
                event.preventDefault();
                return;
            }
            draggingItem = item;
            draggingItem.classList.add('is-dragging');
            event.dataTransfer.effectAllowed = 'move';
        });

        gallerySortable.addEventListener('dragend', () => {
            if (!draggingItem) {
                return;
            }
            draggingItem.classList.remove('is-dragging');
            draggingItem = null;
            syncGalleryInputs();
        });

        gallerySortable.addEventListener('dragover', (event) => {
            if (!draggingItem) {
                return;
            }
            event.preventDefault();
            const afterElement = getDragAfterElement(gallerySortable, event.clientY);
            if (!afterElement) {
                gallerySortable.appendChild(draggingItem);
            } else {
                gallerySortable.insertBefore(draggingItem, afterElement);
            }
        });

        syncGalleryInputs();
    }
</script>
@endpush
