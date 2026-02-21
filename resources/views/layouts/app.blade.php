<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>@yield('title', $siteSettings?->site_name ?? 'QR Endirim')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('template/styles/main.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: { DEFAULT: '#ff5f00', hover: '#e65600', light: '#fff4e5' },
                        secondary: { DEFAULT: '#0a2a66', dark: '#071d47' },
                    },
                    fontFamily: { sans: ['Inter', 'sans-serif'] },
                    boxShadow: {
                        orange: '0 10px 15px -3px rgba(255, 95, 0, 0.3)',
                        premium: '0 20px 50px -12px rgba(0, 0, 0, 0.1)',
                    },
                },
            },
        };
    </script>
    @stack('styles')
</head>
<body class="bg-white text-slate-800 antialiased gradient-bg font-sans">
@php
    $path = request()->path();
    $lang = request('lang', app()->getLocale());
    $localeMap = [
        'az' => ['AZ', 'https://flagcdn.com/w20/az.png'],
        'en' => ['EN', 'https://flagcdn.com/w20/gb.png'],
        'ru' => ['RU', 'https://flagcdn.com/w20/ru.png'],
    ];
    [$localeLabel, $localeFlag] = $localeMap[$lang] ?? $localeMap['az'];
@endphp
<header class="fixed top-0 left-0 w-full z-50 glass border-b border-orange-100">
    <div class="container mx-auto px-4 py-4 flex items-center justify-between gap-4">
        <a href="{{ route('home') }}" class="flex items-center group">
            <img src="{{ asset('template/images/logo.svg') }}" alt="{{ $siteSettings?->site_name ?? 'Logo' }}" class="w-28 md:w-32 transition-transform" />
        </a>

        <nav class="hidden md:flex items-center gap-8">
            <a href="{{ route('home') }}" class="{{ $path === '/' ? 'nav-link-active' : 'text-slate-600' }} hover:text-primary transition-colors text-lg">{{ __('messages.home') }}</a>
            <a href="{{ route('shops.index') }}" class="{{ str_starts_with($path, 'shops') ? 'nav-link-active' : 'text-slate-600' }} hover:text-primary transition-colors text-lg">{{ __('messages.shops') }}</a>
            <a href="{{ route('blogs.index') }}" class="{{ str_starts_with($path, 'blogs') ? 'nav-link-active' : 'text-slate-600' }} hover:text-primary transition-colors text-lg">{{ __('messages.blogs') }}</a>
            <a href="{{ route('services.index') }}" class="{{ str_starts_with($path, 'services') ? 'nav-link-active' : 'text-slate-600' }} hover:text-primary transition-colors text-lg">{{ __('messages.services') }}</a>
            <a href="{{ route('contact') }}" class="{{ $path === 'contact' ? 'nav-link-active' : 'text-slate-600' }} hover:text-primary transition-colors text-lg">{{ __('messages.contact') }}</a>
            @auth
                <a href="{{ route('subscriptions.index') }}" class="{{ str_starts_with($path, 'subscriptions') ? 'nav-link-active' : 'text-slate-600' }} hover:text-primary transition-colors text-lg">{{ __('messages.subscriptions') }}</a>
            @endauth
        </nav>

        <div class="flex items-center gap-3">
            <div class="hidden md:block relative group">
                <button class="flex items-center gap-2 px-3 py-2.5 rounded-full border border-slate-200 bg-white hover:border-primary transition-all duration-300">
                    <img src="{{ $localeFlag }}" class="w-5 h-auto rounded-sm" alt="{{ $localeLabel }}">
                    <span class="text-sm font-bold text-slate-700">{{ $localeLabel }}</span>
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-3.5 h-3.5 text-slate-400 group-hover:text-primary transition-colors">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                    </svg>
                </button>
                <div class="absolute top-full right-0 mt-2 w-32 bg-white rounded-2xl shadow-premium border border-slate-100 py-2 opacity-0 invisible translate-y-2 group-hover:opacity-100 group-hover:visible group-hover:translate-y-0 transition-all duration-300 z-50">
                    <a href="{{ request()->fullUrlWithQuery(['lang' => 'az']) }}" class="flex items-center gap-3 px-4 py-2 hover:bg-slate-50 transition-colors"><img src="https://flagcdn.com/w20/az.png" class="w-5 h-auto rounded-sm" alt="AZ"><span class="text-sm text-slate-700">AZ</span></a>
                    <a href="{{ request()->fullUrlWithQuery(['lang' => 'en']) }}" class="flex items-center gap-3 px-4 py-2 hover:bg-slate-50 transition-colors"><img src="https://flagcdn.com/w20/gb.png" class="w-5 h-auto rounded-sm" alt="EN"><span class="text-sm text-slate-700">EN</span></a>
                    <a href="{{ request()->fullUrlWithQuery(['lang' => 'ru']) }}" class="flex items-center gap-3 px-4 py-2 hover:bg-slate-50 transition-colors"><img src="https://flagcdn.com/w20/ru.png" class="w-5 h-auto rounded-sm" alt="RU"><span class="text-sm text-slate-700">RU</span></a>
                </div>
            </div>

            @auth
                @if(auth()->user()->is_admin)
                    <a href="{{ route('admin.dashboard') }}" class="hidden sm:inline-flex items-center justify-center px-5 py-2.5 rounded-full border-2 border-secondary text-secondary font-semibold hover:bg-secondary hover:text-white transition-all duration-300">{{ __('messages.admin_panel') }}</a>
                @endif
                <form method="post" action="{{ route('logout') }}" class="hidden sm:block">
                    @csrf
                    <button class="inline-flex items-center justify-center px-6 py-2.5 rounded-full border-2 border-primary text-primary font-semibold hover:bg-primary hover:text-white transition-all duration-300" type="submit">{{ __('messages.logout') }}</button>
                </form>
                <a href="{{ route('subscriptions.index') }}" class="sm:hidden w-10 h-10 rounded-full bg-slate-200 border-2 border-primary flex items-center justify-center overflow-hidden">
                    <img src="{{ asset('template/icons/person.svg') }}" class="w-6 h-6" alt="user" />
                </a>
            @else
                <a href="{{ route('login') }}" class="hidden sm:inline-flex items-center justify-center px-6 py-2.5 rounded-full border-2 border-primary text-primary font-semibold hover:bg-primary hover:text-white transition-all duration-300">{{ __('messages.login') }}</a>
                <a href="{{ route('register') }}" class="inline-flex items-center justify-center px-6 py-2.5 rounded-full bg-primary text-white font-semibold shadow-orange hover:bg-primary-hover transition-all duration-300">{{ __('messages.register') }}</a>
            @endauth

            <button id="mobile-menu-toggle" class="md:hidden text-secondary" type="button" aria-label="menu">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-8 h-8">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                </svg>
            </button>
        </div>
    </div>

