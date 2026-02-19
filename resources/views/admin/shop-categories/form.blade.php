@extends('layouts.admin')

@section('title', $category->exists ? __('messages.edit_category') : __('messages.add_category'))

@section('content')
<div class="d-flex align-items-center justify-content-between mb-3">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">{{ __('messages.admin_dashboard') }}</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.shop-categories.index') }}">{{ __('messages.manage_categories') }}</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ $category->exists ? __('messages.edit_category') : __('messages.add_category') }}</li>
        </ol>
    </nav>
    <a class="btn btn-outline-dark btn-sm" href="{{ route('admin.shop-categories.index') }}">{{ __('messages.back_to_categories') }}</a>
</div>
<div class="card shadow-sm p-4">
    <h3 class="mb-3">{{ $category->exists ? __('messages.edit_category') : __('messages.add_category') }}</h3>
    <form method="post" action="{{ $category->exists ? route('admin.shop-categories.update', $category) : route('admin.shop-categories.store') }}">
        @csrf
        @if($category->exists)
            @method('put')
        @endif
        <div class="mb-3">
            <label class="form-label">{{ __('messages.name') }}</label>
            <input class="form-control" name="name" value="{{ old('name', $category->name) }}" required>
        </div>
        <button class="btn btn-brand" type="submit"><i class="bi bi-floppy"></i> {{ __('messages.save') }}</button>
    </form>
</div>
@endsection
