<?php

use App\Http\Controllers\Admin\BlogController as AdminBlogController;
use App\Http\Controllers\Admin\FeatureController as AdminFeatureController;
use App\Http\Controllers\Admin\CityController as AdminCityController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\HeroSlideController as AdminHeroSlideController;
use App\Http\Controllers\Admin\ProfileController as AdminProfileController;
use App\Http\Controllers\Admin\RevenueReportController as AdminRevenueReportController;
use App\Http\Controllers\Admin\ServiceController as AdminServiceController;
use App\Http\Controllers\Admin\SiteSettingController as AdminSiteSettingController;
use App\Http\Controllers\Admin\ShopCategoryController as AdminShopCategoryController;
use App\Http\Controllers\Admin\ShopController as AdminShopController;
use App\Http\Controllers\Admin\SubscriptionPlanController as AdminSubscriptionPlanController;
use App\Http\Controllers\Admin\TransactionController as AdminTransactionController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\SubscriptionController;
use App\Models\Blog;
use App\Models\Feature;
use App\Models\HeroSlide;
use App\Models\Service;
use App\Models\Shop;
use App\Models\SubscriptionPlan;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $slides = collect();
    $blogs = collect();
    $services = collect();
    $featuredShops = collect();
    $plans = collect();
    $features = collect();

    if (Schema::hasTable('hero_slides')) {
        $slides = HeroSlide::query()
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->orderBy('id')
            ->get();
    }

    if (Schema::hasTable('blogs')) {
        $blogs = Blog::query()
            ->published()
            ->where('show_on_home', true)
            ->latest('published_at')
            ->take(3)
            ->get();
    }

    if (Schema::hasTable('services')) {
        $services = Service::query()
            ->published()
            ->latest('published_at')
            ->take(3)
            ->get();
    }

    if (Schema::hasTable('shops')) {
        $featuredShops = Shop::query()
            ->with('category')
            ->orderBy('name')
            ->take(8)
            ->get();
    }

    if (Schema::hasTable('subscription_plans')) {
        $plans = SubscriptionPlan::query()->orderBy('price')->get();
    }

    if (Schema::hasTable('features')) {
        $features = Feature::active()->orderBy('sort_order')->orderBy('id')->get();
    }

    return view('home', [
        'slides' => $slides,
        'homeBlogs' => $blogs,
        'homeServices' => $services,
        'featuredShops' => $featuredShops,
        'plans' => $plans,
        'features' => $features,
    ]);
})->name('home');

Route::middleware('guest')->group(function () {
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.store');
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.store');
});

Route::get('/otp/verify', [AuthController::class, 'showOtp'])->name('otp.show');
Route::post('/otp/verify', [AuthController::class, 'verifyOtp'])->name('otp.verify');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/shops', [ShopController::class, 'index'])->name('shops.index');
Route::get('/shops/{shop}', [ShopController::class, 'show'])->name('shops.show');
Route::post('/shops/{shop}/verify', [ShopController::class, 'verify'])
    ->middleware('auth')
    ->name('shops.verify');
Route::get('/qr/{token}', [ShopController::class, 'scan'])->name('qr.scan');

Route::get('/contact', [ContactController::class, 'index'])->name('contact');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');

Route::get('/blogs', [BlogController::class, 'index'])->name('blogs.index');
Route::get('/blogs/{blog:slug}', [BlogController::class, 'show'])->name('blogs.show');
Route::get('/services', [ServiceController::class, 'index'])->name('services.index');
Route::get('/services/{service:slug}', [ServiceController::class, 'show'])->name('services.show');

Route::middleware('auth')->group(function () {
    Route::get('/subscriptions', [SubscriptionController::class, 'index'])->name('subscriptions.index');
    Route::post('/subscriptions/{plan}/purchase', [SubscriptionController::class, 'purchase'])->name('subscriptions.purchase');
});

Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');

    Route::resource('shops', AdminShopController::class)->except(['show']);
    Route::resource('shop-categories', AdminShopCategoryController::class)->except(['show']);
    Route::resource('cities', AdminCityController::class)->except(['show']);
    Route::post('cities/{city}/toggle', [AdminCityController::class, 'toggle'])->name('cities.toggle');

    Route::get('users', [AdminUserController::class, 'index'])->name('users.index');
    Route::put('users/{user}', [AdminUserController::class, 'update'])->name('users.update');

    Route::resource('plans', AdminSubscriptionPlanController::class)->except(['show']);
    Route::get('transactions', [AdminTransactionController::class, 'index'])->name('transactions.index');

    Route::resource('blogs', AdminBlogController::class)->except(['show']);
    Route::resource('services', AdminServiceController::class)->except(['show']);

    Route::get('reports/revenue', [AdminRevenueReportController::class, 'index'])->name('reports.revenue');
    Route::get('site-settings', [AdminSiteSettingController::class, 'edit'])->name('site-settings.edit');
    Route::put('site-settings', [AdminSiteSettingController::class, 'update'])->name('site-settings.update');

    Route::resource('hero-slides', AdminHeroSlideController::class)->except(['show']);
    Route::post('hero-slides/order', [AdminHeroSlideController::class, 'order'])->name('hero-slides.order');

    Route::resource('features', AdminFeatureController::class)->except(['show']);

    Route::get('profile', [AdminProfileController::class, 'edit'])->name('profile.edit');
    Route::put('profile', [AdminProfileController::class, 'update'])->name('profile.update');
});
