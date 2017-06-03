<?php
namespace Messages;

interface MessageMediatorInterface
{
    public function send($message, $addressee);
}