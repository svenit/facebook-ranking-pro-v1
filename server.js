const port = 3000;
const io = require('socket.io')(port);
const Redis = require('ioredis');
const redis = new Redis();

console.log('App is runnig at port', port);

redis.subscribe('channel');

redis.on('message',(channel, message) => {
    let { event, data } = JSON.parse(message);
    console.log(message);
    io.emit(event, data);
});

var user = {
    count:0,
    increment:() => {
        ++user.count;
    },
    decrement:() => {
        --user.count;
    }
}

io.on('connection',(socket) => {
    console.log(socket.id);
    socket.on('disconnect', () => {
        user.decrement();
        io.emit('user-count',user.count);
    });
    user.increment();
    io.emit('user-count',user.count);
});
