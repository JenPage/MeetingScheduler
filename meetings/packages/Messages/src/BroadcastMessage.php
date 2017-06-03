<?php
namespace Messages;

use Messages\MessagesInterface;

class BroadcastMessage implements MessagesInterface{

    protected $type = 'mail';


    /**
     * @param $type
     * @param string $subject
     * @param $body
     * @param $to
     * @param $from
     * @return string
     */
    public function create($type, $subject='subject of mail message', $body, $to, $from)
    {

        return 'Broadcast Message';
    }

    /**
     * @return string
     */
    public function sendit()
    {
        return 'Broadcast Message';
    }
}
