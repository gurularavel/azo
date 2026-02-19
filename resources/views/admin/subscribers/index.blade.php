@extends('layouts.admin')

@section('title', __('messages.manage_subscribers'))

@section('content')
<div class="d-flex align-items-center justify-content-between mb-3">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">{{ __('messages.admin_dashboard') }}</a></li>
            <li class="breadcrumb-item active">{{ __('messages.manage_subscribers') }}</li>
        </ol>
    </nav>
    <a class="btn btn-outline-dark btn-sm" href="{{ route('admin.dashboard') }}">{{ __('messages.back_to_dashboard') }}</a>
</div>

<div class="d-flex align-items-center justify-content-between mb-3">
    <div>
        <h3 class="mb-1">{{ __('messages.manage_subscribers') }}</h3>
        <div class="text-muted small">{{ $subscribers->total() }} {{ __('messages.total') }}</div>
    </div>
</div>

<div class="card shadow-sm">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>{{ __('messages.email') }}</th>
                    <th>{{ __('messages.date') }}</th>
                    <th style="width:80px">{{ __('messages.actions') }}</th>
                </tr>
            </thead>
            <tbody>
            @forelse($subscribers as $sub)
            <tr>
                <td class="text-muted small">{{ $sub->id }}</td>
                <td><i class="bi bi-envelope me-1 text-muted"></i> {{ $sub->email }}</td>
                <td class="text-muted small">{{ $sub->created_at->format('d.m.Y H:i') }}</td>
                <td>
                    <form method="post" action="{{ route('admin.subscribers.destroy', $sub) }}" class="m-0"
                          onsubmit="return confirm('{{ __('messages.delete') }}?')">
                        @csrf @method('delete')
                        <button class="btn btn-sm btn-outline-danger" type="submit">
                            <i class="bi bi-trash"></i>
                        </button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="4" class="text-center text-muted py-4">
                    <i class="bi bi-envelope fs-3 d-block mb-2 opacity-50"></i>
                    {{ __('messages.no_subscribers') }}
                </td>
            </tr>
            @endforelse
            </tbody>
        </table>
    </div>
    <div class="card-footer bg-white">
        {{ $subscribers->links('vendor.pagination.admin-template') }}
    </div>
</div>
@endsection
