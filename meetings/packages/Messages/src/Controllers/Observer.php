<?php

//publisher
interface Subject{
    public function attach($observable);
    public function detach($index);
    public function notify();
}


//subscriber
interface Observer{

    public function handle();
}

//concrete classes

class Login implements Subject{

    protected $observers = [];

    public function attach($observable)
    {
        if(is_array($observable))
        {
            foreach($observable as $observer)
            {
                if(! $observer instanceof Observer)
                {
                    throw new Exception;
                }
                $this->attach($observer);
            }
            return;
        }
        $this->observers[] = $observable;

        return $this;
    }

    public function detach($index)
    {
        unset($this->observers[$index]);
    }

    public function notify()
    {
        foreach($this->observers as $observer)
        {
            $observer->handle();
        }
    }

    public function fire()
    {
        //perform login
        $this->notify();
    }
}

class LogHandler implements Observer{

    public function handle()
    {
        var_dump('log something important');
    }
}

class EmailNotifier implements Observer{

    public function handle()
    {
        var_dump('fire off email');
    }
}

$login = new Login;


$login->attach([
    new LogHandler,
    new EmailNotifier
]);

$login->fire();



Event::listen('user.login', function(){

   var_dump('fire off email');

});


Event::listen('user.login', function(){

    var_dump('do some reporting');

});

get('/', function(){
   Event::fire('user.login');
});