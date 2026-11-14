<?php

namespace App\Providers;

use App\Models\Setting;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

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
        View::composer('*', function ($view) {
            $businessName = 'JewelERP';
            $tagline = 'Jewellery Suite';

            if (Schema::hasTable('settings')) {
                try {
                    $businessName = Setting::get('business_name', 'JewelERP') ?: 'JewelERP';
                    $tagline = Setting::get('tagline', 'Jewellery Suite') ?: 'Jewellery Suite';
                } catch (\Throwable) {
                    // fallback
                }
            }

            $view->with('businessName', $businessName);
            $view->with('businessTagline', $tagline);
        });
    }
}
