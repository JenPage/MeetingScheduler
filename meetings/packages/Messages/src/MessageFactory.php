<?php
namespace Messages;

use Messages\DirectMessage;
use Messages\MailMessage;
use Messages\BroadcastMessage;

class MessageFactory
{
    protected $message;

    /**
     * @param null $model
     * @return \Messages\BroadcastMessage|\Messages\DirectMessage|\Messages\MailMessage
     */
    public function factory($model=null)
    {
        switch($model)
        {
            case 'DirectMessage':
                return new DirectMessage();
            case 'MailMessage':
                return new MailMessage();
            case 'BroadcastMessage':
                return new BroadcastMessage();
            default:
                return new MailMessage();
        }
    }

}

