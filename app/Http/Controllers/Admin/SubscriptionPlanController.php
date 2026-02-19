<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SubscriptionPlan;
use Illuminate\Http\Request;

class SubscriptionPlanController extends Controller
{
    public function index()
    {
        $plans = SubscriptionPlan::query()->orderBy('usage_limit')->get();

        return view('admin.plans.index', [
            'plans' => $plans,
        ]);
    }

    public function create()
    {
        return view('admin.plans.form', [
            'plan' => new SubscriptionPlan(),
        ]);
    }

    public function store(Request $request)
    {
        $data = $this->validateData($request);
        SubscriptionPlan::create($data);

        return redirect()->route('admin.plans.index')->with('status', __('messages.plan_saved'));
    }

    public function edit(SubscriptionPlan $plan)
    {
        return view('admin.plans.form', [
            'plan' => $plan,
        ]);
    }

    public function update(Request $request, SubscriptionPlan $plan)
    {
        $data = $this->validateData($request, $plan->id);

        $plan->update($data);

        return redirect()->route('admin.plans.index')->with('status', __('messages.plan_updated'));
    }

    public function destroy(SubscriptionPlan $plan)
    {
        $plan->delete();

        return redirect()->route('admin.plans.index')->with('status', __('messages.plan_deleted'));
    }

    private function validateData(Request $request, ?int $planId = null): array
    {
        return $request->validate([
            'name' => ['required', 'string', 'max:100', 'unique:subscription_plans,name'.($planId ? ','.$planId : '')],
            'price' => ['required', 'numeric', 'min:0'],
            'usage_limit' => ['required', 'integer', 'min:1'],
        ]);
    }
}
