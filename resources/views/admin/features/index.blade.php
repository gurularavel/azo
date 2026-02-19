@extends('layouts.admin')
@section('title', 'Xüsusiyyət Kartları')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="mb-0 fw-bold">Niyə Biz? — Kartlar</h4>
    <a href="{{ route('admin.features.create') }}" class="btn btn-primary btn-sm">
        <i class="bi bi-plus-lg me-1"></i> Yeni Kart
    </a>
</div>

@php
$colorMap = [
    'orange' => ['bg' => '#fff4e5', 'border' => '#fed7a0', 'dot' => '#ff5f00'],
    'blue'   => ['bg' => '#eff6ff', 'border' => '#bfdbfe', 'dot' => '#3b82f6'],
    'green'  => ['bg' => '#f0fdf4', 'border' => '#bbf7d0', 'dot' => '#22c55e'],
    'purple' => ['bg' => '#faf5ff', 'border' => '#e9d5ff', 'dot' => '#a855f7'],
    'red'    => ['bg' => '#fff1f2', 'border' => '#fecdd3', 'dot' => '#ef4444'],
];
@endphp

<div class="card shadow-sm border-0">
    <div class="card-body p-0">
        @if($features->isEmpty())
            <div class="text-center py-5 text-muted">
                <i class="bi bi-grid-3x3-gap fs-1 mb-3 d-block"></i>
                Hələ heç bir kart yoxdur.
            </div>
        @else
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th style="width:50px">#</th>
                        <th style="width:60px">İkon</th>
                        <th>Başlıq</th>
                        <th>Açıqlama</th>
                        <th style="width:80px">Sıra</th>
                        <th style="width:80px">Status</th>
                        <th style="width:110px"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($features as $feature)
                    @php $c = $colorMap[$feature->color] ?? $colorMap['orange']; @endphp
                    <tr>
                        <td class="text-muted small">{{ $feature->id }}</td>
                        <td>
                            <div class="d-flex align-items-center justify-content-center rounded-3"
                                 style="width:42px;height:42px;background:{{ $c['bg'] }};border:1px solid {{ $c['border'] }}">
                                <i class="bi {{ $feature->icon }}" style="color:{{ $c['dot'] }};font-size:1.2rem;"></i>
                            </div>
                        </td>
                        <td class="fw-semibold">{{ $feature->title }}</td>
                        <td class="text-muted small" style="max-width:300px">
                            <span class="text-truncate d-block" style="max-width:280px">
                                {{ $feature->description ?? '—' }}
                            </span>
                        </td>
                        <td class="text-center">{{ $feature->sort_order }}</td>
                        <td>
                            @if($feature->is_active)
                                <span class="badge bg-success-subtle text-success border border-success-subtle">Aktiv</span>
                            @else
                                <span class="badge bg-secondary-subtle text-secondary border border-secondary-subtle">Gizli</span>
                            @endif
                        </td>
                        <td class="text-end">
                            <a href="{{ route('admin.features.edit', $feature) }}" class="btn btn-sm btn-outline-primary me-1">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <form method="post" action="{{ route('admin.features.destroy', $feature) }}"
                                  class="d-inline" onsubmit="return confirm('Silinsin?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @endif
    </div>
</div>

<div class="mt-3 text-muted small">
    <i class="bi bi-info-circle me-1"></i>
    Kartlar sıra nömrəsinə (kiçikdən böyüyə) görə göstərilir.
</div>
@endsection
