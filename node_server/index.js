const port = 3000;
const io = require('socket.io')(port);
const Redis = require('ioredis');
const redis = new Redis();
const axios = require('axios');
const Room = require('./rooms');
const Player = require('./players');
const Util = require('./util');
require('dotenv').config();

process.env['NODE_TLS_REJECT_UNAUTHORIZED'] = 0

let { PVP_PLAYERS_SLOT, PVP_TIME_FINISH, PVP_TIME_PER_TURN, DISCORD_SERVER_LOG, DISCORD_PVP_LOG } = process.env;
let users = [];
let players = [];
let pvpRooms = [];
let intervalRooms = [];

let defaultPvpConfig = {
    slot: parseInt(PVP_PLAYERS_SLOT), 
    timeRemaining: parseInt(PVP_TIME_FINISH),
    timePerTurn: parseInt(PVP_TIME_PER_TURN)
}

redis.subscribe('channel');
redis.on('message',(channel, message) => {
    let { event, data } = JSON.parse(message);
    console.log(event, data);
    io.emit(event, data);
});


console.log('App is runnig at port', port);


try
{
    io.use(async (socket, next) => {
        try {
            let { tokenKey, urlConfirm, ref } = socket.request._query;
            let token = Util.AESDecrypt(tokenKey);
            let cookieHeader = Util.AESDecrypt(ref);
            let verifyStatus = await verifyToken({token, urlConfirm, cookieHeader});
            if(!verifyStatus) {
                return socket.disconnect();
            }
            next();
        }
        catch(e) {
            Util.writeLog({
                url: DISCORD_SERVER_LOG,
                content: `${socket.id} attacked server`
            });
            socket.disconnect();
        }
    });

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
        socket.on(Util.btoa('onConnection'), data => {
            let { id, name } = Util.AESDecryptJSON(data);
            socket.userId = id;
            socket.name = name;
            users[socket.id] = socket;
        });
        socket.on(Util.btoa('joinPvpRoom'), data => {
            let { room, playerInfo } = Util.AESDecryptJSON(data);
            const roomId = room.roomId;
            let player;
            if(typeof(players[room.userId]) == 'undefined') {
                player = new Player({uid: room.userId, team: room.userId, playerInfo, roomId});
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
                        socket.in(roomId).emit(Util.btoa('listenPvp'), Util.AESEncryptJSON({
                            room: pvpRooms[roomId], 
                            message: `Đã kết nối đến thợ săn [ ${player.playerInfo.infor.name} ]`
                        }));
                        io.to(socket.id).emit(Util.btoa('listenPvp'), Util.AESEncryptJSON({
                            room: pvpRooms[roomId], 
                            message: `Đã kết nối đến thợ săn [ ${pvpRooms[roomId].otherPlayers(room.userId)[0].playerInfo.infor.name} ]`
                        }));
                    }
                }
            }
        });
        socket.on(Util.btoa('readyPvp'), data => {
            let { room, status } = Util.AESDecryptJSON(data);
            if(typeof(pvpRooms[room.roomId]) != 'undefined') {
                let joinedRoom = pvpRooms[room.roomId];
                if(joinedRoom.findPlayer(room.userId).length > 0) {
                    let player = joinedRoom.findPlayer(room.userId)[0];
                    player.status.isReady = status;
                    if(joinedRoom.otherPlayers(room.userId).length > 0) {
                        let otherPlayer = joinedRoom.otherPlayers(room.userId)[0];
                        if(otherPlayer.status.isReady && joinedRoom.players.length == joinedRoom.slot) {
                            /*  Start PVP */
                            player.setStats();
                            otherPlayer.setStats();
                            io.in(room.roomId).emit(Util.btoa('listenPvp'), Util.AESEncryptJSON({
                                room: pvpRooms[room.roomId], 
                                message: 'Bắt đầu trận đấu'
                            }));
                            joinedRoom.logs.push(`\n----------- Thông Tin Trận Đấu ----------- \n`);
                            joinedRoom.logs.push(`\nThời gian: ${Util.now()}\n`);
                            joinedRoom.logs.push(`\n${player.playerInfo.infor.name} ( ${player.playerInfo.infor.character.name} ) **VS** ${otherPlayer.playerInfo.infor.name} ( ${otherPlayer.playerInfo.infor.character.name} ) \n`);

                            joinedRoom.setSocketIo({io, socket});
                            joinedRoom.startPvp();
                            /* Time count down */
                            intervalRooms[room.roomId] = setInterval(() => {
                                joinedRoom.timeRemaining -= 1000;
                                if(joinedRoom.timeRemaining >= 0) {
                                    io.in(room.roomId).emit(Util.btoa('updatePvpRoom'), Util.AESEncryptJSON({
                                        room: joinedRoom
                                    }));
                                }
                                else {
                                    const messageLogs = joinedRoom.logs.join('').replace(/<br>/g, '\n');
                                    joinedRoom.newRoom(defaultPvpConfig);
                                    clearInterval(intervalRooms[room.roomId]);
                                    delete intervalRooms[room.roomId];
                                    let data = {
                                        room: pvpRooms[room.roomId], 
                                        message: 'Trận đấu kết thúc',
                                        finishPvp: true
                                    };
                                    io.in(room.roomId).emit(Util.btoa('listenPvp'), Util.AESEncryptJSON(data));
                                    Util.writeLog({
                                        url: DISCORD_PVP_LOG,
                                        name: `#${joinedRoom.id}`,
                                        value: messageLogs
                                    });
                                }
                            }, 1000);
                            return;
                        }
                        socket.to(room.roomId).emit(Util.btoa('listenPvp'), Util.AESEncryptJSON({
                            room: pvpRooms[room.roomId], 
                            message: status ? 'Đối thủ đã sẵn sàng' : 'Đối thủ đã hủy sẵn sàng'
                        }));
                    }
                }
            }
        });
        socket.on(Util.btoa('fightSkill'), data => {
            let { room, user, target, skill } = Util.AESDecryptJSON(data);
            let message;
            if(target == null) return;
            if(typeof(pvpRooms[room.roomId]) != 'undefined') {
                let joinedRoom = pvpRooms[room.roomId];
                let targetPlayer = joinedRoom.findPlayer(target);
                let playerAtk = joinedRoom.findPlayer(user.id);
                if(targetPlayer.length > 0 && playerAtk.length > 0 && joinedRoom.isFighting) {
                    if(playerAtk[0].status.stun.turn == 0 && playerAtk[0].status.silient.turn == 0)
                    {
                        if(playerAtk[0].uid == joinedRoom.turnIndex) {
                            let playerAtkSkill = playerAtk[0].findSkill(skill.id);
                            if(playerAtkSkill.length > 0)
                            {
                                let skillOptions = playerAtkSkill[0].options;
                                if(skillOptions.currentCoolDown == 0 && skillOptions.energy <= playerAtk[0].status.energy) {
                                    let message = '';
                                    let sumAgility = playerAtk[0].status.agility + targetPlayer[0].status.agility;
                                    let sumLucky = playerAtk[0].status.lucky + targetPlayer[0].status.lucky;
                                    /* Calculate the probability success */
                                    let playerAtkProbability = (playerAtk[0].status.agility/sumAgility) * 100;
                                    let randomProbability = Math.floor(Math.random(0, 100) * 100);
                                    if(playerAtkProbability >= randomProbability || targetPlayer[0] == playerAtk[0])
                                    {
                                        let [ minDamage, maxDamage ] = skillOptions.damageRange;
                                        let damageRange = Math.floor(Math.random() * (parseFloat(maxDamage) - parseFloat(minDamage)) + parseFloat(minDamage));
                                        /* Sum damage */
                                        let totalDamage = Util.handleUnit({player: playerAtk[0], unit: damageRange, type: skillOptions.damageType, baseOn: skillOptions.damageBaseOn});
                                        if((playerAtk[0].status.lucky/sumLucky) * 100 >= randomProbability) {
                                            totalDamage *= 2;
                                        }
                                        let effects = ['selfSpecialEffect', 'selfEffect', 'enemySpecialEffect', 'enemyEffect'];
                                        /* Check buff skill */
                                        if(skillOptions.buffSkill) {
                                            effects = ['selfSpecialEffect', 'selfEffect'];
                                        }
                                        /* Handle skill effects */
                                        for(let i in effects) {
                                            if(skillOptions[effects[i]].available.length > 0) {
                                                let availableEffects = skillOptions[effects[i]];
                                                for(let j in availableEffects.available) {
                                                    let effectKey = availableEffects.available[j];
                                                    let { unit, type, turn, probability, animation, description } = availableEffects[effectKey];
                                                    if(probability >= randomProbability)
                                                    {
                                                        switch(effects[i]) {
                                                            case 'selfEffect':
                                                                playerAtk[0].selfEffect[effectKey] = {
                                                                    unit,
                                                                    type, 
                                                                    turn,
                                                                    animation
                                                                };
                                                                message += `[ ${playerAtk[0].playerInfo.infor.name} ]  ${description} <br>`;
                                                                playerAtk[0].pushSkillEffects(animation);
                                                            break;
                                                            case 'enemyEffect':
                                                                targetPlayer[0].selfDebuffEffect[effectKey] = {
                                                                    unit,
                                                                    type, 
                                                                    turn,
                                                                    animation
                                                                };
                                                                message += `[ ${targetPlayer[0].playerInfo.infor.name} ]  ${description} <br>`;
                                                                targetPlayer[0].pushSkillEffects(animation);
                                                            break;
                                                        }
                                                    }
                                                }
                                            }
                                        }
                                        /* Set skill cool down, decrement hp of enemy */
                                        playerAtkSkill[0].options.currentCoolDown = playerAtkSkill[0].options.coolDown;
                                        targetPlayer[0].status.hp -= totalDamage;
                                    }
                                    else {
                                        message = `${playerAtk[0].playerInfo.infor.name} sử dụng kỹ năng thất bại!<br>`;
                                    }
                                    joinedRoom.logs.push(message);
                                    playerAtk[0].status.energy -= skillOptions.energy;
                                    io.in(room.roomId).emit(Util.btoa('listenPvp'), Util.AESEncryptJSON({
                                        room: pvpRooms[room.roomId], 
                                        message
                                    }));
                                    joinedRoom.clearTurn();
                                    joinedRoom.nextTurn();
                                    return;
                                }
                                else {
                                    message = 'Kỹ năng chưa hồi hoặc mana không đủ để thực hiện kỹ năng này!';
                                }
                            }
                            else {
                                message = 'Không tìm thấy kỹ năng này!';
                            }
                        }
                        else {
                            message = 'Chưa đến lượt của bạn';
                        }
                    }
                    else {
                        message = 'Bạn đang ở trong trạng thái choáng, tê liệt, chói hoặc câm lặng...! Không thể sử dụng kỹ năng trong lúc này';
                    }
                }
                io.to(socket.id).emit(Util.btoa('listenPvp'), Util.AESEncryptJSON({
                    room: pvpRooms[room.roomId], 
                    message
                }));
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
                        socket.to(roomId).emit(Util.btoa('listenPvp'), Util.AESEncryptJSON({
                            room: joinedRoom, 
                            message: `${name} đã rời trận`
                        }));
                        socket.leave(roomId);
                    }
                }
            }
        }
        catch(e) {
            Util.writeLog({
                url: DISCORD_SERVER_LOG,
                content: `From NodeJS - ${e.stack}`
            });
        }
    }
}
catch(e) {
    Util.writeLog({
        url: DISCORD_SERVER_LOG,
        name: 'Errors Report',
        value: `${e.stack}`
    });
}