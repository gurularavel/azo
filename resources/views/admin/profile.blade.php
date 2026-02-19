@extends('layouts.admin')

@section('title', __('messages.profile'))

@section('content')
<div class="d-flex align-items-center justify-content-between mb-3">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">{{ __('messages.admin_dashboard') }}</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ __('messages.profile') }}</li>
        </ol>
    </nav>
    <a class="btn btn-outline-dark btn-sm" href="{{ route('admin.dashboard') }}">{{ __('messages.back_to_dashboard') }}</a>
</div>
<div class="card shadow-sm p-4">
    <h3 class="mb-3">{{ __('messages.profile') }}</h3>
    <form method="post" action="{{ route('admin.profile.update') }}">
        @csrf
        @method('put')
        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label">{{ __('messages.name') }}</label>
                <input class="form-control" name="name" value="{{ old('name', $user->name) }}" required>
            </div>
            <div class="col-md-6">
                <label class="form-label">{{ __('messages.email') }}</label>
                <input class="form-control" type="email" name="email" value="{{ old('email', $user->email) }}" required>
            </div>
            <div class="col-md-6">
                <label class="form-label">{{ __('messages.phone') }}</label>
                <input class="form-control" name="phone" value="{{ old('phone', $user->phone) }}" required>
            </div>
            <div class="col-md-6">
                <label class="form-label">{{ __('messages.current_password') }}</label>
                <input class="form-control" type="password" name="current_password">
            </div>
            <div class="col-md-6">
                <label class="form-label">{{ __('messages.new_password') }}</label>
                <input class="form-control" type="password" name="password">
            </div>
            <div class="col-md-6">
                <label class="form-label">{{ __('messages.password_confirm') }}</label>
                <input class="form-control" type="password" name="password_confirmation">
            </div>
        </div>
        <div class="mt-4">
            <button class="btn btn-brand" type="submit"><i class="bi bi-floppy"></i> {{ __('messages.save') }}</button>
        </div>
    </form>
</div>
@endsection
