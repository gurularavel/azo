@extends('layouts.app')

@section('title', $shop->name . ' - ' . ($siteSettings?->site_name ?? 'QR Endirim'))

@section('content')
<div class="pb-16">

    {{-- Hero Banner --}}
    <section class="container mx-auto px-4 py-6 md:py-10">
        <div class="relative bg-secondary rounded-2xl md:rounded-3xl p-6 md:p-10 lg:p-20 overflow-hidden min-h-[320px] md:min-h-[500px] flex flex-col justify-center">
            <div class="absolute inset-0 bg-gradient-to-r from-secondary-dark via-secondary/80 to-transparent"></div>
            @if($shop->header_image_path)
                <img src="{{ asset('storage/' . $shop->header_image_path) }}" class="absolute inset-0 w-full h-full object-cover opacity-40" />
            @endif

            <div class="relative z-10 max-w-2xl">
                @if($shop->logo_path)
                    <div class="mb-5 md:mb-10 p-4 md:p-6 bg-white/10 backdrop-blur-md rounded-sm inline-block border border-white/20">
                        <img src="{{ asset('storage/' . $shop->logo_path) }}" class="h-12 md:h-20 w-auto" style="filter: brightness(0) invert(1);" />
                    </div>
                @endif
                <h1 class="text-3xl sm:text-4xl md:text-5xl lg:text-7xl font-black text-white mb-3 md:mb-6">
                    {{ $shop->name }}
                </h1>
                @if($shop->description)
                    <p class="text-sm sm:text-base md:text-xl text-white/70 leading-relaxed mb-6 md:mb-10 italic">
                        {{ $shop->description }}
                    </p>
                @endif
                <div class="flex flex-wrap gap-3 md:gap-4">
                    <div class="px-5 py-3 md:px-8 md:py-4 bg-primary text-white font-bold rounded-sm flex items-center gap-2 md:gap-3 shadow-xl shadow-orange-500/30">
                        <span class="text-2xl md:text-3xl">{{ $shop->discount_percent }}%</span>
                        <span class="text-sm md:text-base">Hər Alışda <br />Endirim</span>
                    </div>
                    @if($shop->city)
                        <div class="px-5 py-3 md:px-8 md:py-4 bg-white/10 backdrop-blur rounded-sm border border-white/20 text-white font-bold flex items-center gap-2 md:gap-3">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5 md:w-6 md:h-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" />
                            </svg>
                            <span class="text-sm md:text-base">{{ $shop->city->name }}</span>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>

    {{-- Main Content + Sidebar --}}
    <section class="container mx-auto px-4 py-6 md:py-12">
        <div class="grid lg:grid-cols-3 gap-6 md:gap-12">

            {{-- Left Content --}}
            <div class="lg:col-span-2 space-y-6 md:space-y-12">

                {{-- About --}}
                @if($shop->description)
                <div class="bg-white p-6 md:p-12 rounded-xl md:rounded-sm shadow-xl border border-slate-50">
                    <h2 class="text-xl md:text-3xl font-black text-secondary mb-4 md:mb-8">Haqqımızda</h2>
                    <div class="text-slate-500 leading-relaxed text-sm md:text-lg">
                        <p>{{ $shop->description }}</p>
                    </div>
                </div>
                @endif

                {{-- Gallery --}}
                @if($shop->images->isNotEmpty())
                <div class="bg-white p-6 md:p-12 rounded-xl md:rounded-sm shadow-xl border border-slate-50">
                    <h2 class="text-xl md:text-3xl font-black text-secondary mb-6 md:mb-10">Fotolar</h2>
                    <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                        @foreach($shop->images as $image)
                            <div class="rounded-xl overflow-hidden h-40">
                                <img src="{{ asset('storage/' . $image->image_path) }}" alt="{{ $shop->name }}"
                                    class="w-full h-full object-cover hover:scale-110 transition-transform duration-500" />
                            </div>
                        @endforeach
                    </div>
                </div>
                @endif

                {{-- Map --}}
                @if($shop->map_embed)
                <div class="bg-white p-6 md:p-12 rounded-xl md:rounded-sm shadow-xl border border-slate-50">
                    <h2 class="text-xl md:text-3xl font-black text-secondary mb-6 md:mb-8">
                        <span class="flex items-center gap-3">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-7 h-7 text-primary">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" />
                            </svg>
                            {{ __('messages.location') }}
                        </span>
                    </h2>
                    <div class="map-container rounded-2xl overflow-hidden border border-slate-100 shadow-md" style="height:380px;">
                        {!! $shop->map_embed !!}
                    </div>
                </div>
                @endif

            </div>

            {{-- Sidebar --}}
            <div class="space-y-5 md:space-y-8">

                {{-- QR / CTA Card --}}
                <div class="bg-primary p-6 md:p-10 rounded-xl md:rounded-sm text-white shadow-2xl shadow-orange-500/40 md:sticky md:top-32">
                    <h3 class="text-2xl md:text-3xl font-black mb-3 md:mb-6">Xüsusi <br />Təklif!</h3>
                    <div class="text-5xl md:text-6xl font-black mb-5 md:mb-8 italic">
                        {{ $shop->discount_percent }}%
                        <span class="text-base md:text-xl not-italic opacity-50">Endirim</span>
                    </div>
                    <p class="mb-6 md:mb-8 text-white/80 text-sm md:text-base font-medium">
                        Bu endirim yalnız QR Endirim istifadəçiləri üçün keçərlidir.
                    </p>

                    @guest
                        <a href="{{ route('login') }}"
                            class="block w-full py-4 md:py-5 bg-white text-primary text-center font-bold text-base md:text-xl rounded-sm hover:bg-slate-100 transition-all shadow-xl">
                            Daxil ol və QR al
                        </a>
                    @endguest

                    @auth
                        @if($qrSession)
                            {{-- Show QR Code --}}
                            <div class="bg-white rounded-sm p-4 flex flex-col items-center mb-4">
                                @php
                                    $qrUrl = route('qr.scan', $qrSession->token);
                                    $qrImg = 'https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=' . urlencode($qrUrl);
                                @endphp
                                <img src="{{ $qrImg }}" alt="QR Kod" class="w-48 h-48" />
                                <p class="text-slate-500 text-xs mt-3 text-center">Bu kodu kassada göstərin</p>
                                <p class="text-xs text-orange-600 font-bold mt-1 text-center">
                                    Bitmə vaxtı: {{ $qrSession->expires_at->format('H:i') }}
                                </p>
                            </div>
                        @elseif($subscription)
                            <div class="bg-white/20 rounded-sm p-4 text-center mb-4">
                                <p class="text-white/80 text-sm">Qalan istifadə: {{ $subscription->usage_remaining }}</p>
                            </div>
                        @else
                            <a href="{{ route('subscriptions.index') }}"
                                class="block w-full py-4 md:py-5 bg-white text-primary text-center font-bold text-base md:text-xl rounded-sm hover:bg-slate-100 transition-all shadow-xl">
                                Paket Al
                            </a>
                        @endif
                    @endauth
                </div>

                {{-- Info Card --}}
                @if($shop->category || $shop->city)
                <div class="bg-white p-6 md:p-10 rounded-xl md:rounded-sm shadow-xl border border-slate-50">
                    <h4 class="text-base md:text-xl font-bold text-secondary mb-5 md:mb-8">Qısa Məlumat</h4>
                    <div class="space-y-4 md:space-y-6">
                        @if($shop->category)
                            <div class="flex items-center gap-3 md:gap-4">
                                <div class="w-10 h-10 md:w-12 md:h-12 rounded-sm bg-secondary/5 flex items-center justify-center flex-shrink-0">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5 text-primary">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 21v-7.5a.75.75 0 0 1 .75-.75h3a.75.75 0 0 1 .75.75V21m-4.5 0H2.36m11.14 0H18m0 0h3.64m-1.39 0V9.349M3.75 21V9.349" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-xs text-slate-400 font-bold uppercase tracking-widest">Kateqoriya</p>
                                    <p class="font-bold text-secondary text-sm md:text-base">{{ $shop->category->name }}</p>
                                </div>
                            </div>
                        @endif
                        @if($shop->city)
                            <div class="flex items-center gap-3 md:gap-4">
                                <div class="w-10 h-10 md:w-12 md:h-12 rounded-sm bg-secondary/5 flex items-center justify-center flex-shrink-0">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5 text-primary">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-xs text-slate-400 font-bold uppercase tracking-widest">Şəhər</p>
                                    <p class="font-bold text-secondary text-sm md:text-base">{{ $shop->city->name }}</p>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
                @endif

            </div>
        </div>
    </section>

</div>
@endsection

@push('styles')
<style>
    /* Make Google Maps iframe fill its container */
    .map-container iframe {
        width: 100% !important;
        height: 100% !important;
        border: 0;
        display: block;
    }
</style>
@endpush
