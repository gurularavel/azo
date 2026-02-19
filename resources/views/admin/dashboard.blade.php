@extends('layouts.admin')

@section('title', __('messages.admin_dashboard'))

@section('content')
<div class="d-flex align-items-center justify-content-between mb-3">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('messages.home') }}</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ __('messages.admin_dashboard') }}</li>
        </ol>
    </nav>
    <a class="btn btn-outline-dark btn-sm" href="{{ route('home') }}">{{ __('messages.back_to_home') }}</a>
</div>
<h3 class="mb-4">{{ __('messages.admin_dashboard') }}</h3>
<div class="row g-3">
    <div class="col-md-6 col-lg-3">
        <div class="card shadow-sm p-3">
            <div class="text-muted">{{ __('messages.total_users') }}</div>
            <div class="h4">{{ $totalUsers }}</div>
        </div>
    </div>
    <div class="col-md-6 col-lg-3">
        <div class="card shadow-sm p-3">
            <div class="text-muted">{{ __('messages.active_subscriptions') }}</div>
            <div class="h4">{{ $activeSubscriptions }}</div>
        </div>
    </div>
    <div class="col-md-6 col-lg-3">
        <div class="card shadow-sm p-3">
            <div class="text-muted">{{ __('messages.revenue') }}</div>
            <div class="h4">{{ number_format($revenue, 2) }} ₼</div>
        </div>
    </div>
    <div class="col-md-6 col-lg-3">
        <div class="card shadow-sm p-3">
            <div class="text-muted">{{ __('messages.total_transactions') }}</div>
            <div class="h4">{{ $totalTransactions }}</div>
        </div>
    </div>
</div>

<div class="mt-4">
    <h5 class="mb-3">{{ __('messages.quick_links') }}</h5>
    <div class="row g-3 quick-links">
        <div class="col-md-6 col-lg-3">
            <a class="card shadow-sm text-decoration-none h-100 quick-link" href="{{ route('admin.shops.index') }}">
                <div class="card-body">
                    <div class="icon-chip mb-2"><i data-lucide="store"></i></div>
                    <div class="fw-semibold text-dark">{{ __('messages.manage_shops') }}</div>
                    <div class="text-muted small">{{ __('messages.add_shop') }}</div>
                </div>
            </a>
        </div>
        <div class="col-md-6 col-lg-3">
            <a class="card shadow-sm text-decoration-none h-100 quick-link" href="{{ route('admin.users.index') }}">
                <div class="card-body">
                    <div class="icon-chip mb-2"><i data-lucide="users"></i></div>
                    <div class="fw-semibold text-dark">{{ __('messages.manage_users') }}</div>
                    <div class="text-muted small">{{ __('messages.user') }}</div>
                </div>
            </a>
        </div>
        <div class="col-md-6 col-lg-3">
            <a class="card shadow-sm text-decoration-none h-100 quick-link" href="{{ route('admin.plans.index') }}">
                <div class="card-body">
                    <div class="icon-chip mb-2"><i data-lucide="ticket"></i></div>
                    <div class="fw-semibold text-dark">{{ __('messages.manage_plans') }}</div>
                    <div class="text-muted small">{{ __('messages.subscriptions') }}</div>
                </div>
            </a>
        </div>
        <div class="col-md-6 col-lg-3">
            <a class="card shadow-sm text-decoration-none h-100 quick-link" href="{{ route('admin.transactions.index') }}">
                <div class="card-body">
                    <div class="icon-chip mb-2"><i data-lucide="qr-code"></i></div>
                    <div class="fw-semibold text-dark">{{ __('messages.transaction_logs') }}</div>
                    <div class="text-muted small">{{ __('messages.total_transactions') }}</div>
                </div>
            </a>
        </div>
        <div class="col-md-6 col-lg-3">
            <a class="card shadow-sm text-decoration-none h-100 quick-link" href="{{ route('admin.blogs.index') }}">
                <div class="card-body">
                    <div class="icon-chip mb-2"><i data-lucide="book-open"></i></div>
                    <div class="fw-semibold text-dark">{{ __('messages.manage_blogs') }}</div>
                    <div class="text-muted small">{{ __('messages.blogs') }}</div>
                </div>
            </a>
        </div>
        <div class="col-md-6 col-lg-3">
            <a class="card shadow-sm text-decoration-none h-100 quick-link" href="{{ route('admin.services.index') }}">
                <div class="card-body">
                    <div class="icon-chip mb-2"><i data-lucide="briefcase-business"></i></div>
                    <div class="fw-semibold text-dark">{{ __('messages.manage_services') }}</div>
                    <div class="text-muted small">{{ __('messages.services') }}</div>
                </div>
            </a>
        </div>
        <div class="col-md-6 col-lg-3">
            <a class="card shadow-sm text-decoration-none h-100 quick-link" href="{{ route('admin.shop-categories.index') }}">
                <div class="card-body">
                    <div class="icon-chip mb-2"><i data-lucide="tags"></i></div>
                    <div class="fw-semibold text-dark">{{ __('messages.manage_categories') }}</div>
                    <div class="text-muted small">{{ __('messages.categories') }}</div>
                </div>
            </a>
        </div>
        <div class="col-md-6 col-lg-3">
            <a class="card shadow-sm text-decoration-none h-100 quick-link" href="{{ route('admin.cities.index') }}">
                <div class="card-body">
                    <div class="icon-chip mb-2"><i data-lucide="map-pin"></i></div>
                    <div class="fw-semibold text-dark">{{ __('messages.manage_cities') }}</div>
                    <div class="text-muted small">{{ __('messages.cities') }}</div>
                </div>
            </a>
        </div>
        <div class="col-md-6 col-lg-3">
            <a class="card shadow-sm text-decoration-none h-100 quick-link" href="{{ route('admin.reports.revenue') }}">
                <div class="card-body">
                    <div class="icon-chip mb-2"><i data-lucide="bar-chart-3"></i></div>
                    <div class="fw-semibold text-dark">{{ __('messages.revenue_reports') }}</div>
                    <div class="text-muted small">{{ __('messages.revenue') }}</div>
                </div>
            </a>
        </div>
        <div class="col-md-6 col-lg-3">
            <a class="card shadow-sm text-decoration-none h-100 quick-link" href="{{ route('admin.hero-slides.index') }}">
                <div class="card-body">
                    <div class="icon-chip mb-2"><i data-lucide="images"></i></div>
                    <div class="fw-semibold text-dark">{{ __('messages.manage_slides') }}</div>
                    <div class="text-muted small">{{ __('messages.slides') }}</div>
                </div>
            </a>
        </div>
        <div class="col-md-6 col-lg-3">
            <a class="card shadow-sm text-decoration-none h-100 quick-link" href="{{ route('admin.site-settings.edit') }}">
                <div class="card-body">
                    <div class="icon-chip mb-2"><i data-lucide="settings"></i></div>
                    <div class="fw-semibold text-dark">Site Settings</div>
                    <div class="text-muted small">Homepage & footer</div>
                </div>
            </a>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .icon-chip {
        width: 40px;
        height: 40px;
        border-radius: 12px;
        background: rgba(31, 59, 83, 0.08);
        color: #1f3b53;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 1.2rem;
    }
    .quick-link {
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }
    .quick-link:hover {
        transform: translateY(-2px);
        box-shadow: 0 18px 40px rgba(15, 23, 42, 0.12);
    }
</style>
@endpush
