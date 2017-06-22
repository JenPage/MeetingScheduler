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

class UserSignedUp implements ShouldBroadcast{

    use SerializesModels;

    //only public are serialized
    public $username;

    /**
     * Create a new Event instance
     *
     * UserSignedUp constructor.
     */
    public function __construct($username)
    {
        $this->username = $username;
    }

    /**
     * Get the channels the event should be broadcast on
     */
    public function broadcastOn()
    {

        return new Channel('test-channel');
        //return ['test-channel'];
    }

}