const CryptoJS = require('./cryto');
let key = "let author = 'sven307';console.log(author);";

const Util = {
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