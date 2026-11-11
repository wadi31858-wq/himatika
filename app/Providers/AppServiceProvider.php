<?php

namespace App\Providers;

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
        \Illuminate\Support\Facades\View::composer('*', function ($view) {
            $profile = \App\Models\Profile::first();
            $settings = [];
            try {
                if (\Illuminate\Support\Facades\Schema::hasTable('site_settings')) {
                    $settings = \App\Models\SiteSetting::pluck('value', 'key')->toArray();
                }
            } catch (\Throwable $e) {
                // fallback
            }

            $view->with('globalProfile', $profile)
                 ->with('siteSettings', $settings);
        });
    }
}
