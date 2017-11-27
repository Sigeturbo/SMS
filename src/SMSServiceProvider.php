<?php

namespace SigeTurbo\SMS;

use Illuminate\Support\ServiceProvider;

class SMSServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/Config/sms.php' => config_path('sms.php'),
        ], 'config');
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //Config
        $this->mergeConfigFrom( __DIR__.'/Config/sms.php', 'sms');
        $this->app["sms"] = $this->app->singleton('sms',function ($app) {
            return new SMS;
        });
    }
}
