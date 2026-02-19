<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Admin') — {{ $siteSettings?->site_name ?? 'QR Endirim' }}</title>
    <link rel="icon" type="image/svg+xml" href="{{ asset('template/images/logo.svg') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        :root {
            --sidebar-w: 260px;
            --sidebar-collapsed-w: 68px;
            --sidebar-bg: #111827;
            --sidebar-text: #9ca3af;
            --sidebar-active-bg: rgba(255,255,255,.1);
            --sidebar-active-text: #fff;
            --topbar-h: 60px;
        }

        body { background: #f3f4f6; font-family: 'Inter', sans-serif; }

        /* ── Sidebar ── */
        #admin-sidebar {
            position: fixed;
            top: 0; left: 0; bottom: 0;
            width: var(--sidebar-w);
            background: var(--sidebar-bg);
            display: flex;
            flex-direction: column;
            transition: width .25s ease;
            z-index: 1040;
            overflow: hidden;
        }
        #admin-sidebar.collapsed { width: var(--sidebar-collapsed-w); }

        /* Logo area */
        .sidebar-logo {
            display: flex;
            align-items: center;
            gap: .75rem;
            padding: 1rem 1.1rem;
            border-bottom: 1px solid rgba(255,255,255,.07);
            min-height: 64px;
            flex-shrink: 0;
        }
        .sidebar-logo img { width: 36px; height: 36px; object-fit: contain; flex-shrink: 0; }
        .sidebar-logo .logo-text {
            font-size: .9rem;
            font-weight: 700;
            color: #fff;
            white-space: nowrap;
            opacity: 1;
            transition: opacity .2s;
        }
        #admin-sidebar.collapsed .logo-text { opacity: 0; width: 0; overflow: hidden; }

        /* Nav */
        .sidebar-nav {
            flex: 1;
            overflow-y: auto;
            overflow-x: hidden;
            padding: .75rem .6rem;
        }
        .sidebar-nav::-webkit-scrollbar { width: 4px; }
        .sidebar-nav::-webkit-scrollbar-track { background: transparent; }
        .sidebar-nav::-webkit-scrollbar-thumb { background: rgba(255,255,255,.15); border-radius: 4px; }

        .sidebar-nav .nav-link {
            display: flex;
            align-items: center;
            gap: .75rem;
            color: var(--sidebar-text);
            border-radius: .5rem;
            padding: .55rem .75rem;
            white-space: nowrap;
            font-size: .875rem;
            transition: background .15s, color .15s;
        }
        .sidebar-nav .nav-link i {
            font-size: 1.1rem;
            flex-shrink: 0;
            width: 22px;
            text-align: center;
        }
        .sidebar-nav .nav-link .link-text {
            opacity: 1;
            transition: opacity .2s;
            overflow: hidden;
        }
        #admin-sidebar.collapsed .sidebar-nav .nav-link .link-text { opacity: 0; width: 0; }

        .sidebar-nav .nav-link:hover,
        .sidebar-nav .nav-link.active {
            background: var(--sidebar-active-bg);
            color: var(--sidebar-active-text);
        }

        .sidebar-section-label {
            font-size: .65rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .08em;
            color: #4b5563;
            padding: .9rem .75rem .3rem;
            white-space: nowrap;
            opacity: 1;
            transition: opacity .2s;
        }
        #admin-sidebar.collapsed .sidebar-section-label { opacity: 0; }

        /* Sidebar bottom */
        .sidebar-bottom {
            padding: .75rem .6rem 1rem;
            border-top: 1px solid rgba(255,255,255,.07);
            flex-shrink: 0;
        }

        /* ── Main ── */
        #admin-main {
            margin-left: var(--sidebar-w);
            transition: margin-left .25s ease;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }
        #admin-main.expanded { margin-left: var(--sidebar-collapsed-w); }

        /* Topbar */
        .admin-topbar {
            position: sticky;
            top: 0;
            z-index: 1030;
            background: #fff;
            border-bottom: 1px solid #e5e7eb;
            height: var(--topbar-h);
            display: flex;
            align-items: center;
            padding: 0 1.25rem;
            gap: .75rem;
        }

        #sidebar-toggle {
            background: none;
            border: 1px solid #e5e7eb;
            border-radius: .5rem;
            width: 36px; height: 36px;
            display: flex; align-items: center; justify-content: center;
            cursor: pointer;
            color: #374151;
            flex-shrink: 0;
        }
        #sidebar-toggle:hover { background: #f3f4f6; }

        .admin-content { padding: 1.5rem; flex: 1; }

        /* ── Brand button (Add / Save primary actions) ── */
        .btn-brand {
            display: inline-flex;
            align-items: center;
            gap: .4rem;
            background: linear-gradient(135deg, #213b67 0%, #16304f 100%);
            color: #fff !important;
            border: none;
            font-weight: 600;
            font-size: .875rem;
            letter-spacing: .015em;
            padding: .48rem 1.2rem;
            border-radius: .55rem;
            box-shadow: 0 2px 10px rgba(33,59,103,.28), inset 0 1px 0 rgba(255,255,255,.12);
            transition: transform .18s ease, box-shadow .18s ease, background .18s ease;
            cursor: pointer;
            text-decoration: none !important;
            white-space: nowrap;
        }
        .btn-brand:hover {
            background: linear-gradient(135deg, #1a3055 0%, #0f2035 100%);
            color: #fff !important;
            transform: translateY(-2px);
            box-shadow: 0 8px 22px rgba(33,59,103,.38), inset 0 1px 0 rgba(255,255,255,.12);
        }
        .btn-brand:active {
            transform: translateY(0);
            box-shadow: 0 2px 8px rgba(33,59,103,.22);
        }
        .btn-brand i { font-size: .95em; }

        /* btn-primary override — consistent with btn-brand */
        .btn-primary {
            background: linear-gradient(135deg, #213b67 0%, #16304f 100%) !important;
            border-color: transparent !important;
            font-weight: 600;
            letter-spacing: .015em;
            border-radius: .55rem;
            box-shadow: 0 2px 10px rgba(33,59,103,.28), inset 0 1px 0 rgba(255,255,255,.12) !important;
            transition: transform .18s ease, box-shadow .18s ease !important;
        }
        .btn-primary:hover {
            background: linear-gradient(135deg, #1a3055 0%, #0f2035 100%) !important;
            border-color: transparent !important;
            transform: translateY(-2px);
            box-shadow: 0 8px 22px rgba(33,59,103,.38) !important;
        }
        .btn-primary:active, .btn-primary:focus {
            background: linear-gradient(135deg, #16304f 0%, #0f2035 100%) !important;
            transform: translateY(0) !important;
            box-shadow: 0 2px 8px rgba(33,59,103,.22) !important;
        }

        /* Lang buttons */
        .lang-btn { font-size: .75rem; font-weight: 600; padding: .25rem .6rem; }
        .lang-btn.active-lang { background: #213b67; color: #fff; border-color: #213b67; }

        /* ── Nav Groups (accordion) ── */
        .nav-group { margin-bottom: 2px; }

        .nav-group-toggle {
            display: flex;
            align-items: center;
            gap: .75rem;
            width: 100%;
            background: none;
            border: none;
            color: var(--sidebar-text);
            border-radius: .5rem;
            padding: .55rem .75rem;
            white-space: nowrap;
            font-size: .875rem;
            cursor: pointer;
            transition: background .15s, color .15s;
            text-align: left;
        }
        .nav-group-toggle:hover {
            background: var(--sidebar-active-bg);
            color: var(--sidebar-active-text);
        }
        .nav-group-icon {
            flex-shrink: 0;
            width: 22px;
            text-align: center;
            font-size: 1.1rem;
        }
        .nav-group-label { flex: 1; overflow: hidden; }
        .nav-group-chevron {
            font-size: .7rem !important;
            width: auto !important;
            flex-shrink: 0;
            transition: transform .2s ease;
        }
        .nav-group-toggle:not(.collapsed) .nav-group-chevron { transform: rotate(180deg); }

        .nav-group-items { padding-left: .5rem; }

        .nav-link.nav-sub {
            padding-left: 1.1rem;
            font-size: .845rem;
        }
        .nav-link.nav-sub i { font-size: 1rem; }

        /* Hide group toggles text in collapsed sidebar */
        #admin-sidebar.collapsed .nav-group-toggle .link-text { opacity: 0; width: 0; }
        #admin-sidebar.collapsed .nav-group-items { display: none !important; }
        #admin-sidebar.collapsed .nav-group-toggle {
            justify-content: center;
            padding: .55rem 0;
        }
        #admin-sidebar.collapsed .nav-group-icon { width: 100%; font-size: 1.1rem; }

        /* Tooltip on collapsed */
        #admin-sidebar.collapsed .nav-link { position: relative; }
        #admin-sidebar.collapsed .nav-link:hover::after {
            content: attr(data-label);
            position: absolute;
            left: calc(var(--sidebar-collapsed-w) - 8px);
            top: 50%;
            transform: translateY(-50%);
            background: #1f2937;
            color: #fff;
            font-size: .78rem;
            padding: .3rem .65rem;
            border-radius: .4rem;
            white-space: nowrap;
            z-index: 9999;
            pointer-events: none;
        }

        /* Overlay for mobile */
        #sidebar-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,.4);
            z-index: 1039;
        }

        @media (max-width: 767.98px) {
            #admin-sidebar {
                transform: translateX(-100%);
                width: var(--sidebar-w) !important;
                transition: transform .25s ease;
            }
            #admin-sidebar.mobile-open {
                transform: translateX(0);
            }
            #admin-main { margin-left: 0 !important; }
        }
    </style>
    @stack('styles')
</head>
<body>

{{-- Sidebar --}}
<aside id="admin-sidebar">

    {{-- Logo --}}
    <div class="sidebar-logo">
        <img src="{{ asset('template/images/logo.svg') }}" alt="logo" style="filter: brightness(0) invert(1);">
        <span class="logo-text">{{ $siteSettings?->site_name ?? 'QR Endirim' }}</span>
    </div>

    {{-- Nav --}}
    <nav class="sidebar-nav">
        @php
            $cur = request()->route()?->getName();
            $u   = auth()->user();

            // Determine which accordion group is active
            $activeCatalog  = str_starts_with($cur ?? '', 'admin.shops') || str_starts_with($cur ?? '', 'admin.shop-categories') || str_starts_with($cur ?? '', 'admin.cities');
            $activeFinance  = str_starts_with($cur ?? '', 'admin.users') || str_starts_with($cur ?? '', 'admin.roles') || str_starts_with($cur ?? '', 'admin.plans') || str_starts_with($cur ?? '', 'admin.transactions') || str_starts_with($cur ?? '', 'admin.reports');
            $activeContent  = str_starts_with($cur ?? '', 'admin.blogs') || str_starts_with($cur ?? '', 'admin.services') || str_starts_with($cur ?? '', 'admin.hero-slides') || str_starts_with($cur ?? '', 'admin.features') || str_starts_with($cur ?? '', 'admin.partners');
            $activeMessages = str_starts_with($cur ?? '', 'admin.subscribers') || str_starts_with($cur ?? '', 'admin.contact-messages');
            $activeSystem   = str_starts_with($cur ?? '', 'admin.site-settings') || str_starts_with($cur ?? '', 'admin.translations');
        @endphp

        {{-- Dashboard --}}
        <a class="nav-link {{ $cur === 'admin.dashboard' ? 'active' : '' }}"
           href="{{ route('admin.dashboard') }}" data-label="{{ __('messages.admin_dashboard') }}">
            <i class="bi bi-speedometer2"></i>
            <span class="link-text">{{ __('messages.admin_dashboard') }}</span>
        </a>

        {{-- GROUP: Kataloq --}}
        @if($u->hasSection('shops') || $u->hasSection('shop-categories') || $u->hasSection('cities'))
        <div class="nav-group">
            <button class="nav-group-toggle {{ $activeCatalog ? '' : 'collapsed' }}"
                    data-bs-toggle="collapse" data-bs-target="#grp-catalog"
                    aria-expanded="{{ $activeCatalog ? 'true' : 'false' }}">
                <span class="nav-group-icon"><i class="bi bi-shop"></i></span>
                <span class="link-text nav-group-label">{{ __('messages.nav_group_catalog') }}</span>
                <i class="bi bi-chevron-down nav-group-chevron link-text"></i>
            </button>
            <div id="grp-catalog" class="collapse nav-group-items {{ $activeCatalog ? 'show' : '' }}">
                @if($u->hasSection('shops'))
                <a class="nav-link nav-sub {{ str_starts_with($cur ?? '', 'admin.shops') ? 'active' : '' }}"
                   href="{{ route('admin.shops.index') }}" data-label="{{ __('messages.nav_shops') }}">
                    <i class="bi bi-shop"></i>
                    <span class="link-text">{{ __('messages.nav_shops') }}</span>
                </a>
                @endif
                @if($u->hasSection('shop-categories'))
                <a class="nav-link nav-sub {{ str_starts_with($cur ?? '', 'admin.shop-categories') ? 'active' : '' }}"
                   href="{{ route('admin.shop-categories.index') }}" data-label="{{ __('messages.nav_categories') }}">
                    <i class="bi bi-tags"></i>
                    <span class="link-text">{{ __('messages.nav_categories') }}</span>
                </a>
                @endif
                @if($u->hasSection('cities'))
                <a class="nav-link nav-sub {{ str_starts_with($cur ?? '', 'admin.cities') ? 'active' : '' }}"
                   href="{{ route('admin.cities.index') }}" data-label="{{ __('messages.nav_cities') }}">
                    <i class="bi bi-geo-alt"></i>
                    <span class="link-text">{{ __('messages.nav_cities') }}</span>
                </a>
                @endif
            </div>
        </div>
        @endif

        {{-- GROUP: İstifadəçilər & Maliyyə --}}
        @if($u->hasSection('users') || $u->hasSection('roles') || $u->hasSection('plans') || $u->hasSection('transactions') || $u->hasSection('reports'))
        <div class="nav-group">
            <button class="nav-group-toggle {{ $activeFinance ? '' : 'collapsed' }}"
                    data-bs-toggle="collapse" data-bs-target="#grp-finance"
                    aria-expanded="{{ $activeFinance ? 'true' : 'false' }}">
                <span class="nav-group-icon"><i class="bi bi-people"></i></span>
                <span class="link-text nav-group-label">{{ __('messages.nav_group_users_finance') }}</span>
                <i class="bi bi-chevron-down nav-group-chevron link-text"></i>
            </button>
            <div id="grp-finance" class="collapse nav-group-items {{ $activeFinance ? 'show' : '' }}">
                @if($u->hasSection('users'))
                <a class="nav-link nav-sub {{ str_starts_with($cur ?? '', 'admin.users') ? 'active' : '' }}"
                   href="{{ route('admin.users.index') }}" data-label="{{ __('messages.nav_users') }}">
                    <i class="bi bi-people"></i>
                    <span class="link-text">{{ __('messages.nav_users') }}</span>
                </a>
                @endif
                @if($u->hasSection('roles'))
                <a class="nav-link nav-sub {{ str_starts_with($cur ?? '', 'admin.roles') ? 'active' : '' }}"
                   href="{{ route('admin.roles.index') }}" data-label="{{ __('messages.nav_roles') }}">
                    <i class="bi bi-shield-lock"></i>
                    <span class="link-text">{{ __('messages.nav_roles') }}</span>
                </a>
                @endif
                @if($u->hasSection('plans'))
                <a class="nav-link nav-sub {{ str_starts_with($cur ?? '', 'admin.plans') ? 'active' : '' }}"
                   href="{{ route('admin.plans.index') }}" data-label="{{ __('messages.nav_plans') }}">
                    <i class="bi bi-credit-card"></i>
                    <span class="link-text">{{ __('messages.nav_plans') }}</span>
                </a>
                @endif
                @if($u->hasSection('transactions'))
                <a class="nav-link nav-sub {{ str_starts_with($cur ?? '', 'admin.transactions') ? 'active' : '' }}"
                   href="{{ route('admin.transactions.index') }}" data-label="{{ __('messages.nav_transactions') }}">
                    <i class="bi bi-receipt"></i>
                    <span class="link-text">{{ __('messages.nav_transactions') }}</span>
                </a>
                @endif
                @if($u->hasSection('reports'))
                <a class="nav-link nav-sub {{ str_starts_with($cur ?? '', 'admin.reports') ? 'active' : '' }}"
                   href="{{ route('admin.reports.revenue') }}" data-label="{{ __('messages.nav_reports') }}">
                    <i class="bi bi-bar-chart-line"></i>
                    <span class="link-text">{{ __('messages.nav_reports') }}</span>
                </a>
                @endif
            </div>
        </div>
        @endif

        {{-- GROUP: Kontent --}}
        @if($u->hasSection('blogs') || $u->hasSection('services') || $u->hasSection('hero-slides') || $u->hasSection('features') || $u->hasSection('partners'))
        <div class="nav-group">
            <button class="nav-group-toggle {{ $activeContent ? '' : 'collapsed' }}"
                    data-bs-toggle="collapse" data-bs-target="#grp-content"
                    aria-expanded="{{ $activeContent ? 'true' : 'false' }}">
                <span class="nav-group-icon"><i class="bi bi-layout-text-window"></i></span>
                <span class="link-text nav-group-label">{{ __('messages.nav_group_content') }}</span>
                <i class="bi bi-chevron-down nav-group-chevron link-text"></i>
            </button>
            <div id="grp-content" class="collapse nav-group-items {{ $activeContent ? 'show' : '' }}">
                @if($u->hasSection('blogs'))
                <a class="nav-link nav-sub {{ str_starts_with($cur ?? '', 'admin.blogs') ? 'active' : '' }}"
                   href="{{ route('admin.blogs.index') }}" data-label="{{ __('messages.nav_blogs') }}">
                    <i class="bi bi-newspaper"></i>
                    <span class="link-text">{{ __('messages.nav_blogs') }}</span>
                </a>
                @endif
                @if($u->hasSection('services'))
                <a class="nav-link nav-sub {{ str_starts_with($cur ?? '', 'admin.services') ? 'active' : '' }}"
                   href="{{ route('admin.services.index') }}" data-label="{{ __('messages.nav_services') }}">
                    <i class="bi bi-grid"></i>
                    <span class="link-text">{{ __('messages.nav_services') }}</span>
                </a>
                @endif
                @if($u->hasSection('hero-slides'))
                <a class="nav-link nav-sub {{ str_starts_with($cur ?? '', 'admin.hero-slides') ? 'active' : '' }}"
                   href="{{ route('admin.hero-slides.index') }}" data-label="{{ __('messages.nav_slides') }}">
                    <i class="bi bi-images"></i>
                    <span class="link-text">{{ __('messages.nav_slides') }}</span>
                </a>
                @endif
                @if($u->hasSection('features'))
                <a class="nav-link nav-sub {{ str_starts_with($cur ?? '', 'admin.features') ? 'active' : '' }}"
                   href="{{ route('admin.features.index') }}" data-label="{{ __('messages.nav_features') }}">
                    <i class="bi bi-grid-3x3-gap"></i>
                    <span class="link-text">{{ __('messages.nav_features') }}</span>
                </a>
                @endif
                @if($u->hasSection('partners'))
                <a class="nav-link nav-sub {{ str_starts_with($cur ?? '', 'admin.partners') ? 'active' : '' }}"
                   href="{{ route('admin.partners.index') }}" data-label="{{ __('messages.nav_partners') }}">
                    <i class="bi bi-building"></i>
                    <span class="link-text">{{ __('messages.nav_partners') }}</span>
                </a>
                @endif
            </div>
        </div>
        @endif

        {{-- GROUP: Mesajlar --}}
        @if($u->hasSection('subscribers') || $u->hasSection('contact-messages'))
        @php $unreadCount = \App\Models\ContactMessage::unread()->count(); @endphp
        <div class="nav-group">
            <button class="nav-group-toggle {{ $activeMessages ? '' : 'collapsed' }}"
                    data-bs-toggle="collapse" data-bs-target="#grp-messages"
                    aria-expanded="{{ $activeMessages ? 'true' : 'false' }}">
                <span class="nav-group-icon"><i class="bi bi-chat-square-text"></i></span>
                <span class="link-text nav-group-label d-flex align-items-center gap-2">
                    {{ __('messages.nav_group_messages') }}
                    @if($unreadCount > 0)
                        <span class="badge bg-danger rounded-pill" style="font-size:.55rem">{{ $unreadCount }}</span>
                    @endif
                </span>
                <i class="bi bi-chevron-down nav-group-chevron link-text"></i>
            </button>
            <div id="grp-messages" class="collapse nav-group-items {{ $activeMessages ? 'show' : '' }}">
                @if($u->hasSection('subscribers'))
                <a class="nav-link nav-sub {{ str_starts_with($cur ?? '', 'admin.subscribers') ? 'active' : '' }}"
                   href="{{ route('admin.subscribers.index') }}" data-label="{{ __('messages.nav_subscribers') }}">
                    <i class="bi bi-envelope-check"></i>
                    <span class="link-text">{{ __('messages.nav_subscribers') }}</span>
                </a>
                @endif
                @if($u->hasSection('contact-messages'))
                <a class="nav-link nav-sub {{ str_starts_with($cur ?? '', 'admin.contact-messages') ? 'active' : '' }}"
                   href="{{ route('admin.contact-messages.index') }}" data-label="{{ __('messages.nav_contact_messages') }}">
                    <i class="bi bi-chat-square-text"></i>
                    <span class="link-text d-flex align-items-center gap-2">
                        {{ __('messages.nav_contact_messages') }}
                        @if($unreadCount > 0)
                            <span class="badge bg-danger rounded-pill" style="font-size:.55rem">{{ $unreadCount }}</span>
                        @endif
                    </span>
                </a>
                @endif
            </div>
        </div>
        @endif

        {{-- GROUP: Sistem --}}
        @if($u->hasSection('site-settings') || $u->hasSection('translations'))
        <div class="nav-group">
            <button class="nav-group-toggle {{ $activeSystem ? '' : 'collapsed' }}"
                    data-bs-toggle="collapse" data-bs-target="#grp-system"
                    aria-expanded="{{ $activeSystem ? 'true' : 'false' }}">
                <span class="nav-group-icon"><i class="bi bi-gear"></i></span>
                <span class="link-text nav-group-label">{{ __('messages.nav_group_system') }}</span>
                <i class="bi bi-chevron-down nav-group-chevron link-text"></i>
            </button>
            <div id="grp-system" class="collapse nav-group-items {{ $activeSystem ? 'show' : '' }}">
                @if($u->hasSection('site-settings'))
                <a class="nav-link nav-sub {{ str_starts_with($cur ?? '', 'admin.site-settings') ? 'active' : '' }}"
                   href="{{ route('admin.site-settings.edit') }}" data-label="{{ __('messages.nav_settings') }}">
                    <i class="bi bi-sliders"></i>
                    <span class="link-text">{{ __('messages.nav_settings') }}</span>
                </a>
                @endif
                @if($u->hasSection('translations'))
                <a class="nav-link nav-sub {{ str_starts_with($cur ?? '', 'admin.translations') ? 'active' : '' }}"
                   href="{{ route('admin.translations.index') }}" data-label="{{ __('messages.nav_translations') }}">
                    <i class="bi bi-translate"></i>
                    <span class="link-text">{{ __('messages.nav_translations') }}</span>
                </a>
                @endif
            </div>
        </div>
        @endif

        {{-- Profile --}}
        <a class="nav-link {{ str_starts_with($cur ?? '', 'admin.profile') ? 'active' : '' }}"
           href="{{ route('admin.profile.edit') }}" data-label="{{ __('messages.profile') }}">
            <i class="bi bi-person-circle"></i>
            <span class="link-text">{{ __('messages.profile') }}</span>
        </a>
    </nav>

    {{-- Bottom --}}
    <div class="sidebar-bottom">
        <a class="nav-link mb-1" href="{{ route('home') }}" data-label="{{ __('messages.back_to_home') }}"
           style="color: #9ca3af; border-radius:.5rem; padding:.5rem .75rem; display:flex; align-items:center; gap:.75rem; font-size:.875rem;">
            <i class="bi bi-arrow-left-circle" style="font-size:1.1rem; width:22px; text-align:center; flex-shrink:0;"></i>
            <span class="link-text">{{ __('messages.back_to_home') }}</span>
        </a>
        <form method="post" action="{{ route('logout') }}">
            @csrf
            <button type="submit"
                style="display:flex; align-items:center; gap:.75rem; width:100%; background:rgba(239,68,68,.15); border:none; color:#f87171; border-radius:.5rem; padding:.55rem .75rem; font-size:.875rem; cursor:pointer; white-space:nowrap; transition:background .15s;"
                onmouseover="this.style.background='rgba(239,68,68,.25)'" onmouseout="this.style.background='rgba(239,68,68,.15)'">
                <i class="bi bi-box-arrow-right" style="font-size:1.1rem; width:22px; text-align:center; flex-shrink:0;"></i>
                <span class="link-text">{{ __('messages.logout') }}</span>
            </button>
        </form>
    </div>
</aside>

{{-- Mobile overlay --}}
<div id="sidebar-overlay"></div>

{{-- Main --}}
<div id="admin-main">

    {{-- Topbar --}}
    <div class="admin-topbar">
        <button id="sidebar-toggle" title="Menyunu gizlət/göstər">
            <i class="bi bi-layout-sidebar"></i>
        </button>

        <span class="text-muted small flex-grow-1 d-flex align-items-center gap-2">
            {{ auth()->user()->name ?? 'Admin' }}
            @php $r = auth()->user()->role ?? 'user'; @endphp
            @if($r === 'superadmin')
                <span class="badge bg-danger-subtle text-danger" style="font-size:.65rem">Superadmin</span>
            @elseif($r === 'admin')
                <span class="badge bg-warning-subtle text-warning" style="font-size:.65rem">Admin</span>
            @endif
        </span>

        {{-- Language switcher --}}
        @php $curLang = app()->getLocale(); @endphp
        <div class="d-flex gap-1">
            <a href="{{ request()->fullUrlWithQuery(['lang' => 'az']) }}"
               class="btn btn-sm btn-outline-secondary lang-btn {{ $curLang === 'az' ? 'active-lang' : '' }}">AZ</a>
            <a href="{{ request()->fullUrlWithQuery(['lang' => 'en']) }}"
               class="btn btn-sm btn-outline-secondary lang-btn {{ $curLang === 'en' ? 'active-lang' : '' }}">EN</a>
            <a href="{{ request()->fullUrlWithQuery(['lang' => 'ru']) }}"
               class="btn btn-sm btn-outline-secondary lang-btn {{ $curLang === 'ru' ? 'active-lang' : '' }}">RU</a>
        </div>
    </div>

    {{-- Alerts --}}
    <div class="admin-content">
        @if(session('status'))
            <div class="alert alert-success alert-dismissible fade show">
                {{ session('status') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @yield('content')
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    const sidebar   = document.getElementById('admin-sidebar');
    const mainEl    = document.getElementById('admin-main');
    const toggleBtn = document.getElementById('sidebar-toggle');
    const overlay   = document.getElementById('sidebar-overlay');
    const STORAGE_KEY = 'admin_sidebar_collapsed';
    const isMobile = () => window.innerWidth < 768;

    function applyState(collapsed) {
        if (isMobile()) {
            sidebar.classList.toggle('mobile-open', !collapsed);
            overlay.style.display = collapsed ? 'none' : 'block';
        } else {
            sidebar.classList.toggle('collapsed', collapsed);
            mainEl.classList.toggle('expanded', collapsed);
            overlay.style.display = 'none';
        }
    }

    // Restore desktop state
    let isCollapsed = localStorage.getItem(STORAGE_KEY) === '1';
    if (!isMobile()) applyState(isCollapsed);

    toggleBtn.addEventListener('click', () => {
        if (isMobile()) {
            const open = sidebar.classList.contains('mobile-open');
            applyState(open); // toggle: if open → close (collapsed=true)
        } else {
            isCollapsed = !isCollapsed;
            localStorage.setItem(STORAGE_KEY, isCollapsed ? '1' : '0');
            applyState(isCollapsed);
        }
    });

    overlay.addEventListener('click', () => applyState(true));
</script>
@stack('scripts')
</body>
</html>
