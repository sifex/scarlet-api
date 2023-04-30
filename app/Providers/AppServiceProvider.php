<?php

namespace App\Providers;

use App\Settings;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Inertia\Inertia;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        Schema::defaultStringLength(191);

        Inertia::share([
            // ...
            'locale' => function () {
                return app()->getLocale();
            },
            'language' => function () {
                return [
                    'app' => __('app'),
                ];
            },
            // ...
        ]);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
