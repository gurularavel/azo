@extends('layouts.app')

@section('title', 'Abunəlik - ' . ($siteSettings?->site_name ?? 'QR Endirim'))

@section('content')
<div class="container mx-auto px-4 py-16 pb-24">

    <div class="mb-12">
        <h1 class="text-4xl font-extrabold text-secondary mb-2">
            İstifadə <span class="text-primary">Tarixçəsi</span>
        </h1>
        <p class="text-slate-500 font-medium">Paketiniz və bütün endirim əməliyyatlarınızın siyahısı</p>
    </div>

    <div class="grid lg:grid-cols-12 gap-12 items-start">

        {{-- Subscription Plans + Current Status --}}
        <div class="lg:col-span-4 space-y-6">

            {{-- Current Plan Status --}}
            <div class="bg-white p-8 rounded-2xl shadow-xl border border-slate-100 relative overflow-hidden">
                <div class="hidden md:block absolute top-0 right-0 w-32 h-32 bg-primary/5 rounded-full -mr-16 -mt-16"></div>
                <h2 class="text-xl font-bold text-secondary mb-6">Paket Vəziyyəti</h2>

                @if($current)
                    <div class="mb-6 p-6 bg-slate-50 rounded-sm border border-slate-100">
                        <p class="text-slate-400 text-sm font-bold uppercase tracking-wider mb-2">Aktiv Paket</p>
                        <h3 class="text-2xl font-black text-secondary">{{ $current->plan?->name ?? 'Paket' }}</h3>
                        @if($current->usage_limit > 0)
                            <div class="mt-4">
                                @php $usedPercent = $current->usage_limit > 0 ? (($current->usage_limit - $current->usage_remaining) / $current->usage_limit) * 100 : 0; @endphp
                                <div class="w-full h-3 bg-slate-200 rounded-full overflow-hidden">
                                    <div class="h-full bg-primary rounded-full transition-all" style="width: {{ $usedPercent }}%"></div>
                                </div>
                                <p class="mt-2 text-primary font-bold">
                                    {{ $current->usage_limit - $current->usage_remaining }} / {{ $current->usage_limit }} istifadə edilib
                                </p>
                                <p class="text-slate-400 text-sm mt-1">{{ $current->usage_remaining }} istifadə qalıb</p>
                            </div>
                        @else
                            <p class="mt-2 text-green-600 font-bold">Limitsiz istifadə</p>
                        @endif
                        @if($current->expires_at)
                            <p class="text-slate-400 text-sm mt-2">Bitmə tarixi: {{ $current->expires_at->format('d.m.Y') }}</p>
                        @endif
                    </div>
                @else
                    <div class="mb-6 p-6 bg-slate-50 rounded-sm border border-slate-100 text-center">
                        <p class="text-slate-500">Aktiv paketiniz yoxdur</p>
                    </div>
                @endif

                <a href="#plans"
                    class="w-full mt-2 py-4 bg-primary text-white font-bold rounded-sm hover:bg-primary-hover transition-all shadow-lg shadow-orange-500/20 text-center block">
                    Yeni Paket Al
                </a>
            </div>

            {{-- Available Plans --}}
            <div id="plans" class="space-y-4">
                <h2 class="text-xl font-bold text-secondary">Paketlər</h2>
                @foreach($plans as $plan)
                <div class="bg-white p-6 rounded-2xl shadow-lg border {{ $current && $current->plan_id === $plan->id ? 'border-primary' : 'border-slate-100' }} relative">
                    @if($current && $current->plan_id === $plan->id)
                        <span class="absolute -top-3 left-4 bg-primary text-white text-xs font-bold px-3 py-1 rounded-full">Aktiv</span>
                    @endif
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-xl font-black text-secondary">{{ $plan->name }}</h3>
                        <div class="text-right">
                            <span class="text-2xl font-extrabold text-secondary">{{ $plan->price > 0 ? $plan->price . '₼' : 'Pulsuz' }}</span>
                            @if($plan->price > 0)
                                <span class="text-slate-400 text-sm block">/ aylıq</span>
                            @endif
                        </div>
                    </div>
                    <p class="text-slate-500 text-sm mb-4">
                        {{ $plan->usage_limit > 0 ? $plan->usage_limit . ' istifadə haqqı' : 'Limitsiz istifadə' }}
                    </p>
                    <form action="{{ route('subscriptions.purchase', $plan) }}" method="post">
                        @csrf
                        <button type="submit"
                            class="w-full py-3 rounded-sm font-bold text-sm transition-all {{ $current && $current->plan_id === $plan->id ? 'bg-slate-100 text-slate-400 cursor-not-allowed' : 'bg-secondary text-white hover:bg-secondary-dark' }}"
                            {{ $current && $current->plan_id === $plan->id ? 'disabled' : '' }}>
                            {{ $current && $current->plan_id === $plan->id ? 'Cari Paket' : 'Seç' }}
                        </button>
                    </form>
                </div>
                @endforeach
            </div>
        </div>

        {{-- Transactions --}}
        <div class="lg:col-span-8">
            <div class="bg-white rounded-sm shadow-xl border border-slate-100 overflow-hidden">
                <div class="p-8 border-b border-slate-50">
                    <h2 class="text-xl font-bold text-secondary">Son Əməliyyatlar</h2>
                </div>

                @if($transactions->isEmpty())
                    <div class="p-12 text-center">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-12 h-12 text-slate-300 mx-auto mb-4">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 9.776c.112-.017.227-.026.344-.026h15.812c.117 0 .232.009.344.026m-16.5 0a2.25 2.25 0 0 0-1.883 2.542l.857 6a2.25 2.25 0 0 0 2.227 1.932H19.05a2.25 2.25 0 0 0 2.227-1.932l.857-6a2.25 2.25 0 0 0-1.883-2.542m-16.5 0V6A2.25 2.25 0 0 1 6 3.75h3.879a1.5 1.5 0 0 1 1.06.44l2.122 2.12a1.5 1.5 0 0 0 1.06.44H18A2.25 2.25 0 0 1 20.25 9v.776" />
                        </svg>
                        <p class="text-slate-400">Hələ heç bir əməliyyat yoxdur</p>
                        <a href="{{ route('shops.index') }}" class="inline-block mt-4 px-6 py-2.5 bg-primary text-white rounded-sm font-bold hover:bg-primary-hover transition-all">
                            Mağazalara bax
                        </a>
                    </div>
                @else
                    <div class="overflow-x-auto">
                        <table class="w-full text-left">
                            <thead>
                                <tr class="bg-slate-50/50">
                                    <th class="px-8 py-5 text-sm font-bold text-slate-400 uppercase tracking-widest">Tarix</th>
                                    <th class="px-8 py-5 text-sm font-bold text-slate-400 uppercase tracking-widest">Mağaza</th>
                                    <th class="px-8 py-5 text-sm font-bold text-slate-400 uppercase tracking-widest">Endirim</th>
                                    <th class="px-8 py-5 text-sm font-bold text-slate-400 uppercase tracking-widest text-right">Status</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-50">
                                @foreach($transactions as $tx)
                                <tr class="hover:bg-slate-50/50 transition-colors">
                                    <td class="px-8 py-6">
                                        <p class="font-bold text-secondary">{{ $tx->scanned_at->format('d F Y') }}</p>
                                        <p class="text-slate-400 text-sm">Saat {{ $tx->scanned_at->format('H:i') }}</p>
                                    </td>
                                    <td class="px-8 py-6">
                                        <div class="flex items-center gap-3">
                                            @if($tx->shop?->logo_path)
                                                <div class="w-10 h-10 rounded-sm border border-slate-100 overflow-hidden">
                                                    <img src="{{ asset('storage/' . $tx->shop->logo_path) }}" class="w-full h-full object-cover">
                                                </div>
                                            @endif
                                            <span class="font-bold">{{ $tx->shop?->name ?? 'Mağaza' }}</span>
                                        </div>
                                    </td>
                                    <td class="px-8 py-6 font-bold text-primary">{{ $tx->discount_percent }}% Endirim</td>
                                    <td class="px-8 py-6 text-right">
                                        <span class="px-3 py-1 bg-green-100 text-green-600 text-xs font-bold rounded-full uppercase">Uğurlu</span>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>

    </div>
</div>
@endsection
