<?php
abstract class HomeChecker{
    protected $successor;

    public abstract function check(HomeStatus $home);


    public function setSuccessor(HomeChecker $successor)
    {
        $this->successor = $successor;
    }


    public function next(HomeStatus $home)
    {
        if($this->successor)
        {
            $this->successor->check($home);
        }
    }
}

class Locks extends HomeChecker{
    public function check(HomeStatus $home)
    {
        if(!$home->locked)
        {
            throw new \Exception('The doors are not locked');
        }

        $this->next($home);
    }
}

class Lights extends HomeChecker{

    public function check(HomeStatus $home)
    {
        if(!$home->lightsOff)
        {
            throw new \Exception('The lights are on');
        }

        $this->next($home);
    }
}

class Alarm extends HomeChecker{
    public function check(HomeStatus $home)
    {
        if(!$home->alarmOn)
        {
            throw new \Exception('The alarm hasnt been set');
        }

        $this->next($home);
    }
}

class HomeStatus{
    public $alarmOn = true;
    public $locked = false;
    public $lightsOff = true;
}

//set up objects different ways to handle the request
//any of these objects can slice through the chain
$locks = new Locks;
$lights = new Lights;
$alarm = new Alarm;


$locks->setSuccessor($lights);
$lights->setSuccessor($alarm);


//$status = new HomeStatus;

$locks->check(new HomeStatus);

