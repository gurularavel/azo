@extends('layouts.app')

@section('title', __('messages.services') . ' - ' . ($siteSettings?->site_name ?? 'QR Endirim'))

@section('content')
<div class="pb-16">

    {{-- Hero --}}
    <section class="container mx-auto px-4 py-12 md:py-20">
        <div class="bg-white border border-slate-100 shadow-premium rounded-3xl p-8 md:p-20 overflow-hidden relative">
            <div class="hidden md:block absolute top-0 right-0 w-96 h-96 bg-primary/10 rounded-full blur-[120px] -mr-48 -mt-48 animate-pulse"></div>
            <div class="hidden md:block absolute bottom-0 left-0 w-96 h-96 bg-blue-500/10 rounded-full blur-[120px] -ml-48 -mb-48 animate-pulse"></div>

            <div class="relative z-10 grid md:grid-cols-2 gap-12 items-center">
                <div class="animate__animated animate__fadeInLeft">
                    <span class="inline-block text-primary font-bold uppercase tracking-widest text-sm bg-orange-50 px-5 py-2 rounded-full border border-orange-100 mb-6">
                        {{ __('messages.services') }}
                    </span>
                    <h1 class="text-3xl sm:text-5xl md:text-6xl font-black text-secondary leading-tight mb-6">
                        {!! nl2br(e($siteSettings?->services_hero_title ?: "Azərbaycanın Ən Böyük\nEndirim Platforması")) !!}
                    </h1>
                    <p class="text-xl text-slate-600 leading-relaxed mb-8">
                        {{ $siteSettings?->services_hero_subtitle ?: 'Biz müştərilərimizə mağazalardan ən yaxşı endirimlər əldə etməyə kömək edirik. Alış-verişi hər kəs üçün daha sərfəli və əlçatan etmək bizim əsas hədəfimizdir.' }}
                    </p>
                </div>
                <div class="animate__animated animate__fadeInRight hidden md:block">
                    <img src="{{ asset('template/images/about/hero.svg') }}" alt="Services" class="w-full drop-shadow-2xl" />
                </div>
            </div>
        </div>
    </section>

    {{-- Services Grid --}}
    @if($services->isNotEmpty())
    <section class="container mx-auto px-4 py-12">
        <div class="text-center mb-16">
            <span class="bg-orange-50 text-primary border border-orange-100 px-4 py-1.5 rounded-full text-sm font-bold uppercase tracking-widest mb-4 inline-block">Xidmətlər</span>
            <h2 class="text-4xl font-extrabold text-secondary">Nə Təklif <span class="text-primary">Edirik?</span></h2>
        </div>
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($services as $service)
            @php
                $imgUrl = $service->image_path
                    ? (str_starts_with($service->image_path, 'http') ? $service->image_path : asset('storage/'.$service->image_path))
                    : null;
            @endphp
            <div class="group bg-white rounded-2xl border border-slate-100 shadow-lg hover:shadow-2xl transition-all duration-500 overflow-hidden">
                @if($imgUrl)
                <div class="relative h-52 overflow-hidden">
                    <img src="{{ $imgUrl }}"
                         class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700"
                         alt="{{ $service->title }}" />
                </div>
                @endif
                <div class="p-8">
                    <h3 class="text-2xl font-bold text-secondary group-hover:text-primary transition-colors mb-3">
                        {{ $service->title }}
                    </h3>
                    @if($service->excerpt)
                        <p class="text-slate-500 leading-relaxed line-clamp-3">{{ strip_tags($service->excerpt) }}</p>
                    @endif
                    <a href="{{ route('services.show', $service) }}"
                       class="inline-flex items-center gap-2 mt-6 text-primary font-bold hover:gap-3 transition-all">
                        {{ __('messages.read_more') }}
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-4 h-4">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" />
                        </svg>
                    </a>
                </div>
            </div>
            @endforeach
        </div>

        @if($services->hasPages())
        <div class="mt-12">
            {{ $services->links() }}
        </div>
        @endif
    </section>
    @endif

</div>
@endsection
