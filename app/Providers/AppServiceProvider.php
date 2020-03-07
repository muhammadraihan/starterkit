<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use URL;

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
        // fix mysql string length error
        Schema::defaultStringLength(191);
        // force apps to use secure protocol
        if($this->app->environment('production')){
            URL::forceScheme('https');
        }
    }
}
