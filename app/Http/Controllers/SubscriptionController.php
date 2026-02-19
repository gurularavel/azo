<?php

namespace App\Http\Controllers;

use App\Models\SubscriptionPlan;
use App\Models\UserSubscription;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    public function index(Request $request)
    {
        $plans = SubscriptionPlan::query()->orderBy('usage_limit')->get();
        $current = $request->user()->activeSubscription()->with('plan')->first();
        $transactions = $request->user()
            ->qrTransactions()
            ->with('shop')
            ->latest('scanned_at')
            ->take(10)
            ->get();

        return view('subscriptions.index', [
            'plans' => $plans,
            'current' => $current,
            'transactions' => $transactions,
        ]);
    }

    public function purchase(Request $request, SubscriptionPlan $plan)
    {
        $user = $request->user();

        UserSubscription::query()
            ->where('user_id', $user->id)
            ->where('status', 'active')
            ->update(['status' => 'inactive']);

        UserSubscription::create([
            'user_id' => $user->id,
            'plan_id' => $plan->id,
            'price_paid' => $plan->price,
            'usage_limit' => $plan->usage_limit,
            'usage_remaining' => $plan->usage_limit,
            'status' => 'active',
            'activated_at' => now(),
        ]);

        return redirect()->route('subscriptions.index')->with('status', __('messages.subscription_active'));
    }
}
