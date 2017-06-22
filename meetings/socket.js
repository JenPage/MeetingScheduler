var server = require('http').Server();

var io = require('socket.io')(server);

var Redis = require('ioredis');

var redis = new Redis({PORT: 2722});

//redis.subscribe('test-channel');
redis.subscribe('get-messages');
redis.subscribe('invite-contact');
redis.on('message', function(channel, message){


    console.log(channel, message);

   // console.log(channel, meeting_invite);

    message = JSON.parse(message);

    io.emit(channel + ':' + message.event, message.data);

});

server.listen(3000);