@extends('layouts.admin')

@section('title', __('messages.manage_services'))

@section('content')
<div class="d-flex align-items-center justify-content-between mb-3">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">{{ __('messages.admin_dashboard') }}</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ __('messages.manage_services') }}</li>
        </ol>
    </nav>
    <a class="btn btn-outline-dark btn-sm" href="{{ route('admin.dashboard') }}">{{ __('messages.back_to_dashboard') }}</a>
</div>
<div class="d-flex align-items-center justify-content-between mb-3">
    <h3 class="mb-0">{{ __('messages.manage_services') }}</h3>
    <a class="btn btn-brand" href="{{ route('admin.services.create') }}">{{ __('messages.add_service') }}</a>
</div>

<div class="card shadow-sm">
    <div class="table-responsive">
        <table class="table table-striped mb-0">
            <thead>
                <tr>
                    <th>{{ __('messages.title') }}</th>
                    <th>{{ __('messages.status') }}</th>
                    <th>{{ __('messages.actions') }}</th>
                </tr>
            </thead>
            <tbody>
            @forelse($services as $service)
                <tr>
                    <td>{{ $service->title }}</td>
                    <td>
                        <span class="badge {{ $service->is_published ? 'bg-success' : 'bg-secondary' }}">
                            {{ $service->is_published ? __('messages.published') : __('messages.draft') }}
                        </span>
                    </td>
                    <td>
                        <div class="d-flex align-items-center gap-2">
                            <a class="btn btn-sm btn-outline-dark" href="{{ route('admin.services.edit', $service) }}">{{ __('messages.edit') }}</a>
                            <form class="m-0" method="post" action="{{ route('admin.services.destroy', $service) }}">
                                @csrf
                                @method('delete')
                                <button class="btn btn-sm btn-outline-danger" type="submit">{{ __('messages.delete') }}</button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="3" class="text-center text-muted py-4">{{ __('messages.no_services') }}</td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>
    <div class="card-footer bg-white">
        {{ $services->links('vendor.pagination.admin-template') }}
    </div>
</div>
@endsection
