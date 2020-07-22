const port = 3000;
const io = require('socket.io')(port);
const Redis = require('ioredis');
const mysql = require('mysql');
const redis = new Redis();
const Room = require('./rooms');
const Player = require('./players');
const CryptoJS = require('./cryto');
const axios = require('axios');
var fs = require('fs');


process.env['NODE_TLS_REJECT_UNAUTHORIZED'] = 0


// var connection = mysql.createConnection({
//     host     : '127.0.0.1',
//     user     : 'root',
//     password : 'admin',
//     database : 'facebook_game'
// });
// connection.connect();

console.log('App is runnig at port', port);

redis.subscribe('channel');

redis.on('message',(channel, message) => {
    let { event, data } = JSON.parse(message);
    console.log(event, data);
    io.emit(event, data);
});

let users = [];
let players = [];
let pvpRooms = [];
let intervalRooms = [];

const defaultPvpConfig = {
    slot: 2, 
    timeRemaining: 15 * 1000,
    timePerTurn: 3000
}

io.use(async (socket, next) => {
    try {
        let { tokenKey, urlConfirm, ref } = socket.request._query;
        let token = AESDecrypt(tokenKey);
        let cookieHeader = AESDecrypt(ref);
        let verifyStatus = await verifyToken({token, urlConfirm, cookieHeader});
        if(!verifyStatus) {
            return socket.disconnect();
        }
        next();
    }
    catch(e) {
        fs.appendFile('socket_logs.txt', `[ ${now()} ] - Socket ID : ${socket.id} attacked server \n`, 'utf8', function(e) {
            if(e) console.log(e);
        });
        socket.disconnect();
    }
});

let key = "let author = 'sven307';console.log(author);";

function AESEncrypt(data) {
    return CryptoJS.AES.encrypt(data, key).toString();
};

function AESEncryptJSON(data) {
    return AESEncrypt(JSON.stringify(data));
};

function AESDecrypt(data) {
    return CryptoJS.AES.decrypt(data, key).toString(CryptoJS.enc.Utf8);
}

function AESDecryptJSON(data) {
    return JSON.parse(AESDecrypt(data));
}

async function verifyToken({token, urlConfirm, cookieHeader}) {
    let res = await axios.post(`${urlConfirm}/verify-token`, {
        token
    }, {
        headers: {
            cookie:cookieHeader
        }
    });
    return res.data == 1;
}

io.on('connection', handleConnect);

function handleConnect(socket) {
    socket.on('onConnection', data => {
        let { id, name } = AESDecryptJSON(data);
        socket.userId = id;
        socket.name = name;
        users[socket.id] = socket;
    });
    socket.on('joinPvpRoom', data => {
        let { room, playerInfo } = AESDecryptJSON(data);
        const roomId = room.roomId;
        let player;
        if(typeof(players[room.userId]) == 'undefined') {
            player = new Player({uid: room.userId, playerInfo, roomId});
            players[room.userId] = player;
        }
        else {
            player = players[room.userId];
        }
        player.socketId = socket.id;
        if(typeof(pvpRooms[roomId]) == 'undefined') {
            let room = pvpRooms[roomId] = new Room(roomId);
            room.newRoom(defaultPvpConfig);
            if(room.addPlayer(player)) {
                socket.join(roomId);
            }
        }
        else {
            if(pvpRooms[roomId].addPlayer(player)) {
                socket.join(roomId);
                if(pvpRooms[roomId].players.length == pvpRooms[roomId].slot) {
                    socket.in(roomId).emit('listenPvp', AESEncryptJSON({
                        room: pvpRooms[roomId], 
                        message: `Đã kết nối đến thợ săn [ ${player.playerInfo.infor.name} ]`
                    }));
                    io.to(socket.id).emit('listenPvp', AESEncryptJSON({
                        room: pvpRooms[roomId], 
                        message: `Đã kết nối đến thợ săn [ ${pvpRooms[roomId].otherPlayers(room.userId)[0].playerInfo.infor.name} ]`
                    }));
                }
            }
        }
    });
    socket.on('readyPvp', data => {
        let { room, status } = AESDecryptJSON(data);
        if(typeof(pvpRooms[room.roomId]) != 'undefined') {
            let joinedRoom = pvpRooms[room.roomId];
            if(joinedRoom.findPlayer(room.userId).length > 0) {
                let player = joinedRoom.findPlayer(room.userId)[0];
                player.status.isReady = status;
                if(joinedRoom.otherPlayers(room.userId).length > 0) {
                    let otherPlayer = joinedRoom.otherPlayers(room.userId)[0];
                    if(otherPlayer.status.isReady && joinedRoom.players.length == joinedRoom.slot) {
                        /*  Start PVP */
                        joinedRoom.startPvp();
                        player.setStats();
                        otherPlayer.setStats();
                        let data = {
                            room: pvpRooms[room.roomId], 
                            message: 'Bắt đầu trận đấu'
                        };
                        io.in(room.roomId).emit('listenPvp', AESEncryptJSON(data));
                        /* Time count down */
                        intervalRooms[room.roomId] = setInterval(() => {
                            joinedRoom.timeRemaining -= 1000;
                            if(joinedRoom.timeRemaining >= 0) {
                                io.in(room.roomId).emit('updatePvpRoom', AESEncryptJSON({
                                    room: joinedRoom
                                }));
                            }
                            else {
                                joinedRoom.newRoom(defaultPvpConfig);
                                clearInterval(intervalRooms[room.roomId]);
                                delete intervalRooms[room.roomId];
                                let data = {
                                    room: pvpRooms[room.roomId], 
                                    message: 'Trận đấu kết thúc',
                                    finishPvp: true
                                };
                                io.in(room.roomId).emit('listenPvp', AESEncryptJSON(data));
                            }
                        }, 1000);
                        return;
                    }
                    socket.to(room.roomId).emit('listenPvp', AESEncryptJSON({
                        room: pvpRooms[room.roomId], 
                        message: status ? 'Đối thủ đã sẵn sàng' : 'Đối thủ đã hủy sẵn sàng'
                    }));
                }
            }
        }
    });
    socket.on('error', function (err) {
        console.log(err);
    });
    socket.on('disconnect', () => {
        let user = users[socket.id];
        playerExitPvp(user, socket);
    });
}

function playerExitPvp(user, socket) {
    try {
        if(typeof(user) != 'undefined') {
            if(typeof(players[user.userId]) != 'undefined') {
                let { name, userId } = user;
                let { roomId } = players[userId];
                if(typeof(pvpRooms[roomId]) != 'undefined')
                {
                    let joinedRoom = pvpRooms[roomId];
                    if(joinedRoom.findPlayer(userId).length > 0 && joinedRoom.isFighting) {
                        let player = joinedRoom.findPlayer(userId);
                        if(typeof(player[0]) != 'undefined') {
                            player[0].isConnect = false;
                            player[0].status.isTurn = false;
                        }
                    }
                    else {
                        joinedRoom.removePlayer(userId);
                        delete players[userId];
                        delete users[socket.id];
                    }
                    socket.to(roomId).emit('listenPvp', AESEncryptJSON({
                        room: joinedRoom, 
                        message: `${name} đã rời trận`
                    }));
                    socket.leave(roomId);
                }
            }
        }
    }
    catch(e) {
        console.log(e);
    }
}

function now() {
    let date = new Date();
    return `${date.getHours()}:${date.getMinutes()}:${date.getSeconds()} ${date.getDate()}/${date.getMonth()}/${date.getFullYear()}`;
}