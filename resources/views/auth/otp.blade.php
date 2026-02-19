@extends('layouts.auth')

@section('title', 'OTP Doğrulaması - QR Endirim')
@section('container_class', 'max-w-2xl')

@section('content')
<div class="bg-white rounded-sm shadow-2xl border border-slate-100 overflow-hidden flex flex-col md:flex-row">

    <div class="md:w-1/2 bg-secondary p-12 flex flex-col justify-center items-center text-white relative">
        <div class="absolute inset-0 bg-primary/10 opacity-50"></div>
        <img src="{{ asset('template/images/otp.svg') }}" class="w-full max-w-xs relative z-10 animate-pulse" />
        <div class="mt-8 text-center relative z-10">
            <h2 class="text-2xl font-bold mb-2">Təhlükəsizlik</h2>
            <p class="text-white/60 text-sm">Hesabınızın təhlükəsizliyi üçün kodu daxil edin</p>
        </div>
    </div>

    <div class="md:w-1/2 p-10 md:p-14 flex flex-col justify-center">
        <div class="mb-10 text-center md:text-left">
            <h1 class="text-3xl font-extrabold text-secondary mb-4">OTP Doğrulaması</h1>
            <p class="text-slate-500 leading-relaxed">
                @if(isset($user) && $user->phone)
                    <span class="font-bold text-secondary">{{ $user->phone }}</span> nömrəsinə
                @endif
                göndərilən 6 rəqəmli kodu daxil edin.
            </p>
            @if(session('otp_code'))
                <div class="mt-3 p-3 bg-orange-50 border border-orange-200 rounded-sm text-sm">
                    <span class="text-orange-700 font-bold">Test kodu: {{ session('otp_code') }}</span>
                </div>
            @endif
        </div>

        <form action="{{ route('otp.verify') }}" method="post" class="space-y-8" id="otp-form">
            @csrf
            <input type="hidden" name="code" id="otp-hidden" />

            <div class="flex justify-between gap-2">
                @for($i = 1; $i <= 6; $i++)
                    <input type="text" maxlength="1" inputmode="numeric" pattern="[0-9]"
                        class="otp-digit w-12 h-14 md:w-14 md:h-16 text-center text-2xl font-bold bg-slate-50 border-2 border-slate-100 rounded-sm focus:border-primary focus:bg-white focus:ring-4 focus:ring-primary/10 outline-none transition-all" />
                @endfor
            </div>

            <button type="submit"
                class="w-full py-5 rounded-sm bg-primary text-white font-bold text-lg shadow-lg shadow-orange-500/30 hover:bg-primary-hover transition-all">
                Təsdiq Et
            </button>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    const digits = document.querySelectorAll('.otp-digit');
    const hidden = document.getElementById('otp-hidden');
    const form = document.getElementById('otp-form');

    digits.forEach((input, index) => {
        input.addEventListener('input', (e) => {
            const val = e.target.value.replace(/\D/g, '');
            e.target.value = val.slice(-1);
            if (val && index < digits.length - 1) digits[index + 1].focus();
            updateHidden();
        });
        input.addEventListener('keydown', (e) => {
            if (e.key === 'Backspace' && !e.target.value && index > 0) digits[index - 1].focus();
        });
    });

    function updateHidden() {
        hidden.value = Array.from(digits).map(d => d.value).join('');
    }

    form.addEventListener('submit', (e) => {
        updateHidden();
        if (hidden.value.length !== 6) {
            e.preventDefault();
            digits[0].focus();
        }
    });
</script>
@endpush
