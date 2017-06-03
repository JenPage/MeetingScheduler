<?php
namespace Messages;

use Messages\DirectMessage;
use Messages\MailMessage;
use Messages\BroadcastMessage;

class MessageFactory
{
    protected $message;


    public function factory($model=null)
    {
        // for some reason this doesn't work
        // return $this->message = new $model();

        // but this does
        switch($model)
        {
            case 'DirectMessage':
                return new DirectMessage();
            case "MailMessage":
                return new MailMessage();
            case "BroadcastMessage":
                return new BroadcastMessage();
            default:
                return new MailMessage();
        }

    }

}

