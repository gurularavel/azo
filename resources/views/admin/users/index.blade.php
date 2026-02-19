@extends('layouts.admin')

@section('title', __('messages.manage_users'))

@section('content')
<div class="d-flex align-items-center justify-content-between mb-3">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">{{ __('messages.admin_dashboard') }}</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ __('messages.manage_users') }}</li>
        </ol>
    </nav>
    <a class="btn btn-outline-dark btn-sm" href="{{ route('admin.dashboard') }}">{{ __('messages.back_to_dashboard') }}</a>
</div>
<h3 class="mb-3">{{ __('messages.manage_users') }}</h3>

<div class="card shadow-sm">
    <div class="table-responsive">
        <table class="table table-striped mb-0">
            <thead>
                <tr>
                    <th>{{ __('messages.name') }}</th>
                    <th>{{ __('messages.email') }}</th>
                    <th>{{ __('messages.plan') }}</th>
                    <th>{{ __('messages.usage_remaining') }}</th>
                    <th>{{ __('messages.blocked') }}</th>
                    <th>{{ __('messages.actions') }}</th>
                </tr>
            </thead>
            <tbody>
            @foreach($users as $user)
                <tr>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->activeSubscription?->plan?->name ?? '-' }}</td>
                    <td>{{ $user->activeSubscription?->usage_remaining ?? '-' }}</td>
                    <td>{{ $user->is_blocked ? __('messages.yes') : __('messages.no') }}</td>
                    <td>
                        <form method="post" action="{{ route('admin.users.update', $user) }}" class="d-flex gap-2">
                            @csrf
                            @method('put')
                            <input class="form-control form-control-sm" type="number" name="usage_remaining" placeholder="{{ __('messages.usage_remaining') }}" value="{{ $user->activeSubscription?->usage_remaining }}">
                            <select class="form-select form-select-sm" name="is_blocked">
                                <option value="0" @selected(!$user->is_blocked)>{{ __('messages.active') }}</option>
                                <option value="1" @selected($user->is_blocked)>{{ __('messages.blocked') }}</option>
                            </select>
                            <button class="btn btn-sm btn-outline-dark" type="submit">{{ __('messages.update') }}</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    <div class="card-footer bg-white">
        {{ $users->links('vendor.pagination.admin-template') }}
    </div>
</div>
@endsection
