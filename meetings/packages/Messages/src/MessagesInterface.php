<?php
namespace Messages;

interface MessagesInterface{

    function create($type, $subject, $body, $to, $from);
    function sendit();

}