@extends('layouts.admin')

@section('title', __('messages.manage_shops'))

@section('content')
<div class="d-flex align-items-center justify-content-between mb-3">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">{{ __('messages.admin_dashboard') }}</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ __('messages.manage_shops') }}</li>
        </ol>
    </nav>
    <a class="btn btn-outline-dark btn-sm" href="{{ route('admin.dashboard') }}">{{ __('messages.back_to_dashboard') }}</a>
</div>
<div class="d-flex align-items-center justify-content-between mb-3">
    <h3 class="mb-0">{{ __('messages.manage_shops') }}</h3>
    <a class="btn btn-brand" href="{{ route('admin.shops.create') }}">{{ __('messages.add_shop') }}</a>
</div>
<form method="get" class="card shadow-sm p-3 mb-3">
    <div class="row g-2 align-items-end">
        <div class="col-md-6">
            <label class="form-label">{{ __('messages.category') }}</label>
            <select class="form-select" name="category_id">
                <option value="">{{ __('messages.select_category') }}</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" @selected($selectedCategoryId === $category->id)>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="col-md-6 d-flex gap-2 align-items-center justify-content-end">
            <button class="btn btn-brand" type="submit">{{ __('messages.filter') }}</button>
            <a class="btn btn-brand" href="{{ route('admin.shops.index') }}">{{ __('messages.clear_filter') }}</a>
        </div>
    </div>
</form>

<div class="card shadow-sm">
    <div class="table-responsive">
        <table class="table table-striped mb-0">
            <thead>
                <tr>
                    <th>{{ __('messages.logo') }}</th>
                    <th>{{ __('messages.name') }}</th>
                    <th>{{ __('messages.category') }}</th>
                    <th>{{ __('messages.city') }}</th>
                    <th>{{ __('messages.discount') }}</th>
                    <th>{{ __('messages.actions') }}</th>
                </tr>
            </thead>
            <tbody>
            @foreach($shops as $shop)
                @php
                    $logoUrl = $shop->logo_path
                        ? (str_starts_with($shop->logo_path, 'http') ? $shop->logo_path : asset('storage/'.$shop->logo_path))
                        : null;
                @endphp
                <tr>
                    <td>
                        @if($logoUrl)
                            <img class="shop-logo-thumb" src="{{ $logoUrl }}" alt="{{ $shop->name }}">
                        @else
                            <span class="shop-logo-placeholder">{{ strtoupper(substr($shop->name, 0, 1)) }}</span>
                        @endif
                    </td>
                    <td>{{ $shop->name }}</td>
                    <td>{{ $shop->category?->name ?? '-' }}</td>
                    <td>{{ $shop->city?->name ?? '-' }}</td>
                    <td>{{ $shop->discount_percent }}%</td>
                    <td>
                        <div class="d-flex align-items-center gap-2">
                            <a class="btn btn-sm btn-outline-dark" href="{{ route('admin.shops.edit', $shop) }}">{{ __('messages.edit') }}</a>
                            <form class="m-0" method="post" action="{{ route('admin.shops.destroy', $shop) }}">
                                @csrf
                                @method('delete')
                                <button class="btn btn-sm btn-outline-danger" type="submit">{{ __('messages.delete') }}</button>
                            </form>
                        </div>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    <div class="card-footer bg-white">
        {{ $shops->links('vendor.pagination.admin-template') }}
    </div>
</div>
@endsection

@push('styles')
<style>
    .shop-logo-thumb,
    .shop-logo-placeholder {
        width: 200px;
        max-width: 100%;
        height: auto;
        display: inline-block;
        font-weight: 700;
        color: #1f3b53;
        background: #f1f3f5;
        border: 1px solid #e2e6ea;
        padding: 4px 8px;
    }
</style>
@endpush
