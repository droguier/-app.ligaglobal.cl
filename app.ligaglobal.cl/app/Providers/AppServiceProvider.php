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
        // Agrega la ruta personalizada para las vistas
        $this->loadViewsFrom(app_path('Http/Resources/views'), 'LigaGlobal');
    }
}
