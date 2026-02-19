@extends('layouts.auth')

@section('title', 'OTP Doğrulaması - QR Endirim')
@section('container_class', 'max-w-md')

@section('content')

{{-- Logo --}}
<div class="text-center mb-8">
    <a href="{{ route('home') }}" class="inline-flex items-center justify-center mb-5">
        <img src="{{ asset('template/images/logo.svg') }}" alt="Logo" class="w-16 h-16" />
    </a>

    {{-- Shield icon --}}
    <div class="w-20 h-20 rounded-full bg-orange-50 border-4 border-orange-100 flex items-center justify-center mx-auto mb-5">
        <svg class="w-10 h-10 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
        </svg>
    </div>

    <h1 class="text-2xl font-extrabold text-secondary mb-2">Telefonu Təsdiqlə</h1>
    <p class="text-slate-500 text-sm leading-relaxed">
        @if(isset($user) && $user->phone)
            <span class="font-bold text-secondary">{{ $user->phone }}</span> nömrəsinə
        @endif
        göndərilən <span class="font-bold text-primary">4 rəqəmli</span> kodu daxil edin.
    </p>

    @if(session('otp_code'))
        <div class="mt-4 inline-flex items-center gap-2 px-4 py-2 bg-orange-50 border border-orange-200 rounded-full text-sm">
            <svg class="w-4 h-4 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <span class="text-orange-700">Test kodu: <strong>{{ session('otp_code') }}</strong></span>
        </div>
    @endif
</div>

{{-- Card --}}
<div class="bg-white rounded-2xl shadow-2xl border border-slate-100 p-8 md:p-10">

    <form action="{{ route('otp.verify') }}" method="post" id="otp-form">
        @csrf
        <input type="hidden" name="code" id="otp-hidden" />

        {{-- 4 digit boxes --}}
        <div class="flex justify-center gap-3 mb-8">
            @for($i = 0; $i < 4; $i++)
                <input type="text" inputmode="numeric" pattern="[0-9]" maxlength="1"
                    class="otp-digit w-16 h-20 text-center text-3xl font-black text-secondary bg-slate-50 border-2 border-slate-200 rounded-xl outline-none transition-all duration-150
                           focus:border-primary focus:bg-white focus:ring-4 focus:ring-primary/10 focus:scale-105
                           caret-primary" />
            @endfor
        </div>

        <button type="submit" id="otp-submit"
            class="w-full py-4 rounded-xl bg-primary text-white font-bold text-base shadow-lg shadow-orange-500/30 hover:bg-orange-600 active:scale-95 transition-all disabled:opacity-50 disabled:cursor-not-allowed"
            disabled>
            <span class="flex items-center justify-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
                Təsdiqlə
            </span>
        </button>
    </form>

    <div class="mt-6 text-center text-sm text-slate-400">
        <a href="{{ route('register') }}" class="hover:text-primary transition-colors">
            ← Qeydiyyata qayıt
        </a>
    </div>
</div>

@endsection

@push('styles')
<style>
    .otp-digit.is-filled {
        border-color: #ff5f00;
        background: #fff;
        color: #0a2a66;
    }
</style>
@endpush

@push('scripts')
<script>
(function () {
    const digits  = Array.from(document.querySelectorAll('.otp-digit'));
    const hidden  = document.getElementById('otp-hidden');
    const form    = document.getElementById('otp-form');
    const submit  = document.getElementById('otp-submit');

    function getCode() {
        return digits.map(d => d.value).join('');
    }

    function sync() {
        const code = getCode();
        hidden.value = code;
        submit.disabled = code.length !== 4;
        digits.forEach(d => d.classList.toggle('is-filled', d.value !== ''));
    }

    function focusNext(index) {
        if (index < digits.length - 1) digits[index + 1].focus();
    }

    function focusPrev(index) {
        if (index > 0) digits[index - 1].focus();
    }

    digits.forEach((input, i) => {
        input.addEventListener('focus', () => input.select());

        input.addEventListener('input', (e) => {
            const val = e.target.value.replace(/\D/g, '');
            input.value = val.slice(-1);
            sync();
            if (input.value) focusNext(i);
        });

        input.addEventListener('keydown', (e) => {
            if (e.key === 'Backspace') {
                if (!input.value) {
                    focusPrev(i);
                } else {
                    input.value = '';
                    sync();
                }
                e.preventDefault();
            } else if (e.key === 'ArrowLeft') {
                focusPrev(i);
            } else if (e.key === 'ArrowRight') {
                focusNext(i);
            }
        });

        // Handle paste on any digit box
        input.addEventListener('paste', (e) => {
            e.preventDefault();
            const pasted = (e.clipboardData || window.clipboardData)
                .getData('text').replace(/\D/g, '').slice(0, 4);
            pasted.split('').forEach((char, idx) => {
                if (digits[idx]) digits[idx].value = char;
            });
            const focusIdx = Math.min(pasted.length, digits.length - 1);
            digits[focusIdx].focus();
            sync();
        });
    });

    // Auto-submit when all 4 digits are entered
    form.addEventListener('input', () => {
        if (getCode().length === 4) {
            setTimeout(() => form.requestSubmit(), 300);
        }
    });

    // Focus first box on load
    digits[0].focus();
})();
</script>
@endpush
