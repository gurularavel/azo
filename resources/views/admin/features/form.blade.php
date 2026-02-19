@extends('layouts.admin')
@section('title', $feature->exists ? 'Kartı Düzəlt' : 'Yeni Kart')

@section('content')
<div class="d-flex align-items-center gap-2 mb-4">
    <a href="{{ route('admin.features.index') }}" class="btn btn-sm btn-outline-secondary">
        <i class="bi bi-arrow-left"></i>
    </a>
    <h4 class="mb-0 fw-bold">{{ $feature->exists ? 'Kartı Düzəlt' : 'Yeni Kart' }}</h4>
</div>

@php
$colors = [
    'orange' => 'Narıncı',
    'blue'   => 'Mavi',
    'green'  => 'Yaşıl',
    'purple' => 'Bənövşəyi',
    'red'    => 'Qırmızı',
];

$icons = [
    'bi-lightning-charge' => 'İldırım',
    'bi-building'         => 'Bina',
    'bi-piggy-bank'       => 'Qənaət',
    'bi-qr-code'          => 'QR Kod',
    'bi-shield-check'     => 'Təhlükəsizlik',
    'bi-clock'            => 'Sürət',
    'bi-star'             => 'Ulduz',
    'bi-heart'            => 'Ürək',
    'bi-gift'             => 'Hədiyyə',
    'bi-trophy'           => 'Uğur',
    'bi-people'           => 'İnsanlar',
    'bi-phone'            => 'Telefon',
    'bi-graph-up'         => 'Artım',
    'bi-patch-check'      => 'Yoxlama',
    'bi-wallet2'          => 'Cüzdan',
    'bi-shop'             => 'Mağaza',
    'bi-truck'            => 'Çatdırılma',
    'bi-percent'          => 'Faiz',
    'bi-tag'              => 'Teq',
    'bi-credit-card'      => 'Kart',
];

$colorDot = [
    'orange' => '#ff5f00',
    'blue'   => '#3b82f6',
    'green'  => '#22c55e',
    'purple' => '#a855f7',
    'red'    => '#ef4444',
];
@endphp

<div class="row">
    <div class="col-lg-7">
        <div class="card shadow-sm border-0">
            <div class="card-body p-4">
                <form method="post"
                      action="{{ $feature->exists ? route('admin.features.update', $feature) : route('admin.features.store') }}">
                    @csrf
                    @if($feature->exists) @method('PUT') @endif

                    {{-- Title --}}
                    <div class="mb-4">
                        <label class="form-label fw-semibold">Başlıq <span class="text-danger">*</span></label>
                        <input type="text" name="title" value="{{ old('title', $feature->title) }}"
                               class="form-control @error('title') is-invalid @enderror"
                               placeholder="Məs: Sürətli və Asan" required />
                        @error('title') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    {{-- Description --}}
                    <div class="mb-4">
                        <label class="form-label fw-semibold">Açıqlama</label>
                        <textarea name="description" rows="3"
                                  class="form-control @error('description') is-invalid @enderror"
                                  placeholder="Qısa izah mətni...">{{ old('description', $feature->description) }}</textarea>
                        @error('description') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    {{-- Icon --}}
                    <div class="mb-4">
                        <label class="form-label fw-semibold">İkon <span class="text-danger">*</span></label>
                        <div class="d-flex flex-wrap gap-2 mb-2" id="icon-grid">
                            @foreach($icons as $cls => $label)
                            <label class="icon-option" title="{{ $label }}">
                                <input type="radio" name="icon" value="{{ $cls }}"
                                       {{ old('icon', $feature->icon ?? 'bi-lightning-charge') === $cls ? 'checked' : '' }}
                                       style="display:none">
                                <div class="icon-box d-flex flex-column align-items-center justify-content-center gap-1 rounded-3 border p-2"
                                     style="width:58px;cursor:pointer;transition:all .15s;">
                                    <i class="bi {{ $cls }}" style="font-size:1.4rem;"></i>
                                    <span style="font-size:.55rem;text-align:center;line-height:1.2">{{ $label }}</span>
                                </div>
                            </label>
                            @endforeach
                        </div>
                        <small class="text-muted">Və ya Bootstrap Icons class adını əl ilə daxil edin:</small>
                        <input type="text" id="icon-manual" placeholder="bi-star"
                               class="form-control form-control-sm mt-1"
                               value="{{ old('icon', $feature->icon ?? 'bi-lightning-charge') }}" />
                        @error('icon') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                    </div>

                    {{-- Color --}}
                    <div class="mb-4">
                        <label class="form-label fw-semibold">Rəng tonu <span class="text-danger">*</span></label>
                        <div class="d-flex gap-3 flex-wrap">
                            @foreach($colors as $val => $label)
                            <label class="d-flex align-items-center gap-2" style="cursor:pointer">
                                <input type="radio" name="color" value="{{ $val }}"
                                       {{ old('color', $feature->color ?? 'orange') === $val ? 'checked' : '' }}>
                                <span class="rounded-circle d-inline-block border"
                                      style="width:18px;height:18px;background:{{ $colorDot[$val] }}"></span>
                                {{ $label }}
                            </label>
                            @endforeach
                        </div>
                        @error('color') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                    </div>

                    {{-- Sort + Active --}}
                    <div class="row mb-4">
                        <div class="col-sm-4">
                            <label class="form-label fw-semibold">Sıra nömrəsi</label>
                            <input type="number" name="sort_order" min="0"
                                   value="{{ old('sort_order', $feature->sort_order ?? 0) }}"
                                   class="form-control" />
                        </div>
                        <div class="col-sm-4 d-flex align-items-end">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" name="is_active" id="is_active"
                                       value="1" {{ old('is_active', $feature->is_active ?? true) ? 'checked' : '' }}>
                                <label class="form-check-label fw-semibold" for="is_active">Aktiv</label>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-floppy"></i>
                            {{ $feature->exists ? 'Yadda Saxla' : 'Əlavə Et' }}
                        </button>
                        <a href="{{ route('admin.features.index') }}" class="btn btn-outline-secondary">Ləğv Et</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Preview --}}
    <div class="col-lg-5 mt-4 mt-lg-0">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white fw-semibold border-0 pb-0">
                <i class="bi bi-eye me-1"></i> Önizləmə
            </div>
            <div class="card-body">
                <div id="preview-card" class="group p-6 rounded-3 border position-relative"
                     style="background:#fff;padding:2rem;border-color:#e2e8f0!important">
                    <div id="preview-icon-wrap"
                         class="d-flex align-items-center justify-content-center rounded-3 mb-3 border"
                         style="width:56px;height:56px;background:#fff4e5;border-color:#fed7a0!important">
                        <i id="preview-icon" class="bi bi-lightning-charge" style="font-size:1.5rem;color:#ff5f00"></i>
                    </div>
                    <h5 id="preview-title" class="fw-bold mb-2" style="color:#0a2a66">Başlıq</h5>
                    <p id="preview-desc" class="text-muted mb-0" style="font-size:.9rem;line-height:1.6">Açıqlama mətni burada görünəcək...</p>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
