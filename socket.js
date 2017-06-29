var app = require('express')();
var server = require('http').Server(app);

var io = require('socket.io')(server);

var Redis = require('ioredis');
var redis = new Redis();


redis.psubscribe('*', function(err, count) {});

redis.on('pmessage', function(subscribed, channel, message) {
    console.log(channel, message);
    message = JSON.parse(message);
    io.emit(message.event, channel, message.data);
});


server.listen(1827);