</header>

{{-- Mobile Menu Overlay --}}
<div id="mobile-menu-overlay" class="fixed inset-0 bg-white z-[60] p-6 flex flex-col overflow-y-auto hidden animate__animated" style="animation-duration:0.35s">
    <div class="flex justify-between items-center mb-8">
        <a href="{{ route('home') }}" class="flex items-center">
            <img src="{{ asset('template/images/logo.svg') }}" alt="{{ $siteSettings?->site_name ?? 'Logo' }}" class="w-14" />
        </a>
        <button id="mobile-menu-close" class="text-secondary">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-8 h-8">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
    </div>
    <nav class="flex-1 flex flex-col gap-4 text-xl font-bold text-secondary">
        <a href="{{ route('home') }}" class="{{ request()->is('/') ? 'text-primary' : '' }}">{{ __('messages.home') }}</a>
        <a href="{{ route('shops.index') }}" class="{{ request()->is('shops*') ? 'text-primary' : '' }}">{{ __('messages.shops') }}</a>
        <a href="{{ route('blogs.index') }}" class="{{ request()->is('blogs*') ? 'text-primary' : '' }}">{{ __('messages.blogs') }}</a>
        <a href="{{ route('services.index') }}" class="{{ request()->is('services*') ? 'text-primary' : '' }}">{{ __('messages.services') }}</a>
        <a href="{{ route('contact') }}" class="{{ request()->is('contact') ? 'text-primary' : '' }}">{{ __('messages.contact') }}</a>
        @auth
            <a href="{{ route('subscriptions.index') }}" class="{{ request()->is('subscriptions*') ? 'text-primary' : '' }}">{{ __('messages.subscriptions') }}</a>
            @if(auth()->user()->is_admin)
                <a href="{{ route('admin.dashboard') }}" class="">{{ __('messages.admin_panel') }}</a>
            @endif
        @endauth

        <div class="mt-6 pt-6 border-t border-slate-100 flex flex-col gap-3">
            @auth
                @if(auth()->user()->is_admin)
                    <a href="{{ route('admin.dashboard') }}" class="w-full py-3 text-center rounded-xl border-2 border-secondary text-secondary text-base font-semibold">{{ __('messages.admin_panel') }}</a>
                @endif
                <form method="post" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full py-3 text-center rounded-xl border-2 border-primary text-primary text-base font-semibold">{{ __('messages.logout') }}</button>
                </form>
            @else
                <a href="{{ route('login') }}" class="w-full py-3 text-center rounded-xl border-2 border-primary text-primary text-base font-semibold">{{ __('messages.login') }}</a>
                <a href="{{ route('register') }}" class="w-full py-3 text-center rounded-xl bg-primary text-white text-base font-semibold">{{ __('messages.register') }}</a>
            @endauth
        </div>

        <div class="mt-auto pt-8 pb-4">
            <p class="text-sm font-bold text-slate-400 uppercase tracking-widest mb-4">{{ __('messages.language') ?? 'Dil seçimi' }}</p>
            <div class="flex gap-4">
                <a href="{{ request()->fullUrlWithQuery(['lang' => 'az']) }}"
                   class="flex flex-col items-center gap-2 flex-1 p-3 rounded-xl border-2 transition-all {{ $lang === 'az' ? 'border-primary bg-slate-50' : 'border-transparent bg-slate-50/50 hover:border-slate-200' }}">
                    <img src="https://flagcdn.com/w40/az.png" class="w-7 h-auto rounded-sm shadow-sm" alt="AZ">
                    <span class="text-xs font-bold {{ $lang === 'az' ? 'text-secondary' : 'text-slate-400' }}">AZ</span>
                </a>
                <a href="{{ request()->fullUrlWithQuery(['lang' => 'en']) }}"
                   class="flex flex-col items-center gap-2 flex-1 p-3 rounded-xl border-2 transition-all {{ $lang === 'en' ? 'border-primary bg-slate-50' : 'border-transparent bg-slate-50/50 hover:border-slate-200' }}">
                    <img src="https://flagcdn.com/w40/gb.png" class="w-7 h-auto rounded-sm shadow-sm" alt="EN">
                    <span class="text-xs font-bold {{ $lang === 'en' ? 'text-secondary' : 'text-slate-400' }}">EN</span>
                </a>
                <a href="{{ request()->fullUrlWithQuery(['lang' => 'ru']) }}"
                   class="flex flex-col items-center gap-2 flex-1 p-3 rounded-xl border-2 transition-all {{ $lang === 'ru' ? 'border-primary bg-slate-50' : 'border-transparent bg-slate-50/50 hover:border-slate-200' }}">
                    <img src="https://flagcdn.com/w40/ru.png" class="w-7 h-auto rounded-sm shadow-sm" alt="RU">
                    <span class="text-xs font-bold {{ $lang === 'ru' ? 'text-secondary' : 'text-slate-400' }}">RU</span>
                </a>
            </div>
        </div>
    </nav>
