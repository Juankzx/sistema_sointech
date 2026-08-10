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
        // Configurar idioma español para fechas Carbon
        \Carbon\Carbon::setLocale('es');
        setlocale(LC_TIME, 'es_CL.utf8', 'es_CL', 'spanish');

        // RateLimiters de Seguridad Anti Fuerza Bruta y Escaneo
        \Illuminate\Support\Facades\RateLimiter::for('login', function (\Illuminate\Http\Request $request) {
            return \Illuminate\Cache\RateLimiting\Limit::perMinute(5)->by($request->ip());
        });

        \Illuminate\Support\Facades\RateLimiter::for('public-tracking', function (\Illuminate\Http\Request $request) {
            return \Illuminate\Cache\RateLimiting\Limit::perMinute(30)->by($request->ip());
        });

        \Illuminate\Support\Facades\RateLimiter::for('client-signature', function (\Illuminate\Http\Request $request) {
            return \Illuminate\Cache\RateLimiting\Limit::perMinute(15)->by($request->ip());
        });

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
