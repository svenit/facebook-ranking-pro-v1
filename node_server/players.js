
const NUMBER = 'NUMBER';
const PERCENT = 'PERCENT';

let statsBuffs = {
    available: [],
    hp: {
        parameter: 0,
        unit: NUMBER,
        turn: 0
    },
    strength: {
        parameter: 0,
        unit: NUMBER,
        turn: 0
    },
    energy: {
        parameter: 0,
        unit: NUMBER,
        turn: 0
    },
    intelligent: {
        parameter: 0,
        unit: NUMBER,
        turn: 0
    }, 
    armor_strength: {
        parameter: 0,
        unit: NUMBER,
        turn: 0
    }, 
    armor_intelligent: {
        parameter: 0,
        unit: NUMBER,
        turn: 0
    }, 
    lucky: {
        parameter: 0,
        unit: NUMBER,
        turn: 0
    }, 
    agility: {
        parameter: 0,
        unit: NUMBER,
        turn: 0
    }, 
};

let effectBuffs = {
    available: [],
    hpBleeding: {
        parameter: 0,
        statEffect: 'hp',
        unit: NUMBER,
        turn: 0
    },
    energyBleeding: {
        parameter: 0,
        statEffect: 'energy',
        unit: NUMBER,
        turn: 0
    },
    silent: {
        parameter: 0,
        statEffect: null,
        unit: null,
        turn: 0
    },
};

let status = {
    isTurn: false,
    isReady: false,
    hp: 0,
    energy: 0, 
    stunTurn: 0,
    stunType: null
};

let Player = function({uid, playerInfo, roomId}) {
    let self = {
        uid, 
        isConnect: true,
        roomId,
        playerInfo,
        status: Object.assign({}, status),
        statsBuffs: Object.assign({}, statsBuffs),
        effectBuffs: Object.assign({}, effectBuffs),
    };

    self.remake = function() {
        self.status = Object.assign({}, status);
        self.statsBuffs = Object.assign({}, statsBuffs);
        self.effectBuffs = Object.assign({}, effectBuffs);
    };

    self.setStats = function() {
        self.status.hp = self.playerInfo.power.hp;
        self.status.energy = self.playerInfo.power.energy;
    };

    return self;
}

module.exports = Player;