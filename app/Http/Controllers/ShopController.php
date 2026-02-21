<?php

namespace App\Http\Controllers;

use App\Models\QrSession;
use App\Models\QrTransaction;
use App\Models\Shop;
use App\Models\ShopCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ShopController extends Controller
{
    public function index()
    {
        $categoryId = request()->integer('category_id');

        $shops = Shop::query()
            ->with(['category', 'city'])
            ->when($categoryId, fn ($query) => $query->where('shop_category_id', $categoryId))
            ->orderBy('name')
            ->get();
        $categories = ShopCategory::query()
            ->withCount('shops')
            ->orderBy('name')
            ->get();
        $totalShops = Shop::query()->count();

        return view('shops.index', [
            'shops' => $shops,
            'categories' => $categories,
            'selectedCategoryId' => $categoryId,
            'totalShops' => $totalShops,
        ]);
    }

    public function show(Request $request, Shop $shop)
    {
        $shop->load(['images', 'category', 'city']);
        $user = $request->user();
        $subscription = null;
        $qrSession = null;

        if ($user) {
            $subscription = $user->activeSubscription()
                ->where('usage_remaining', '>', 0)
                ->first();

            if ($subscription) {
                $qrSession = QrSession::query()
                    ->where('user_id', $user->id)
                    ->where('shop_id', $shop->id)
                    ->whereNull('used_at')
                    ->where('expires_at', '>', now())
                    ->latest()
                    ->first();

                if (!$qrSession) {
                    $qrSession = QrSession::create([
                        'user_id' => $user->id,
                        'shop_id' => $shop->id,
                        'token' => hash('sha256', Str::uuid()->toString().Str::random(12)),
                        'expires_at' => now()->addMinutes(10),
                    ]);
                }
            }
        }

        return view('shops.show', [
            'shop' => $shop,
            'subscription' => $subscription,
            'qrSession' => $qrSession,
        ]);
    }

    public function scan(Request $request, string $token)
    {
        $qrSession = QrSession::query()
            ->with(['user', 'shop'])
            ->where('token', $token)
            ->whereNull('used_at')
            ->where('expires_at', '>', now())
            ->first();

        if (!$qrSession) {
            return view('qr.scan-result', [
                'success' => false,
                'shop'    => null,
                'message' => __('messages.qr_invalid'),
                'remaining' => null,
            ]);
        }

        $result = DB::transaction(function () use ($qrSession) {
            $subscription = $qrSession->user->activeSubscription()->lockForUpdate()->first();

            if (!$subscription || $subscription->usage_remaining < 1) {
                return ['ok' => false, 'remaining' => 0];
            }

            $subscription->decrement('usage_remaining');
            $subscription->refresh();
            $qrSession->update(['used_at' => now()]);

            QrTransaction::create([
                'user_id'          => $qrSession->user_id,
                'shop_id'          => $qrSession->shop_id,
                'qr_session_id'    => $qrSession->id,
                'discount_percent' => $qrSession->shop->discount_percent,
                'scanned_at'       => now(),
            ]);

            return ['ok' => true, 'remaining' => $subscription->usage_remaining];
        });

        if (!$result['ok']) {
            return view('qr.scan-result', [
                'success'   => false,
                'shop'      => $qrSession->shop,
                'message'   => __('messages.qr_limit_reached'),
                'remaining' => null,
            ]);
        }

        return view('qr.scan-result', [
            'success'   => true,
            'shop'      => $qrSession->shop,
            'message'   => __('messages.qr_scan_success', ['count' => $result['remaining']]),
            'remaining' => $result['remaining'],
        ]);
    }

    public function verify(Request $request, Shop $shop)
    {
        $request->validate([
            'token' => ['required', 'string'],
        ]);

        $user = $request->user();

        $qrSession = QrSession::query()
            ->where('token', $request->input('token'))
            ->where('user_id', $user->id)
            ->where('shop_id', $shop->id)
            ->whereNull('used_at')
            ->where('expires_at', '>', now())
            ->first();

        if (!$qrSession) {
            return back()->withErrors(['token' => __('messages.qr_invalid')]);
        }

        $result = DB::transaction(function () use ($user, $shop, $qrSession) {
            $subscription = $user->activeSubscription()->lockForUpdate()->first();

            if (!$subscription || $subscription->usage_remaining < 1) {
                return false;
            }

            $subscription->decrement('usage_remaining');
            $qrSession->update(['used_at' => now()]);

            QrTransaction::create([
                'user_id' => $user->id,
                'shop_id' => $shop->id,
                'qr_session_id' => $qrSession->id,
                'discount_percent' => $shop->discount_percent,
                'scanned_at' => now(),
            ]);

            return true;
        });

        if (!$result) {
            return back()->withErrors(['token' => __('messages.no_usage_left')]);
        }

        return back()->with('status', __('messages.qr_verified'));
    }
}
