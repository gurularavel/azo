@extends('layouts.app')

@section('title', 'Əlaqə - ' . ($siteSettings?->site_name ?? 'QR Endirim'))

@section('content')
<div class="pb-24">
    <div class="container mx-auto px-4 py-16">

        {{-- Page Header --}}
        <div class="text-center max-w-2xl mx-auto mb-20 animate__animated animate__fadeIn">
            <span class="text-primary font-bold uppercase tracking-widest text-sm bg-orange-100 px-4 py-1.5 rounded-full">Əlaqə</span>
            <h1 class="text-4xl sm:text-5xl font-extrabold text-secondary mt-6 mb-6">
                Bizimlə <span class="text-primary">Əlaqə</span> Saxlayın
            </h1>
            <p class="text-xl text-slate-600 leading-relaxed">
                Sualınız, təklifiniz və ya əməkdaşlıq fikriniz var? Bizə yazın, 24 saat ərzində sizə geri dönək.
            </p>
        </div>

        <div class="grid lg:grid-cols-12 gap-12 items-start">

            {{-- Left: Contact Info --}}
            <div class="lg:col-span-5 space-y-5 md:space-y-8 animate__animated animate__fadeInLeft">
                <div class="bg-secondary p-6 sm:p-8 md:p-14 rounded-sm text-white relative overflow-hidden">
                    <div class="hidden md:block absolute top-0 right-0 w-64 h-64 bg-white/5 rounded-full blur-3xl -mr-32 -mt-32"></div>
                    <h2 class="text-xl sm:text-2xl md:text-3xl font-bold mb-8 md:mb-12 relative z-10">Əlaqə Məlumatları</h2>

                    <div class="space-y-6 md:space-y-10 relative z-10">
                        @if($siteSettings?->contact_phone)
                        <div class="flex gap-4 group">
                            <div class="w-10 h-10 sm:w-12 sm:h-12 md:w-16 md:h-16 rounded-2xl bg-white/10 flex items-center justify-center flex-shrink-0 group-hover:bg-primary transition-all">
                                <img src="{{ asset('template/icons/phone-white.svg') }}" class="w-5 h-5 sm:w-6 sm:h-6 md:w-8 md:h-8" />
                            </div>
                            <div>
                                <p class="text-white/60 mb-0.5 text-xs sm:text-sm">Qaynar Xətt</p>
                                <p class="text-base sm:text-lg md:text-2xl font-bold">{{ $siteSettings->contact_phone }}</p>
                            </div>
                        </div>
                        @endif

                        @if($siteSettings?->contact_email)
                        <div class="flex gap-4 group">
                            <div class="w-10 h-10 sm:w-12 sm:h-12 md:w-16 md:h-16 rounded-2xl bg-white/10 flex items-center justify-center flex-shrink-0 group-hover:bg-primary transition-all">
                                <img src="{{ asset('template/icons/email-white.svg') }}" class="w-5 h-5 sm:w-6 sm:h-6 md:w-8 md:h-8" />
                            </div>
                            <div>
                                <p class="text-white/60 mb-0.5 text-xs sm:text-sm">E-mail Ünvanı</p>
                                <p class="text-base sm:text-lg md:text-2xl font-bold">{{ $siteSettings->contact_email }}</p>
                            </div>
                        </div>
                        @else
                        <div class="flex gap-4 group">
                            <div class="w-10 h-10 sm:w-12 sm:h-12 md:w-16 md:h-16 rounded-2xl bg-white/10 flex items-center justify-center flex-shrink-0 group-hover:bg-primary transition-all">
                                <img src="{{ asset('template/icons/email-white.svg') }}" class="w-5 h-5 sm:w-6 sm:h-6 md:w-8 md:h-8" />
                            </div>
                            <div>
                                <p class="text-white/60 mb-0.5 text-xs sm:text-sm">E-mail Ünvanı</p>
                                <p class="text-base sm:text-lg md:text-2xl font-bold">info@qrendirim.az</p>
                            </div>
                        </div>
                        @endif

                        <div class="flex gap-4 group">
                            <div class="w-10 h-10 sm:w-12 sm:h-12 md:w-16 md:h-16 rounded-2xl bg-white/10 flex items-center justify-center flex-shrink-0 group-hover:bg-primary transition-all">
                                <img src="{{ asset('template/icons/location-white.svg') }}" class="w-5 h-5 sm:w-6 sm:h-6 md:w-8 md:h-8" />
                            </div>
                            <div>
                                <p class="text-white/60 mb-0.5 text-xs sm:text-sm">Ünvanımız</p>
                                <p class="text-base sm:text-lg md:text-2xl font-bold">Bakı ş. Nəsimi r. <br />S.Vurğun küç 8</p>
                            </div>
                        </div>
                    </div>

                    @if($siteSettings?->facebook_url || $siteSettings?->instagram_url || $siteSettings?->youtube_url)
                    <div class="mt-10 md:mt-20 pt-6 md:pt-10 border-t border-white/10 relative z-10">
                        <h3 class="text-xl font-bold mb-6">Sosial Media</h3>
                        <div class="flex gap-4">
                            @if($siteSettings?->facebook_url)
                            <a href="{{ $siteSettings->facebook_url }}" target="_blank"
                                class="w-12 h-12 rounded-sm bg-white/10 flex items-center justify-center hover:bg-primary transition-all">
                                <svg fill="currentColor" viewBox="0 0 24 24" class="w-6 h-6">
                                    <path d="M18.77 7.46H14.5v-1.9c0-.9.6-1.1 1-1.1h3V.5h-4.33C10.24.5 9.5 3.44 9.5 5.32v2.14H7.5V12h2v11.5h5V12h2.82l.45-4.54z" />
                                </svg>
                            </a>
                            @endif
                            @if($siteSettings?->instagram_url)
                            <a href="{{ $siteSettings->instagram_url }}" target="_blank"
                                class="w-12 h-12 rounded-sm bg-white/10 flex items-center justify-center hover:bg-primary transition-all">
                                <svg fill="currentColor" viewBox="0 0 24 24" class="w-6 h-6">
                                    <path d="M12.315 2c2.43 0 2.784.013 3.808.06 1.064.049 1.791.218 2.427.465a4.902 4.902 0 011.772 1.153 4.902 4.902 0 011.153 1.772c.247.636.416 1.363.465 2.427.048 1.067.06 1.407.06 4.123v.08c0 2.643-.012 2.987-.06 4.043-.049 1.064-.218 1.791-.465 2.427a4.902 4.902 0 01-1.153 1.772 4.902 4.902 0 01-1.772 1.153c-.636.247-1.363.416-2.427.465-1.067.048-1.407.06-4.123.06h-.08c-2.643 0-2.987-.012-4.043-.06-1.064-.049-1.791-.218-2.427-.465a4.902 4.902 0 01-1.772-1.153 4.902 4.902 0 01-1.153-1.772c-.247-.636-.416-1.363-.465-2.427-.047-1.024-.06-1.379-.06-3.808v-.63c0-2.43.013-2.784.06-3.808.049-1.064.218-1.791.465-2.427a4.902 4.902 0 011.153-1.772A4.902 4.902 0 015.45 2.525c.636-.247 1.363-.416 2.427-.465C8.901 2.013 9.256 2 11.685 2h.63zm-.081 1.802h-.468c-2.456 0-2.784.011-3.807.058-.975.045-1.504.207-1.857.344-.467.182-.8.398-1.15.748-.35.35-.566.683-.748 1.15-.137.353-.3.882-.344 1.857-.047 1.023-.058 1.351-.058 3.807v.468c0 2.456.011 2.784.058 3.807.045.975.207 1.504.344 1.857.182.466.399.8.748 1.15.35.35.683.566 1.15.748.353.137.882.3 1.857.344 1.054.048 1.37.058 4.041.058h.08c2.597 0 2.917-.01 3.96-.058.976-.045 1.505-.207 1.858-.344.466-.182.8-.398 1.15-.748.35-.35.566-.683.748-1.15.137-.353.3-.882.344-1.857.048-1.055.058-1.37.058-4.041v-.08c0-2.597-.01-2.917-.058-3.96-.045-.976-.207-1.505-.344-1.858a3.097 3.097 0 00-.748-1.15 3.098 3.098 0 00-1.15-.748c-.353-.137-.882-.3-1.857-.344-1.023-.047-1.351-.058-3.807-.058zM12 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16.35a4.188 4.188 0 110-8.376 4.188 4.188 0 010 8.376zm4.962-10.405a1.44 1.44 0 11-2.88 0 1.44 1.44 0 012.88 0z" />
                                </svg>
                            </a>
                            @endif
                            @if($siteSettings?->youtube_url)
                            <a href="{{ $siteSettings->youtube_url }}" target="_blank"
                                class="w-12 h-12 rounded-sm bg-white/10 flex items-center justify-center hover:bg-primary transition-all">
                                <svg fill="currentColor" viewBox="0 0 24 24" class="w-6 h-6">
                                    <path d="M23.498 6.186a3.016 3.016 0 00-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505a3.017 3.017 0 00-2.122 2.136C0 8.055 0 12 0 12s0 3.945.501 5.814a3.015 3.015 0 002.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 002.122-2.136C24 15.945 24 12 24 12s0-3.945-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z" />
                                </svg>
                            </a>
                            @endif
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            {{-- Right: Contact Form --}}
            <div class="lg:col-span-7 animate__animated animate__fadeInRight">
                <div class="bg-white p-8 md:p-14 rounded-sm shadow-premium ring-1 ring-slate-100">
                    <h2 class="text-3xl font-bold text-secondary mb-10">Mesaj Göndərin</h2>

                    <form action="{{ route('contact.store') }}" method="post" class="space-y-6">
                        @csrf

                        <div class="grid md:grid-cols-2 gap-6">
                            <div class="space-y-2">
                                <label class="text-sm font-bold text-slate-500 ml-4">Ad və Soyad</label>
                                <input type="text" name="name" value="{{ old('name') }}" placeholder="Məs: Emil Abbasov"
                                    class="w-full px-6 py-4 rounded-sm bg-slate-50 border border-slate-100 focus:bg-white focus:border-primary focus:ring-4 focus:ring-primary/10 outline-none transition-all font-medium" />
                            </div>
                            <div class="space-y-2">
                                <label class="text-sm font-bold text-slate-500 ml-4">E-mail</label>
                                <input type="email" name="email" value="{{ old('email') }}" placeholder="example@mail.com"
                                    class="w-full px-6 py-4 rounded-sm bg-slate-50 border border-slate-100 focus:bg-white focus:border-primary focus:ring-4 focus:ring-primary/10 outline-none transition-all font-medium" />
                            </div>
                        </div>

                        <div class="space-y-2">
                            <label class="text-sm font-bold text-slate-500 ml-4">Telefon Nömrəsi</label>
                            <input type="text" name="phone" value="{{ old('phone') }}" placeholder="+994 50 000 00 00"
                                class="w-full px-6 py-4 rounded-sm bg-slate-50 border border-slate-100 focus:bg-white focus:border-primary focus:ring-4 focus:ring-primary/10 outline-none transition-all font-medium" />
                        </div>

                        <div class="space-y-2">
                            <label class="text-sm font-bold text-slate-500 ml-4">Müraciət Mətni</label>
                            <textarea name="message" rows="5" placeholder="Sualınız və ya təklifinizi buraya yazın..."
                                class="w-full px-6 py-4 rounded-sm bg-slate-50 border border-slate-100 focus:bg-white focus:border-primary focus:ring-4 focus:ring-primary/10 outline-none transition-all font-medium resize-none">{{ old('message') }}</textarea>
                        </div>

                        <button type="submit"
                            class="w-full py-5 rounded-sm bg-primary text-white font-bold text-lg shadow-lg shadow-orange-500/30 hover:bg-primary-hover transition-all">
                            Mesajı Göndər
                        </button>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
