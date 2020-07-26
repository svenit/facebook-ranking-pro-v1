let selfEffect = {};
let passiveEffect = {};
let selfSpecialEffect = {};

let status = {
    isTurn: false,
    isReady: false,
    hp: 0,
    energy: 0, 
    stun: {
        turn: 0,
        animation: null
    },
    silient: {
        turn: 0,
        animation: null
    },
    target: {
        uid: null,
        turn: 0
    }
};

let Player = function({uid, team, playerInfo, roomId}) {
    let self = {
        uid, 
        team,
        isConnect: true,
        roomId,
        playerInfo,
        effectAnimation: [],
        status: Object.assign({}, status),
        selfEffect: Object.assign({}, selfEffect),
        passiveEffect: Object.assign({}, passiveEffect),
        selfSpecialEffect: Object.assign({}, selfSpecialEffect),
    };

    self.remake = function() {
        self.effectAnimation = [];
        self.status = Object.assign({}, status);
        self.selfEffect = Object.assign({}, selfEffect);
        self.passiveEffect = Object.assign({}, passiveEffect);
        self.selfSpecialEffect = Object.assign({}, selfSpecialEffect);
    };

    self.setStats = function() {
        self.status.hp = self.playerInfo.power.hp;
        self.status.energy = self.playerInfo.power.energy;
    };

    return self;
}

module.exports = Player;