const port = 3000;
var io = require('socket.io')(port);
var Redis = require('ioredis');
var redis = new Redis();

console.log('App is runnig at port', port);

redis.subscribe('channel');

redis.on('message',(channel, message) => {
    let { event, data } = JSON.parse(message);
    console.log(event);
    io.emit(event, data);
});

io.on('connection',(socket) => {
    console.log(socket.id);
});
