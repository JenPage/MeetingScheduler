<?php
namespace Messages;

use Messages\MessageFactory;

class MessageMaker {

    protected $messageTypes = array();
    protected $message;
    protected $subject;
    protected $type;
    protected $body;
    protected $status;
    protected $to;
    protected $from;

    public function __construct()
    {
        $this->message = new MessageFactory();
    }


    public function make($model=null)
    {

        return $message = $this->message->factory($model);
       // $this->messageTypes[]=$message->create($this->type, $this->subject, $this->body, $this->to, $this->from);
    }

    public function getMessageTypes()
    {
        return $this->messageTypes;
    }
}