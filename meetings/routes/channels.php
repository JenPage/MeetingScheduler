<?php

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Auth;


Broadcast::channel('App.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

Broadcast::channel('order.{orderId}', function ($user, $orderId) {
    return $user->id === Order::findOrNew($orderId)->user_id;
});

Broadcast::channel('test-channel', function(){
    $data = [
        'event' => 'UserSignedUp',
        'data' => [
            'username' => 'JohnDoe'
        ]
    ];
    Redis::publish('test-channel', json_encode($data));
});

Broadcast::channel('get-messages', function ($user, $recipient) {

    Redis::publish('get-messages', json_encode($sentto));
    return $user->id === $recipient;
});

Broadcast::channel('invite-contact', function ($user, $recipient) {

    Redis::publish('invite-contact', json_encode($sentto));
    return $user->id === $recipient;
});
