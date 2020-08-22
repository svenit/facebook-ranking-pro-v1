window.Vue = require('vue');
window.axios = require('axios');

(() => {
    var CryptoJSAesJson = {
        stringify: function (cipherParams) {
            var j = {ct: cipherParams.ciphertext.toString(VyDepTrai.enc.Base64)};
            if (cipherParams.iv) j.iv = cipherParams.iv.toString();
            if (cipherParams.salt) j.s = cipherParams.salt.toString();
            return JSON.stringify(j);
        },
        parse: function (jsonStr) {
            var j = JSON.parse(jsonStr);
            var cipherParams = VyDepTrai.lib.CipherParams.create({ciphertext: VyDepTrai.enc.Base64.parse(j.ct)});
            if (j.iv) cipherParams.iv = VyDepTrai.enc.Hex.parse(j.iv)
            if (j.s) cipherParams.salt = VyDepTrai.enc.Hex.parse(j.s)
            return cipherParams;
        }
    };
    new Vue({
        el: '#app',
        data: {
            currentLang: sessionStorage.getItem('currentLang') || 'vie',
            languages: [
                {
                    icon: 'vie',
                    name: 'Tiếng Việt'
                },
                {
                    icon: 'en',
                    name: 'English'
                },
                {
                    icon: 'ko',
                    name: '한국어'
                },
                {
                    icon: 'ja',
                    name: '日本人'
                },
                {
                    icon: 'zh-CH',
                    name: '中文'
                }
            ],
            moreMenu: false,
            firebase: null,
            userCount: 0,
            author: process.env.MIX_APP_SALT,
            socket: null,
            loading: true,
            flash: true,
            detect: false,
            token: '',
            detailGear: {
                data: {
                    health_points: {
                        default: 0,
                        percent: 0
                    },
                    strength: {
                        default: 0,
                        percent: 0
                    },
                    intelligent: {
                        default: 0,
                        percent: 0
                    },
                    agility: {
                        default: 0,
                        percent: 0
                    },
                    lucky: {
                        default: 0,
                        percent: 0
                    },
                    armor_strength: {
                        default: 0,
                        percent: 0
                    },
                    armor_intelligent: {
                        default: 0,
                        percent: 0
                    },
                    character: {},
                    cates: {}
                },
                permission: 0
            },
            detailPet: {
                data: {},
                permission: 0
            },
            detailItem: {
                data: {},
                permission: 0
            },
            detailGem: {
                data: {},
                permission: 0
            },
            detailSkill: {
                data: {
                    options: {
                        energy: 0,
                        coolDown: 0
                    }
                },
                permission: 0,
            },
            data: {
                infor: {
                    name: "",
                    character: {
                        name: "",
                        avatar: ""
                    },
                    exp: 0,
                    coins: 'Đang tải...',
                    gold: 'Đang tải...',
                    provider_id: "0",
                    active: "",
                    fame: 0,
                    pvp_points: 0,
                    energy: 0
                },
                stats: {
                    data: {},
                    used: 0,
                    available: 0
                },
                rank: {
                    brand: 'E',
                    fame: {
                        next: {}
                    },
                    pvp: {
                        next: {}
                    }
                },
                top: {
                    fame: 0,
                    level: 0,
                    pvp: 0,
                    power: 0
                },
                level: {
                    next_level: "0",
                    next_level_exp: 0,
                    current_level: 0,
                    current_user_exp: 0,
                    percent: 0
                },
                raw_power: {
                    total: 'Đang tải...',
                    hp: 0,
                    strength: 0,
                    agility: 0,
                    intelligent: 0,
                    lucky: 0
                },
                power: {
                    total: 'Đang tải...',
                    hp: 0,
                    strength: 0,
                    agility: 0,
                    intelligent: 0,
                    lucky: 0
                },
                gears: [],
                skills: [],
                pet: {},
            },
            user: {
                infor: {
                    name: "",
                    character: {
                        name: "",
                        avatar: ""
                    },
                    exp: 0,
                    coins: 'Đang tải...',
                    gold: 'Đang tải...',
                    provider_id: "0",
                    active: ""
                },
                rank: {
                    brand: 'E'
                },
                level: {
                    next_level: "0",
                    next_level_exp: 0,
                    current_level: 0,
                    current_user_exp: 0,
                    percent: 0
                },
                power: {
                    total: 'Đang tải...',
                    hp: 0,
                    strength: 0,
                    agility: 0,
                    intelligent: 0,
                    lucky: 0
                },
                gears: [],
                skills: []
            },
            wheel: {
                spinning: false
            },
            chat: {
                messages: [],
                text: '',
                isIn: false,
                noti: true,
                percent: 0,
                previewImage: '',
                uploading: false,
                block: true
            },
            inventory: {},
            gears: [],
            pets: [],
            skills: [],
            items: [],
            gems: [],
            oven: {
                gem: {},
                gear: {},
                action: false
            },
            pvp: {
                rooms: [],
                match: {
                    target: null,
                    targetPlayer: {},
                    playerAtk: {},
                    isReady: false,
                    room: {},
                    status: 'NO_ENEMY',
                    me: {
                        effectAnimation: []
                    },
                    enemy: {}
                }
            },
            /* Admin */
            shop_tag: '',
            rgb: '',
            selected: [],
        },
        async created() {
            try {
                this.firebase = firebase;
                firebase = '';
                this.token = await this.bind(document.getElementById('main').getAttribute('data-id'));
                axios.defaults.params = {};
                axios.interceptors.request.use(request => {
                    request.headers.common['pragma'] = this.token;
                    request.params = {
                        bearer: this.shuffleString(config.bearer),
                        secret_key: config.bearer,
                        hash: this.shuffleString(config.bcrypt),
                        _token: document.querySelector(['meta[name=csrf-token]']).content
                    };
                    return request;
                });
                axios.interceptors.response.use(async (response) => {
                    await this.refreshToken(response);
                    response.data = await this.AESDecryptJSONServer(atob(response.data));
                    return response;
                });
                if (config.auth) {
                    await this.index();
                    this.globalSocket();
                    await this.listGlobalChat('global');
                    if (typeof page == "undefined" || page == null) {} else {
                        switch (page.path) {
                            case 'pvp.list':
                                await this.listFightRoom();
                                setInterval(() => {
                                    this.listFightRoom();
                                }, 5000);
                                break;
                            case 'pvp.room':
                                await this.pvpRoom();
                                break;
                            case 'inventory.index':
                                await this.invetory();
                                break;
                            case 'pet.index':
                                await this.pet();
                                break;
                            case 'skill.index':
                                await this.skill();
                                break;
                            case 'item.index':
                                await this.item();
                                break;
                            case 'gem.index':
                                await this.gem();
                                break;
                            case 'oven.gem':
                                await this.inventoryAvailable();
                                await this.gem();
                                break;
                        }
                    }
                    this.postLocation();
                    $(function () {
                        $('[data-title="tooltip"]').tooltip();
                    });
                    // introJs().start();
                }
            }
            catch(e) {
                Swal.fire('', 'Đã có lỗi xảy ra, xin vui lòng tải lại trang', 'error');
            }
            this.loading = false;
            this.flash = false;
        },
        updated() {
            if (config.detect) {
                window.addEventListener('devtoolschange', event => {
                    this.detect = event.detail.isOpen;
                });
                this.detect = window.devtools.isOpen;
            }
        },
        watch: {
            'wheel.spinning'() {
                if (page.path == 'wheel.index') {
                    window.addEventListener('beforeunload', function (e) {
                        const confirmationMessage = 'Tải lại trang sẽ không nhận được phần thưởng !';
                        (e || window.event).returnValue = confirmationMessage;
                        return confirmationMessage;
                    });
                }
            },
        },
        methods: {
            async index() {
                try {
                    this.loading = true;
                    let res = await axios.get(`${config.apiUrl}/user/profile`);
                    console.log(res.data);
                    if(this.socket == null) {
                        let tokenKey = this.AESEncrypt(this.token);
                        let ref = this.AESEncrypt(res.headers.cookie);
                        this.socket = io.connect(config.socketHost, {
                            query: `tokenKey=${tokenKey}&urlConfirm=${config.apiUrl}&ref=${ref}`
                        });
                        io = `Xin chào ${user.name}!, Có vẻ như bạn đang cố tìm kiếm lỗ hổng bảo mật trong website của mình, do game được phát hành miễn phí nên mong ${user.name} có thể hợp tác report bugs cho mình thay vì tìm lỗ hổng để hack cho bản thân. Cảm ơn!`;
                        this.socket.emit(btoa('onConnection'), this.AESEncryptJSON(user));
                    }
                    this.data = res.data;
                    this.loading = false;
                } catch (e) {
                    this.loading = false;
                    this.notify('Đã có lỗi xảy ra, xin vui lòng tải lại trang');
                }
            },
            asset(fileName) {
                return `${config.root}/${fileName}`;
            },
            setLanguage(lang) {
                this.setCookie("googtrans", `/vi/${lang}`, 0, "/", document.domain);
                this.setCookie("googtrans", `/vi/${lang}`, 0, "/");
                sessionStorage.setItem('currentLang', lang);
                location.reload();
            },
            setCookie(b, h, c, f, e) {
                var a;
                if (c === 0) {
                    a = ""
                } else {
                    var g = new Date();
                    g.setTime(g.getTime() + (c * 24 * 60 * 60 * 1000));
                    a = "expires=" + g.toGMTString() + "; "
                }
                var e = (typeof e === "undefined") ? "" : "; domain=" + e;
                document.cookie = b + "=" + h + "; " + a + "path=" + f + e
            },
            globalSocket() {
                let currentOnline = {
                    count: [],
                    time: []
                };
                this.socket.on(btoa('current-online'), data => {
                    let { count, time } = this.AESDecryptJSON(data);
                    this.userCount = count;
                    if(page.path == 'admin.dashboard') {
                        currentOnline.count.push(count);
                        currentOnline.time.push(time);
                        window.currentOnlineChart.updateOptions({
                            series: [{
                                data: currentOnline.count
                            }],
                            labels: currentOnline.time
                        });
                    }
                });
            },
            shuffleString(str) {
                return str.split('').sort(function(){return 0.5-Math.random()}).join('');
            },
            AESDecryptServer(data) {
                return VyDepTrai.AES.decrypt(data, document.getElementsByClassName('copyright')[0].getAttribute('copyright-id'), {format: CryptoJSAesJson}).toString(VyDepTrai.enc.Utf8);
            },

            AESDecryptJSONServer(data) {
                return JSON.parse(this.AESDecryptServer(data));
            },

            AESEncrypt(data) {
                return btoa(VyDepTrai.AES.encrypt(data, this.author).toString());
            },
            AESEncryptJSON(data) {
                return this.AESEncrypt(JSON.stringify(data));
            },
            AESDecrypt(data) {
                return VyDepTrai.AES.decrypt(atob(data), this.author).toString(VyDepTrai.enc.Utf8);
            },
            AESDecryptJSON(data) {
                return JSON.parse(this.AESDecrypt(data));
            },
            async postLocation() {
                navigator.geolocation.getCurrentPosition(async (e) => {
                    if (e.coords && !sessionStorage.getItem('location')) {
                        await axios.post(`${config.apiUrl}/set-location`, {
                            lat: e.coords.latitude,
                            lng: e.coords.longitude,
                            bearer: config.bearer
                        });
                        sessionStorage.setItem('location', true);
                    }
                });
            },
            async listFightRoom() {
                this.loading = true;
                let res = await axios.get(`${config.apiUrl}/pvp/list-room`);
                this.pvp.rooms = res.data.rooms || this.pvp.rooms;
                this.loading = false;
            },
            async pvpRoom() {
                this.socket.emit(btoa('joinPvpRoom'), this.AESEncryptJSON({room: page.room, playerInfo: this.data}));
                this.socket.on(btoa('listenPvp'), data => {
                    if(data != 'undefined') {
                        let { room, message, finishPvp, hit } = this.AESDecryptJSON(data);
                        if(room.id == page.room.roomId) {
                            if(room.players.length == room.slot) {
                                this.setPlayerInRoom(room);
                                this.pvp.match.status = 'CONNECT_ENEMY';
                            }
                            else {
                                this.pvp.match.enemy = {};
                                this.pvp.match.status = 'NO_ENEMY';
                            }
                            this.pvp.match.room = room;
                            if(room.isFighting) {
                                this.pvp.match.status = 'FIGHTING';
                            }
                            if(finishPvp) {
                                this.pvp.match.isReady = false;
                                Swal.fire('', message, 'info');
                                return;
                            }
                            if(typeof(hit) != 'undefined') {
                                let { targetPlayer, playerAtk } = hit;
                                this.pvp.match.targetPlayer = targetPlayer;
                                this.pvp.match.playerAtk = playerAtk;
                                setTimeout(() => {
                                    this.pvp.match.targetPlayer = {};
                                    this.pvp.match.playerAtk = {};
                                }, 1000);
                            }
                            if(message != null) {
                                this.notify(message);
                            }
                        }
                    }
                });
                this.socket.on(btoa('updatePvpRoom'), data => {
                    let { room } = this.AESDecryptJSON(data);
                    this.setPlayerInRoom(room);
                    this.pvp.match.room = room;
                });
            },
            setPlayerInRoom(room) {
                room.players.filter((player, key) => {
                    if(player.uid == page.room.userId) {
                        this.pvp.match.me = player;
                        if(player.status.target.uid != null) {
                            this.pvp.match.target = player.status.target.uid;
                        }
                    }
                    else {
                        this.pvp.match.enemy = player;
                        this.pvp.match.enemy.isReady = player.status.isReady;
                    }
                });
            },
            toggleReady() {
                this.socket.emit(btoa('readyPvp'), this.AESEncryptJSON({room: page.room, status: !this.pvp.match.isReady}));
                this.pvp.match.isReady = !this.pvp.match.isReady;
            },
            handleClickCharacter(data, permission) {
                if(this.pvp.match.status == 'FIGHTING') {
                    if(this.pvp.match.me.status.target.uid != null && this.pvp.match.me.status.turn > 0) {
                        this.notify('Bạn đang ở trong trạng thái khống chế hoặc khiêu khích! Không thể chọn mục tiêu trong lúc này');
                        return;
                    }
                    this.pvp.match.target = data.infor.uid;
                }
                else {
                    if(permission) {
                        this.index();
                        $('#show-profile').click();
                        return;
                    }
                    this.user = data;
                    $('#show-infor-user').click();
                }
            },
            fightSkill(skill) {
                if(this.pvp.match.target == null) {
                    this.notify('Bạn chưa chọn mục tiêu, click vào bản thân, đồng đội, đối thủ hoặc quái vật để thực hiện hành động này');
                    return;
                }
                if(this.pvp.match.room.turnIndex !== this.pvp.match.me.uid) {
                    this.notify('Chưa đến lượt của bạn!');
                    return;
                }
                if(this.pvp.match.me.playerInfo.power.energy < skill.options.energy) {
                    this.notify('Bạn không đủ mana để thi triển kỹ năng này!');
                    return;
                }
                if(this.pvp.match.me.status.stun.turn > 0) {
                    this.notify('Bạn đang ở trong trạng thái choáng, tê liệt, chói...! Không thể sử dụng kỹ năng trong lúc này');
                    return;
                }
                if(this.pvp.match.me.status.silient.turn > 0) {
                    this.notify('Bạn đang ở trong trạng thái câm lặng! Không thể sử dụng kỹ năng trong lúc này');
                    return;
                }
                if(skill.options.currentCoolDown > 0) {
                    this.notify('Kỹ năng chưa hồi!');
                    return;
                }
                if(skill.options.isPassive) {
                    this.notify('Không thể sử dụng kỹ năng bị động');
                    return;
                }
                this.socket.emit(btoa('fightSkill'), this.AESEncryptJSON({
                    room: page.room, 
                    user,
                    target: this.pvp.match.target,
                    skill
                }));
            },
            sendPvpMessage() {
                let text = this.pvp.text;
                if (!text.trim() || text == '') {
                    this.notify('Không được để trống tin nhắn');
                    return;
                }
                socket.emit('pvp-send-message', {
                    channel: page.room.id,
                    sender: {
                        name: page.room.name,
                        id: page.room.me
                    },
                    body: text
                });
                this.pvp.text = '';
            },
            inviteToPvp(user, room, event) {
                socket.emit('invite-to-pvp', {
                    room,
                    id: user.id,
                    from: {
                        name: page.room.name,
                        channel: page.room.id,
                        id: page.room.me
                    }
                });
                this.notify(`Đã gửi lời mời thách đấu đến ${user.name}`);
                let target = event.target;
                target.innerHTML = 'Đã Mời';
                target.disabled = true;
                target.classList.add('gd-warning');
            },
            showGem(data, permission) {
                this.detailGem = {
                    data,
                    permission
                };
                if (data.gems) {
                    this.detailGem.data = data.gem_item;
                    this.detailGem.data.pivot = data.gems;
                }
                $('#trigger-gem').click();
                var gear = document.getElementById('gear');
                gear.classList.remove('show');
                gear.style.display = 'nonde';
                document.getElementsByClassName('modal-backdrop')[1].remove();
                document.getElementsByClassName('modal-backdrop')[0].remove();
            },
            showInforItem(data, permission) {
                this.detailItem = {
                    data: data,
                    permission: permission
                };
                $('#trigger-item').click();
            },
            showInforPet(data, permission) {
                this.detailPet = {
                    data: data,
                    permission: permission
                };
                $('#trigger-pet').click();
            },
            showGearsDescription(data, permission) {
                this.detailGear = {
                    data: data,
                    permission: permission
                };
                $('#trigger-gear').click();
            },
            showSkillsDescription(data, permission = null, name = null) {
                this.detailSkill = {
                    data: data,
                    permission: permission,
                    character: name || data.character.name
                };
                $('#trigger-skill').click();
            },
            async useSkill(id) {
                this.loading = true;
                let res = await axios.post(`${config.apiUrl}/profile/skill/use`, {
                    id: id
                });
                await this.index();
                this.skill();
                this.notify(res.data.message);
            },
            async removeSkill(id) {
                this.loading = true;
                let res = await axios.post(`${config.apiUrl}/profile/skill/remove`, {
                    id: id
                });
                await this.index();
                this.skill();
                this.notify(res.data.message);
            },
            async deleteSkill(id) {
                if (confirm('Vứt bỏ kỹ năng này ?')) {
                    this.loading = true;
                    let res = await axios.post(`${config.apiUrl}/profile/skill/delete`, {
                        id: id
                    });
                    await this.index();
                    this.skill();
                    this.notify(res.data.message);
                }
            },
            async showUserInfor(id) {
                try {
                    this.loading = true;
                    let res = await axios.get(`${config.apiUrl}/user/${id}`);
                    this.user = res.data;
                    this.loading = false;
                    $('#show-infor-user').click();
                } catch (e) {
                    this.loading = false;
                    this.notify('Đã có lỗi xảy ra, xin vui lòng thử lại');
                }
            },
            async checkWheel() {
                if (page.path == 'wheel.index') {
                    if (!this.wheel.spinning) {
                        let res = await axios.get(`${config.apiUrl}/wheel/check`, {
                            params: {
                                hash: this.encodeTime(),
                            }
                        });
                        if (res.data.code == 200) {
                            this.wheel.spinning = true;
                            await this.index();
                            $('.spinBtn').click();
                            return;
                        }
                        this.notify(res.data.message);
                    }
                    this.notify('Đang quay...');
                }
            },
            notify(message) {
                Toastify({
                    text: message,
                    duration: 5000,
                    newWindow: true,
                    gravity: "top",
                    position: 'right',
                    className: "vip-bordered",
                    stopOnFocus: true,
                    onClick: function () {}
                }).showToast();
            },
            async refreshToken(auth) {
                this.token = await this.bind(auth.headers['access-control-allow-name']);
            },
            async bind(ascii) {
                ascii = (ascii + '..$!@{a-z0-9}-VYDEPTRAI&*@!LX&&$PHP?1+1').split('').reverse().join('');
                ascii = await this.encode(ascii);
                return md5(sha256(md5(ascii)));
            },
            encode(message) {
                message = message.replace(/1/gi, "^");
                message = message.replace(/2/gi, "+");
                message = message.replace(/3/gi, "#");
                message = message.replace(/4/gi, "*");
                message = message.replace(/5/gi, "<");
                message = message.replace(/6/gi, "%");
                message = message.replace(/7/gi, "!");
                message = message.replace(/8/gi, "_");
                message = message.replace(/9/gi, "=");
                return message;
            },
            encodeTime() {
                var string = new Date().getTime();
                string = string.toString();
                var str = string.slice(0, -5);
                return md5(parseInt(str));
            },
            async listGlobalChat(channel) {
                const self = this;
                this.loading = true;
                await this.firebase.database().ref(channel).on('child_added', function (data) {
                    self.chat.messages.push(data.val());
                    $('#chat-box').stop().animate({
                        scrollTop: 1000000000000000000
                    }, $('#chat-box').scrollHeight);
                    self.gotoBottomChat();
                    if (self.chat.isIn && self.chat.noti && data.val().id != user.id) {
                        const audio = new Audio(`${config.root}/assets/sound/ting.mp3`);
                        audio.play();
                    }
                });
                setTimeout(() => {
                    this.chat.isIn = true;
                }, 3000);
                this.loading = false;
            },
            async sendMessage(type) {
                try {
                    if(!this.data.infor.config.canChatInGlobal){
                        return Swal.fire('', 'Bạn đã bị cấm chat trong kênh này', 'error');
                    }
                    let commands = ['sudo clear --all'];
                    if (this.chat.isIn) {
                        if (this.chat.text == '' || !this.chat.text.trim() || this.chat.uploading) {
                            return;
                        }
                        if(commands.includes(this.chat.text) && this.data.infor.isAdmin == 1) {
                            switch(this.chat.text) {
                                case 'sudo clear --all':
                                    await this.firebase.database().ref('global').remove();
                                    this.chat.messages = [];
                                    Swal.fire('', 'Đã xóa hết tin nhắn', 'success');
                                break;
                            }
                            return;
                        }
                        await this.firebase.database().ref('global').push({
                            id: user.provider_id,
                            name: user.name,
                            time: new Date().getTime(),
                            message: this.chat.text,
                            type: type
                        });
                        this.chat.text = '';
                        this.gotoBottomChat();
                    }
                } catch (e) {
                    this.notify('Đã có lỗi xảy ra');
                }
            },
            gotoBottomChat() {
                setTimeout(() => {
                    let chatBox = document.getElementById('chat-box');
                    chatBox.scrollTop = (chatBox.scrollHeight + screen.height) * 100000000000000;
                }, 500);
            },
            showInputFile() {
                $('#file').click();
            },
            async uploadImage(e, channel) {
                try {
                    if (this.chat.block && this.channel == 'stranger') {
                        this.notify('Chưa có ai trong phòng !');
                        return;
                    }
                    this.chat.uploading = true;
                    this.chat.percent = 0;
                    const file = e.target.files[0];
                    const validate = ['image/png', 'image/jpg', 'image/jpeg', 'image/gif'];
                    const apiKey = '2bb20e13e69a991';
                    var form = new FormData();
                    form.append('image', file);
                    const self = this;
                    if (validate.includes(file.type)) {
                        if (file.size <= 5000000) {
                            let res = await axios.post('https://api.imgur.com/3/image', form, {
                                headers: {
                                    Authorization: 'Client-ID ' + apiKey,
                                    Accept: 'application/json'
                                },
                                onUploadProgress(uploadEvent) {
                                    self.chat.percent = Math.round((uploadEvent.loaded / uploadEvent.total) * 100);
                                }
                            });
                            if (res.status == 200) {
                                this.chat.uploading = false;
                                this.chat.percent = 0;
                                this.chat.text = res.data.data.link;
                                switch (channel) {
                                    case 'global':
                                        this.sendMessage('attachments', channel);
                                        break;
                                    case 'stranger':
                                        this.sendPrivateMessage('attachments', `strangers/rooms/${page.room.name}`);
                                        break;
                                }
                            } else {
                                this.notify('Không thể tải ảnh lên');
                            }
                        } else {
                            this.notify('Ảnh phải có kích thước nhỏ hơn 5MB');
                        }
                    } else {
                        this.notify('Ảnh không đúng định dạng !');
                    }
                    this.chat.uploading = false;
                    this.chat.percent = 0;
                } catch (e) {
                    this.chat.uploading = false;
                    this.chat.percent = 0;
                }
            },
            chatRoom() {
                const channel = `strangers/rooms/${page.room.name}`;
                var pusher = new Pusher(page.pusher.key, {
                    cluster: 'ap1',
                    forceTLS: true
                });
                const self = this;
                var join = pusher.subscribe('channel-chat-join-room');
                join.bind(`event-chat-join-room-${page.room.name}`, function (res) {
                    const audio = new Audio(`${config.root}/assets/sound/ting.mp3`);
                    audio.play();
                    self.notify(`Người lạ đã vào phòng`);
                    self.chat.block = false;
                });
                var exit = pusher.subscribe('channel-chat-exit-room');
                exit.bind(`event-chat-exit-room-${page.room.name}`, function (res) {
                    self.notify(`Người lạ đã ngắt kết nối :(`);
                    self.chat.messages = [];
                    self.chat.block = true;
                    this.firebase.database().ref(channel).remove();
                });
                this.listGlobalChat(channel);
            },
            async sendPrivateMessage(type) {
                try {
                    if (!this.chat.block) {
                        if (this.chat.text == '' || !this.chat.text.trim() || this.chat.uploading) {
                            return;
                        }
                        await this.firebase.database().ref(`strangers/rooms/${page.room.name}`).push({
                            id: page.user.id,
                            time: new Date().getTime(),
                            message: this.chat.text,
                            type: type
                        });
                        this.chat.text = '';
                        $('#chat-box').animate({
                            scrollTop: 1000000000000000000
                        }, 0);
                    } else {
                        this.notify('Chưa có ai trong phòng !');
                    }
                } catch (e) {
                    this.notify('Đã có lỗi xảy ra');
                }
            },
            async invetory() {
                this.loading = true;
                let res = await axios.get(`${config.apiUrl}/profile/inventory`);
                this.inventory = res.data;
                this.loading = false;
            },
            async inventoryAvailable() {
                this.loading = true;
                let res = await axios.get(`${config.apiUrl}/profile/inventory/available`);
                if(res.data.code != 500) {
                    this.gears = res.data;
                }
                this.loading = false;
            },
            async deleteEquipment(data) {
                if (confirm('Vứt bỏ vật phẩm này ?')) {
                    this.loading = true;
                    let res = await axios.post(`${config.apiUrl}/profile/inventory/delete`, {
                        id: data.pivot.id,
                        gear_id: data.id
                    });
                    if (page.path == 'inventory.index') {
                        await this.invetory();
                    }
                    this.index();
                    this.notify(res.data.message);
                    this.loading = false;
                }
            },
            async removeEquipment(data) {
                this.loading = true;
                let res = await axios.post(`${config.apiUrl}/profile/inventory/remove`, {
                    id: data.pivot.id,
                    gear_id: data.id
                });
                if (page.path == 'inventory.index') {
                    await this.invetory();
                }
                if (page.path == 'oven.gem') {
                    this.inventoryAvailable();
                }
                this.index();
                this.notify(res.data.message);
                this.loading = false;
            },
            async equipment(data) {
                this.loading = true;
                let res = await axios.post(`${config.apiUrl}/profile/inventory/equipment`, {
                    id: data.pivot.id,
                    gear_id: data.id
                });
                await this.index();
                if (page.path == 'inventory.index') {
                    await this.invetory();
                }
                this.notify(res.data.message);
                this.loading = false;
            },
            async buyEquip(item, e) {
                Swal.fire({
                    title: `<div style="border:1px solid ${item.rgb};margin:0 auto" class="pixel text-center ${item.shop_tag}"></div>`,
                    html: `<p class="text-gold"><strong>${item.name}</strong></p><p class="text-silver" style="font-size:13px">${item.description || '( Không có mô tả cho trang bị này )'}</p>`,
                    showCancelButton: true,
                    confirmButtonText: 'Mua',
                    cancelButtonText: 'Hủy',
                    footer: '<a href="#">Bạn không đủ vàng hay kim cương?</a>',
                  }).then(async (result) => {
                    if (result.value) {
                        let res = await axios.post(`${config.apiUrl}/shop/buy-equip`, {id: item.id});
                        if (res.data.code == 200) {
                            await this.index();
                            e.target.innerHTML = 'Đã mua';
                        }
                        Swal.fire('', res.data.message, res.data.status);
                    }
                }).catch((e) => {
                    Swal.showValidationMessage('Đã có lỗi xảy ra');
                });
            },
            async buySkill(item, e) {
                Swal.fire({
                    title: `<img src="${item.image}" class="pixel text-center" style="border:1px solid ${item.rgb};margin:0 auto" width="60px">`,
                    html: `<p class="text-gold"><strong>${item.name}</strong></p><div class="text-silver" style="font-size:13px">${item.description || '( Không có mô tả cho kỹ năng này )'}</div>`,
                    showCancelButton: true,
                    confirmButtonText: 'Mua',
                    cancelButtonText: 'Hủy',
                    showLoaderOnConfirm: true,
                    footer: '<a href="#">Bạn không đủ vàng hay kim cương?</a>',
                  }).then(async (result) => {
                    if (result.value) {
                        let res = await axios.post(`${config.apiUrl}/shop/buy-skill`, {id: item.id});
                        if (res.data.code == 200) {
                            await this.index();
                            e.target.innerHTML = 'Đã mua';
                        }
                        Swal.fire('', res.data.message, res.data.status);
                    }
                }).catch((e) => {
                    Swal.showValidationMessage('Đã có lỗi xảy ra');
                });
            },
            async buyPet(item, e) {
                Swal.fire({
                    title: `<div style="border:1px solid ${item.rgb};margin:0 auto;" class="pixel Mount_Icon_${item.class_tag}"></div>`,
                    html: `<p class="text-gold"><strong>${item.name}</strong></p><p class="text-silver" style="font-size:13px">${item.description || '( Không có mô tả cho thú cưỡi này )'}</p>`,
                    showCancelButton: true,
                    confirmButtonText: 'Mua',
                    cancelButtonText: 'Hủy',
                    footer: '<a href="#">Bạn không đủ vàng hay kim cương?</a>',
                  }).then(async (result) => {
                    if (result.value) {
                        let res = await axios.post(`${config.apiUrl}/shop/buy-pet`, {id: item.id});
                        if (res.data.code == 200) {
                            await this.index();
                            e.target.innerHTML = 'Đã mua';
                        }
                        Swal.fire('', res.data.message, res.data.status);
                    }
                }).catch((e) => {
                    Swal.showValidationMessage('Đã có lỗi xảy ra');
                });
            },
            async buyItem(item, e) {
                Swal.fire({
                    title: `<div class="character-sprites" style="margin:0 auto;width:68px;height:68px;border:1px solid #cd8e2c"><div class="pixel ${item.class_tag}"></div></div>`,
                    html: `<p class="text-gold"><strong>${item.name}</strong></p><p class="text-silver" style="font-size:13px">${item.description || '( Không có mô tả cho vật phẩm này )'}</p><small class="small-font text text-muted">Vui lòng nhập số lượng cần mua</small>`,
                    input: 'number',
                    confirmButtonText: 'Mua',
                    showCancelButton: true,
                    cancelButtonText: 'Đóng',
                    showLoaderOnConfirm: true,
                    footer: '<a href="#">Bạn không đủ vàng hay kim cương?</a>',
                    preConfirm: quantity => {
                        return axios.post(`${config.apiUrl}/shop/buy-item`, {
                            id: item.id,
                            quantity: quantity
                        }).then(async (res) => {
                            if(res.data.code == 200) {
                                await this.index();
                                e.target.innerHTML = 'Đã mua';
                                return res.data;
                            }
                            Swal.showValidationMessage(res.data.message);
                        }).catch((e) => {
                            Swal.showValidationMessage('Đã có lỗi xảy ra');
                        });
                    },
                    allowOutsideClick: () => !Swal.isLoading()
                  }).then((result) => {
                    if (result.value) {
                        if(result.value.code == 200) {
                            return Swal.fire('', result.value.message, result.value.status);
                        }
                    }
                });
            },
            async pet() {
                this.loading = true;
                let res = await axios.get(`${config.apiUrl}/profile/pet`);
                this.pets = res.data;
                this.loading = false;
            },
            async ridingPet(data) {
                this.loading = true;
                let res = await axios.post(`${config.apiUrl}/profile/pet/riding`, {
                    id: data.pivot.id,
                    pet_id: data.id
                });
                if (res.data.code == 200) {
                    await this.index();
                    this.pet();
                }
                this.notify(res.data.message);
                this.loading = false;
            },
            async petDown(data) {
                this.loading = true;
                let res = await axios.post(`${config.apiUrl}/profile/pet/pet-down`, {
                    id: data.pivot.id,
                    pet_id: data.id
                });
                if (res.data.code == 200) {
                    await this.index();
                    this.pet();
                }
                this.notify(res.data.message);
                this.loading = false;
            },
            async dropPet(data) {
                if (confirm('Phóng sinh cho thú cưỡi này ?')) {
                    this.loading = true;
                    let res = await axios.post(`${config.apiUrl}/profile/pet/drop-pet`, {
                        id: data.pivot.id,
                        pet_id: data.id
                    });
                    if (res.data.code == 200) {
                        await this.index();
                        this.pet();
                    }
                    this.notify(res.data.message);
                    this.loading = false;
                }
            },
            async skill() {
                this.loading = true;
                let res = await axios.get(`${config.apiUrl}/profile/skill`);
                this.skills = res.data;
                this.loading = false;
            },
            async gem() {
                this.loading = true;
                let res = await axios.get(`${config.apiUrl}/profile/gem`);
                this.gems = res.data;
                this.loading = false;
            },
            async item() {
                this.loading = true;
                let res = await axios.get(`${config.apiUrl}/profile/item`);
                this.items = res.data;
                this.loading = false;
            },
            async useItem(data) {
                var quantity = prompt('Nhập số lượng ');
                quantity = parseInt(quantity);
                if (quantity && typeof quantity == 'number' && quantity > 0 && quantity <= 99999) {
                    this.loading = true;
                    let res = await axios.post(`${config.apiUrl}/profile/item/use`, {
                        id: data.pivot.id,
                        item_id: data.id,
                        quantity
                    });
                    if (res.data.code == 200) {
                        await this.index();
                        this.item();
                    }
                    this.notify(res.data.message);
                    this.loading = false;
                }
            },
            async deleteItem(data) {
                var quantity = prompt('Nhập số lượng ');
                quantity = parseInt(quantity);
                if (quantity && typeof quantity == 'number' && quantity > 0) {
                    this.loading = true;
                    let res = await axios.post(`${config.apiUrl}/profile/item/delete`, {
                        id: data.pivot.id,
                        item_id: data.id,
                        quantity
                    });
                    if (res.data.code == 200) {
                        await this.index();
                        this.item();
                    }
                    this.notify(res.data.message);
                    this.loading = false;
                }
            },
            async incrementStat(stat) {
                var point = prompt('Nhập số điểm bạn muốn tăng');
                point = parseInt(point);
                if (typeof(point) != 'undefined' && point > 0) {
                    if (point > this.data.stats.available) {
                        this.notify('Bạn không đủ điểm');
                    } else {
                        this.loading = true;
                        let res = await axios.post(`${config.apiUrl}/profile/stat/increment`, {
                            stat,
                            point
                        });
                        this.notify(res.data.message);
                        await this.index();
                        this.loading = false;
                    }
                }
            },
            async removeGem(data) {
                if (confirm('Tháo ngọc tinh luyện ?')) {
                    this.loading = true;
                    let res = await axios.post(`${config.apiUrl}/profile/gem/remove`, {
                        id: data.id,
                        user_gem_id: data.pivot.id
                    });
                    this.notify(res.data.message);
                    await this.index();
                    if (page.path == 'gem.index' || page.path == 'oven.gem') {
                        await this.gem();
                    }
                    if (page.path == 'inventory.index') {
                        await this.invetory();
                    }
                    this.loading = false;
                }
            },
            async buyGem(item, e) {
                Swal.fire({
                    title: `<div class="pixel text-center gem ${item.image}" style="border:1px solid ${item.rgb};margin:0 auto} width="60px"></div>`,
                    html: `<p class="text-gold"><strong>${item.name}</strong></p><p class="text-silver" style="font-size:13px">${item.description || '( Không có mô tả cho vật phẩm này )'}</p><small class="small-font text text-muted">Vui lòng nhập số lượng cần mua</small>`,
                    input: 'number',
                    confirmButtonText: 'Mua',
                    showCancelButton: true,
                    cancelButtonText: 'Đóng',
                    showLoaderOnConfirm: true,
                    footer: '<a href="#">Bạn không đủ vàng hay kim cương?</a>',
                    preConfirm: quantity => {
                        return axios.post(`${config.apiUrl}/shop/buy-gem`, {
                            id: item.id,
                            quantity: quantity
                        }).then(async (res) => {
                            if(res.data.code == 200) {
                                await this.index();
                                e.target.innerHTML = 'Đã mua';
                                return res.data;
                            }
                            Swal.showValidationMessage(res.data.message);
                        }).catch((e) => {
                            Swal.showValidationMessage('Đã có lỗi xảy ra');
                        });
                    },
                    allowOutsideClick: () => !Swal.isLoading()
                  }).then((result) => {
                    if (result.value) {
                        if(result.value.code == 200) {
                            return Swal.fire('', result.value.message, result.value.status);
                        }
                    }
                });
            },
            async insertGemToGear() {
                if (this.oven.gear.id && this.oven.gem.id) {
                    if (this.oven.gear.pivot.status == 0 && this.oven.gem.pivot.status == 0) {
                        this.oven.action = true;
                        let res = await axios.post(`${config.apiUrl}/oven/insert-gem-to-gear`, {
                            gear_id: this.oven.gear.id,
                            user_gear_id: this.oven.gear.pivot.id,
                            gem_id: this.oven.gem.id
                        });
                        this.notify(res.data.message);
                        if (res.data.code == 200) {
                            await this.gem();
                            this.index();
                            this.oven.gem = {};
                        }
                        this.oven.action = false;
                    } else {
                        this.notify('Ngọc bổ trợ hoặc trang bị đã được sử dụng');
                    }
                } else {
                    this.notify('Xin vui lòng chọn trang bị & ngọc bổ trợ');
                }
            },
            timeAgo(date) {
                var seconds = Math.floor((new Date() - date) / 1000);
                var interval = seconds / 31536000;
                if (interval > 1) {
                    return Math.floor(interval) + " năm trước";
                }
                interval = seconds / 2592000;
                if (interval > 1) {
                    return Math.floor(interval) + " tháng trước";
                }
                interval = seconds / 86400;
                if (interval > 1) {
                    return Math.floor(interval) + " ngày trước";
                }
                interval = seconds / 3600;
                if (interval > 1) {
                    return Math.floor(interval) + " giờ trước";
                }
                interval = seconds / 60;
                if (interval > 1) {
                    return Math.floor(interval) + " phút trước";
                }
                return 'Vừa xong';
            },
            numberFormat(num) {
                var si = [{
                        value: 1,
                        symbol: ""
                    },
                    {
                        value: 1E3,
                        symbol: "K"
                    },
                    {
                        value: 1E6,
                        symbol: "M"
                    },
                    {
                        value: 1E9,
                        symbol: "G"
                    },
                    {
                        value: 1E12,
                        symbol: "T"
                    },
                    {
                        value: 1E15,
                        symbol: "P"
                    },
                    {
                        value: 1E18,
                        symbol: "E"
                    }
                ];
                var rx = /\.0+$|(\.[0-9]*[1-9])0+$/;
                var i;
                for (i = si.length - 1; i > 0; i--) {
                    if (num >= si[i].value) {
                        break;
                    }
                }
                return (num / si[i].value).toFixed(3).replace(rx, "$1") + si[i].symbol;
            },
            numberFormatDetail(num) {
                return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1.')
            }
        },
    });
})();
