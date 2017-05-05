<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use \App\Articles;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {

    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
//        $this->app->bind(
//            'Illuminate\Contracts\Auth\Register',
//            'App\Services\Register'
//        );
    }
}
