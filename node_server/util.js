const CryptoJS = require('./cryto');
let key = "let author = 'sven307';console.log(author);";

const Util = {
    
    renderSkillEffectMessage: function({name, unit, type, turn}) {
        let effectsMap = {
            hp: 'HP hồi',
            energy: 'Mana hồi',
            strength: 'Sức Mạnh tăng',
            intelligent: 'Trí Tuệ tăng',
            agility: 'Nhanh Nhẹn tăng',
            lucky: 'May Mắn tăng',
            armor_strength: 'Kháng Công tăng',
            armor_intelligent: 'Kháng Phép tăng'
        };
        return `${effectsMap[name]} ${unit}${type == 'percent' ? '%' : ''} trong vòng ${turn} lượt <br>`
    },
    handleUnit: function ({player, unit, type, baseOn}) {
        let totalDamage = 0;
        switch(type) {
            case 'number':
                totalDamage = unit + player.status[baseOn];
            break;
        }
        return totalDamage;
    },
    AESEncrypt: function(data) {
        return Util.btoa(CryptoJS.AES.encrypt(data, key).toString());
    },
    AESEncryptJSON: function(data) {
        return Util.AESEncrypt(JSON.stringify(data));
    },
    AESDecrypt: function(data) {
        return CryptoJS.AES.decrypt(Util.atob(data), key).toString(CryptoJS.enc.Utf8);
    },
    AESDecryptJSON: function(data) {
        return JSON.parse(Util.AESDecrypt(data));
    },
    btoa: function(string) {
        return new Buffer.from(string).toString('base64');
    },
    atob: function(string) {
        return new Buffer.from(string, 'base64').toString('ascii');
    }
}

module.exports = Util;