@extends('layouts.admin')

@section('title', $plan->exists ? __('messages.edit_plan') : __('messages.add_plan'))

@section('content')
<div class="d-flex align-items-center justify-content-between mb-3">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">{{ __('messages.admin_dashboard') }}</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.plans.index') }}">{{ __('messages.manage_plans') }}</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ $plan->exists ? __('messages.edit_plan') : __('messages.add_plan') }}</li>
        </ol>
    </nav>
    <a class="btn btn-outline-dark btn-sm" href="{{ route('admin.plans.index') }}">{{ __('messages.back_to_plans') }}</a>
</div>
<div class="card shadow-sm p-4">
    <h3 class="mb-3">{{ $plan->exists ? __('messages.edit_plan') : __('messages.add_plan') }}</h3>
    <form method="post" action="{{ $plan->exists ? route('admin.plans.update', $plan) : route('admin.plans.store') }}">
        @csrf
        @if($plan->exists)
            @method('put')
        @endif
        <div class="mb-3">
            <label class="form-label">{{ __('messages.name') }}</label>
            <input class="form-control" name="name" value="{{ old('name', $plan->name) }}" required>
        </div>
        <div class="mb-3">
            <label class="form-label">{{ __('messages.price') }}</label>
            <input class="form-control" type="number" step="0.01" name="price" value="{{ old('price', $plan->price) }}" required>
        </div>
        <div class="mb-3">
            <label class="form-label">{{ __('messages.usage_limit_label') }}</label>
            <input class="form-control" type="number" name="usage_limit" value="{{ old('usage_limit', $plan->usage_limit) }}" required>
        </div>
        <button class="btn btn-brand" type="submit">{{ __('messages.save') }}</button>
    </form>
</div>
@endsection
