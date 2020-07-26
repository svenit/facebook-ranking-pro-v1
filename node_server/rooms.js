let Room = function(id) {
    var self = {
        id,
        slot: 0,
        turnIndex: null,
        currentTurn: 0,
        timeRemaining: 0,
        isFighting: false,
        players: [],
        masterId: null,
        timePerTurn: 0,
        playerSetTurn: []
    }

    let turnTimeout;
    let socketServer;

    self.setSocket = function(socket) {
        socketServer = socket;
    };

    self.newRoom = function({slot, timeRemaining, timePerTurn}) {
        self.slot = slot;
        self.turnIndex = null;
        self.currentTurn = 0;
        self.timeRemaining = timeRemaining;
        self.isFighting = false;
        self.timePerTurn = timePerTurn;
        self.players.map(player => player.remake());
        clearTimeout(turnTimeout);
    };

    self.nextTurn = function() {
        let turn = self.currentTurn++ % self.playerSetTurn.length;
        let player = self.findPlayer(self.playerSetTurn[turn].uid);
        if(typeof(player[0]) != 'undefined') {
            player = player[0];
            /* Next turn if player is stunned or disconnected */
            if(player.status.stun.turn > 0 || !player.isConnect || typeof(socketServer[player.socketId]) == 'undefined') {
                /* If the player is stunned, passing turn to other player */
                if(player.status.stun.turn > 0) {
                    --player.status.stun.turn;
                }
                /* If cannot connect to player, set player status is disconnected */
                player.isConnect = typeof(socketServer[player.socketId]) != 'undefined';
                return self.nextTurn();
            }
            self.turnIndex = player.uid;
            /* Decrement turn countdown of skill per turn */
            player.playerInfo.skills.map(skill => {
                if(skill.options.currentCoolDown > 0) {
                    --skill.options.currentCoolDown;
                }
            });
            self.triggerTimeOut();
        }
    };

    self.triggerTimeOut = function() {
        turnTimeout = setTimeout(() => {
            self.nextTurn();
        }, self.timePerTurn);
    };

    self.startPvp = function() {
        self.isFighting = true;
        let orderPlayersByLucky = [];
        for(let i in self.players) {
            orderPlayersByLucky.push({
                uid: self.players[i].uid,
                lucky: self.players[i].playerInfo.power.lucky
            });
            /* Remake all countdown skill */
            self.players[i].playerInfo.skills.map(skill => skill.options.currentCoolDown = 0);
        }
        self.playerSetTurn = orderPlayersByLucky.sort((a, b) => b.lucky - a.lucky);
        self.nextTurn();
    };
    
    self.removePlayer = function(uid) {
        for(let i in self.players)
        {
            if(self.players[i].uid == uid) {
                self.players.splice(i, 1);
            }
        }
    };
    
    self.addPlayer = function(player) {
        let { players, slot } = self;
        let findPlayer = self.findPlayer(player.uid);
        if (findPlayer.length == 0) {
            if(players.length < slot) {
                players.push(player);
                self.masterId = players[0].uid;
                return true;
            }
        }
        else {
            findPlayer[0].socketId = player.socketId;
            findPlayer[0].isConnect = true;
            return true;
        }
        return false;
    };

    self.otherPlayers = function(uid) {
        return self.players.filter(item => item.uid != uid);
    };

    self.findPlayer = function(uid) {
        return self.players.filter(item => item.uid == uid);
    };

    return self;
}

module.exports = Room;