<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        View::composer('voyager::auth.login', function ($view) {
            if (view()->exists('vendor.voyager.auth.login')) {
                $view->setPath(resource_path('views/vendor/voyager/auth/login.blade.php'));
            }
        });
    }
}
