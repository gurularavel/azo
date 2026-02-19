<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\QrTransaction;
use App\Models\User;
use App\Models\UserSubscription;

class DashboardController extends Controller
{
    public function index()
    {
        $totalUsers = User::query()->count();
        $activeSubscriptions = UserSubscription::query()->where('status', 'active')->count();
        $revenue = UserSubscription::query()->sum('price_paid');
        $totalTransactions = QrTransaction::query()->count();

        return view('admin.dashboard', [
            'totalUsers' => $totalUsers,
            'activeSubscriptions' => $activeSubscriptions,
            'revenue' => $revenue,
            'totalTransactions' => $totalTransactions,
        ]);
    }
}
