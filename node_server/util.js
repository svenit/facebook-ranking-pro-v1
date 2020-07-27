const CryptoJS = require('./cryto');
const axios = require('axios');

let key = "let author = 'sven307';console.log(author);";

const Util = {
    handleUnit({player, unit, type, baseOn}) {
        let totalDamage = 0;
        switch(type) {
            case 'number':
                totalDamage = unit + player.status[baseOn];
            break;
        }
        return totalDamage;
    },
    AESEncrypt(data) {
        return Util.btoa(CryptoJS.AES.encrypt(data, key).toString());
    },
    AESEncryptJSON(data) {
        return Util.AESEncrypt(JSON.stringify(data));
    },
    AESDecrypt(data) {
        return CryptoJS.AES.decrypt(Util.atob(data), key).toString(CryptoJS.enc.Utf8);
    },
    AESDecryptJSON(data) {
        return JSON.parse(Util.AESDecrypt(data));
    },
    btoa(string) {
        return new Buffer.from(string).toString('base64');
    },
    atob(string) {
        return new Buffer.from(string, 'base64').toString('ascii');
    },
    now() {
        let date = new Date();
        return `${date.getHours()}:${date.getMinutes()}:${date.getSeconds()} ${date.getDate()}/${date.getMonth()}/${date.getFullYear()}`;
    },
    writeLog({url, name, value}) {
        axios.post(url, {
            embeds: [
                {
                    color: 15258703,
                    author: {
                        name: 'Solo Leveling Simulator',
                        icon_url: "https://i.imgur.com/R66g1Pe.jpg"
                    },
                    fields: [
                        {
                            name,
                            value,
                        },
                    ],
                    footer: {
                        text: `Tin nhắn được tạo lúc: ${Util.now()}`,
                    }
                }
            ]
        });
    }
}

module.exports = Util;