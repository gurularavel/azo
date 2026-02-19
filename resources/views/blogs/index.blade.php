@extends('layouts.app')

@section('title', 'Bloq - ' . ($siteSettings?->site_name ?? 'QR Endirim'))

@section('content')
<div class="pb-16">

    <section class="container mx-auto px-4 py-12">

        {{-- Featured / Latest Blog Hero --}}
        @if($blogs->isNotEmpty())
        @php $featured = $blogs->first(); @endphp
        <div class="rounded-[2.5rem] p-12 md:p-20 relative overflow-hidden mb-24 bg-slate-900 min-h-[300px] flex flex-col justify-end">
            @if($featured->cover_image_path)
                <img src="{{ asset('storage/' . $featured->cover_image_path) }}" class="absolute inset-0 w-full h-full object-cover opacity-50" />
            @endif
            <div class="absolute inset-0 bg-gradient-to-r from-secondary-dark via-secondary/80 to-transparent"></div>
            <div class="relative z-10 max-w-2xl text-white">
                <span class="bg-primary px-4 py-1.5 rounded-full text-sm font-bold uppercase tracking-wider mb-6 inline-block">Ən Son Məqalə</span>
                <h1 class="text-4xl md:text-6xl font-extrabold mb-6 leading-tight text-white">{{ $featured->title }}</h1>
                @if($featured->excerpt)
                    <p class="text-xl text-slate-300 mb-8 leading-relaxed">{{ $featured->excerpt }}</p>
                @endif
                <a href="{{ route('blogs.show', $featured) }}"
                    class="inline-flex items-center gap-2 px-8 py-4 bg-primary rounded-sm font-bold hover:bg-primary-hover transition-all">
                    Davamını Oxu
                </a>
            </div>
        </div>
        @endif

        <div class="grid lg:grid-cols-3 gap-12">

            {{-- Blog Grid --}}
            <div class="lg:col-span-2">
                <h2 class="text-3xl font-extrabold text-secondary mb-10">Bütün <span class="text-primary italic">Məqalələr</span></h2>

                @if($blogs->isEmpty())
                    <div class="text-center py-16">
                        <p class="text-slate-400 text-lg">Hələlik məqalə yoxdur.</p>
                    </div>
                @else
                    <div class="grid md:grid-cols-2 gap-8">
                        @foreach($blogs as $blog)
                        <article class="group bg-white rounded-2xl border border-slate-100 shadow-lg hover:shadow-2xl transition-all duration-500 overflow-hidden">
                            <div class="relative h-64 overflow-hidden">
                                @if($blog->cover_image_path)
                                    <img src="{{ asset('storage/' . $blog->cover_image_path) }}"
                                        class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700"
                                        alt="{{ $blog->title }}" />
                                @else
                                    <div class="w-full h-full bg-slate-200 flex items-center justify-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-16 h-16 text-slate-400">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 7.5h1.5m-1.5 3h1.5m-7.5 3h7.5m-7.5 3h7.5" />
                                        </svg>
                                    </div>
                                @endif
                                <div class="absolute top-4 left-4 bg-white/90 backdrop-blur px-4 py-1.5 rounded-sm text-secondary text-sm font-bold">
                                    {{ $blog->published_at?->format('d.m.Y') }}
                                </div>
                            </div>
                            <div class="p-8">
                                <h3 class="text-2xl font-bold text-secondary mb-4 group-hover:text-primary transition-colors line-clamp-2">
                                    {{ $blog->title }}
                                </h3>
                                @if($blog->excerpt)
                                    <p class="text-slate-500 mb-6 line-clamp-2">{{ $blog->excerpt }}</p>
                                @endif
                                <div class="flex items-center justify-between pt-6 border-t border-slate-50">
                                    <a href="{{ route('blogs.show', $blog) }}"
                                        class="text-primary font-bold hover:gap-3 transition-all flex items-center gap-2">
                                        Oxu
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-4 h-4">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" />
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        </article>
                        @endforeach
                    </div>

                    {{-- Pagination --}}
                    @if($blogs->hasPages())
                        <div class="mt-12">
                            {{ $blogs->links() }}
                        </div>
                    @endif
                @endif
            </div>

            {{-- Sidebar --}}
            <div class="space-y-8">
                <div class="bg-primary p-6 md:p-8 rounded-sm text-white relative overflow-hidden group">
                    <div class="hidden md:block absolute -top-10 -right-10 w-32 h-32 bg-white/10 rounded-full group-hover:scale-150 transition-transform duration-700"></div>
                    <h4 class="text-xl md:text-2xl font-bold mb-3 md:mb-4 relative z-10">Premium Paketə Keç!</h4>
                    <p class="text-white/80 mb-6 md:mb-8 relative z-10">Limitsiz istifadə və xüsusi hədiyyələr üçün abunə ol.</p>
                    <a href="{{ route('register') }}"
                        class="inline-block px-6 py-2.5 md:px-8 md:py-3 bg-white text-primary rounded-sm font-bold hover:bg-slate-50 transition-all">İndi Aktiv Et</a>
                </div>
            </div>

        </div>
    </section>
</div>
@endsection
