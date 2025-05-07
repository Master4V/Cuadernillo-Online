<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Auth;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * Define your route model bindings, pattern filters, etc.
     */
    //public const HOME = '/dashboard'; // o tu ruta por defecto
    protected function redirectTo()
    {
        $user = Auth::user();

        if ($user->hasRole('alumno')) {
            return '/alumno/dashboard';
        } elseif ($user->hasRole('profesor')) {
            return '/profesor/dashboard';
        }

        return '/'; // fallback si no tiene rol válido
    }
    
    public function boot(): void
    {
        // En el método boot() de tu provider:
        $this->configureRateLimiting();
        Route::aliasMiddleware('role', \App\Http\Middleware\CheckRole::class);

        $this->routes(function () {
            Route::middleware('api')
                ->prefix('api')
                ->group(base_path('routes/api.php'));

            Route::middleware(['web', 'role:alumno'])
                ->prefix('alumno')
                ->name('alumno.')
                ->group(base_path('routes/alumno.php'));

            Route::middleware(['web', 'role:profesor'])
                ->prefix('profesor')
                ->name('profesor.')
                ->group(base_path('routes/profesor.php'));

            Route::middleware('web')
                ->group(base_path('routes/web.php'));
        });

        Route::aliasMiddleware('role', \App\Http\Middleware\CheckRole::class);
    }

    /**
     * Configure the rate limiters for the application.
     */
    protected function configureRateLimiting(): void
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });
    }
}
