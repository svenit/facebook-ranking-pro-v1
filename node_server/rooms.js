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
        let turn = ++self.currentTurn % self.players.length;
        /* Next turn if player is stunned or disconnected */
        if(self.players[turn].status.stunTurn > 0 || !self.players[turn].isConnect || typeof(socketServer[self.players[turn].socketId]) == 'undefined') {
            /* If the player is stunned, passing turn to other player */
            if(self.players[turn].status.stunTurn > 0) {
                --self.players[turn].status.stunTurn;
            }
            /* If cannot connect to player, set player status is disconnected */
            self.players[turn].isConnect = typeof(socketServer[self.players[turn].socketId]) != 'undefined';
            return self.nextTurn();
        }
        self.turnIndex = self.players[turn].uid;
        /* Decrement turn countdown of skill per turn */
        self.players[turn].playerInfo.skills.map(skill => {
            if(skill.options.currentCountDown > 0) {
                --skill.options.currentCountDown;
            }
        });
        self.triggerTimeOut();
    };

    self.triggerTimeOut = function() {
        turnTimeout = setTimeout(() => {
            self.nextTurn();
        }, self.timePerTurn);
    };

    self.startPvp = function() {
        self.isFighting = true;
        let turnIndex = self.players[0].uid;
        let max = 0;
        for(let i in self.players) {
            if(max < self.players[i].playerInfo.power.agility) {
                max = self.players[i].playerInfo.power.agility;
                turnIndex = self.players[i].uid;
            }
            /* Remake all countdown skill */
            self.players[i].playerInfo.skills.map(skill => skill.options.currentCountDown = 0);
        }
        self.turnIndex = turnIndex;
        self.triggerTimeOut();
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
        player.order = players.length;
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