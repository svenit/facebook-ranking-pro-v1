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

    self.newRoom = function({slot, timeRemaining, timePerTurn}) {
        self.slot = slot;
        self.turnIndex = null;
        self.currentTurn = 0;
        self.timeRemaining = timeRemaining;
        self.isFighting = false;
        self.timePerTurn = timePerTurn;
        self.players.map(player => player.remake());
        clearTimeout(turnTimeout);
    }

    self.nextTurn = function() {
        let currentTurn = self.currentTurn++;
        let turn = currentTurn % self.players.length;
        /* Next turn if player is stun */
        if(self.players[turn].status.isStun) {
            return self.nextTurn();
        }
        self.turnIndex = self.players[turn].uid;
        self.triggerTimeOut();
    }

    self.triggerTimeOut = function() {
        turnTimeout = setTimeout(() => {
            self.nextTurn();
        }, self.timePerTurn);
    }

    self.startPvp = function() {
        self.isFighting = true;
        let turnIndex = self.players[0].uid;
        let max = 0;
        for(let i in self.players) {
            if(max < self.players[i].playerInfo.power.agility) {
                max = self.players[i].playerInfo.power.agility;
                turnIndex = self.players[i].uid;
            }
        }
        self.turnIndex = turnIndex;
        self.triggerTimeOut();
    }
    
    self.removePlayer = function(uid) {
        for(let i in self.players)
        {
            if(self.players[i].uid == uid) {
                self.players.splice(i, 1);
            }
        }
    }
    
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
    }

    self.otherPlayers = function(uid) {
        return self.players.filter(item => item.uid != uid);
    }

    self.findPlayer = function(uid) {
        return self.players.filter(item => item.uid == uid);
    }

    return self;
}

module.exports = Room;