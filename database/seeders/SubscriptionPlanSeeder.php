<?php

namespace Database\Seeders;

use App\Models\SubscriptionPlan;
use Illuminate\Database\Seeder;

class SubscriptionPlanSeeder extends Seeder
{
    public function run(): void
    {
        $plans = [
            ['name' => 'Sade', 'price' => 5.00, 'usage_limit' => 3],
            ['name' => 'Gold', 'price' => 12.00, 'usage_limit' => 10],
            ['name' => 'Premium', 'price' => 20.00, 'usage_limit' => 20],
        ];

        foreach ($plans as $plan) {
            SubscriptionPlan::query()->updateOrCreate(
                ['name' => $plan['name']],
                $plan
            );
        }
    }
}
