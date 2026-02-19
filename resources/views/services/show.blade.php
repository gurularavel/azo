@extends('layouts.app')

@section('title', $service->name . ' - ' . ($siteSettings?->site_name ?? 'QR Endirim'))

@section('content')
<div class="pb-16">
    <article class="container mx-auto px-4 max-w-4xl py-12">

        {{-- Breadcrumb --}}
        <nav class="flex items-center gap-2 text-sm text-slate-400 mb-8">
            <a href="{{ route('home') }}" class="hover:text-primary transition-colors">Ana Səhifə</a>
            <span>/</span>
            <a href="{{ route('services.index') }}" class="hover:text-primary transition-colors">Haqqımızda</a>
            <span>/</span>
            <span class="text-slate-600">{{ $service->name }}</span>
        </nav>

        {{-- Cover Image --}}
        @if($service->cover_image_path)
        <div class="rounded-sm overflow-hidden mb-12 shadow-2xl">
            <img src="{{ asset('storage/' . $service->cover_image_path) }}" class="w-full h-auto max-h-[500px] object-cover" alt="{{ $service->name }}" />
        </div>
        @endif

        {{-- Title --}}
        <h1 class="text-4xl md:text-5xl font-black text-secondary mb-8 leading-tight">
            {{ $service->name }}
        </h1>

        {{-- Description / Body --}}
        @if($service->description)
            <div class="prose prose-lg max-w-none text-slate-600 leading-relaxed">
                {!! $service->description !!}
            </div>
        @endif

        {{-- Back --}}
        <div class="mt-16 pt-8 border-t border-slate-100">
            <a href="{{ route('services.index') }}"
                class="inline-flex items-center gap-2 px-6 py-3 rounded-sm border-2 border-secondary text-secondary font-bold hover:bg-secondary hover:text-white transition-all">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-4 h-4">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
                </svg>
                Geri
            </a>
        </div>

    </article>
</div>
@endsection
