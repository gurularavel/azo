@extends('layouts.app')

@section('title', ($siteSettings?->site_name ?? 'QR Endirim') . ' - Endirimli Alış-verişin Yeni Yolu')

@push('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
<style>
    .stores-swiper .swiper-slide { height: auto; display: flex; }
    .stores-swiper .swiper-slide > div { width: 100%; }
    .hero-gradient { background: linear-gradient(135deg, #fff4e5 0%, #fff 50%, #f0f4ff 100%); }
</style>
@endpush

@section('content')

{{-- Hero Section --}}
@php
    $slide        = $slides->first();
    $heroTitle    = $slide?->title    ?? $siteSettings?->hero_title    ?? null;
    $heroSubtitle = $slide?->subtitle ?? $siteSettings?->hero_subtitle ?? null;
    $heroBtnPrimaryText = $slide?->button_text   ?? $siteSettings?->hero_primary_text   ?? 'İndi Başla';
    $heroBtnPrimaryUrl  = $slide?->button_url    ?? $siteSettings?->hero_primary_url    ?? route('register');
    $heroBtnSecText     = $siteSettings?->hero_secondary_text ?? 'Mağazalara Bax';
    $heroBtnSecUrl      = $siteSettings?->hero_secondary_url  ?? route('shops.index');
    $heroImage = null;
    if ($slide?->image_path) {
        $heroImage = str_starts_with($slide->image_path, 'http')
            ? $slide->image_path
            : asset('storage/' . $slide->image_path);
    } elseif ($siteSettings?->hero_image) {
        $heroImage = str_starts_with($siteSettings->hero_image, 'http')
            ? $siteSettings->hero_image
            : asset('storage/' . $siteSettings->hero_image);
    }
    $statUsersVal     = $siteSettings?->hero_stat_users_value     ?? '50k+';
    $statUsersLabel   = $siteSettings?->hero_stat_users_label     ?? 'İstifadəçi';
    $statPartVal      = $siteSettings?->hero_stat_partners_value  ?? '100+';
    $statPartLabel    = $siteSettings?->hero_stat_partners_label  ?? 'Partnyor';
    $statSavVal       = $siteSettings?->hero_stat_savings_value   ?? '25%';
    $statSavLabel     = $siteSettings?->hero_stat_savings_label   ?? 'Orta Qənaət';
@endphp

<section class="hero-gradient">
    <div class="container mx-auto px-4 py-16 md:py-24 flex flex-col md:flex-row items-center gap-12">
        <div class="flex-1 animate__animated animate__fadeInLeft">
            <span class="inline-block bg-orange-50 text-primary border border-orange-100 px-4 py-1.5 rounded-full text-sm font-bold uppercase tracking-widest mb-6">
                {{ $siteSettings?->site_name ?? 'QR Endirim' }}
            </span>

            @if($heroTitle)
                <h1 class="text-4xl md:text-6xl font-black text-secondary leading-tight mb-6">
                    {!! nl2br(e($heroTitle)) !!}
                </h1>
            @else
                <h1 class="text-4xl md:text-6xl font-black text-secondary leading-tight mb-6">
                    Endirimli <span class="text-primary italic">Alış-verişin</span><br />Yeni Yolu
                </h1>
            @endif

            @if($heroSubtitle)
                <p class="text-xl text-slate-600 leading-relaxed mb-10">{{ $heroSubtitle }}</p>
            @else
                <p class="text-xl text-slate-600 leading-relaxed mb-10">
                    Sevdiyiniz mağazalarda QR kod ilə anında endirim əldə edin. Plastik kartlara ehtiyac yoxdur.
                </p>
            @endif

            <div class="flex flex-wrap gap-4 mb-12">
                <a href="{{ $heroBtnPrimaryUrl }}"
                    class="inline-flex items-center gap-2 px-8 py-4 rounded-full bg-primary text-white font-bold text-lg shadow-orange hover:bg-primary-hover transition-all duration-300">
                    {{ $heroBtnPrimaryText }}
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" />
                    </svg>
                </a>
                <a href="{{ $heroBtnSecUrl }}"
                    class="inline-flex items-center gap-2 px-8 py-4 rounded-full border-2 border-secondary text-secondary font-bold text-lg hover:bg-secondary hover:text-white transition-all duration-300">
                    {{ $heroBtnSecText }}
                </a>
            </div>

            <div class="flex gap-8 pt-8 border-t border-slate-100">
                <div>
                    <p class="text-3xl font-bold text-secondary">{{ $statUsersVal }}</p>
                    <p class="text-slate-500">{{ $statUsersLabel }}</p>
                </div>
                <div>
                    <p class="text-3xl font-bold text-secondary">{{ $statPartVal }}</p>
                    <p class="text-slate-500">{{ $statPartLabel }}</p>
                </div>
                <div>
                    <p class="text-3xl font-bold text-secondary">{{ $statSavVal }}</p>
                    <p class="text-slate-500">{{ $statSavLabel }}</p>
                </div>
            </div>
        </div>

        <div class="flex-1 relative animate__animated animate__fadeInRight">
            <div class="relative z-10 rounded-2xl overflow-hidden shadow-2xl bg-secondary/5 border border-white/20 backdrop-blur-sm p-4">
                <img src="{{ $heroImage ?? asset('template/images/homepage/hero-modern.png') }}" alt="Hero"
                    class="hidden md:block w-full h-auto rounded-xl shadow-premium" />
            </div>
            <div class="hidden md:block absolute -top-10 -right-10 w-40 h-40 bg-primary/10 rounded-full blur-3xl animate-pulse"></div>
            <div class="hidden md:block absolute -bottom-10 -left-10 w-60 h-60 bg-blue-500/10 rounded-full blur-3xl animate-pulse"></div>
        </div>
    </div>
</section>

{{-- Partner Logos --}}
@if($partners->isNotEmpty())
<section class="py-20 overflow-hidden">
    <div class="container mx-auto px-4">
        <div class="flex flex-col items-center mb-12">
            <span class="bg-orange-50 text-primary border border-orange-100 px-4 py-1.5 rounded-full text-sm font-bold uppercase tracking-widest mb-4">Şəbəkəmiz</span>
            <h2 class="text-3xl font-bold text-secondary text-center">Etibar Edən Partnyorlarımız</h2>
        </div>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6 items-center">
            @foreach($partners as $partner)
            @php
                $logoUrl = $partner->logo_path
                    ? (str_starts_with($partner->logo_path, 'http') ? $partner->logo_path : asset('storage/' . $partner->logo_path))
                    : null;
            @endphp
            <div class="group bg-white p-6 rounded-lg border border-slate-100 shadow-sm hover:shadow-xl transition-all duration-300 flex items-center justify-center h-48">
                @if($partner->website_url)
                    <a href="{{ $partner->website_url }}" target="_blank" rel="noopener" class="flex items-center justify-center w-full h-full">
                @endif
                @if($logoUrl)
                    <img src="{{ $logoUrl }}" alt="{{ $partner->name }}"
                        class="h-32 w-auto object-contain grayscale group-hover:grayscale-0 transition-all duration-500" />
                @else
                    <span class="text-slate-400 font-semibold text-lg">{{ $partner->name }}</span>
                @endif
                @if($partner->website_url)
                    </a>
                @endif
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- Services --}}
@if($homeServices->isNotEmpty())
<section class="py-24 bg-slate-50/60">
    <div class="container mx-auto px-4">
        <div class="text-center max-w-2xl mx-auto mb-16">
            <span class="bg-orange-50 text-primary border border-orange-100 px-4 py-1.5 rounded-full text-sm font-bold uppercase tracking-widest mb-4 inline-block">{{ __('messages.services') }}</span>
            <h2 class="text-4xl font-extrabold text-secondary">Nə Təklif <span class="text-primary">Edirik?</span></h2>
        </div>
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($homeServices as $service)
            @php
                $svcImg = $service->image_path
                    ? (str_starts_with($service->image_path, 'http') ? $service->image_path : asset('storage/'.$service->image_path))
                    : null;
            @endphp
            <div class="group bg-white rounded-2xl border border-slate-100 shadow-lg hover:shadow-2xl transition-all duration-500 overflow-hidden flex flex-col">
                @if($svcImg)
                <div class="h-48 overflow-hidden flex-shrink-0">
                    <img src="{{ $svcImg }}" alt="{{ $service->title }}"
                         class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700" />
                </div>
                @endif
                <div class="p-7 flex flex-col flex-1">
                    <h3 class="text-xl font-bold text-secondary group-hover:text-primary transition-colors mb-3">
                        {{ $service->title }}
                    </h3>
                    @if($service->excerpt)
                    <p class="text-slate-500 leading-relaxed line-clamp-3 flex-1 text-sm">
                        {{ strip_tags($service->excerpt) }}
                    </p>
                    @endif
                    <a href="{{ route('services.show', $service) }}"
                       class="inline-flex items-center gap-2 mt-5 text-primary font-bold text-sm hover:gap-3 transition-all">
                        {{ __('messages.read_more') }}
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-4 h-4">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" />
                        </svg>
                    </a>
                </div>
            </div>
            @endforeach
        </div>
        <div class="text-center mt-12">
            <a href="{{ route('services.index') }}"
               class="inline-flex items-center gap-2 px-8 py-4 rounded-full border-2 border-secondary text-secondary font-bold hover:bg-secondary hover:text-white transition-all">
                {{ __('messages.services') }} — Hamısına bax
            </a>
        </div>
    </div>
</section>
@endif

{{-- Why Us --}}
@if($features->isNotEmpty())
<section class="py-24">
    <div class="container mx-auto px-4">
        <div class="text-center max-w-2xl mx-auto mb-20">
            <h2 class="text-4xl font-extrabold mb-6">Niyə Məhz <span class="text-primary tracking-tight">QREndirim?</span></h2>
            <p class="text-xl text-slate-600">Sizin qənaətiniz və rahatlığınız üçün ən müasir texnologiyadan istifadə edirik.</p>
        </div>

        @php
        $colorClasses = [
            'orange' => ['wrap' => 'bg-orange-50 border-orange-100', 'hover' => 'group-hover:bg-primary',   'icon' => 'text-primary group-hover:text-white'],
            'blue'   => ['wrap' => 'bg-blue-50 border-blue-100',     'hover' => 'group-hover:bg-secondary', 'icon' => 'text-secondary group-hover:text-white'],
            'green'  => ['wrap' => 'bg-green-50 border-green-100',   'hover' => 'group-hover:bg-green-600', 'icon' => 'text-green-600 group-hover:text-white'],
            'purple' => ['wrap' => 'bg-purple-50 border-purple-100', 'hover' => 'group-hover:bg-purple-600','icon' => 'text-purple-600 group-hover:text-white'],
            'red'    => ['wrap' => 'bg-red-50 border-red-100',       'hover' => 'group-hover:bg-red-600',   'icon' => 'text-red-600 group-hover:text-white'],
        ];
        @endphp

        <div class="grid md:grid-cols-3 gap-8">
            @foreach($features as $feature)
            @php $c = $colorClasses[$feature->color] ?? $colorClasses['orange']; @endphp
            <div class="group bg-white p-10 rounded-3xl border border-slate-100 shadow-premium hover:shadow-2xl transition-all duration-500">
                <div class="w-16 h-16 rounded-2xl {{ $c['wrap'] }} {{ $c['hover'] }} flex items-center justify-center mb-8 border transition-all duration-500 shadow-sm">
                    <i class="bi {{ $feature->icon }} text-3xl {{ $c['icon'] }} transition-colors duration-500"></i>
                </div>
                <h3 class="text-2xl font-bold mb-4 text-secondary">{{ $feature->title }}</h3>
                @if($feature->description)
                    <p class="text-slate-600 text-lg leading-relaxed">{{ $feature->description }}</p>
                @endif
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- Featured Shops Swiper --}}
@if($featuredShops->isNotEmpty())
<section class="py-24 bg-slate-50/50">
    <div class="container mx-auto px-4">
        <div class="flex items-center justify-between mb-12">
            <div>
                <span class="bg-orange-50 text-primary border border-orange-100 px-4 py-1.5 rounded-full text-sm font-bold uppercase tracking-widest mb-4 inline-block">Populyar</span>
                <h2 class="text-4xl font-extrabold text-secondary">Seçilmiş <span class="text-primary">Mağazalar</span></h2>
            </div>
            <div class="flex items-center gap-4">
                <a href="{{ route('shops.index') }}" class="hidden sm:flex items-center gap-2 text-primary font-bold hover:gap-3 transition-all mr-8">
                    Hamısına bax
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" />
                    </svg>
                </a>
                <div class="flex gap-2">
                    <button class="swiper-prev-btn w-12 h-12 rounded-full border border-slate-200 flex items-center justify-center text-slate-400 hover:border-primary hover:text-primary transition-all bg-white shadow-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" />
                        </svg>
                    </button>
                    <button class="swiper-next-btn w-12 h-12 rounded-full border border-slate-200 flex items-center justify-center text-slate-400 hover:border-primary hover:text-primary transition-all bg-white shadow-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <div class="swiper stores-swiper -mx-4 sm:mx-0 !pb-12">
            <div class="swiper-wrapper py-6">
                @foreach($featuredShops as $shop)
                <div class="swiper-slide">
                    <div class="group bg-white rounded-2xl border border-slate-100 shadow-lg hover:shadow-2xl transition-all duration-500 overflow-hidden flex flex-col h-full">
                        <div class="relative h-52 overflow-hidden">
                            @if($shop->header_image_path)
                                <img src="{{ asset('storage/' . $shop->header_image_path) }}"
                                    class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700"
                                    alt="{{ $shop->name }}" />
                            @else
                                <div class="w-full h-full bg-slate-200 flex items-center justify-center">
                                    <span class="text-slate-400 text-4xl font-black">{{ mb_substr($shop->name, 0, 1) }}</span>
                                </div>
                            @endif
                            <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                            <div class="absolute bottom-6 left-6">
                                <span class="px-4 py-1.5 bg-primary text-white text-sm font-bold rounded-full">{{ $shop->discount_percent }}% Endirim</span>
                            </div>
                        </div>
                        <div class="p-6 flex-1 flex flex-col">
                            <div class="flex items-start justify-between mb-4">
                                <div>
                                    <h3 class="text-2xl font-bold group-hover:text-primary transition-colors">{{ $shop->name }}</h3>
                                    <span class="text-slate-400 font-medium">{{ $shop->category?->name }}</span>
                                </div>
                            </div>
                            @if($shop->description)
                                <p class="text-slate-600 mb-8 line-clamp-2">{{ $shop->description }}</p>
                            @endif
                            <a href="{{ route('shops.show', $shop) }}"
                                class="mt-auto w-full py-4 rounded-xl bg-secondary text-white font-bold text-center hover:bg-secondary-dark transition-all">Mağazaya bax</a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            <div class="swiper-pagination !bottom-0"></div>
        </div>

        <div class="mt-12 text-center sm:hidden">
            <a href="{{ route('shops.index') }}" class="inline-flex items-center gap-2 px-8 py-4 rounded-full bg-white border border-slate-200 text-secondary font-bold hover:bg-slate-50 transition-all">
                Hamısına bax
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" />
                </svg>
            </a>
        </div>
    </div>
