@extends('layouts.auth')

@section('title', 'Qeydiyyat - QR Endirim')

@section('content')
<div class="text-center mb-10">
    <a href="{{ route('home') }}" class="inline-flex items-center mb-4">
        <img src="{{ asset('template/images/logo.svg') }}" alt="Logo" class="w-20 h-20" />
    </a>
    <h1 class="text-2xl font-bold text-secondary">Yeni Hesab Yarat</h1>
    <p class="text-slate-500">Endirimlərdən yararlanmaq üçün qeydiyyatdan keçin</p>
</div>

<div class="bg-white p-10 rounded-sm shadow-2xl border border-slate-100">
    <form action="{{ route('register.store') }}" method="post" class="space-y-5">
        @csrf

        <div class="space-y-2">
            <label class="text-sm font-bold text-slate-500 ml-4">Ad və Soyad</label>
            <div class="relative">
                <span class="absolute left-6 top-1/2 -translate-y-1/2 text-slate-400">
                    <svg fill="none" class="w-5 h-5" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                </span>
                <input type="text" name="name" value="{{ old('name') }}" placeholder="Ad Soyad"
                    class="w-full pl-14 pr-6 py-4 rounded-sm bg-slate-50 border border-slate-100 focus:bg-white focus:border-primary focus:ring-4 focus:ring-primary/10 outline-none transition-all font-medium" />
            </div>
        </div>

        <div class="space-y-2">
            <label class="text-sm font-bold text-slate-500 ml-4">E-mail</label>
            <div class="relative">
                <span class="absolute left-6 top-1/2 -translate-y-1/2 text-slate-400">
                    <svg fill="none" class="w-5 h-5" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" />
                    </svg>
                </span>
                <input type="email" name="email" value="{{ old('email') }}" placeholder="email@example.com"
                    class="w-full pl-14 pr-6 py-4 rounded-sm bg-slate-50 border border-slate-100 focus:bg-white focus:border-primary focus:ring-4 focus:ring-primary/10 outline-none transition-all font-medium" />
            </div>
        </div>

        <div class="space-y-2">
            <label class="text-sm font-bold text-slate-500 ml-4">Telefon Nömrəsi</label>
            <div class="relative">
                <span class="absolute left-6 top-1/2 -translate-y-1/2 text-slate-400">
                    <svg fill="none" class="w-5 h-5" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                    </svg>
                </span>
                <input type="text" name="phone" value="{{ old('phone') }}" placeholder="+994 50 000 00 00"
                    class="w-full pl-14 pr-6 py-4 rounded-sm bg-slate-50 border border-slate-100 focus:bg-white focus:border-primary focus:ring-4 focus:ring-primary/10 outline-none transition-all font-medium" />
            </div>
        </div>

        <div class="space-y-2">
            <label class="text-sm font-bold text-slate-500 ml-4">Şifrə</label>
            <div class="relative">
                <span class="absolute left-6 top-1/2 -translate-y-1/2 text-slate-400">
                    <svg fill="none" class="w-5 h-5" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                    </svg>
                </span>
                <input type="password" name="password" placeholder="••••••••"
                    class="w-full pl-14 pr-6 py-4 rounded-sm bg-slate-50 border border-slate-100 focus:bg-white focus:border-primary focus:ring-4 focus:ring-primary/10 outline-none transition-all font-medium" />
            </div>
        </div>

        <div class="space-y-2">
            <label class="text-sm font-bold text-slate-500 ml-4">Şifrəni Təsdiqlə</label>
            <div class="relative">
                <span class="absolute left-6 top-1/2 -translate-y-1/2 text-slate-400">
                    <svg fill="none" class="w-5 h-5" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                    </svg>
                </span>
                <input type="password" name="password_confirmation" placeholder="••••••••"
                    class="w-full pl-14 pr-6 py-4 rounded-sm bg-slate-50 border border-slate-100 focus:bg-white focus:border-primary focus:ring-4 focus:ring-primary/10 outline-none transition-all font-medium" />
            </div>
        </div>

        <div class="px-2 text-sm text-slate-500 leading-relaxed">
            Qeydiyyatdan keçməklə siz bizim <a href="#" class="text-primary font-bold hover:underline">İstifadəçi
                Qaydalarımızı</a> və <a href="#" class="text-primary font-bold hover:underline">Məxfilik Siyasətimizi</a>
            qəbul etmiş olursunuz.
        </div>

        <button type="submit"
            class="w-full py-5 rounded-sm bg-primary text-white font-bold text-lg shadow-lg shadow-orange-500/30 hover:bg-primary-hover transition-all">
            Qeydiyyatdan Keç
        </button>
    </form>

    <div class="mt-8 pt-8 border-t border-slate-50 text-center">
        <p class="text-slate-500">Hesabınız var? <a href="{{ route('login') }}"
                class="text-primary font-bold hover:underline">Daxil ol</a></p>
    </div>
</div>
@endsection
