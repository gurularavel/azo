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
                <span class="absolute left-6 top-1/2 -translate-y-1/2 text-slate-400 z-10">
                    <svg fill="none" class="w-5 h-5" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                    </svg>
                </span>
                <span class="absolute top-1/2 -translate-y-1/2 font-bold text-secondary text-sm pointer-events-none select-none z-10" style="left:3.25rem">+994</span>
                <input type="tel" id="phone-display" maxlength="12" placeholder="50 123 45 67" autocomplete="tel"
                    class="w-full pr-6 py-4 rounded-sm bg-slate-50 border border-slate-100 focus:bg-white focus:border-primary focus:ring-4 focus:ring-primary/10 outline-none transition-all font-medium"
                    style="padding-left:7.75rem" />
                <input type="hidden" name="phone" id="phone-hidden" value="{{ old('phone', request('phone')) }}" />
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
            Qeydiyyatdan keçməklə siz bizim
            <button type="button" onclick="openLegalModal('terms')"
                class="text-primary font-bold hover:underline">İstifadəçi Qaydalarımızı</button>
            və
            <button type="button" onclick="openLegalModal('privacy')"
                class="text-primary font-bold hover:underline">Məxfilik Siyasətimizi</button>
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

{{-- Legal Popup Modal --}}
<div id="legal-modal"
     class="fixed inset-0 z-50 hidden items-center justify-center p-4"
     role="dialog" aria-modal="true">

    {{-- Backdrop --}}
    <div id="legal-backdrop"
         class="absolute inset-0 bg-secondary/60 backdrop-blur-sm"
         onclick="closeLegalModal()"></div>

    {{-- Modal panel --}}
    <div class="relative w-full max-w-2xl max-h-[85vh] flex flex-col bg-white rounded-2xl shadow-2xl overflow-hidden">

        {{-- Header --}}
        <div class="flex items-center justify-between px-8 py-5 border-b border-slate-100 flex-shrink-0">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-full bg-orange-50 flex items-center justify-center">
                    <svg id="modal-icon-terms" class="hidden w-5 h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    <svg id="modal-icon-privacy" class="hidden w-5 h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                    </svg>
                </div>
                <h2 id="legal-modal-title" class="text-lg font-bold text-secondary"></h2>
            </div>
            <button onclick="closeLegalModal()"
                class="w-9 h-9 rounded-full flex items-center justify-center text-slate-400 hover:bg-slate-100 hover:text-slate-600 transition-all">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        {{-- Body --}}
        <div class="flex-1 overflow-y-auto px-8 py-6">
            <div id="legal-modal-body" class="prose prose-slate max-w-none text-slate-600 leading-relaxed text-sm">
            </div>
            <div id="legal-modal-empty" class="hidden text-center py-12 text-slate-400">
                <svg class="w-12 h-12 mx-auto mb-3 opacity-40" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                <p>Məzmun hələ əlavə edilməyib.</p>
            </div>
        </div>

        {{-- Footer --}}
        <div class="px-8 py-4 border-t border-slate-100 flex-shrink-0 flex justify-end">
            <button onclick="closeLegalModal()"
                class="px-6 py-2.5 rounded-full bg-primary text-white font-bold text-sm hover:bg-primary-hover transition-all shadow-sm shadow-orange-500/30">
                Bağla
            </button>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .prose h1, .prose h2, .prose h3 { color: #0a2a66; font-weight: 700; margin-top: 1.4em; margin-bottom: .5em; }
    .prose h1 { font-size: 1.4rem; }
    .prose h2 { font-size: 1.15rem; }
    .prose h3 { font-size: 1rem; }
    .prose p { margin-bottom: .9em; }
    .prose ul, .prose ol { padding-left: 1.4em; margin-bottom: .9em; }
    .prose li { margin-bottom: .3em; }
    .prose a { color: #ff5f00; text-decoration: underline; }
    .prose strong { color: #0a2a66; }
    #legal-modal.flex { display: flex; }
</style>
@endpush

@push('scripts')
<script>
    // ── Phone +994 mask ──
    (function () {
        const display = document.getElementById('phone-display');
        const hidden  = document.getElementById('phone-hidden');
        if (!display || !hidden) return;

        function digitsOnly(str) {
            return str.replace(/\D/g, '').slice(0, 9);
        }

        function fmt(digits) {
            let r = digits.slice(0, 2);
            if (digits.length > 2) r += ' ' + digits.slice(2, 5);
            if (digits.length > 5) r += ' ' + digits.slice(5, 7);
            if (digits.length > 7) r += ' ' + digits.slice(7, 9);
            return r;
        }

        // Restore from old() value on page load
        const init = hidden.value;
        if (init && init.startsWith('+994')) {
            display.value = fmt(digitsOnly(init.slice(4)));
        }

        display.addEventListener('input', function () {
            const digits = digitsOnly(this.value);
            this.value = fmt(digits);
            hidden.value = digits.length ? '+994' + digits : '';
        });

        display.addEventListener('keydown', function (e) {
            // Allow: backspace, delete, tab, escape, arrows, home, end
            const allow = ['Backspace','Delete','Tab','Escape','ArrowLeft','ArrowRight','Home','End'];
            if (allow.includes(e.key)) return;
            // Block non-digits
            if (!/^[0-9]$/.test(e.key)) e.preventDefault();
        });

        // Paste: strip non-digits
        display.addEventListener('paste', function (e) {
            e.preventDefault();
            const pasted = (e.clipboardData || window.clipboardData).getData('text');
            // If pasted value starts with +994, strip it
            const raw = pasted.startsWith('+994') ? pasted.slice(4) : pasted;
            const digits = digitsOnly(raw);
            this.value = fmt(digits);
            hidden.value = digits.length ? '+994' + digits : '';
        });
    })();

    const termsContent  = @json($siteSettings?->terms_content ?? '');
    const privacyContent = @json($siteSettings?->privacy_content ?? '');

    const modalEl    = document.getElementById('legal-modal');
    const modalTitle = document.getElementById('legal-modal-title');
    const modalBody  = document.getElementById('legal-modal-body');
    const modalEmpty = document.getElementById('legal-modal-empty');
    const iconTerms   = document.getElementById('modal-icon-terms');
    const iconPrivacy = document.getElementById('modal-icon-privacy');

    function openLegalModal(type) {
        const isTerms = type === 'terms';
        modalTitle.textContent = isTerms ? 'İstifadəçi Qaydaları' : 'Məxfilik Siyasəti';
        iconTerms.classList.toggle('hidden', !isTerms);
        iconPrivacy.classList.toggle('hidden', isTerms);

        const content = isTerms ? termsContent : privacyContent;
        if (content && content.trim()) {
            modalBody.innerHTML = content;
            modalBody.classList.remove('hidden');
            modalEmpty.classList.add('hidden');
        } else {
            modalBody.classList.add('hidden');
            modalEmpty.classList.remove('hidden');
        }

        modalEl.classList.remove('hidden');
        modalEl.classList.add('flex');
        document.body.style.overflow = 'hidden';
    }

    function closeLegalModal() {
        modalEl.classList.add('hidden');
        modalEl.classList.remove('flex');
        document.body.style.overflow = '';
    }

    document.addEventListener('keydown', e => {
        if (e.key === 'Escape') closeLegalModal();
    });
</script>
@endpush
