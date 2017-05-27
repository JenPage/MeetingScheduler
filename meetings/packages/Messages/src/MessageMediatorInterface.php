<?php

interface MessageMediatorInterface
{
    public function send($message, $addressee);
}