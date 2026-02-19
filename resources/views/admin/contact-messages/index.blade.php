@extends('layouts.admin')

@section('title', __('messages.manage_contact_messages'))

@section('content')
<div class="d-flex align-items-center justify-content-between mb-3">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">{{ __('messages.admin_dashboard') }}</a></li>
            <li class="breadcrumb-item active">{{ __('messages.manage_contact_messages') }}</li>
        </ol>
    </nav>
    <a class="btn btn-outline-dark btn-sm" href="{{ route('admin.dashboard') }}">{{ __('messages.back_to_dashboard') }}</a>
</div>

<div class="d-flex align-items-center justify-content-between mb-3">
    <h3 class="mb-0">{{ __('messages.manage_contact_messages') }}</h3>
    <span class="text-muted small">{{ $messages->total() }} {{ __('messages.total') }}</span>
</div>

<div class="card shadow-sm">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th style="width:20px"></th>
                    <th>{{ __('messages.name') }}</th>
                    <th>{{ __('messages.email') }}</th>
                    <th class="d-none d-md-table-cell">{{ __('messages.phone') }}</th>
                    <th>{{ __('messages.message') }}</th>
                    <th>{{ __('messages.date') }}</th>
                    <th style="width:80px">{{ __('messages.actions') }}</th>
                </tr>
            </thead>
            <tbody>
            @forelse($messages as $msg)
            <tr class="{{ !$msg->is_read ? 'table-warning' : '' }}">
                <td>
                    @if(!$msg->is_read)
                        <span class="badge bg-warning-subtle text-warning rounded-pill" title="{{ __('messages.unread') }}">
                            <i class="bi bi-circle-fill" style="font-size:.45rem"></i>
                        </span>
                    @endif
                </td>
                <td class="fw-semibold">{{ $msg->name }}</td>
                <td>
                    <a href="mailto:{{ $msg->email }}" class="text-decoration-none text-dark">
                        <i class="bi bi-envelope me-1 text-muted"></i>{{ $msg->email }}
                    </a>
                </td>
                <td class="text-muted small d-none d-md-table-cell">{{ $msg->phone ?? '—' }}</td>
                <td>
                    <span class="d-inline-block text-truncate" style="max-width:260px" title="{{ $msg->message }}">
                        {{ $msg->message }}
                    </span>
                </td>
                <td class="text-muted small text-nowrap">{{ $msg->created_at->format('d.m.Y H:i') }}</td>
                <td>
                    <form method="post" action="{{ route('admin.contact-messages.destroy', $msg) }}" class="m-0"
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
                <td colspan="7" class="text-center text-muted py-4">
                    <i class="bi bi-chat-square-text fs-3 d-block mb-2 opacity-50"></i>
                    {{ __('messages.no_contact_messages') }}
                </td>
            </tr>
            @endforelse
            </tbody>
        </table>
    </div>
    <div class="card-footer bg-white">
        {{ $messages->links('vendor.pagination.admin-template') }}
    </div>
</div>
@endsection
