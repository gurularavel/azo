@extends('layouts.app')

@section('title', 'Mağazalar - ' . ($siteSettings?->site_name ?? 'QR Endirim'))

@section('content')
<div class="pb-16">

    {{-- Page Header --}}
    <section class="bg-slate-50 border-b border-slate-100 py-10 mb-10">
        <div class="container mx-auto px-4">
            <div class="flex flex-col md:flex-row items-center justify-between gap-6">
                <div>
                    <h1 class="text-4xl font-black text-secondary mb-2">
                        Bütün <span class="text-primary">Mağazalar</span>
                    </h1>
                    <p class="text-slate-500 font-medium">{{ $totalShops }} mağaza sizinlə əməkdaşlıq edir</p>
                </div>
                <div class="flex flex-wrap gap-3">
                    <a href="{{ route('shops.index') }}"
                        class="px-5 py-2.5 rounded-full text-sm font-bold transition-all {{ !$selectedCategoryId ? 'bg-primary text-white shadow-orange' : 'bg-white border border-slate-200 text-slate-600 hover:border-primary hover:text-primary' }}">
                        Hamısı
                    </a>
                    @foreach($categories as $category)
                        <a href="{{ route('shops.index', ['category_id' => $category->id]) }}"
                            class="px-5 py-2.5 rounded-full text-sm font-bold transition-all {{ $selectedCategoryId === $category->id ? 'bg-primary text-white shadow-orange' : 'bg-white border border-slate-200 text-slate-600 hover:border-primary hover:text-primary' }}">
                            {{ $category->name }}
                            <span class="ml-1 text-xs opacity-70">({{ $category->shops_count }})</span>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    {{-- Shops Grid --}}
    <div class="container mx-auto px-4">
        @if($shops->isEmpty())
            <div class="text-center py-24">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-16 h-16 text-slate-300 mx-auto mb-4">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 21v-7.5a.75.75 0 0 1 .75-.75h3a.75.75 0 0 1 .75.75V21m-4.5 0H2.36m11.14 0H18m0 0h3.64m-1.39 0V9.349M3.75 21V9.349m0 0a3.001 3.001 0 0 0 3.75-.615 3.001 3.001 0 0 0 3.75.615 3.001 3.001 0 0 0 3.75-.615 3.001 3.001 0 0 0 3.75.615m-15 0-1.033 3.9a.75.75 0 0 0 .726.95h.75a.75.75 0 0 0 .75-.75V11.25m3.75 0v3.75a.75.75 0 0 0 .75.75h.75a.75.75 0 0 0 .75-.75V11.25" />
                </svg>
                <h3 class="text-xl font-bold text-slate-400">Mağaza tapılmadı</h3>
                <p class="text-slate-400 mt-2">Başqa kateqoriya seçin</p>
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($shops as $shop)
                <div class="group bg-white rounded-2xl border border-slate-100 shadow-lg hover:shadow-2xl transition-all duration-500 overflow-hidden flex flex-col">
                    <div class="relative h-56 overflow-hidden">
                        @if($shop->header_image_path)
                            <img src="{{ asset('storage/' . $shop->header_image_path) }}"
                                class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700"
                                alt="{{ $shop->name }}" />
                        @else
                            <div class="w-full h-full bg-gradient-to-br from-secondary/10 to-primary/10 flex items-center justify-center">
                                <span class="text-6xl font-black text-secondary/30">{{ mb_substr($shop->name, 0, 1) }}</span>
                            </div>
                        @endif
                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                        <div class="absolute bottom-6 left-6 flex items-center gap-2">
                            <span class="px-4 py-1.5 bg-primary text-white text-sm font-bold rounded-full">{{ $shop->discount_percent }}% Endirim</span>
                        </div>
                        @if($shop->logo_path)
                            <div class="absolute top-4 right-4 w-12 h-12 rounded-xl bg-white p-1 shadow-lg">
                                <img src="{{ asset('storage/' . $shop->logo_path) }}" alt="{{ $shop->name }}" class="w-full h-full object-contain" />
                            </div>
                        @endif
                    </div>
                    <div class="p-8 flex-1 flex flex-col">
                        <div class="flex items-start justify-between mb-4">
                            <div>
                                <h3 class="text-2xl font-bold group-hover:text-primary transition-colors">{{ $shop->name }}</h3>
                                <div class="flex items-center gap-2 mt-1">
                                    @if($shop->category)
                                        <span class="text-slate-400 font-medium">{{ $shop->category->name }}</span>
                                    @endif
                                    @if($shop->city)
                                        <span class="text-slate-300">•</span>
                                        <span class="text-slate-400 text-sm">{{ $shop->city->name }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        @if($shop->description)
                            <p class="text-slate-600 mb-8 line-clamp-2">{{ $shop->description }}</p>
                        @endif
                        <a href="{{ route('shops.show', $shop) }}"
                            class="mt-auto w-full py-4 rounded-sm bg-secondary text-white font-bold text-center hover:bg-secondary-dark transition-all">
                            Mağazaya bax
                        </a>
                    </div>
                </div>
                @endforeach
            </div>
        @endif
    </div>
</div>
@endsection
