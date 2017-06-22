<?php namespace Message;
namespace Messages\Facades;

use Illuminate\Support\Facades\Facade;

class MessageFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'Messages';
    }
}
