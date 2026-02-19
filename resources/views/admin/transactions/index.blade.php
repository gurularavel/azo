@extends('layouts.admin')

@section('title', __('messages.transaction_logs'))

@section('content')
<div class="d-flex align-items-center justify-content-between mb-3">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">{{ __('messages.admin_dashboard') }}</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ __('messages.transaction_logs') }}</li>
        </ol>
    </nav>
    <a class="btn btn-outline-dark btn-sm" href="{{ route('admin.dashboard') }}">{{ __('messages.back_to_dashboard') }}</a>
</div>
<h3 class="mb-3">{{ __('messages.transaction_logs') }}</h3>

<div class="card shadow-sm">
    <div class="table-responsive">
        <table class="table table-striped mb-0">
            <thead>
                <tr>
                    <th>{{ __('messages.user') }}</th>
                    <th>{{ __('messages.shop') }}</th>
                    <th>{{ __('messages.category') }}</th>
                    <th>{{ __('messages.discount') }}</th>
                    <th>{{ __('messages.date') }}</th>
                </tr>
            </thead>
            <tbody>
            @foreach($transactions as $transaction)
                <tr>
                    <td>{{ $transaction->user?->name ?? '-' }}</td>
                    <td>{{ $transaction->shop?->name ?? '-' }}</td>
                    <td>{{ $transaction->shop?->category?->name ?? '-' }}</td>
                    <td>{{ $transaction->discount_percent }}%</td>
                    <td>{{ $transaction->scanned_at->format('Y-m-d H:i') }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    <div class="card-footer bg-white">
        {{ $transactions->links('vendor.pagination.admin-template') }}
    </div>
</div>
@endsection