</section>
@endif

{{-- Pricing Plans --}}
@if($plans->isNotEmpty())
<section class="bg-secondary py-24 lg:rounded-lg sm:mx-4 overflow-hidden relative">
    <div class="hidden md:block absolute top-0 right-0 w-[500px] h-[500px] bg-primary/10 rounded-full blur-[120px] -mr-64 -mt-64"></div>
    <div class="hidden md:block absolute bottom-0 left-0 w-[400px] h-[400px] bg-blue-500/10 rounded-full blur-[100px] -ml-48 -mb-48"></div>
    <div class="container mx-auto px-4 relative z-10">
        <div class="text-center max-w-2xl mx-auto mb-20">
            <h2 class="text-4xl font-extrabold mb-6 text-white">Sizə Uyğun <span class="text-primary italic">Paketi</span> Seçin</h2>
            <p class="text-xl text-slate-300">Hər kəsin ehtiyacına uyğun hazırlanmış xüsusi tariflər</p>
        </div>
        <div class="grid md:grid-cols-3 gap-8 items-end">
            @foreach($plans as $i => $plan)
            @if($i === 1)
            <div class="bg-white p-1 shadow-2xl rounded-3xl relative transform translate-y-[-24px] mt-10 md:mt-0">
                <div class="absolute -top-4 inset-x-0 flex justify-center">
                    <span class="bg-primary text-white px-6 py-1.5 rounded-full text-sm font-bold uppercase tracking-widest">Ən Çox Seçilən</span>
                </div>
                <div class="p-10 flex flex-col h-full bg-slate-50 rounded-[22px]">
                    <h3 class="text-secondary text-2xl font-bold mb-2">{{ $plan->name }}</h3>
                    <div class="mb-8">
                        <span class="text-secondary text-5xl font-extrabold">{{ $plan->price > 0 ? $plan->price : '0' }}</span>
                        <span class="text-slate-500 text-xl font-bold">{{ $plan->price > 0 ? '₼ / aylıq' : '₼ / pulsuz' }}</span>
                    </div>
                    <ul class="space-y-4 mb-10">
                        <li class="flex items-center gap-3 text-slate-700">
                            <div class="w-5 h-5 rounded-full bg-primary/20 flex items-center justify-center flex-shrink-0">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="3" stroke="currentColor" class="w-3 h-3 text-primary">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
                                </svg>
                            </div>
                            {{ $plan->usage_limit > 0 ? $plan->usage_limit . ' İstifadə haqqı' : 'Limitsiz İstifadə' }}
                        </li>
                        <li class="flex items-center gap-3 text-slate-700">
                            <div class="w-5 h-5 rounded-full bg-primary/20 flex items-center justify-center flex-shrink-0">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="3" stroke="currentColor" class="w-3 h-3 text-primary">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
                                </svg>
                            </div>
                            Bütün mağazalarda keçərli
                        </li>
                    </ul>
                    <a href="{{ route('subscriptions.index') }}"
                        class="w-full py-4 rounded-xl bg-primary text-white font-bold shadow-orange hover:bg-primary-hover transition-all mt-auto text-center block">Abunə Ol</a>
                </div>
            </div>
            @else
            <div class="bg-white/5 backdrop-blur-md p-10 rounded-3xl border border-white/10 flex flex-col hover:bg-white/10 transition-all duration-300">
                <h3 class="text-white text-2xl font-bold mb-2">{{ $plan->name }}</h3>
                <div class="mb-8">
                    <span class="text-white text-5xl font-extrabold">{{ $plan->price > 0 ? $plan->price : '0' }}</span>
                    <span class="text-slate-400 text-xl">{{ $plan->price > 0 ? '₼ / aylıq' : '₼ / pulsuz' }}</span>
                </div>
                <ul class="space-y-4 mb-10">
                    <li class="flex items-center gap-3 text-slate-300">
                        <div class="w-5 h-5 rounded-full bg-green-500/20 flex items-center justify-center flex-shrink-0">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="3" stroke="currentColor" class="w-3 h-3 text-green-500">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
                            </svg>
                        </div>
                        {{ $plan->usage_limit > 0 ? $plan->usage_limit . ' İstifadə haqqı' : 'Limitsiz İstifadə' }}
                    </li>
                    <li class="flex items-center gap-3 text-slate-300">
                        <div class="w-5 h-5 rounded-full bg-green-500/20 flex items-center justify-center flex-shrink-0">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="3" stroke="currentColor" class="w-3 h-3 text-green-500">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
                            </svg>
                        </div>
                        Bütün mağazalarda keçərli
                    </li>
                </ul>
                <a href="{{ route('subscriptions.index') }}"
                    class="w-full py-4 rounded-xl border-2 border-white/20 text-white font-bold hover:bg-white/10 transition-all mt-auto text-center block">Seç</a>
            </div>
            @endif
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- Featured Blogs --}}
@if($homeBlogs->isNotEmpty())
<section class="py-24 bg-slate-50/50">
    <div class="container mx-auto px-4">
        <div class="flex items-center justify-between mb-12">
            <div>
                <span class="bg-orange-50 text-primary border border-orange-100 px-4 py-1.5 rounded-full text-sm font-bold uppercase tracking-widest mb-4 inline-block">Bloq</span>
                <h2 class="text-4xl font-extrabold text-secondary">Son <span class="text-primary">Məqalələr</span></h2>
            </div>
            <a href="{{ route('blogs.index') }}" class="hidden sm:flex items-center gap-2 text-primary font-bold hover:gap-3 transition-all">
                Hamısına bax
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" />
                </svg>
            </a>
        </div>
        <div class="grid md:grid-cols-3 gap-8">
            @foreach($homeBlogs as $blog)
            <article class="group bg-white rounded-2xl border border-slate-100 shadow-lg hover:shadow-2xl transition-all duration-500 overflow-hidden flex flex-col">
                <div class="relative h-52 overflow-hidden">
                    @if($blog->cover_image_path)
                        <img src="{{ asset('storage/' . $blog->cover_image_path) }}"
                            class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700"
                            alt="{{ $blog->title }}" />
                    @else
                        <div class="w-full h-full bg-slate-200 flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-16 h-16 text-slate-400">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 7.5h1.5m-1.5 3h1.5m-7.5 3h7.5m-7.5 3h7.5m3-9h3.375c.621 0 1.125.504 1.125 1.125V18a2.25 2.25 0 0 1-2.25 2.25M16.5 7.5V18a2.25 2.25 0 0 0 2.25 2.25M16.5 7.5V4.875c0-.621-.504-1.125-1.125-1.125H4.125C3.504 3.75 3 4.254 3 4.875V18a2.25 2.25 0 0 0 2.25 2.25h13.5M6 7.5h3v3H6v-3Z" />
                            </svg>
                        </div>
                    @endif
                </div>
                <div class="p-6 flex-1 flex flex-col">
                    <p class="text-slate-400 text-sm mb-2">{{ $blog->published_at?->format('d.m.Y') }}</p>
                    <h3 class="text-xl font-bold text-secondary group-hover:text-primary transition-colors mb-3 line-clamp-2">{{ $blog->title }}</h3>
                    @if($blog->excerpt)
                        <p class="text-slate-600 mb-6 line-clamp-3">{{ $blog->excerpt }}</p>
                    @endif
                    <a href="{{ route('blogs.show', $blog) }}"
                        class="mt-auto inline-flex items-center gap-2 text-primary font-bold hover:gap-3 transition-all">
                        Oxu
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-4 h-4">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" />
                        </svg>
                    </a>
                </div>
            </article>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- CTA Section --}}
