<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Schema;
use App\Models\Setting;
use Illuminate\Support\Facades\Config;

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
        try {
            if (Schema::hasTable('settings')) {
                $appSettings = Setting::first();
                if ($appSettings) {
                    View::share('appSettings', $appSettings);

                    if ($appSettings->timezone) {
                        date_default_timezone_set($appSettings->timezone);
                        Config::set('app.timezone', $appSettings->timezone);
                    }
                } else {
                    View::share('appSettings', null);
                }
            }
        } catch (\Exception $e) {
            // Ignore during migrations or initial setup
        }
    }
}
