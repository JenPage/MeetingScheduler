<?php
namespace Messages;

use Messages\MessagesInterface;
use Messages\Models\Messages as Message;

class DirectMessage implements MessagesInterface{

    /**
     * @param $type
     * @param $subject
     * @param $body
     * @param $to
     * @param $from
     * @return string
     */
    public function create_message($type, $subject, $body, $status, $company, $to, $from)
    {
        $message = [
            'type' => $type,
            'subject' => $subject,
            'body' => $body,
            'status' => $status,
            'recipient_company' => $company,
            'recipient_user' => $to,
            'sender' => $from,
        ];

        Message::create($message);
        return 'message created';
    }

    /**
     * @return string
     */
    public function sendit()
    {
        return 'DirectMessage';
    }
}