<section class="container mx-auto px-4 py-24">
    <div class="bg-primary/90 p-12 md:p-20 rounded-3xl relative overflow-hidden shadow-2xl">
        <div class="hidden md:block absolute top-0 right-0 w-64 h-64 bg-white/10 rounded-full -mr-32 -mt-32 blur-3xl"></div>
        <div class="hidden md:block absolute bottom-0 left-0 w-64 h-64 bg-black/10 rounded-full -ml-32 -mb-32 blur-3xl"></div>
        <div class="relative z-10 grid md:grid-cols-2 gap-12 items-center text-white">
            <div>
                <h2 class="text-4xl md:text-5xl font-extrabold mb-6 leading-tight text-white">Endirim Dünyasına <br />Giriş Edin!</h2>
                <p class="text-xl opacity-90 leading-relaxed">Yeni gələn mağazalardan və xüsusi həftəlik endirimlərdən ilk siz xəbərdar olun.</p>
            </div>
            <div class="flex flex-col gap-4">
                @if(session('subscriber_success'))
                    <div class="bg-white/20 border border-white/40 text-white rounded-xl px-6 py-4 text-center font-semibold">
                        ✅ Uğurla abunə oldunuz!
                    </div>
                @else
                <form action="{{ route('subscribers.store') }}" method="post" class="flex flex-col gap-3">
                    @csrf
                    <input
                        type="email"
                        name="email"
                        required
                        placeholder="email@example.com"
                        class="w-full px-6 py-4 rounded-xl text-gray-900 text-lg bg-white placeholder-gray-400 outline-none focus:ring-4 focus:ring-white/40 shadow-lg"
                    >
                    @error('email')
                        <p class="text-white/80 text-sm">{{ $message }}</p>
                    @enderror
                    <button type="submit"
                        class="w-full py-4 rounded-xl bg-secondary text-white font-bold text-lg text-center hover:bg-secondary-dark hover:scale-[1.01] transition-all duration-300 shadow-lg">
                        Abunə Ol və Qazan
                    </button>
                </form>
                @endif
            </div>
        </div>
    </div>
</section>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<script>
    new Swiper('.stores-swiper', {
        slidesPerView: 1,
        spaceBetween: 24,
        pagination: { el: '.swiper-pagination', clickable: true },
        navigation: {
            nextEl: '.swiper-next-btn',
            prevEl: '.swiper-prev-btn',
        },
        breakpoints: {
            640: { slidesPerView: 2 },
            1024: { slidesPerView: 3 },
        },
    });
</script>
@endpush
