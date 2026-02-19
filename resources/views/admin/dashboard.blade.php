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
        <div class="card shadow-sm p-3 d-flex flex-row align-items-center gap-3">
            <div class="icon-chip icon-chip--blue"><i class="bi bi-people-fill"></i></div>
            <div>
                <div class="text-muted small">{{ __('messages.total_users') }}</div>
                <div class="h5 mb-0 fw-bold">{{ $totalUsers }}</div>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-lg-3">
        <div class="card shadow-sm p-3 d-flex flex-row align-items-center gap-3">
            <div class="icon-chip icon-chip--teal"><i class="bi bi-patch-check-fill"></i></div>
            <div>
                <div class="text-muted small">{{ __('messages.active_subscriptions') }}</div>
                <div class="h5 mb-0 fw-bold">{{ $activeSubscriptions }}</div>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-lg-3">
        <div class="card shadow-sm p-3 d-flex flex-row align-items-center gap-3">
            <div class="icon-chip icon-chip--orange"><i class="bi bi-cash-stack"></i></div>
            <div>
                <div class="text-muted small">{{ __('messages.revenue') }}</div>
                <div class="h5 mb-0 fw-bold">{{ number_format($revenue, 2) }} ₼</div>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-lg-3">
        <div class="card shadow-sm p-3 d-flex flex-row align-items-center gap-3">
            <div class="icon-chip icon-chip--purple"><i class="bi bi-receipt"></i></div>
            <div>
                <div class="text-muted small">{{ __('messages.total_transactions') }}</div>
                <div class="h5 mb-0 fw-bold">{{ $totalTransactions }}</div>
            </div>
        </div>
    </div>
</div>

<div class="mt-4">
    <h5 class="mb-3">{{ __('messages.quick_links') }}</h5>
    <div class="row g-3 quick-links">
        @php
        $links = [
            ['route' => 'admin.shops.index',          'icon' => 'bi-shop',            'color' => 'blue',   'title' => __('messages.manage_shops'),      'sub' => __('messages.add_shop')],
            ['route' => 'admin.users.index',          'icon' => 'bi-people',          'color' => 'indigo', 'title' => __('messages.manage_users'),      'sub' => __('messages.user')],
            ['route' => 'admin.plans.index',          'icon' => 'bi-credit-card',     'color' => 'teal',   'title' => __('messages.manage_plans'),      'sub' => __('messages.subscriptions')],
            ['route' => 'admin.transactions.index',   'icon' => 'bi-qr-code',         'color' => 'orange', 'title' => __('messages.transaction_logs'),  'sub' => __('messages.total_transactions')],
            ['route' => 'admin.blogs.index',          'icon' => 'bi-newspaper',       'color' => 'purple', 'title' => __('messages.manage_blogs'),      'sub' => __('messages.blogs')],
            ['route' => 'admin.services.index',       'icon' => 'bi-grid',            'color' => 'green',  'title' => __('messages.manage_services'),   'sub' => __('messages.services')],
            ['route' => 'admin.shop-categories.index','icon' => 'bi-tags',            'color' => 'pink',   'title' => __('messages.manage_categories'), 'sub' => __('messages.categories')],
            ['route' => 'admin.cities.index',         'icon' => 'bi-geo-alt',         'color' => 'red',    'title' => __('messages.manage_cities'),     'sub' => __('messages.cities')],
            ['route' => 'admin.reports.revenue',      'icon' => 'bi-bar-chart-line',  'color' => 'teal',   'title' => __('messages.revenue_reports'),   'sub' => __('messages.revenue')],
            ['route' => 'admin.hero-slides.index',    'icon' => 'bi-images',          'color' => 'blue',   'title' => __('messages.manage_slides'),     'sub' => __('messages.slides')],
            ['route' => 'admin.features.index',       'icon' => 'bi-grid-3x3-gap',    'color' => 'indigo', 'title' => 'Niyə Biz? Kartları',             'sub' => 'Features'],
            ['route' => 'admin.partners.index',       'icon' => 'bi-building',        'color' => 'green',  'title' => __('messages.manage_partners'),   'sub' => __('messages.partners')],
            ['route' => 'admin.site-settings.edit',   'icon' => 'bi-sliders',         'color' => 'orange', 'title' => __('messages.site_settings'),     'sub' => 'Homepage & footer'],
        ];
        @endphp

        @foreach($links as $link)
        <div class="col-md-6 col-lg-3">
            <a class="card shadow-sm text-decoration-none h-100 quick-link" href="{{ route($link['route']) }}">
                <div class="card-body d-flex align-items-start gap-3">
                    <div class="icon-chip icon-chip--{{ $link['color'] }} flex-shrink-0">
                        <i class="bi {{ $link['icon'] }}"></i>
                    </div>
                    <div>
                        <div class="fw-semibold text-dark lh-sm">{{ $link['title'] }}</div>
                        <div class="text-muted small mt-1">{{ $link['sub'] }}</div>
                    </div>
                </div>
            </a>
        </div>
        @endforeach
    </div>
</div>
@endsection

@push('styles')
<style>
    .icon-chip {
        width: 44px;
        height: 44px;
        border-radius: 12px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 1.2rem;
        flex-shrink: 0;
    }
    .icon-chip--blue   { background: #e8f0fe; color: #1a56db; }
    .icon-chip--indigo { background: #ede9fe; color: #6d28d9; }
    .icon-chip--teal   { background: #d1fae5; color: #0d9488; }
    .icon-chip--orange { background: #fff3e0; color: #f57c00; }
    .icon-chip--purple { background: #fae8ff; color: #9333ea; }
    .icon-chip--green  { background: #dcfce7; color: #16a34a; }
    .icon-chip--pink   { background: #fce7f3; color: #db2777; }
    .icon-chip--red    { background: #fee2e2; color: #dc2626; }

    .quick-link {
        transition: transform 0.18s ease, box-shadow 0.18s ease, border-color 0.18s ease;
        border: 1px solid #f1f3f5;
    }
    .quick-link:hover {
        transform: translateY(-3px);
        box-shadow: 0 12px 32px rgba(15, 23, 42, 0.10);
        border-color: #dee2e6;
    }
</style>
@endpush
