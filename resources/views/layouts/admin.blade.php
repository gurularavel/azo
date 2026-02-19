<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Admin') — {{ $siteSettings?->site_name ?? 'QR Endirim' }}</title>
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

        /* Lang buttons */
        .lang-btn { font-size: .75rem; font-weight: 600; padding: .25rem .6rem; }
        .lang-btn.active-lang { background: #213b67; color: #fff; border-color: #213b67; }

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
        @php $cur = request()->route()?->getName(); @endphp

        <div class="sidebar-section-label">Ümumi</div>

        <a class="nav-link {{ $cur === 'admin.dashboard' ? 'active' : '' }}"
           href="{{ route('admin.dashboard') }}" data-label="{{ __('messages.admin_dashboard') }}">
            <i class="bi bi-speedometer2"></i>
            <span class="link-text">{{ __('messages.admin_dashboard') }}</span>
        </a>

        <div class="sidebar-section-label">Kataloq</div>

        <a class="nav-link {{ str_starts_with($cur ?? '', 'admin.shops') ? 'active' : '' }}"
           href="{{ route('admin.shops.index') }}" data-label="{{ __('messages.manage_shops') }}">
            <i class="bi bi-shop"></i>
            <span class="link-text">{{ __('messages.manage_shops') }}</span>
        </a>

        <a class="nav-link {{ str_starts_with($cur ?? '', 'admin.shop-categories') ? 'active' : '' }}"
           href="{{ route('admin.shop-categories.index') }}" data-label="{{ __('messages.manage_categories') }}">
            <i class="bi bi-tags"></i>
            <span class="link-text">{{ __('messages.manage_categories') }}</span>
        </a>

        <a class="nav-link {{ str_starts_with($cur ?? '', 'admin.cities') ? 'active' : '' }}"
           href="{{ route('admin.cities.index') }}" data-label="{{ __('messages.manage_cities') }}">
            <i class="bi bi-geo-alt"></i>
            <span class="link-text">{{ __('messages.manage_cities') }}</span>
        </a>

        <div class="sidebar-section-label">İstifadəçilər & Maliyyə</div>

        <a class="nav-link {{ str_starts_with($cur ?? '', 'admin.users') ? 'active' : '' }}"
           href="{{ route('admin.users.index') }}" data-label="{{ __('messages.manage_users') }}">
            <i class="bi bi-people"></i>
            <span class="link-text">{{ __('messages.manage_users') }}</span>
        </a>

        <a class="nav-link {{ str_starts_with($cur ?? '', 'admin.plans') ? 'active' : '' }}"
           href="{{ route('admin.plans.index') }}" data-label="{{ __('messages.manage_plans') }}">
            <i class="bi bi-credit-card"></i>
            <span class="link-text">{{ __('messages.manage_plans') }}</span>
        </a>

        <a class="nav-link {{ str_starts_with($cur ?? '', 'admin.transactions') ? 'active' : '' }}"
           href="{{ route('admin.transactions.index') }}" data-label="{{ __('messages.transaction_logs') }}">
            <i class="bi bi-receipt"></i>
            <span class="link-text">{{ __('messages.transaction_logs') }}</span>
        </a>

        <a class="nav-link {{ str_starts_with($cur ?? '', 'admin.reports') ? 'active' : '' }}"
           href="{{ route('admin.reports.revenue') }}" data-label="{{ __('messages.revenue_reports') }}">
            <i class="bi bi-bar-chart-line"></i>
            <span class="link-text">{{ __('messages.revenue_reports') }}</span>
        </a>

        <div class="sidebar-section-label">Kontent</div>

        <a class="nav-link {{ str_starts_with($cur ?? '', 'admin.blogs') ? 'active' : '' }}"
           href="{{ route('admin.blogs.index') }}" data-label="{{ __('messages.manage_blogs') }}">
            <i class="bi bi-newspaper"></i>
            <span class="link-text">{{ __('messages.manage_blogs') }}</span>
        </a>

        <a class="nav-link {{ str_starts_with($cur ?? '', 'admin.services') ? 'active' : '' }}"
           href="{{ route('admin.services.index') }}" data-label="{{ __('messages.manage_services') }}">
            <i class="bi bi-grid"></i>
            <span class="link-text">{{ __('messages.manage_services') }}</span>
        </a>

        <a class="nav-link {{ str_starts_with($cur ?? '', 'admin.hero-slides') ? 'active' : '' }}"
           href="{{ route('admin.hero-slides.index') }}" data-label="{{ __('messages.manage_slides') }}">
            <i class="bi bi-images"></i>
            <span class="link-text">{{ __('messages.manage_slides') }}</span>
        </a>

        <a class="nav-link {{ str_starts_with($cur ?? '', 'admin.features') ? 'active' : '' }}"
           href="{{ route('admin.features.index') }}" data-label="Niyə Biz? Kartları">
            <i class="bi bi-grid-3x3-gap"></i>
            <span class="link-text">Niyə Biz? Kartları</span>
        </a>

        <div class="sidebar-section-label">Sistem</div>

        <a class="nav-link {{ str_starts_with($cur ?? '', 'admin.site-settings') ? 'active' : '' }}"
           href="{{ route('admin.site-settings.edit') }}" data-label="{{ __('messages.site_settings') }}">
            <i class="bi bi-sliders"></i>
            <span class="link-text">{{ __('messages.site_settings') }}</span>
        </a>

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

        <span class="text-muted small flex-grow-1">{{ auth()->user()->name ?? 'Admin' }}</span>

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
