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
    const app = new Vue({
        el: '#app',
        data: {
            author: "let author = 'sven307';console.log(author);",
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
                    pvp_points: 0
                },
                stats: {
                    data: {},
                    used: 0,
                    available: 0
                },
                rank: {
                    power: 'Đang tải...',
                    rich: 0
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
                    power: 'Đang tải...',
                    rich: 0
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
                response.data = await this.AESDecryptJSONServer(response.data);
                return response;
            });
            if (config.auth) {
                await this.index();
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
                        case 'chat.global':
                            await this.listGlobalChat('global');
                            break;
                        case 'chat.stranger':
                            if (page.room.people == 2) {
                                this.chat.block = false;
                            } else {
                                this.chat.message = [];
                            }
                            await this.chatRoom();
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
                    console.log(e);
                    this.loading = false;
                    this.notify('Đã có lỗi xảy ra, xin vui lòng tải lại trang');
                }
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
                        let { room, message, finishPvp } = this.AESDecryptJSON(data);
                        console.log(room);
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
                                console.log('Kết thúc', room);
                                return;
                            }
                            this.notify(message);
                        }
                    }
                });
                this.socket.on(btoa('updatePvpRoom'), data => {
                    let { room } = this.AESDecryptJSON(data);
                    console.log(room);
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
                    console.log(e);
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
                this.token = await this.bind(auth.headers.authorization);
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
                await firebase.database().ref(channel).on('child_added', function (data) {
                    self.chat.messages.push(data.val());
                    $('#chat-box').stop().animate({
                        scrollTop: 1000000000000000000
                    }, $('#chat-box').scrollHeight);
                    if (self.chat.isIn && self.chat.noti && data.val().id != page.user.id) {
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
                    if (this.chat.isIn) {
                        if (this.chat.text == '' || !this.chat.text.trim() || this.chat.uploading) {
                            return;
                        }
                        await firebase.database().ref('global').push({
                            id: page.user.id,
                            name: page.user.name,
                            time: new Date().getTime(),
                            message: this.chat.text,
                            type: type
                        });
                        this.chat.text = '';
                        $('#chat-box').animate({
                            scrollTop: 1000000000000000000
                        }, 0);
                    }
                } catch (e) {
                    this.notify('Đã có lỗi xảy ra');
                    console.log(e);
                }
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
                    firebase.database().ref(channel).remove();
                });
                this.listGlobalChat(channel);
            },
            async sendPrivateMessage(type) {
                try {
                    if (!this.chat.block) {
                        if (this.chat.text == '' || !this.chat.text.trim() || this.chat.uploading) {
                            return;
                        }
                        await firebase.database().ref(`strangers/rooms/${page.room.name}`).push({
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
                    console.log(e);
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
                this.gears = res.data;
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
            async buyEquip(id, e) {
                if (confirm('Mua trang bị này ?')) {
                    let res = await axios.post(`${config.apiUrl}/shop/buy-equip`, {
                        id: id
                    })
                    this.notify(res.data.message);
                    if (res.data.code == 200) {
                        await this.index();
                    }
                    if (res.data.code == 200) {
                        e.target.innerHTML = 'Đã mua';
                    }
                    this.loading = false;
                }
            },
            async buySkill(id, e) {
                if (confirm('Mua kỹ năng này ?')) {
                    let res = await axios.post(`${config.apiUrl}/shop/buy-skill`, {
                        id: id
                    })
                    if (res.data.code == 200) {
                        await this.index();
                    }
                    this.notify(res.data.message);
                    if (res.data.code == 200) {
                        e.target.innerHTML = 'Đã mua';
                    }
                    this.loading = false;
                }
            },
            async buyPet(id, e) {
                if (confirm('Mua thú cưỡi này ?')) {
                    let res = await axios.post(`${config.apiUrl}/shop/buy-pet`, {
                        id: id
                    })
                    if (res.data.code == 200) {
                        await this.index();
                    }
                    this.notify(res.data.message);
                    if (res.data.code == 200) {
                        e.target.innerHTML = 'Đã mua';
                    }
                    this.loading = false;
                }
            },
            async buyItem(id, e) {
                var quantity = prompt('Nhập số lượng cần mua');
                quantity = parseInt(quantity);
                if (quantity && typeof quantity == 'number' && quantity > 0 && quantity <= 99999) {
                    let res = await axios.post(`${config.apiUrl}/shop/buy-item`, {
                        id: id,
                        quantity: quantity
                    })
                    if (res.data.code == 200) {
                        await this.index();
                    }
                    this.notify(res.data.message);
                    if (res.data.code == 200) {
                        e.target.innerHTML = 'Đã mua';
                    }
                } else {
                    this.notify('Số lượng quá lớn hoặc không hợp lệ');
                }
                this.loading = false;
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
                var point = prompt('Nhập số điểm bạn muốn cộng');
                point = parseInt(point);
                if (point && typeof point == 'number' && point > 0) {
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
                } else {
                    this.notify('Giá trị lỗi');
                }
            },
            async removeGem(data) {
                console.log(data);
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
            async buyGem(gem) {
                var quantity = prompt('Nhập số lượng cần mua');
                quantity = parseInt(quantity);
                if (quantity && typeof quantity == 'number' && quantity > 0 && quantity <= 10) {
                    let res = await axios.post(`${config.apiUrl}/shop/buy-gem`, {
                        id: gem,
                        quantity: quantity
                    })
                    if (res.data.code == 200) {
                        await this.index();
                    }
                    this.notify(res.data.message);
                    if (res.data.code == 200) {
                        e.target.innerHTML = 'Đã mua';
                    }
                } else {
                    this.notify('Số lượng quá lớn hoặc không hợp lệ');
                }
                this.loading = false;
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
            timeAgo(time) {
                return moment(time).locale('vi').fromNow(true);
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
            },
        },
    });
})();
