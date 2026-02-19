@extends('layouts.admin')

@section('title', $city->exists ? __('messages.edit_city') : __('messages.add_city'))

@section('content')
<div class="d-flex align-items-center justify-content-between mb-3">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">{{ __('messages.admin_dashboard') }}</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.cities.index') }}">{{ __('messages.manage_cities') }}</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ $city->exists ? __('messages.edit_city') : __('messages.add_city') }}</li>
        </ol>
    </nav>
    <a class="btn btn-outline-dark btn-sm" href="{{ route('admin.cities.index') }}">{{ __('messages.back_to_cities') }}</a>
</div>
<div class="card shadow-sm p-4">
    <h3 class="mb-3">{{ $city->exists ? __('messages.edit_city') : __('messages.add_city') }}</h3>
    <form method="post" action="{{ $city->exists ? route('admin.cities.update', $city) : route('admin.cities.store') }}">
        @csrf
        @if($city->exists)
            @method('put')
        @endif
        <div class="mb-3">
            <label class="form-label">{{ __('messages.name') }}</label>
            <input class="form-control" name="name" value="{{ old('name', $city->name) }}" required>
        </div>
        <div class="mb-3">
            <label class="form-label">{{ __('messages.status') }}</label>
            <div class="form-check">
                <input type="hidden" name="is_active" value="0">
                <input class="form-check-input" type="checkbox" name="is_active" value="1" @checked(old('is_active', $city->is_active ?? true))>
                <label class="form-check-label">{{ __('messages.active') }}</label>
            </div>
        </div>
        <button class="btn btn-brand" type="submit">{{ __('messages.save') }}</button>
    </form>
</div>
@endsection
