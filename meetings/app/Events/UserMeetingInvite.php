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

class UserMeetingInvite implements ShouldBroadcast{

    use SerializesModels;

    //only public are serialized
    public $meeting_invite;


    /**
     * Create a new Event instance
     *
     * UserSentMessage constructor.
     */
    public function __construct($meeting_invite)
    {
        \Log::info($meeting_invite);
        $this->meeting_invite = $meeting_invite;
    }

    /**
     * Get the channels the event should be broadcast on
     */
    public function broadcastOn()
    {
        return new Channel('invite-contact');
    }

}