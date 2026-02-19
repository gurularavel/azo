@extends('layouts.app')

@section('title', 'Haqqımızda - ' . ($siteSettings?->site_name ?? 'QR Endirim'))

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
                        Biz Kimik?
                    </span>
                    <h1 class="text-3xl sm:text-5xl md:text-6xl font-black text-secondary leading-tight mb-6">
                        Azərbaycanın Ən Böyük<br />
                        <span class="text-primary">Endirim Platforması</span>
                    </h1>
                    <p class="text-xl text-slate-600 leading-relaxed mb-8">
                        Biz müştərilərimizə mağazalardan ən yaxşı endirimlər əldə etməyə kömək edirik. Alış-verişi hər kəs üçün daha sərfəli və əlçatan etmək bizim əsas hədəfimizdir.
                    </p>
                    <div class="flex flex-col sm:flex-row gap-4">
                        <div class="bg-slate-50 border border-slate-100 rounded-2xl p-6 flex-1 text-center">
                            <div class="text-4xl font-black text-primary">50k+</div>
                            <div class="text-slate-500 font-medium mt-1">İstifadəçi</div>
                        </div>
                        <div class="bg-slate-50 border border-slate-100 rounded-2xl p-6 flex-1 text-center">
                            <div class="text-4xl font-black text-primary">100+</div>
                            <div class="text-slate-500 font-medium mt-1">Partnyor</div>
                        </div>
                    </div>
                </div>
                <div class="animate__animated animate__fadeInRight hidden md:block">
                    <img src="{{ asset('template/images/about/hero.svg') }}" alt="About" class="w-full drop-shadow-2xl" />
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
            <div class="group bg-white rounded-2xl border border-slate-100 shadow-lg hover:shadow-2xl transition-all duration-500 overflow-hidden">
                @if($service->cover_image_path)
                    <div class="relative h-48 overflow-hidden">
                        <img src="{{ asset('storage/' . $service->cover_image_path) }}"
                            class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700"
                            alt="{{ $service->name }}" />
                    </div>
                @endif
                <div class="p-8">
                    <h3 class="text-2xl font-bold text-secondary group-hover:text-primary transition-colors mb-3">
                        {{ $service->name }}
                    </h3>
                    @if($service->description)
                        <p class="text-slate-500 leading-relaxed line-clamp-3">{{ $service->description }}</p>
                    @endif
                    @if($service->slug)
                        <a href="{{ route('services.show', $service) }}"
                            class="inline-flex items-center gap-2 mt-6 text-primary font-bold hover:gap-3 transition-all">
                            Ətraflı
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-4 h-4">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" />
                            </svg>
                        </a>
                    @endif
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

    {{-- Mission Section --}}
    <section class="container mx-auto px-4 py-16">
        <div class="grid md:grid-cols-2 gap-16 items-center">
            <div class="grid grid-cols-2 gap-4">
                @foreach(['about1', 'about2', 'about3', 'about4'] as $i => $img)
                <div class="rounded-sm overflow-hidden shadow-xl {{ $i % 2 === 1 ? 'mt-8' : '' }}">
                    <img src="{{ asset('template/images/about/' . $img . '.jpg') }}" class="w-full" alt="About" />
                </div>
                @endforeach
            </div>
            <div>
                <span class="bg-orange-50 text-primary border border-orange-100 px-4 py-1.5 rounded-full text-sm font-bold uppercase tracking-widest mb-6 inline-block">Missiyamız</span>
                <h2 class="text-4xl font-black text-secondary mb-8">
                    Missiyamız və <span class="text-primary">Görüşümüz</span>
                </h2>
                <div class="space-y-6 text-lg text-slate-600 leading-relaxed">
                    <p>İstifadəçilərin sevdikləri mağazalarda endirimlərdən faydalanmasını asanlaşdıran kupon platformasıdır. Sadəcə bir neçə kliklə paket seç, QR kodunu əldə et və partnyor mağazalarda endirimli alış-veriş et!</p>
                    <p>Platformamız istifadəçilərə vaxt itirmədən, kağız kuponlar və mürəkkəb kampaniyalarla məşğul olmadan real endirimlərdən yararlanmaq imkanı yaradır.</p>
                </div>
                <a href="{{ route('shops.index') }}"
                    class="inline-flex items-center gap-2 mt-8 px-8 py-4 rounded-full bg-primary text-white font-bold shadow-orange hover:bg-primary-hover transition-all">
                    Mağazalara Bax
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" />
                    </svg>
                </a>
            </div>
        </div>
    </section>

</div>
@endsection
