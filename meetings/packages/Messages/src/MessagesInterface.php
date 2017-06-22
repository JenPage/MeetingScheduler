<?php
namespace Messages;

interface MessagesInterface{

    function create_message($type, $subject, $body, $status, $company, $to, $from);
    function sendit();

}