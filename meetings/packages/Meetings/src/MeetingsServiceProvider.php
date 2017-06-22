<?php

namespace Meetings;

use Meetings;
use Illuminate\Support\ServiceProvider;


class MeetingsServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {

        require __DIR__ . '/../vendor/autoload.php';

    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {

        $this->app->singleton('Meetings', function () {
            return new Meetings();
        });
        include __DIR__.'/routes.php';
        $this->app->make('Meetings\Controllers\MeetingsController');

    }



}
