<?php


namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class SupportServiceProvider extends ServiceProvider{
    public function register () {
        $this->app->singleton(\App\Contracts\Support\Sms::class, function ($app) {
            return new \App\Support\Sms($app);
        });
    }

    public function boot () { }
}