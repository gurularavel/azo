@extends('layouts.app')

@section('title', $blog->title . ' - ' . ($siteSettings?->site_name ?? 'QR Endirim'))

@section('content')
<div class="pb-16">
    <article class="container mx-auto px-4 max-w-4xl py-12">

        {{-- Breadcrumb --}}
        <nav class="flex items-center gap-2 text-sm text-slate-400 mb-8">
            <a href="{{ route('home') }}" class="hover:text-primary transition-colors">Ana Səhifə</a>
            <span>/</span>
            <a href="{{ route('blogs.index') }}" class="hover:text-primary transition-colors">Bloq</a>
            <span>/</span>
            <span class="text-slate-600">{{ $blog->title }}</span>
        </nav>

        {{-- Cover Image --}}
        @if($blog->cover_image_path)
        <div class="rounded-sm overflow-hidden mb-12 shadow-2xl">
            <img src="{{ asset('storage/' . $blog->cover_image_path) }}" class="w-full h-auto max-h-[500px] object-cover" alt="{{ $blog->title }}" />
        </div>
        @endif

        {{-- Meta --}}
        <div class="flex items-center gap-4 mb-8">
            @if($blog->published_at)
                <span class="flex items-center gap-2 text-slate-400 text-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 9v7.5" />
                    </svg>
                    {{ $blog->published_at->format('d.m.Y') }}
                </span>
            @endif
        </div>

        {{-- Title --}}
        <h1 class="text-4xl md:text-5xl font-black text-secondary mb-8 leading-tight">
            {{ $blog->title }}
        </h1>

        {{-- Excerpt --}}
        @if($blog->excerpt)
            <p class="text-xl font-medium text-slate-700 mb-10 leading-relaxed border-l-4 border-primary pl-6">
                {{ $blog->excerpt }}
            </p>
        @endif

        {{-- Body --}}
        @if($blog->body)
            <div class="prose prose-lg max-w-none text-slate-600 leading-relaxed space-y-6">
                {!! $blog->body !!}
            </div>
        @endif

        {{-- Footer / Back --}}
        <div class="mt-16 pt-8 border-t border-slate-100 flex items-center justify-between">
            <a href="{{ route('blogs.index') }}"
                class="inline-flex items-center gap-2 px-6 py-3 rounded-sm border-2 border-secondary text-secondary font-bold hover:bg-secondary hover:text-white transition-all">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-4 h-4">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
                </svg>
                Bütün məqalələr
            </a>
        </div>

    </article>
</div>
@endsection