.icon-option input:checked + .icon-box {
    background: #eff6ff;
    border-color: #3b82f6 !important;
    color: #1d4ed8;
}
.icon-box { border-color: #e2e8f0 !important; }
.icon-box:hover { background: #f8fafc; border-color: #94a3b8 !important; }
</style>
@endpush

@push('scripts')
<script>
const colorMap = {
    orange: { bg: '#fff4e5', border: '#fed7a0', dot: '#ff5f00' },
    blue:   { bg: '#eff6ff', border: '#bfdbfe', dot: '#3b82f6' },
    green:  { bg: '#f0fdf4', border: '#bbf7d0', dot: '#22c55e' },
    purple: { bg: '#faf5ff', border: '#e9d5ff', dot: '#a855f7' },
    red:    { bg: '#fff1f2', border: '#fecdd3', dot: '#ef4444' },
};

const iconInput  = document.getElementById('icon-manual');
const prevIcon   = document.getElementById('preview-icon');
const prevWrap   = document.getElementById('preview-icon-wrap');
const prevTitle  = document.getElementById('preview-title');
const prevDesc   = document.getElementById('preview-desc');

function syncIconRadios(val) {
    document.querySelectorAll('input[name="icon"]').forEach(r => {
        r.checked = (r.value === val);
    });
    iconInput.value = val;
}

// Radio click → update hidden input & manual field
document.querySelectorAll('input[name="icon"]').forEach(r => {
    r.addEventListener('change', () => {
        iconInput.value = r.value;
        updateIconPreview(r.value);
    });
});

// Manual field → sync radios
iconInput.addEventListener('input', () => {
    const val = iconInput.value.trim();
    syncIconRadios(val);
    updateIconPreview(val);
    // sync hidden name=icon for submission
    const hidden = document.querySelector('input[name="icon"][type="radio"]:checked');
    if (!hidden) {
        // add a hidden input dynamically if no radio matches
        let h = document.getElementById('icon-hidden-fallback');
        if (!h) { h = document.createElement('input'); h.type='hidden'; h.name='icon'; h.id='icon-hidden-fallback'; iconInput.form.appendChild(h); }
        h.value = val;
    }
});

function updateIconPreview(cls) {
    prevIcon.className = 'bi ' + cls;
}

// Color change
document.querySelectorAll('input[name="color"]').forEach(r => {
    r.addEventListener('change', () => updateColorPreview(r.value));
});

function updateColorPreview(color) {
    const c = colorMap[color] || colorMap.orange;
    prevIcon.style.color = c.dot;
    prevWrap.style.background = c.bg;
    prevWrap.style.borderColor = c.border + '!important';
}

// Title & desc live update
document.querySelector('input[name="title"]').addEventListener('input', e => {
    prevTitle.textContent = e.target.value || 'Başlıq';
});
document.querySelector('textarea[name="description"]').addEventListener('input', e => {
    prevDesc.textContent = e.target.value || 'Açıqlama mətni burada görünəcək...';
});

// Init
const initColor = document.querySelector('input[name="color"]:checked')?.value || 'orange';
updateColorPreview(initColor);
const initIcon = document.querySelector('input[name="icon"]:checked')?.value || 'bi-lightning-charge';
updateIconPreview(initIcon);
const initTitle = document.querySelector('input[name="title"]').value;
if (initTitle) prevTitle.textContent = initTitle;
const initDesc = document.querySelector('textarea[name="description"]').value;
if (initDesc) prevDesc.textContent = initDesc;
</script>
@endpush
@endsection
