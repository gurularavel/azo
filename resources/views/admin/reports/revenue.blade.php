@extends('layouts.admin')

@section('title', __('messages.revenue_reports'))

@section('content')
<div class="d-flex align-items-center justify-content-between mb-3">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">{{ __('messages.admin_dashboard') }}</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ __('messages.revenue_reports') }}</li>
        </ol>
    </nav>
    <a class="btn btn-outline-dark btn-sm" href="{{ route('admin.dashboard') }}">{{ __('messages.back_to_dashboard') }}</a>
</div>

<h3 class="mb-3">{{ __('messages.revenue_reports') }}</h3>

<div class="card shadow-sm mb-4">
    <div class="card-body">
        <h5 class="mb-3">{{ __('messages.daily_report') }}</h5>
        <div class="revenue-chart">
            <canvas id="revenue-chart"></canvas>
        </div>
    </div>
</div>

<div class="row g-3">
    <div class="col-lg-6">
        <div class="card shadow-sm h-100">
            <div class="card-header bg-white">
                <h6 class="mb-0">{{ __('messages.daily_report') }}</h6>
            </div>
            <div class="table-responsive">
                <table class="table table-striped mb-0">
                    <thead>
                        <tr>
                            <th>{{ __('messages.date') }}</th>
                            <th>{{ __('messages.subscriptions_count') }}</th>
                            <th>{{ __('messages.revenue') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                    @forelse($daily as $row)
                        <tr>
                            <td>{{ $row->period }}</td>
                            <td>{{ $row->subscriptions }}</td>
                            <td>{{ number_format((float) $row->amount, 2) }} ₼</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="text-center text-muted py-4">{{ __('messages.no_data') }}</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="card shadow-sm h-100">
            <div class="card-header bg-white">
                <h6 class="mb-0">{{ __('messages.monthly_report') }}</h6>
            </div>
            <div class="table-responsive">
                <table class="table table-striped mb-0">
                    <thead>
                        <tr>
                            <th>{{ __('messages.month') }}</th>
                            <th>{{ __('messages.subscriptions_count') }}</th>
                            <th>{{ __('messages.revenue') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                    @forelse($monthly as $row)
                        <tr>
                            <td>{{ $row->period }}</td>
                            <td>{{ $row->subscriptions }}</td>
                            <td>{{ number_format((float) $row->amount, 2) }} ₼</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="text-center text-muted py-4">{{ __('messages.no_data') }}</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .revenue-chart {
        position: relative;
        height: 260px;
    }
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
<script>
    const chartCanvas = document.getElementById('revenue-chart');
    if (chartCanvas) {
        const labels = @json($chartLabels);
        const data = @json($chartData);
        new Chart(chartCanvas, {
            type: 'line',
            data: {
                labels,
                datasets: [{
                    label: '{{ __('messages.revenue') }}',
                    data,
                    borderColor: '#1f3b53',
                    backgroundColor: 'rgba(31, 59, 83, 0.12)',
                    fill: true,
                    tension: 0.3,
                }],
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false,
                    },
                },
                scales: {
                    y: {
                        ticks: {
                            callback: function (value) {
                                return value + ' ₼';
                            },
                        },
                    },
                },
            },
        });
    }
</script>
@endpush
