<?php
namespace Messages;

use Messages\MessagesInterface;

class DirectMessage implements MessagesInterface{


     protected $type = 'direct';


    /**
     * @param $type
     * @param $subject
     * @param $body
     * @param $to
     * @param $from
     * @return string
     */
    public function create($type, $subject, $body, $to, $from)
    {
        return 'Direct Message';
    }


    /**
     * @return string
     */
    public function sendit()
    {

        return 'DirectMessage';
    }
}
