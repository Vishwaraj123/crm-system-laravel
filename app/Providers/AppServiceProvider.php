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
        Schema::defaultStringLength(191);

        // Share settings globally with every view
        View::composer('*', function ($view) {
            try {
                $appSettings = Setting::allAsArray();
            } catch (\Exception $e) {
                // Table may not exist yet during migrations
                $appSettings = [];
            }
            $view->with('appSettings', $appSettings);
        });
    }
}
