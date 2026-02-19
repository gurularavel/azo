<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\UserSubscription;

class RevenueReportController extends Controller
{
    public function index()
    {
        $daily = UserSubscription::query()
            ->selectRaw('DATE(COALESCE(activated_at, created_at)) as period')
            ->selectRaw('SUM(price_paid) as amount')
            ->selectRaw('COUNT(*) as subscriptions')
            ->groupBy('period')
            ->orderByDesc('period')
            ->limit(30)
            ->get();

        $monthly = UserSubscription::query()
            ->selectRaw("DATE_FORMAT(COALESCE(activated_at, created_at), '%Y-%m') as period")
            ->selectRaw('SUM(price_paid) as amount')
            ->selectRaw('COUNT(*) as subscriptions')
            ->groupBy('period')
            ->orderByDesc('period')
            ->limit(12)
            ->get();

        $chartRows = $daily->reverse()->values();

        return view('admin.reports.revenue', [
            'daily' => $daily,
            'monthly' => $monthly,
            'chartLabels' => $chartRows->pluck('period'),
            'chartData' => $chartRows->pluck('amount'),
        ]);
    }
}
