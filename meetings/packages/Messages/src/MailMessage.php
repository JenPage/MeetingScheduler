<?php
namespace Messages;

use Messages\MessagesInterface;

class MailMessage implements MessagesInterface{

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

        return 'Mail Message';
    }

    /**
     * @return string
     */
    public function sendit()
    {
        return 'Mail Message';
    }
}
