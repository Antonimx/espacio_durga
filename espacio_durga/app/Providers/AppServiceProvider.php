<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\Usuario;
use Carbon\Carbon;

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
        Gate::define('admin-gestion', function (Usuario $usuario) {
            return $usuario->esAdmin();
        });
        Carbon::setLocale('es'); 
        setlocale(LC_TIME, 'es_ES.UTF-8');
    }
}
