<?php

namespace App\Providers;

use App\Models\SiteSetting;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Throwable;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::useBootstrapFive();

        View::composer('*', function ($view) {
            static $siteSettingsLoaded = false;
            static $siteSettings = null;

            if (!$siteSettingsLoaded) {
                $siteSettingsLoaded = true;

                try {
                    if (Schema::hasTable('site_settings')) {
                        $siteSettings = SiteSetting::query()->first();
                    }
                } catch (Throwable $exception) {
                    $siteSettings = null;
                }
            }

            $view->with('siteSettings', $siteSettings);
        });
    }
}
