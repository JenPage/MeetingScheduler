<?php

namespace Billing;
use Billing\Billing;
use Billing\PlanInterface;
use Illuminate\Support\ServiceProvider;

class BillingServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        include __DIR__.'/routes.php';

        $this->app->bind('Billing\PlanInterface', 'Billing\MessagePlan');

    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {

        $this->app->singleton('billing', function () {
            return new Billing();
        });

        $this->app->singleton('BillingLogger', function(){
            return new BillingLogger(
                config('billing.environment'),
                config('billing.logfile')
            );
        });

    }



}
