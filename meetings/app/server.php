<?php
namespace App;

use Hoa\Websocket\Server;
use Hoa\Socket;
use  Hoa\Event\Bucket;

/*Create a server variable with the link to the tcp IP and custom port you need to
specify the Homestead IP if you are using homestead or, for local environment using
WAMP, MAMP, ... use 127.0.0..1*/

//$server = new Server(
//    new Socket\Server('tcp://192.168.10.10:8889')
//);
//
////Manages the message event to get send data for each client using the broadcast method
//$server->on('message', function ( Bucket $bucket ) {
//    var_dump(
//      $bucket->getSource(),
//        $bucket->getData()
//
//    );
//    $data = $bucket->getData();
//   // echo 'message: ', $data['message'], "\n";
//    $bucket->getSource()->broadcast($data['message']);
//    return;
//});
////Execute the server
//$server->run();
require_once(__DIR__.'/../vendor/autoload.php');


$websocket = new \Hoa\Websocket\Server(
    new \Hoa\Socket\Server('ws://192.168.10.10:8889')
);
$websocket->on('open', function (\Hoa\Event\Bucket $bucket) {
    echo 'new connection', "\n";

    return;
});
$websocket->on('message', function (\Hoa\Event\Bucket $bucket) {
    $data = $bucket->getData();
    echo '> message ', $data['message'], "\n";
    $bucket->getSource()->send($data['message']);
    $bucket->getSource()->broadcast($data['message']);
    echo '< echo', "\n";

    return;
});
$websocket->on('close', function (\Hoa\Event\Bucket $bucket) {
    echo 'connection closed', "\n";

    return;
});
$websocket->run();