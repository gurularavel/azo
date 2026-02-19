@extends('layouts.admin')

@section('title', __('messages.manage_cities'))

@section('content')
<div class="d-flex align-items-center justify-content-between mb-3">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">{{ __('messages.admin_dashboard') }}</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ __('messages.manage_cities') }}</li>
        </ol>
    </nav>
    <a class="btn btn-outline-dark btn-sm" href="{{ route('admin.dashboard') }}">{{ __('messages.back_to_dashboard') }}</a>
</div>
<div class="d-flex align-items-center justify-content-between mb-3">
    <h3 class="mb-0">{{ __('messages.manage_cities') }}</h3>
    <a class="btn btn-brand" href="{{ route('admin.cities.create') }}"><i class="bi bi-plus-lg"></i> {{ __('messages.add_city') }}</a>
</div>

<div class="card shadow-sm">
    <div class="table-responsive">
        <table class="table table-striped mb-0">
            <thead>
                <tr>
                    <th>{{ __('messages.name') }}</th>
                    <th>{{ __('messages.status') }}</th>
                    <th>{{ __('messages.shop_count') }}</th>
                    <th>{{ __('messages.actions') }}</th>
                </tr>
            </thead>
            <tbody>
            @forelse($cities as $city)
                <tr>
                    <td>{{ $city->name }}</td>
                    <td>
                        @if($city->is_active)
                            <span class="badge bg-success">{{ __('messages.active') }}</span>
                        @else
                            <span class="badge bg-secondary">{{ __('messages.inactive') }}</span>
                        @endif
                    </td>
                    <td>{{ $city->shops_count }}</td>
                    <td>
                        <div class="d-flex align-items-center gap-2">
                            <form class="m-0" method="post" action="{{ route('admin.cities.toggle', $city) }}">
                                @csrf
                                @method('patch')
                                <button class="btn btn-sm btn-outline-dark" type="submit">
                                    {{ $city->is_active ? __('messages.disable') : __('messages.enable') }}
                                </button>
                            </form>
                            <a class="btn btn-sm btn-outline-dark" href="{{ route('admin.cities.edit', $city) }}">{{ __('messages.edit') }}</a>
                            <form class="m-0" method="post" action="{{ route('admin.cities.destroy', $city) }}">
                                @csrf
                                @method('delete')
                                <button class="btn btn-sm btn-outline-danger" type="submit">{{ __('messages.delete') }}</button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="text-center text-muted py-4">{{ __('messages.no_cities') }}</td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
