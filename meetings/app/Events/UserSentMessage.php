<?php
namespace App\Events;

use App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\InteractsWithSockets;

// if you want to use this say implements ShouldBroadcast to broadcast to all the clients
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class UserSentMessage implements ShouldBroadcast{

    use SerializesModels;

    //only public are serialized
    public $user;
    public $recipient;
    public $message;


    /**
     * Create a new Event instance
     *
     * UserSentMessage constructor.
     */
    public function __construct($user, $recipient, $message)
    {
        $this->user = $user;
        $this->recipient = $recipient;
        $this->message = $message;
    }

    /**
     * Get the channels the event should be broadcast on
     */
    public function broadcastOn()
    {
        return new Channel('get-messages');
    }

}