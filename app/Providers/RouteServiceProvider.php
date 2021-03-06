<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to the "home" route for your application.
     *
     * This is used by Laravel authentication to redirect users after login.
     *
     * @var string
     */
    public const HOME = '/home';

    /**
     * The controller namespace for the application.
     *
     * When present, controller route declarations will automatically be prefixed with this namespace.
     *
     * @var string|null
     */
    // protected $namespace = 'App\\Http\\Controllers';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        $this->configureRateLimiting();

        $this->routes(function () {
            Route::prefix('api')
                ->middleware('api')
                ->namespace($this->namespace)
                ->group(base_path('routes/api.php'));

            Route::middleware('web')
                ->namespace($this->namespace)
                ->group(base_path('routes/web.php'));
        });
    }

    /**
     * Configure the rate limiters for the application.
     *
     * @return void
     */
    protected function configureRateLimiting()
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by(optional($request->user())->id ?: $request->ip());
        });

        // RateLimiter::for('login', function (Request $request) {
        //     return $request->user()
        //         ? Limit::perMinute(100)->by($request->user()->id)
        //         : Limit::perMinute(10)->by($request->ip());
        // });
        // RateLimiter::for('login', function (Request $request) {
        //     return [
        //         Limit::perMinute(500),
        //         Limit::perMinute(3)->by($request->input('email')),
        //     ];
        // });
        if (!App::environment('local')) {
            RateLimiter::for('login', function (Request $request) {
                return [
                    Limit::perMinutes(60, 50)->by($request->ip()),
                    Limit::perMinutes(1, 5)->by($request->input('email'))->response(function () {
                        return response([
                            'message' => 'Unauthorized.'
                        ], 401);
                    }),
                ];
            });
        } else {
            RateLimiter::for('login', function (Request $request) {
                return [
                    // Limit::perMinutes(60, 50)->by($request->ip()),
                    // Limit::perMinutes(1, 5)->by($request->input('email'))->response(function () {
                    //     return response([
                    //         'message' => 'Unauthorized.'
                    //     ], 401);
                    // }),
                    Limit::none()->by($request->input('email'))->response(function () {
                        return response([
                            'message' => 'Unauthorized.'
                        ], 401);
                    }),
                ];
            });
        }
    }
}
