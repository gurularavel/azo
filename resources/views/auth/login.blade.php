@extends('layouts.auth')

@section('title', 'Daxil Ol - QR Endirim')

@section('content')
<div class="text-center mb-10">
    <a href="{{ route('home') }}" class="inline-flex items-center mb-4">
        <img src="{{ asset('template/images/logo.svg') }}" alt="Logo" class="w-20 h-20" />
    </a>
    <h1 class="text-2xl font-bold text-secondary">Xoş Gəlmisiniz!</h1>
    <p class="text-slate-500">Məlumatlarınızı daxil edərək hesaba girin</p>
</div>

<div class="bg-white p-10 rounded-sm shadow-2xl border border-slate-100">
    <form action="{{ route('login.store') }}" method="post" class="space-y-6">
        @csrf

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

        <button type="submit"
            class="w-full py-5 rounded-sm bg-primary text-white font-bold text-lg shadow-lg shadow-orange-500/30 hover:bg-primary-hover transition-all">
            Daxil Ol
        </button>
    </form>

    <div class="mt-8 pt-8 border-t border-slate-50 text-center">
        <p class="text-slate-500">Hesabınız yoxdur? <a href="{{ route('register') }}"
                class="text-primary font-bold hover:underline">Qeydiyyatdan keç</a></p>
    </div>
</div>
@endsection