</div>

<main class="pt-24 min-h-screen">
    @if(session('status'))
        <div class="container mx-auto px-4 mt-4">
            <div class="mb-4 p-4 rounded-sm bg-green-50 text-green-800 border border-green-200">{{ session('status') }}</div>
        </div>
    @endif
    @if(session('error'))
        <div class="container mx-auto px-4 mt-4">
            <div class="mb-4 p-4 rounded-sm bg-red-50 text-red-800 border border-red-200">{{ session('error') }}</div>
        </div>
    @endif
    @if($errors->any())
        <div class="container mx-auto px-4 mt-4">
            <div class="mb-4 p-4 rounded-sm bg-red-50 text-red-800 border border-red-200">
                <ul class="list-disc pl-5 space-y-1">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif

    @yield('content')
</main>

<footer class="bg-white pt-24 pb-12 border-t border-slate-100">
    <div class="container mx-auto px-4">
        <div class="grid md:grid-cols-4 gap-12 mb-16">

            {{-- Logo + Description --}}
            <div class="col-span-2 md:col-span-1">
                <a href="{{ route('home') }}" class="flex items-center mb-6">
                    <img src="{{ asset('template/images/logo.svg') }}" alt="{{ $siteSettings?->site_name ?? 'Logo' }}" class="w-32" />
                </a>
                @if(!empty($siteSettings?->footer_text))
                    <p class="text-slate-500 text-lg leading-relaxed">{{ $siteSettings->footer_text }}</p>
                @else
                    <p class="text-slate-500 text-lg leading-relaxed">Azərbaycanın ən müasir və sürətli endirim platforması. Sevdiyiniz mağazalarda hər zaman sərfəli alış-veriş edin.</p>
                @endif
            </div>

            {{-- Links --}}
            <div>
                <h4 class="text-secondary font-bold text-xl mb-6">Keçidlər</h4>
                <ul class="space-y-4">
                    <li><a href="{{ route('home') }}" class="text-slate-500 hover:text-primary transition-colors">Ana Səhifə</a></li>
                    <li><a href="{{ route('services.index') }}" class="text-slate-500 hover:text-primary transition-colors">Haqqımızda</a></li>
                    <li><a href="{{ route('shops.index') }}" class="text-slate-500 hover:text-primary transition-colors">Mağazalar</a></li>
                    <li><a href="{{ route('blogs.index') }}" class="text-slate-500 hover:text-primary transition-colors">Bloq</a></li>
                </ul>
            </div>

            {{-- Support --}}
            <div>
                <h4 class="text-secondary font-bold text-xl mb-6">Dəstək</h4>
                <ul class="space-y-4">
                    <li><a href="{{ route('contact') }}" class="text-slate-500 hover:text-primary transition-colors">Əlaqə</a></li>
                    @auth
                        <li><a href="{{ route('subscriptions.index') }}" class="text-slate-500 hover:text-primary transition-colors">Abunəliyim</a></li>
                    @else
                        <li><a href="{{ route('register') }}" class="text-slate-500 hover:text-primary transition-colors">Qeydiyyat</a></li>
                        <li><a href="{{ route('login') }}" class="text-slate-500 hover:text-primary transition-colors">Daxil ol</a></li>
                    @endauth
                </ul>
            </div>

            {{-- Social Media --}}
            <div>
                <h4 class="text-secondary font-bold text-xl mb-6">Sosial Media</h4>
                <div class="flex gap-4">
                    @if($siteSettings?->facebook_url)
                    <a href="{{ $siteSettings->facebook_url }}" target="_blank"
                        class="w-12 h-12 rounded-xl bg-slate-50 flex items-center justify-center text-slate-400 hover:bg-primary hover:text-white transition-all">
                        <svg fill="currentColor" viewBox="0 0 24 24" class="w-5 h-5">
                            <path d="M18.77 7.46H14.5v-1.9c0-.9.6-1.1 1-1.1h3V.5h-4.33C10.24.5 9.5 3.44 9.5 5.32v2.14H7.5V12h2v11.5h5V12h2.82l.45-4.54z" />
                        </svg>
                    </a>
                    @else
                    <a href="#"
                        class="w-12 h-12 rounded-xl bg-slate-50 flex items-center justify-center text-slate-400 hover:bg-primary hover:text-white transition-all">
                        <svg fill="currentColor" viewBox="0 0 24 24" class="w-5 h-5">
                            <path d="M18.77 7.46H14.5v-1.9c0-.9.6-1.1 1-1.1h3V.5h-4.33C10.24.5 9.5 3.44 9.5 5.32v2.14H7.5V12h2v11.5h5V12h2.82l.45-4.54z" />
                        </svg>
                    </a>
                    @endif

                    @if($siteSettings?->instagram_url)
                    <a href="{{ $siteSettings->instagram_url }}" target="_blank"
                        class="w-12 h-12 rounded-xl bg-slate-50 flex items-center justify-center text-slate-400 hover:bg-primary hover:text-white transition-all">
                        <svg fill="currentColor" viewBox="0 0 24 24" class="w-5 h-5">
                            <path d="M12.315 2c2.43 0 2.784.013 3.808.06 1.064.049 1.791.218 2.427.465a4.902 4.902 0 011.772 1.153 4.902 4.902 0 011.153 1.772c.247.636.416 1.363.465 2.427.048 1.067.06 1.407.06 4.123v.08c0 2.643-.012 2.987-.06 4.043-.049 1.064-.218 1.791-.465 2.427a4.902 4.902 0 01-1.153 1.772 4.902 4.902 0 01-1.772 1.153c-.636.247-1.363.416-2.427.465-1.067.048-1.407.06-4.123.06h-.08c-2.643 0-2.987-.012-4.043-.06-1.064-.049-1.791-.218-2.427-.465a4.902 4.902 0 01-1.772-1.153 4.902 4.902 0 01-1.153-1.772c-.247-.636-.416-1.363-.465-2.427-.047-1.024-.06-1.379-.06-3.808v-.63c0-2.43.013-2.784.06-3.808.049-1.064.218-1.791.465-2.427a4.902 4.902 0 011.153-1.772A4.902 4.902 0 015.45 2.525c.636-.247 1.363-.416 2.427-.465C8.901 2.013 9.256 2 11.685 2h.63zm-.081 1.802h-.468c-2.456 0-2.784.011-3.807.058-.975.045-1.504.207-1.857.344-.467.182-.8.398-1.15.748-.35.35-.566.683-.748 1.15-.137.353-.3.882-.344 1.857-.047 1.023-.058 1.351-.058 3.807v.468c0 2.456.011 2.784.058 3.807.045.975.207 1.504.344 1.857.182.466.399.8.748 1.15.35.35.683.566 1.15.748.353.137.882.3 1.857.344 1.054.048 1.37.058 4.041.058h.08c2.597 0 2.917-.01 3.96-.058.976-.045 1.505-.207 1.858-.344.466-.182.8-.398 1.15-.748.35-.35.566-.683.748-1.15.137-.353.3-.882.344-1.857.048-1.055.058-1.37.058-4.041v-.08c0-2.597-.01-2.917-.058-3.96-.045-.976-.207-1.505-.344-1.858a3.097 3.097 0 00-.748-1.15 3.098 3.098 0 00-1.15-.748c-.353-.137-.882-.3-1.857-.344-1.023-.047-1.351-.058-3.807-.058zM12 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16.35a4.188 4.188 0 110-8.376 4.188 4.188 0 010 8.376zm4.962-10.405a1.44 1.44 0 11-2.88 0 1.44 1.44 0 012.88 0z" />
                        </svg>
                    </a>
                    @else
                    <a href="#"
                        class="w-12 h-12 rounded-xl bg-slate-50 flex items-center justify-center text-slate-400 hover:bg-primary hover:text-white transition-all">
                        <svg fill="currentColor" viewBox="0 0 24 24" class="w-5 h-5">
                            <path d="M12.315 2c2.43 0 2.784.013 3.808.06 1.064.049 1.791.218 2.427.465a4.902 4.902 0 011.772 1.153 4.902 4.902 0 011.153 1.772c.247.636.416 1.363.465 2.427.048 1.067.06 1.407.06 4.123v.08c0 2.643-.012 2.987-.06 4.043-.049 1.064-.218 1.791-.465 2.427a4.902 4.902 0 01-1.153 1.772 4.902 4.902 0 01-1.772 1.153c-.636.247-1.363.416-2.427.465-1.067.048-1.407.06-4.123.06h-.08c-2.643 0-2.987-.012-4.043-.06-1.064-.049-1.791-.218-2.427-.465a4.902 4.902 0 01-1.772-1.153 4.902 4.902 0 01-1.153-1.772c-.247-.636-.416-1.363-.465-2.427-.047-1.024-.06-1.379-.06-3.808v-.63c0-2.43.013-2.784.06-3.808.049-1.064.218-1.791.465-2.427a4.902 4.902 0 011.153-1.772A4.902 4.902 0 015.45 2.525c.636-.247 1.363-.416 2.427-.465C8.901 2.013 9.256 2 11.685 2h.63zm-.081 1.802h-.468c-2.456 0-2.784.011-3.807.058-.975.045-1.504.207-1.857.344-.467.182-.8.398-1.15.748-.35.35-.566.683-.748 1.15-.137.353-.3.882-.344 1.857-.047 1.023-.058 1.351-.058 3.807v.468c0 2.456.011 2.784.058 3.807.045.975.207 1.504.344 1.857.182.466.399.8.748 1.15.35.35.683.566 1.15.748.353.137.882.3 1.857.344 1.054.048 1.37.058 4.041.058h.08c2.597 0 2.917-.01 3.96-.058.976-.045 1.505-.207 1.858-.344.466-.182.8-.398 1.15-.748.35-.35.566-.683.748-1.15.137-.353.3-.882.344-1.857.048-1.055.058-1.37.058-4.041v-.08c0-2.597-.01-2.917-.058-3.96-.045-.976-.207-1.505-.344-1.858a3.097 3.097 0 00-.748-1.15 3.098 3.098 0 00-1.15-.748c-.353-.137-.882-.3-1.857-.344-1.023-.047-1.351-.058-3.807-.058zM12 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16.35a4.188 4.188 0 110-8.376 4.188 4.188 0 010 8.376zm4.962-10.405a1.44 1.44 0 11-2.88 0 1.44 1.44 0 012.88 0z" />
                        </svg>
                    </a>
                    @endif

                    @if($siteSettings?->youtube_url)
                    <a href="{{ $siteSettings->youtube_url }}" target="_blank"
                        class="w-12 h-12 rounded-xl bg-slate-50 flex items-center justify-center text-slate-400 hover:bg-primary hover:text-white transition-all">
                        <svg fill="currentColor" viewBox="0 0 24 24" class="w-5 h-5">
                            <path d="M23.498 6.186a3.016 3.016 0 00-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505a3.017 3.017 0 00-2.122 2.136C0 8.055 0 12 0 12s0 3.945.501 5.814a3.015 3.015 0 002.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 002.122-2.136C24 15.945 24 12 24 12s0-3.945-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z" />
                        </svg>
                    </a>
                    @else
                    <a href="#"
                        class="w-12 h-12 rounded-xl bg-slate-50 flex items-center justify-center text-slate-400 hover:bg-primary hover:text-white transition-all">
                        <svg fill="currentColor" viewBox="0 0 24 24" class="w-5 h-5">
                            <path d="M23.498 6.186a3.016 3.016 0 00-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505a3.017 3.017 0 00-2.122 2.136C0 8.055 0 12 0 12s0 3.945.501 5.814a3.015 3.015 0 002.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 002.122-2.136C24 15.945 24 12 24 12s0-3.945-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z" />
                        </svg>
                    </a>
                    @endif
                </div>
            </div>

        </div>

        {{-- Bottom Bar --}}
        <div class="pt-12 border-t border-slate-100 flex flex-col md:flex-row justify-between items-center gap-6">
            <p class="text-slate-500 font-medium">&copy; {{ now()->year }} {{ $siteSettings?->site_name ?? 'QR Endirim' }}. Bütün hüquqlar qorunur.</p>
            <div class="flex items-center gap-2">
                <div class="w-2 h-2 rounded-full bg-green-500 animate-pulse"></div>
                <span class="text-slate-500">Sistem aktivdir</span>
            </div>
        </div>
    </div>
</footer>

<script>
    const mobileToggle = document.getElementById('mobile-menu-toggle');
    const mobileOverlay = document.getElementById('mobile-menu-overlay');
    const mobileClose = document.getElementById('mobile-menu-close');

    function openMobileMenu() {
        mobileOverlay.classList.remove('hidden', 'animate__fadeOutDown');
        mobileOverlay.classList.add('animate__fadeInUp');
        document.body.style.overflow = 'hidden';
    }

    function closeMobileMenu() {
        mobileOverlay.classList.remove('animate__fadeInUp');
        mobileOverlay.classList.add('animate__fadeOutDown');
        document.body.style.overflow = '';
        setTimeout(() => mobileOverlay.classList.add('hidden'), 350);
    }

    if (mobileToggle) mobileToggle.addEventListener('click', openMobileMenu);
    if (mobileClose) mobileClose.addEventListener('click', closeMobileMenu);
</script>
@stack('scripts')
</body>
</html>
