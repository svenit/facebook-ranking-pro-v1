let selfEffect = {};
let selfDebuffEffect = {};
let passiveEffect = {};
let selfSpecialEffect = {};

let status = {
    isTurn: false,
    isReady: false,
    hp: 0,
    energy: 0, 
    strength: 0,
    intelligent: 0,
    agility: 0,
    lucky: 0,
    armor_strength: 0,
    armor_intelligent: 0,
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
        selfDebuffEffect:  Object.assign({}, selfDebuffEffect),
        passiveEffect: Object.assign({}, passiveEffect),
        selfSpecialEffect: Object.assign({}, selfSpecialEffect),
    };

    self.remake = function() {
        self.effectAnimation = [];
        self.status = Object.assign({}, status);
        self.selfEffect = Object.assign({}, selfEffect);
        self.selfDebuffEffect = Object.assign({}, selfDebuffEffect);
        self.passiveEffect = Object.assign({}, passiveEffect);
        self.selfSpecialEffect = Object.assign({}, selfSpecialEffect); 
    };

    self.findSkill = function(id) {
        return self.playerInfo.skills.filter(skill => skill.id == id);
    };

    self.pushSkillEffects = function(name) {
        self.effectAnimation.push(name);
    }

    self.removeSkillEffect = function(name) {
        if(self.effectAnimation.includes(name)) {
            let effectIndex = self.effectAnimation.indexOf(name);
            self.effectAnimation.splice(effectIndex, 1);
        }
    }

    self.setStats = function() {
        self.status.hp = self.playerInfo.power.hp;
        self.status.energy = self.playerInfo.power.energy;
        self.status.strength = self.playerInfo.power.strength;
        self.status.intelligent = self.playerInfo.power.intelligent;
        self.status.agility = self.playerInfo.power.agility;
        self.status.lucky = self.playerInfo.power.lucky;
        self.status.armor_strength = self.playerInfo.power.armor_strength;
        self.status.armor_intelligent = self.playerInfo.power.armor_intelligent;

        /* Setup passive skill */
        self.passiveEffect = Object.assign({}, passiveEffect);
        self.playerInfo.skills.filter(skill => skill.options.isPassive).map(skill => {
            if(skill.options.passiveEffect.available.length > 0) {
                let availablePassiveSkills = skill.options.passiveEffect.available;
                for(let i in availablePassiveSkills) {
                    let effectKey = availablePassiveSkills[i];
                    let { unit, type, probability, initTurn, animation, baseOn, description  } = skill.options.passiveEffect[effectKey];
                    self.passiveEffect[effectKey] = {
                        unit,
                        type,
                        probability,
                        turn: initTurn,
                        initTurn,
                        animation,
                        baseOn,
                        description
                    };
                    self.effectAnimation.push(animation);
                }
            };
        });
    };

    return self;
}

module.exports = Player;