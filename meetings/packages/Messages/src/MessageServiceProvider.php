<?php

namespace Messages;
use Messages\Messages;
use Illuminate\Support\ServiceProvider;



class MessageServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        include __DIR__.'/routes.php';
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {

        $this->app->singleton('messages', function () {
            return new Messages();
        });

        $this->app->singleton('MessageLogger', function(){
            return new MessageLogger(
                config('messages.environment'),
                config('messages.logfile')
            );
        });

    }


//    protected static $instance;
//
//    public static function getInstance()
//    {
//        if (is_null(static::$instance)) {
//            static::$instance = new static();
//        }
//
//        return static::$instance;
//    }


}
