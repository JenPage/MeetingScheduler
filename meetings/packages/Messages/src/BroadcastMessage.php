<?php
namespace Messages;

use Messages\MessagesInterface;
use Messages\Models\Messages as Message;

class BroadcastMessage implements MessagesInterface{

    /**
     * @param $type
     * @param string $subject
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
            return 'message '.$status;
    }

    /**
     * @return string
     */
    public function sendit()
    {
        return 'Broadcast Message';
    }
}
