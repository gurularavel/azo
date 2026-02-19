@extends('layouts.app')

@section('title', $service->title . ' - ' . ($siteSettings?->site_name ?? 'QR Endirim'))

@section('content')
<div class="pb-16">
    <article class="container mx-auto px-4 max-w-4xl py-12">

        {{-- Breadcrumb --}}
        <nav class="flex items-center gap-2 text-sm text-slate-400 mb-8">
            <a href="{{ route('home') }}" class="hover:text-primary transition-colors">{{ __('messages.home') }}</a>
            <span>/</span>
            <a href="{{ route('services.index') }}" class="hover:text-primary transition-colors">{{ __('messages.services') }}</a>
            <span>/</span>
            <span class="text-slate-600">{{ $service->title }}</span>
        </nav>

        {{-- Cover Image --}}
        @php
            $imgUrl = $service->image_path
                ? (str_starts_with($service->image_path, 'http') ? $service->image_path : asset('storage/'.$service->image_path))
                : null;
        @endphp
        @if($imgUrl)
        <div class="rounded-2xl overflow-hidden mb-12 shadow-2xl">
            <img src="{{ $imgUrl }}" class="w-full h-auto max-h-[500px] object-cover" alt="{{ $service->title }}" />
        </div>
        @endif

        {{-- Title --}}
        <h1 class="text-4xl md:text-5xl font-black text-secondary mb-6 leading-tight">
            {{ $service->title }}
        </h1>

        @if($service->excerpt)
        <p class="text-xl text-slate-500 leading-relaxed mb-10 border-l-4 border-primary pl-5">
            {{ strip_tags($service->excerpt) }}
        </p>
        @endif

        {{-- Body --}}
        @if($service->body)
        <div class="prose prose-lg max-w-none text-slate-700 leading-relaxed">
            {!! $service->body !!}
        </div>
        @endif

        {{-- Back --}}
        <div class="mt-16 pt-8 border-t border-slate-100">
            <a href="{{ route('services.index') }}"
               class="inline-flex items-center gap-2 px-6 py-3 rounded-full border-2 border-secondary text-secondary font-bold hover:bg-secondary hover:text-white transition-all">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-4 h-4">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
                </svg>
                {{ __('messages.back_to_services') }}
            </a>
        </div>

    </article>
</div>
@endsection
