<?php

namespace Alsharie\AdenBankPayment;

use Illuminate\Support\ServiceProvider;

class  AdenBankServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = true;

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        // Config file
        $this->publishes([
            __DIR__ . '/../config/adenBank.php' => config_path('adenBank.php'),
        ]);

        // Merge config
        $this->mergeConfigFrom(__DIR__ . '/../config/adenBank.php', 'AdenBank');
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(AdenBank::class, function () {
            return new AdenBank();
        });
    }
}