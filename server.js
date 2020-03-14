const port = 3000;
const io = require('socket.io')(port);
const Redis = require('ioredis');
const redis = new Redis();
const map = new Map();

console.log('App is runnig at port', port);

redis.subscribe('channel');

redis.on('message',(channel, message) => {
    let { event, data } = JSON.parse(message);
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
io.on('connection',handleConnect);

var players = [];

function handleConnect(socket)
{
    socket.on('disconnect',() => {
        user.decrement();
        io.emit('user-count',user.count);
        socket.broadcast.emit(`enemy-disconnected-pvp-${players[socket.id]}`,{
            channel:players[socket.id],
            id:socket.id
        });
    });
    user.increment();
    io.emit('user-count',user.count);
    socket.on('set-pvp-room',(data) => {
        players[socket.id] = data;
        socket.broadcast.emit('enemy-reconnect-pvp');
    });
    socket.on('event-pvp-time',(data) => {
        io.emit(`event-pvp-time-${data.channel}`,{
            time:data.time,
            id:socket.id
        })
    });

    socket.on('pvp-ready',(data) => {
        socket.broadcast.emit(`enemy-pvp-ready-${data.channel}`,{
            id:data.id,
            status:data.status
        });
    });

    socket.on('pvp-turn-out',(data) => {
        socket.broadcast.emit(`enemy-pvp-turn-out-${data.channel}`,{
            id:data.id
        });
    });
}
