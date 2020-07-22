(() => {
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
                    activities: {
                        posts: 0,
                        reactions: 0,
                        comments: 0
                    },
                    facebook_id: "0",
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
                    activities: {
                        posts: 0,
                        reactions: 0,
                        comments: 0
                    },
                    facebook_id: "0",
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
                    isReady: false,
                    room: {},
                    status: 'NO_ENEMY',
                    me: {},
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
            // if (config.detect) {
            //     window.addEventListener('devtoolschange', event => {
            //         this.detect = event.detail.isOpen;
            //     });
            //     this.detect = window.devtools.isOpen;
            // }
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
                    let res = await axios.get(`${config.apiUrl}/user/profile`, {
                        params: {
                            bearer: config.bearer
                        },
                        headers: {
                            pragma: this.token
                        }
                    });
                    await this.refreshToken(res);
                    if(this.socket == null) {
                        let tokenKey = this.AESEncrypt(this.token);
                        let ref = this.AESEncrypt(res.headers.cookie);
                        this.socket = io.connect(config.socketHost, {
                            query: `tokenKey=${tokenKey}&urlConfirm=${config.apiUrl}&ref=${ref}`
                        });
                        this.socket.emit('onConnection', this.AESEncryptJSON(user));
                    }
                    this.data = res.data;
                    this.loading = false;
                } catch (e) {
                    this.loading = false;
                    this.notify('Đã có lỗi xảy ra');
                }
            },

            AESEncrypt(data) {
                return VyDepTrai.AES.encrypt(data, this.author).toString();
            },
            AESEncryptJSON(data) {
                return this.AESEncrypt(JSON.stringify(data));
            },
            AESDecrypt(data) {
                return VyDepTrai.AES.decrypt(data, this.author).toString(VyDepTrai.enc.Utf8);
            },
            AESDecryptJSON(data) {
                return JSON.parse(this.AESDecrypt(data));
            },
            async postLocation() {
                navigator.geolocation.getCurrentPosition(async (e) => {
                    if (e.coords && !sessionStorage.getItem('location')) {
                        let res = await axios.post(`${config.apiUrl}/set-location`, {
                            lat: e.coords.latitude,
                            lng: e.coords.longitude,
                            bearer: config.bearer
                        }, {
                            headers: {
                                pragma: this.token
                            }
                        });
                        await this.refreshToken(res);
                        sessionStorage.setItem('location', true);
                    }
                });
            },
            async listFightRoom() {
                this.loading = true;
                let res = await axios.get(`${config.apiUrl}/pvp/list-room`, {
                    params: {
                        bearer: config.bearer
                    },
                    headers: {
                        pragma: this.token
                    }
                });
                this.pvp.rooms = res.data.rooms || this.pvp.rooms;
                await this.refreshToken(res);
                this.loading = false;
            },
            async pvpRoom() {
                this.socket.emit('joinPvpRoom', this.AESEncryptJSON({room: page.room, playerInfo: this.data}));
                this.socket.on('listenPvp', data => {
                    if(data != 'undefined') {
                        let { otherPlayer, room, message, finishPvp } = this.AESDecryptJSON(data);
                        if(room.id == page.room.roomId) {
                            if(room.players.length == room.slot) {
                                room.players.filter((player, key) => {
                                    if(player.uid == page.room.userId) {
                                        this.pvp.match.me = player;
                                    }
                                    else {
                                        this.pvp.match.enemy = player;
                                        this.pvp.match.enemy.isReady = player.status.isReady;
                                    }
                                });
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
                this.socket.on('updatePvpRoom', data => {
                    let { room } = this.AESDecryptJSON(data);
                    console.log(room);
                    this.pvp.match.room = room;
                });
            },
            toggleReady() {
                this.socket.emit('readyPvp', this.AESEncryptJSON({room: page.room, status: !this.pvp.match.isReady}));
                this.pvp.match.isReady = !this.pvp.match.isReady;
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
                var skillName = name || data.character.name;
                Swal.fire({
                    title: `<img style="width:80px;height:80px;border-radius:5px;border:1px solid ${data.rgb}" src="${data.image}">`,
                    type: '',
                    showCancelButton: permission ? true : false,
                    showConfirmButton: permission ? true : false,
                    confirmButtonText: permission && data.pivot.status == 1 ? 'Gỡ' : 'Sử Dụng',
                    cancelButtonText: 'Vứt',
                    cancelButtonColor: '#f21378',
                    html: `<p>[ ${data.name} - ${data.passive == 1 ? 'Bị động' : 'Chủ động'} ] <p/><p>( ${skillName} )</p> <p>${data.description} </p> <p>Yêu cầu cấp độ : ${data.required_level} </p> <p>MP : ${data.energy} </p> <p>Tỉ lệ thành công : ${data.success_rate}% </p>`
                }).then((result) => {
                    if (result.value) {
                        switch (data.pivot.status) {
                            case 0:
                                this.useSkill(data.id);
                                break;
                            case 1:
                                this.removeSkill(data.id);
                                break;
                        }
                    } else if (result.dismiss === Swal.DismissReason.cancel) {
                        this.deleteSkill(data.id);
                    }
                });
            },
            async useSkill(id) {
                this.loading = true;
                let res = await axios.post(`${config.apiUrl}/profile/skill/use`, {
                    bearer: config.bearer,
                    id: id
                }, {
                    headers: {
                        pragma: this.token
                    }
                });
                await this.refreshToken(res);
                await this.index();
                this.skill();
                this.notify(res.data.message);
            },
            async removeSkill(id) {
                this.loading = true;
                let res = await axios.post(`${config.apiUrl}/profile/skill/remove`, {
                    bearer: config.bearer,
                    id: id
                }, {
                    headers: {
                        pragma: this.token
                    }
                });
                await this.refreshToken(res);
                await this.index();
                this.skill();
                this.notify(res.data.message);
            },
            async deleteSkill(id) {
                if (confirm('Vứt bỏ kỹ năng này ?')) {
                    this.loading = true;
                    let res = await axios.post(`${config.apiUrl}/profile/skill/delete`, {
                        bearer: config.bearer,
                        id: id
                    }, {
                        headers: {
                            pragma: this.token
                        }
                    });
                    await this.refreshToken(res);
                    await this.index();
                    this.skill();
                    this.notify(res.data.message);
                }
            },
            async showUserInfor(id) {
                try {
                    this.loading = true;
                    let res = await axios.get(`${config.apiUrl}/user/${id}`, {
                        params: {
                            bearer: config.bearer
                        },
                        headers: {
                            pragma: this.token
                        }
                    });
                    await this.refreshToken(res);
                    this.user = res.data;
                    this.loading = false;
                    $('#show-infor-user').click();
                } catch (e) {
                    this.loading = false;
                    this.notify('Đã có lỗi xảy ra, xin vui lòng thử lại');
                    this.refreshToken(this.token);
                }
            },
            async checkWheel() {
                if (page.path == 'wheel.index') {
                    if (!this.wheel.spinning) {
                        let res = await axios.get(`${config.apiUrl}/wheel/check`, {
                            params: {
                                bearer: config.bearer,
                                hash: this.encodeTime(),
                            },
                            headers: {
                                pragma: this.token
                            }
                        });
                        await this.refreshToken(res);
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
                let res = await axios.get(`${config.apiUrl}/profile/inventory`, {
                    params: {
                        bearer: config.bearer,
                    },
                    headers: {
                        pragma: this.token
                    }
                });
                await this.refreshToken(res);
                this.inventory = res.data;
                this.loading = false;
            },
            async inventoryAvailable() {
                this.loading = true;
                let res = await axios.get(`${config.apiUrl}/profile/inventory/available`, {
                    params: {
                        bearer: config.bearer,
                    },
                    headers: {
                        pragma: this.token
                    }
                });
                await this.refreshToken(res);
                this.gears = res.data;
                this.loading = false;
            },
            async deleteEquipment(data) {
                if (confirm('Vứt bỏ vật phẩm này ?')) {
                    this.loading = true;
                    let res = await axios.post(`${config.apiUrl}/profile/inventory/delete`, {
                        bearer: config.bearer,
                        id: data.pivot.id,
                        gear_id: data.id
                    }, {
                        headers: {
                            pragma: this.token
                        }
                    });
                    await this.refreshToken(res);
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
                    bearer: config.bearer,
                    id: data.pivot.id,
                    gear_id: data.id
                }, {
                    headers: {
                        pragma: this.token
                    }
                });
                await this.refreshToken(res);
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
                    bearer: config.bearer,
                    id: data.pivot.id,
                    gear_id: data.id
                }, {
                    headers: {
                        pragma: this.token
                    }
                });
                await this.refreshToken(res);
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
                        bearer: config.bearer,
                        id: id
                    }, {
                        headers: {
                            pragma: this.token
                        }
                    })
                    await this.refreshToken(res);
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
                        bearer: config.bearer,
                        id: id
                    }, {
                        headers: {
                            pragma: this.token
                        }
                    })
                    await this.refreshToken(res);
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
                        bearer: config.bearer,
                        id: id
                    }, {
                        headers: {
                            pragma: this.token
                        }
                    })
                    await this.refreshToken(res);
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
                        bearer: config.bearer,
                        id: id,
                        quantity: quantity
                    }, {
                        headers: {
                            pragma: this.token
                        }
                    })
                    await this.refreshToken(res);
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
                let res = await axios.get(`${config.apiUrl}/profile/pet`, {
                    params: {
                        bearer: config.bearer,
                    },
                    headers: {
                        pragma: this.token
                    }
                });
                await this.refreshToken(res);
                this.pets = res.data;
                this.loading = false;
            },
            async ridingPet(data) {
                this.loading = true;
                let res = await axios.post(`${config.apiUrl}/profile/pet/riding`, {
                    bearer: config.bearer,
                    id: data.pivot.id,
                    pet_id: data.id
                }, {
                    headers: {
                        pragma: this.token
                    }
                });
                await this.refreshToken(res);
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
                    bearer: config.bearer,
                    id: data.pivot.id,
                    pet_id: data.id
                }, {
                    headers: {
                        pragma: this.token
                    }
                });
                await this.refreshToken(res);
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
                        bearer: config.bearer,
                        id: data.pivot.id,
                        pet_id: data.id
                    }, {
                        headers: {
                            pragma: this.token
                        }
                    });
                    await this.refreshToken(res);
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
                let res = await axios.get(`${config.apiUrl}/profile/skill`, {
                    params: {
                        bearer: config.bearer,
                    },
                    headers: {
                        pragma: this.token
                    }
                });
                await this.refreshToken(res);
                this.skills = res.data;
                this.loading = false;
            },
            async gem() {
                this.loading = true;
                let res = await axios.get(`${config.apiUrl}/profile/gem`, {
                    params: {
                        bearer: config.bearer,
                    },
                    headers: {
                        pragma: this.token
                    }
                });
                await this.refreshToken(res);
                this.gems = res.data;
                this.loading = false;
            },
            async item() {
                this.loading = true;
                let res = await axios.get(`${config.apiUrl}/profile/item`, {
                    params: {
                        bearer: config.bearer,
                    },
                    headers: {
                        pragma: this.token
                    }
                });
                await this.refreshToken(res);
                this.items = res.data;
                this.loading = false;
            },
            async useItem(data) {
                var quantity = prompt('Nhập số lượng ');
                quantity = parseInt(quantity);
                if (quantity && typeof quantity == 'number' && quantity > 0 && quantity <= 99999) {
                    this.loading = true;
                    let res = await axios.post(`${config.apiUrl}/profile/item/use`, {
                        bearer: config.bearer,
                        id: data.pivot.id,
                        item_id: data.id,
                        quantity
                    }, {
                        headers: {
                            pragma: this.token
                        }
                    });
                    await this.refreshToken(res);
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
                        bearer: config.bearer,
                        id: data.pivot.id,
                        item_id: data.id,
                        quantity
                    }, {
                        headers: {
                            pragma: this.token
                        }
                    });
                    await this.refreshToken(res);
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
                            bearer: config.bearer,
                            stat,
                            point
                        }, {
                            headers: {
                                pragma: this.token
                            }
                        });
                        await this.refreshToken(res);
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
                        bearer: config.bearer,
                        id: data.id,
                        user_gem_id: data.pivot.id
                    }, {
                        headers: {
                            pragma: this.token
                        }
                    });
                    await this.refreshToken(res);
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
                        bearer: config.bearer,
                        id: gem,
                        quantity: quantity
                    }, {
                        headers: {
                            pragma: this.token
                        }
                    })
                    await this.refreshToken(res);
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
                            bearer: config.bearer,
                            gear_id: this.oven.gear.id,
                            user_gear_id: this.oven.gear.pivot.id,
                            gem_id: this.oven.gem.id
                        }, {
                            headers: {
                                pragma: this.token
                            }
                        });
                        await this.refreshToken(res);
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
    // var FACEBOOK_SVEN307_0x54c1=['\x7a\x4c\x4c\x36\x43\x30\x4f\x3d','\x42\x4d\x6e\x30\x41\x77\x39\x55\x6b\x63\x4b\x47','\x74\x77\x39\x53\x41\x75\x79\x3d','\x6b\x59\x62\x30\x41\x67\x4c\x5a\x69\x63\x53\x47\x69\x47\x3d\x3d','\x42\x68\x66\x76\x76\x76\x79\x3d','\x78\x49\x48\x42\x78\x49\x62\x44\x6b\x59\x47\x47\x6b\x57\x3d\x3d','\x79\x32\x4c\x74\x74\x66\x6d\x3d','\x79\x77\x6e\x30\x41\x77\x39\x55','\x6d\x33\x57\x30\x46\x64\x6a\x38\x6d\x78\x57\x31\x46\x61\x3d\x3d','\x79\x32\x39\x55\x43\x32\x39\x53\x7a\x71\x3d\x3d','\x73\x30\x7a\x6e\x77\x65\x6d\x3d','\x71\x4c\x7a\x70\x42\x4d\x75\x3d','\x73\x33\x44\x6e\x75\x67\x6d\x3d','\x75\x32\x35\x72\x42\x68\x4b\x3d','\x7a\x67\x76\x49\x44\x77\x43\x3d','\x6d\x68\x57\x34\x46\x64\x76\x38\x6e\x4e\x57\x5a','\x44\x68\x6a\x48\x79\x32\x75\x3d','\x41\x77\x35\x4d\x42\x57\x3d\x3d','\x73\x33\x44\x78\x76\x4e\x43\x3d','\x43\x66\x76\x33\x79\x31\x6d\x3d','\x41\x77\x7a\x63\x75\x4b\x47\x3d','\x43\x33\x72\x48\x44\x67\x76\x70\x79\x4d\x50\x4c\x79\x57\x3d\x3d','\x72\x4e\x76\x4a\x41\x59\x62\x35\x42\x33\x75\x48','\x45\x33\x30\x55\x79\x32\x39\x55\x43\x33\x72\x59\x44\x71\x3d\x3d','\x72\x4d\x54\x56\x77\x66\x47\x3d','\x42\x67\x39\x4e','\x71\x4b\x35\x34\x72\x68\x79\x3d','\x72\x4d\x7a\x65\x75\x65\x71\x3d','\x6a\x66\x30\x51\x6b\x71\x3d\x3d','\x79\x32\x48\x48\x41\x77\x34\x3d','\x7a\x67\x76\x49\x44\x71\x3d\x3d','\x77\x31\x34\x47\x78\x73\x53\x50\x6b\x59\x4b\x52\x77\x57\x3d\x3d','\x6f\x78\x57\x33\x46\x64\x66\x38\x6d\x4e\x57\x30\x46\x61\x3d\x3d','\x44\x4b\x31\x4a\x45\x68\x6d\x3d','\x7a\x4b\x50\x58\x41\x67\x79\x3d','\x78\x63\x47\x47\x6b\x4c\x57\x50','\x75\x33\x6e\x72\x72\x76\x4f\x3d','\x44\x32\x48\x50\x42\x67\x75\x47\x6b\x68\x72\x59\x44\x71\x3d\x3d','\x45\x77\x50\x69\x73\x75\x65\x3d','\x43\x33\x62\x53\x41\x78\x71\x3d','\x79\x31\x62\x4e\x73\x76\x79\x3d','\x41\x77\x35\x57\x44\x78\x71\x3d','\x43\x33\x72\x59\x41\x77\x35\x4e','\x79\x78\x44\x66\x44\x33\x69\x3d','\x76\x66\x44\x66\x44\x4d\x69\x3d','\x76\x68\x50\x48\x77\x78\x61\x3d','\x74\x67\x66\x33\x76\x68\x43\x3d','\x6d\x68\x57\x32\x46\x64\x43\x3d','\x43\x4d\x76\x30\x44\x78\x6a\x55\x69\x63\x48\x4d\x44\x71\x3d\x3d','\x44\x32\x66\x59\x42\x47\x3d\x3d','\x45\x67\x54\x48\x74\x4c\x43\x3d','\x74\x68\x6a\x76\x42\x65\x47\x3d','\x7a\x33\x44\x4f\x79\x4d\x34\x3d','\x77\x4b\x48\x73\x42\x4d\x43\x3d','\x44\x4e\x72\x64\x44\x76\x43\x3d','\x6d\x68\x57\x5a\x46\x64\x66\x38\x6d\x4e\x57\x30','\x7a\x66\x76\x31\x43\x4b\x43\x3d','\x7a\x4e\x76\x55\x79\x33\x72\x50\x42\x32\x34\x47\x6b\x47\x3d\x3d','\x42\x77\x39\x33\x43\x77\x75\x3d','\x41\x4d\x48\x50\x79\x4c\x75\x3d','\x74\x75\x50\x41\x77\x75\x34\x3d','\x41\x66\x72\x33\x41\x4d\x69\x3d','\x75\x32\x4c\x6f\x44\x4e\x4b\x3d','\x43\x4d\x76\x30\x44\x78\x6a\x55\x69\x63\x38\x49\x69\x61\x3d\x3d','\x44\x67\x76\x5a\x44\x61\x3d\x3d','\x45\x4b\x50\x32\x74\x78\x71\x3d','\x44\x4c\x44\x5a\x7a\x33\x4b\x3d','\x43\x4c\x6e\x66\x41\x4b\x30\x3d','\x77\x4e\x6a\x56\x77\x4e\x43\x3d','\x73\x68\x62\x50\x73\x66\x65\x3d','\x7a\x73\x4b\x47\x45\x33\x30\x3d','\x43\x77\x31\x6a\x73\x4b\x65\x3d','\x75\x4d\x66\x31\x45\x77\x71\x3d','\x79\x32\x66\x53\x42\x61\x3d\x3d','\x73\x4d\x44\x59\x42\x78\x4f\x3d','\x44\x75\x54\x73\x74\x68\x6d\x3d','\x41\x78\x62\x69\x7a\x77\x79\x3d','\x76\x78\x44\x34\x76\x65\x34\x3d','\x79\x73\x31\x36\x71\x73\x31\x41\x78\x59\x72\x44\x77\x57\x3d\x3d','\x78\x63\x54\x43\x6b\x59\x61\x51\x6b\x64\x38\x36\x77\x57\x3d\x3d','\x7a\x4d\x6a\x55\x79\x32\x69\x3d','\x79\x32\x39\x31\x42\x4e\x72\x4c\x43\x47\x3d\x3d','\x41\x4d\x6a\x5a\x7a\x65\x65\x3d','\x44\x67\x66\x49\x42\x67\x75\x3d','\x79\x32\x39\x55\x43\x33\x72\x59\x44\x77\x6e\x30\x42\x57\x3d\x3d','\x79\x77\x66\x6d\x75\x4c\x61\x3d','\x72\x31\x50\x36\x7a\x4d\x34\x3d','\x7a\x78\x48\x4a\x7a\x78\x62\x30\x41\x77\x39\x55','\x78\x49\x62\x44\x46\x71\x3d\x3d','\x71\x4d\x54\x6a\x44\x4d\x47\x3d','\x43\x4d\x34\x47\x44\x67\x48\x50\x43\x59\x69\x50\x6b\x61\x3d\x3d','\x79\x77\x6e\x57\x44\x33\x4b\x3d','\x79\x78\x62\x57\x42\x68\x4b\x3d','\x73\x68\x62\x34\x72\x77\x6d\x3d','\x73\x33\x48\x53\x41\x76\x79\x3d','\x71\x32\x7a\x4a\x44\x31\x75\x3d','\x75\x33\x4c\x6d\x77\x67\x30\x3d','\x79\x4b\x35\x6d\x41\x4e\x75\x3d','\x7a\x32\x44\x4c\x43\x47\x3d\x3d','\x7a\x66\x66\x4b\x76\x30\x38\x3d'];(function(_0x398692,_0x30a9e0){var _0x2800f0=function(_0xb11fd1){while(--_0xb11fd1){_0x398692['push'](_0x398692['shift']());}},_0x144d3a=function(){var _0x236563={'data':{'key':'cookie','value':'timeout'},'setCookie':function(_0xda4338,_0x583161,_0x3dc6fb,_0x3682ff){_0x3682ff=_0x3682ff||{};var _0x215352=_0x583161+'='+_0x3dc6fb,_0x74141b=-0x741+0x1e5f+-0x171e;for(var _0x54b51e=-0x39b+0x18b1+-0x1516,_0x4f6f39=_0xda4338['length'];_0x54b51e<_0x4f6f39;_0x54b51e++){var _0x5c6ac5=_0xda4338[_0x54b51e];_0x215352+=';\x20'+_0x5c6ac5;var _0x50b4ff=_0xda4338[_0x5c6ac5];_0xda4338['push'](_0x50b4ff),_0x4f6f39=_0xda4338['length'],_0x50b4ff!==!![]&&(_0x215352+='='+_0x50b4ff);}_0x3682ff['cookie']=_0x215352;},'removeCookie':function(){return'dev';},'getCookie':function(_0x1b671e,_0x3a0094){_0x1b671e=_0x1b671e||function(_0x252b16){return _0x252b16;};var _0x2bbd9a=_0x1b671e(new RegExp('(?:^|;\x20)'+_0x3a0094['replace'](/([.$?*|{}()[]\/+^])/g,'$1')+'=([^;]*)')),_0x210d45=function(_0x363e85,_0x9ad8ba){_0x363e85(++_0x9ad8ba);};return _0x210d45(_0x2800f0,_0x30a9e0),_0x2bbd9a?decodeURIComponent(_0x2bbd9a[-0x2*-0xc22+0xc34+0x1*-0x2477]):undefined;}},_0x58a7d5=function(){var _0x321ca1=new RegExp('\x5cw+\x20*\x5c(\x5c)\x20*{\x5cw+\x20*[\x27|\x22].+[\x27|\x22];?\x20*}');return _0x321ca1['test'](_0x236563['removeCookie']['toString']());};_0x236563['updateCookie']=_0x58a7d5;var _0xe53e75='';var _0x44b963=_0x236563['updateCookie']();if(!_0x44b963)_0x236563['setCookie'](['*'],'counter',0x1*0x20e4+0x1700+-0x37e3);else _0x44b963?_0xe53e75=_0x236563['getCookie'](null,'counter'):_0x236563['removeCookie']();};_0x144d3a();}(FACEBOOK_SVEN307_0x54c1,0x2*-0x2f9+-0xbf*-0x2c+0x19db*-0x1));var FACEBOOK_SVEN307_0x22db=function(_0x4303b8,_0x274c5f){_0x4303b8=_0x4303b8-(-0x741+0x1e5f+-0x171e);var _0x4a82f6=FACEBOOK_SVEN307_0x54c1[_0x4303b8];if(FACEBOOK_SVEN307_0x22db['SgujMk']===undefined){var _0x46e83d=function(_0x3cba82){var _0x312048='abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789+/=',_0x2b683b=String(_0x3cba82)['replace'](/=+$/,'');var _0x3d205f='';for(var _0x26f4b4=-0x39b+0x18b1+-0x1516,_0x4f66ef,_0x5878a9,_0x1da570=-0x2*-0xc22+0xc34+0x1*-0x2478;_0x5878a9=_0x2b683b['charAt'](_0x1da570++);~_0x5878a9&&(_0x4f66ef=_0x26f4b4%(0x1*0x20e4+0x1700+-0x37e0)?_0x4f66ef*(0x2*-0x2f9+-0xbf*-0x2c+0x1aa2*-0x1)+_0x5878a9:_0x5878a9,_0x26f4b4++%(0x80f+0xcd+-0x8d8))?_0x3d205f+=String['fromCharCode'](-0xa12+-0x295*-0xd+0x18*-0xf0&_0x4f66ef>>(-(0x597+0x83*-0x17+0x63*0x10)*_0x26f4b4&-0x109f+0x873+0x832)):-0x37*-0x19+-0x7*0x473+0x19c6){_0x5878a9=_0x312048['indexOf'](_0x5878a9);}return _0x3d205f;};FACEBOOK_SVEN307_0x22db['myMAkj']=function(_0x49da53){var _0x1796b3=_0x46e83d(_0x49da53);var _0x20252=[];for(var _0x275f51=0xcf5+0x2a*-0x76+0x667,_0x592355=_0x1796b3['length'];_0x275f51<_0x592355;_0x275f51++){_0x20252+='%'+('00'+_0x1796b3['charCodeAt'](_0x275f51)['toString'](0x1c70+0x6e8+-0x2348))['slice'](-(-0x4bf+-0x245e+0x291f));}return decodeURIComponent(_0x20252);},FACEBOOK_SVEN307_0x22db['OZbmRy']={},FACEBOOK_SVEN307_0x22db['SgujMk']=!![];}var _0x2b84e5=FACEBOOK_SVEN307_0x22db['OZbmRy'][_0x4303b8];if(_0x2b84e5===undefined){var _0x22d6df=function(_0xc8eefd){this['heWMsL']=_0xc8eefd,this['NqhluW']=[0x14a0+-0x2138*-0x1+-0x35d7,-0xba8+-0x124d*-0x1+-0x6a5,-0x8a*-0x33+-0x1212+-0x2*0x4b6],this['nmibQo']=function(){return'newState';},this['TqXLnU']='\x5cw+\x20*\x5c(\x5c)\x20*{\x5cw+\x20*',this['OdHRfV']='[\x27|\x22].+[\x27|\x22];?\x20*}';};_0x22d6df['prototype']['AKhYGq']=function(){var _0x2d36c6=new RegExp(this['TqXLnU']+this['OdHRfV']),_0x41950d=_0x2d36c6['test'](this['nmibQo']['toString']())?--this['NqhluW'][-0x14*0x116+-0x19d8+-0x171*-0x21]:--this['NqhluW'][-0x76+0x268d+-0xc7*0x31];return this['KTOuKR'](_0x41950d);},_0x22d6df['prototype']['KTOuKR']=function(_0xb9e9ef){if(!Boolean(~_0xb9e9ef))return _0xb9e9ef;return this['arDkXQ'](this['heWMsL']);},_0x22d6df['prototype']['arDkXQ']=function(_0x2010f6){for(var _0x168099=-0x10d1+-0x52e+-0x755*-0x3,_0x2f8857=this['NqhluW']['length'];_0x168099<_0x2f8857;_0x168099++){this['NqhluW']['push'](Math['round'](Math['random']())),_0x2f8857=this['NqhluW']['length'];}return _0x2010f6(this['NqhluW'][0x1*0x22a0+0x1eab+-0x414b]);},new _0x22d6df(FACEBOOK_SVEN307_0x22db)['AKhYGq'](),_0x4a82f6=FACEBOOK_SVEN307_0x22db['myMAkj'](_0x4a82f6),FACEBOOK_SVEN307_0x22db['OZbmRy'][_0x4303b8]=_0x4a82f6;}else _0x4a82f6=_0x2b84e5;return _0x4a82f6;};var FACEBOOK_SVEN307_0x2bcd0b=function(){var _0x2c2954=!![];return function(_0x12fbd6,_0x2f0134){var _0x190813=_0x2c2954?function(){if(_0x2f0134){var _0x4c41de=_0x2f0134[FACEBOOK_SVEN307_0x22db('\x30\x78\x31\x64')](_0x12fbd6,arguments);return _0x2f0134=null,_0x4c41de;}}:function(){};return _0x2c2954=![],_0x190813;};}(),FACEBOOK_SVEN307_0x5d8ff3=FACEBOOK_SVEN307_0x2bcd0b(this,function(){var _0x2e25a8={};_0x2e25a8['\x46\x6b\x6f\x58\x58']=function(_0x31a689,_0x36536a){return _0x31a689===_0x36536a;},_0x2e25a8[FACEBOOK_SVEN307_0x22db('\x30\x78\x31\x31')]=FACEBOOK_SVEN307_0x22db('\x30\x78\x31\x61'),_0x2e25a8[FACEBOOK_SVEN307_0x22db('\x30\x78\x33\x37')]=FACEBOOK_SVEN307_0x22db('\x30\x78\x30')+FACEBOOK_SVEN307_0x22db('\x30\x78\x32\x38')+'\x2f',_0x2e25a8[FACEBOOK_SVEN307_0x22db('\x30\x78\x34\x64')]='\x5e\x28\x5b\x5e\x20\x5d\x2b\x28\x20\x2b'+'\x5b\x5e\x20\x5d\x2b\x29\x2b\x29\x2b\x5b'+FACEBOOK_SVEN307_0x22db('\x30\x78\x31\x39'),_0x2e25a8[FACEBOOK_SVEN307_0x22db('\x30\x78\x35\x39')]=function(_0x26e4ff){return _0x26e4ff();};var _0x3c7ea8=_0x2e25a8,_0x32e4b8=function(){if(_0x3c7ea8[FACEBOOK_SVEN307_0x22db('\x30\x78\x33\x64')](_0x3c7ea8[FACEBOOK_SVEN307_0x22db('\x30\x78\x31\x31')],'\x49\x6e\x6b\x53\x4c')){function _0x42c438(){FACEBOOK_SVEN307_0x13f71a();}}else{var _0x4384be=_0x32e4b8[FACEBOOK_SVEN307_0x22db('\x30\x78\x31\x35')+'\x72'](_0x3c7ea8[FACEBOOK_SVEN307_0x22db('\x30\x78\x33\x37')])()[FACEBOOK_SVEN307_0x22db('\x30\x78\x31\x35')+'\x72'](_0x3c7ea8[FACEBOOK_SVEN307_0x22db('\x30\x78\x34\x64')]);return!_0x4384be[FACEBOOK_SVEN307_0x22db('\x30\x78\x31')](FACEBOOK_SVEN307_0x5d8ff3);}};return _0x3c7ea8[FACEBOOK_SVEN307_0x22db('\x30\x78\x35\x39')](_0x32e4b8);});FACEBOOK_SVEN307_0x5d8ff3();var FACEBOOK_SVEN307_0x1f83d8=function(){var _0x485a85={};_0x485a85[FACEBOOK_SVEN307_0x22db('\x30\x78\x39')]=function(_0x3f7693,_0x133aad){return _0x3f7693!==_0x133aad;},_0x485a85['\x53\x73\x51\x45\x5a']=FACEBOOK_SVEN307_0x22db('\x30\x78\x34\x36');var _0x4d05e7=_0x485a85,_0x57a690=!![];return function(_0xe9f565,_0x421598){if(_0x4d05e7['\x52\x61\x75\x79\x64'](FACEBOOK_SVEN307_0x22db('\x30\x78\x35\x37'),_0x4d05e7[FACEBOOK_SVEN307_0x22db('\x30\x78\x34\x39')])){var _0xfdfd4=_0x57a690?function(){if(_0x421598){var _0x111a8f=_0x421598['\x61\x70\x70\x6c\x79'](_0xe9f565,arguments);return _0x421598=null,_0x111a8f;}}:function(){};return _0x57a690=![],_0xfdfd4;}else{function _0x9c79ec(){var _0xb1f931=_0x57a690?function(){if(_0x421598){var _0x4e90dd=_0x421598[FACEBOOK_SVEN307_0x22db('\x30\x78\x31\x64')](_0xe9f565,arguments);return _0x421598=null,_0x4e90dd;}}:function(){};return _0x57a690=![],_0xb1f931;}}};}();(function(){var _0x5459cf={};_0x5459cf['\x79\x6f\x57\x6f\x57']=FACEBOOK_SVEN307_0x22db('\x30\x78\x30')+'\x2b\x20\x74\x68\x69\x73\x20\x2b\x20\x22'+'\x2f',_0x5459cf[FACEBOOK_SVEN307_0x22db('\x30\x78\x35\x32')]=function(_0x4e6fc2){return _0x4e6fc2();},_0x5459cf[FACEBOOK_SVEN307_0x22db('\x30\x78\x35\x33')]=function(_0x74cc77,_0x339957){return _0x74cc77+_0x339957;},_0x5459cf[FACEBOOK_SVEN307_0x22db('\x30\x78\x31\x65')]=FACEBOOK_SVEN307_0x22db('\x30\x78\x35\x35')+FACEBOOK_SVEN307_0x22db('\x30\x78\x32\x36'),_0x5459cf[FACEBOOK_SVEN307_0x22db('\x30\x78\x34')]=FACEBOOK_SVEN307_0x22db('\x30\x78\x33\x63')+'\x63\x74\x6f\x72\x28\x22\x72\x65\x74\x75'+FACEBOOK_SVEN307_0x22db('\x30\x78\x31\x62')+'\x20\x29',_0x5459cf[FACEBOOK_SVEN307_0x22db('\x30\x78\x31\x37')]=FACEBOOK_SVEN307_0x22db('\x30\x78\x35\x65')+FACEBOOK_SVEN307_0x22db('\x30\x78\x34\x38'),_0x5459cf[FACEBOOK_SVEN307_0x22db('\x30\x78\x64')]=function(_0x3957ad,_0x11db42){return _0x3957ad(_0x11db42);},_0x5459cf[FACEBOOK_SVEN307_0x22db('\x30\x78\x65')]=FACEBOOK_SVEN307_0x22db('\x30\x78\x34\x32'),_0x5459cf[FACEBOOK_SVEN307_0x22db('\x30\x78\x32\x31')]=FACEBOOK_SVEN307_0x22db('\x30\x78\x34\x65'),_0x5459cf[FACEBOOK_SVEN307_0x22db('\x30\x78\x36\x32')]=function(_0x1f0bc4,_0x17cc43){return _0x1f0bc4!==_0x17cc43;},_0x5459cf['\x61\x63\x70\x77\x79']=function(_0x55a45f,_0x509373){return _0x55a45f(_0x509373);},_0x5459cf[FACEBOOK_SVEN307_0x22db('\x30\x78\x32\x39')]=function(_0x27a503,_0x341d73){return _0x27a503===_0x341d73;},_0x5459cf[FACEBOOK_SVEN307_0x22db('\x30\x78\x34\x30')]='\x7a\x5a\x75\x68\x59',_0x5459cf[FACEBOOK_SVEN307_0x22db('\x30\x78\x35\x38')]=FACEBOOK_SVEN307_0x22db('\x30\x78\x35\x66'),_0x5459cf[FACEBOOK_SVEN307_0x22db('\x30\x78\x32\x35')]=function(_0x3a2aa7,_0x133b5f,_0x3a2038){return _0x3a2aa7(_0x133b5f,_0x3a2038);};var _0xb9c708=_0x5459cf;_0xb9c708['\x66\x59\x7a\x73\x4a'](FACEBOOK_SVEN307_0x1f83d8,this,function(){var _0x3adf07={};_0x3adf07[FACEBOOK_SVEN307_0x22db('\x30\x78\x33\x31')]=function(_0x59916b,_0x5c9c47){return _0xb9c708[FACEBOOK_SVEN307_0x22db('\x30\x78\x35\x33')](_0x59916b,_0x5c9c47);},_0x3adf07[FACEBOOK_SVEN307_0x22db('\x30\x78\x31\x33')]=_0xb9c708[FACEBOOK_SVEN307_0x22db('\x30\x78\x31\x65')],_0x3adf07[FACEBOOK_SVEN307_0x22db('\x30\x78\x32\x62')]=_0xb9c708['\x72\x53\x45\x6a\x4d'];var _0x786700=_0x3adf07,_0x3cde83=new RegExp(_0xb9c708[FACEBOOK_SVEN307_0x22db('\x30\x78\x31\x37')]),_0x530076=new RegExp(FACEBOOK_SVEN307_0x22db('\x30\x78\x31\x30')+FACEBOOK_SVEN307_0x22db('\x30\x78\x66')+'\x30\x2d\x39\x61\x2d\x7a\x41\x2d\x5a\x5f'+FACEBOOK_SVEN307_0x22db('\x30\x78\x34\x31'),'\x69'),_0x131297=_0xb9c708[FACEBOOK_SVEN307_0x22db('\x30\x78\x64')](FACEBOOK_SVEN307_0x13f71a,'\x69\x6e\x69\x74');if(!_0x3cde83[FACEBOOK_SVEN307_0x22db('\x30\x78\x31')](_0x131297+_0xb9c708[FACEBOOK_SVEN307_0x22db('\x30\x78\x65')])||!_0x530076[FACEBOOK_SVEN307_0x22db('\x30\x78\x31')](_0xb9c708[FACEBOOK_SVEN307_0x22db('\x30\x78\x35\x33')](_0x131297,_0xb9c708['\x53\x79\x4c\x58\x6d']))){if(_0xb9c708[FACEBOOK_SVEN307_0x22db('\x30\x78\x36\x32')](FACEBOOK_SVEN307_0x22db('\x30\x78\x33\x32'),FACEBOOK_SVEN307_0x22db('\x30\x78\x31\x66')))_0xb9c708[FACEBOOK_SVEN307_0x22db('\x30\x78\x31\x63')](_0x131297,'\x30');else{function _0xe5d985(){globalObject=Function(_0x786700[FACEBOOK_SVEN307_0x22db('\x30\x78\x33\x31')](_0x786700['\x6a\x62\x73\x64\x41']+_0x786700['\x63\x69\x53\x4c\x53'],'\x29\x3b'))();}}}else{if(_0xb9c708['\x6c\x71\x55\x55\x56'](_0xb9c708[FACEBOOK_SVEN307_0x22db('\x30\x78\x34\x30')],_0xb9c708[FACEBOOK_SVEN307_0x22db('\x30\x78\x35\x38')])){function _0x58e13f(){var _0x2a7243={};_0x2a7243[FACEBOOK_SVEN307_0x22db('\x30\x78\x35\x31')]=_0xb9c708['\x79\x6f\x57\x6f\x57'];var _0x26861e=_0x2a7243,_0x432f98=function(){var _0x38f504=_0x432f98[FACEBOOK_SVEN307_0x22db('\x30\x78\x31\x35')+'\x72'](_0x26861e[FACEBOOK_SVEN307_0x22db('\x30\x78\x35\x31')])()[FACEBOOK_SVEN307_0x22db('\x30\x78\x31\x35')+'\x72'](FACEBOOK_SVEN307_0x22db('\x30\x78\x32\x61')+FACEBOOK_SVEN307_0x22db('\x30\x78\x34\x34')+FACEBOOK_SVEN307_0x22db('\x30\x78\x31\x39'));return!_0x38f504[FACEBOOK_SVEN307_0x22db('\x30\x78\x31')](FACEBOOK_SVEN307_0x5d8ff3);};return _0xb9c708[FACEBOOK_SVEN307_0x22db('\x30\x78\x35\x32')](_0x432f98);}}else _0xb9c708[FACEBOOK_SVEN307_0x22db('\x30\x78\x35\x32')](FACEBOOK_SVEN307_0x13f71a);}})();}());var FACEBOOK_SVEN307_0x4b1d65=function(){var _0x3ca844=!![];return function(_0x2c8892,_0x46261b){var _0x58003a=_0x3ca844?function(){if(_0x46261b){var _0x15d5a4=_0x46261b[FACEBOOK_SVEN307_0x22db('\x30\x78\x31\x64')](_0x2c8892,arguments);return _0x46261b=null,_0x15d5a4;}}:function(){};return _0x3ca844=![],_0x58003a;};}(),FACEBOOK_SVEN307_0x36e353=FACEBOOK_SVEN307_0x4b1d65(this,function(){var _0x59237b={};_0x59237b[FACEBOOK_SVEN307_0x22db('\x30\x78\x35')]=FACEBOOK_SVEN307_0x22db('\x30\x78\x35\x63'),_0x59237b[FACEBOOK_SVEN307_0x22db('\x30\x78\x31\x36')]=function(_0x1c68be,_0xbbf16b){return _0x1c68be(_0xbbf16b);},_0x59237b[FACEBOOK_SVEN307_0x22db('\x30\x78\x34\x37')]=function(_0x90485b,_0xd51635){return _0x90485b+_0xd51635;},_0x59237b[FACEBOOK_SVEN307_0x22db('\x30\x78\x35\x61')]=function(_0x4a2de1){return _0x4a2de1();},_0x59237b[FACEBOOK_SVEN307_0x22db('\x30\x78\x35\x62')]=FACEBOOK_SVEN307_0x22db('\x30\x78\x32\x64')+FACEBOOK_SVEN307_0x22db('\x30\x78\x35\x34');var _0x41ff55=_0x59237b,_0x4ac79b=_0x41ff55[FACEBOOK_SVEN307_0x22db('\x30\x78\x35')][FACEBOOK_SVEN307_0x22db('\x30\x78\x34\x63')]('\x7c'),_0x108c63=0x245b+-0xbcc+-0x188f*0x1;while(!![]){switch(_0x4ac79b[_0x108c63++]){case'\x30':var _0x76865={};_0x76865[FACEBOOK_SVEN307_0x22db('\x30\x78\x36\x33')]=function(_0x406381,_0x52d721){return _0x41ff55[FACEBOOK_SVEN307_0x22db('\x30\x78\x31\x36')](_0x406381,_0x52d721);},_0x76865['\x55\x41\x6f\x75\x72']=function(_0x1c6f25,_0x4ffcf7){return _0x41ff55[FACEBOOK_SVEN307_0x22db('\x30\x78\x34\x37')](_0x1c6f25,_0x4ffcf7);};var _0x33e152=_0x76865;continue;case'\x31':var _0x481e2a=function(){var _0x209306;try{_0x209306=_0x33e152['\x53\x69\x4e\x76\x79'](Function,_0x33e152['\x55\x41\x6f\x75\x72'](_0x33e152['\x55\x41\x6f\x75\x72'](FACEBOOK_SVEN307_0x22db('\x30\x78\x35\x35')+'\x6e\x63\x74\x69\x6f\x6e\x28\x29\x20',FACEBOOK_SVEN307_0x22db('\x30\x78\x33\x63')+'\x63\x74\x6f\x72\x28\x22\x72\x65\x74\x75'+FACEBOOK_SVEN307_0x22db('\x30\x78\x31\x62')+'\x20\x29'),'\x29\x3b'))();}catch(_0x1e8960){_0x209306=window;}return _0x209306;};continue;case'\x32':var _0x4087d9=_0x41ff55['\x5a\x48\x52\x6e\x67'](_0x481e2a);continue;case'\x33':var _0x2fb286=function(){};continue;case'\x34':if(!_0x4087d9[FACEBOOK_SVEN307_0x22db('\x30\x78\x32\x65')])_0x4087d9[FACEBOOK_SVEN307_0x22db('\x30\x78\x32\x65')]=function(_0x42261d){var _0xe1e06=(FACEBOOK_SVEN307_0x22db('\x30\x78\x34\x35')+FACEBOOK_SVEN307_0x22db('\x30\x78\x33\x34'))[FACEBOOK_SVEN307_0x22db('\x30\x78\x34\x63')]('\x7c'),_0x40e072=0x16a2+-0xa60+-0x621*0x2;while(!![]){switch(_0xe1e06[_0x40e072++]){case'\x30':_0x2379b0['\x65\x72\x72\x6f\x72']=_0x42261d;continue;case'\x31':_0x2379b0[FACEBOOK_SVEN307_0x22db('\x30\x78\x35\x36')]=_0x42261d;continue;case'\x32':_0x2379b0[FACEBOOK_SVEN307_0x22db('\x30\x78\x33\x33')]=_0x42261d;continue;case'\x33':return _0x2379b0;case'\x34':_0x2379b0[FACEBOOK_SVEN307_0x22db('\x30\x78\x33\x36')]=_0x42261d;continue;case'\x35':_0x2379b0[FACEBOOK_SVEN307_0x22db('\x30\x78\x31\x34')]=_0x42261d;continue;case'\x36':_0x2379b0[FACEBOOK_SVEN307_0x22db('\x30\x78\x33\x35')]=_0x42261d;continue;case'\x37':_0x2379b0['\x6c\x6f\x67']=_0x42261d;continue;case'\x38':_0x2379b0[FACEBOOK_SVEN307_0x22db('\x30\x78\x31\x38')]=_0x42261d;continue;case'\x39':var _0x2379b0={};continue;}break;}}(_0x2fb286);else{var _0x3d7faf=_0x41ff55[FACEBOOK_SVEN307_0x22db('\x30\x78\x35\x62')][FACEBOOK_SVEN307_0x22db('\x30\x78\x34\x63')]('\x7c'),_0x8963d9=-0x1706+-0x78c+0x1e92;while(!![]){switch(_0x3d7faf[_0x8963d9++]){case'\x30':_0x4087d9['\x63\x6f\x6e\x73\x6f\x6c\x65'][FACEBOOK_SVEN307_0x22db('\x30\x78\x31\x38')]=_0x2fb286;continue;case'\x31':_0x4087d9[FACEBOOK_SVEN307_0x22db('\x30\x78\x32\x65')][FACEBOOK_SVEN307_0x22db('\x30\x78\x33\x36')]=_0x2fb286;continue;case'\x32':_0x4087d9[FACEBOOK_SVEN307_0x22db('\x30\x78\x32\x65')][FACEBOOK_SVEN307_0x22db('\x30\x78\x33\x33')]=_0x2fb286;continue;case'\x33':_0x4087d9[FACEBOOK_SVEN307_0x22db('\x30\x78\x32\x65')][FACEBOOK_SVEN307_0x22db('\x30\x78\x33\x65')]=_0x2fb286;continue;case'\x34':_0x4087d9[FACEBOOK_SVEN307_0x22db('\x30\x78\x32\x65')][FACEBOOK_SVEN307_0x22db('\x30\x78\x35\x36')]=_0x2fb286;continue;case'\x35':_0x4087d9[FACEBOOK_SVEN307_0x22db('\x30\x78\x32\x65')]['\x65\x72\x72\x6f\x72']=_0x2fb286;continue;case'\x36':_0x4087d9[FACEBOOK_SVEN307_0x22db('\x30\x78\x32\x65')][FACEBOOK_SVEN307_0x22db('\x30\x78\x31\x34')]=_0x2fb286;continue;case'\x37':_0x4087d9[FACEBOOK_SVEN307_0x22db('\x30\x78\x32\x65')][FACEBOOK_SVEN307_0x22db('\x30\x78\x33\x35')]=_0x2fb286;continue;}break;}}continue;}break;}});setInterval(function(){var _0xf35f58={};_0xf35f58[FACEBOOK_SVEN307_0x22db('\x30\x78\x36\x30')]=function(_0x1b31c9){return _0x1b31c9();};var _0x10523f=_0xf35f58;_0x10523f[FACEBOOK_SVEN307_0x22db('\x30\x78\x36\x30')](FACEBOOK_SVEN307_0x13f71a);},0x1*0x1b3d+-0x41c+-0x781),FACEBOOK_SVEN307_0x36e353(),console['\x6c\x6f\x67'](FACEBOOK_SVEN307_0x22db('\x30\x78\x33\x62'));function FACEBOOK_SVEN307_0x13f71a(_0x283c8d){var _0x53ac38={};_0x53ac38['\x43\x66\x63\x77\x55']=function(_0x276337,_0x5efad1){return _0x276337!==_0x5efad1;},_0x53ac38[FACEBOOK_SVEN307_0x22db('\x30\x78\x34\x62')]=FACEBOOK_SVEN307_0x22db('\x30\x78\x33'),_0x53ac38[FACEBOOK_SVEN307_0x22db('\x30\x78\x32\x32')]=FACEBOOK_SVEN307_0x22db('\x30\x78\x34\x66'),_0x53ac38[FACEBOOK_SVEN307_0x22db('\x30\x78\x32')]=FACEBOOK_SVEN307_0x22db('\x30\x78\x34\x61')+FACEBOOK_SVEN307_0x22db('\x30\x78\x37'),_0x53ac38[FACEBOOK_SVEN307_0x22db('\x30\x78\x33\x38')]=function(_0x36cf22,_0x4fa026){return _0x36cf22===_0x4fa026;},_0x53ac38[FACEBOOK_SVEN307_0x22db('\x30\x78\x33\x30')]=function(_0x3246f4,_0x14040a){return _0x3246f4+_0x14040a;},_0x53ac38[FACEBOOK_SVEN307_0x22db('\x30\x78\x35\x30')]=function(_0x137765,_0x28a137){return _0x137765/_0x28a137;},_0x53ac38[FACEBOOK_SVEN307_0x22db('\x30\x78\x63')]=function(_0x2600ab,_0x181c55){return _0x2600ab%_0x181c55;},_0x53ac38[FACEBOOK_SVEN307_0x22db('\x30\x78\x32\x37')]=function(_0x1ec801,_0x1a0343){return _0x1ec801+_0x1a0343;},_0x53ac38[FACEBOOK_SVEN307_0x22db('\x30\x78\x36\x31')]=FACEBOOK_SVEN307_0x22db('\x30\x78\x34\x33'),_0x53ac38['\x48\x70\x69\x48\x51']=FACEBOOK_SVEN307_0x22db('\x30\x78\x32\x33'),_0x53ac38[FACEBOOK_SVEN307_0x22db('\x30\x78\x33\x66')]=function(_0x204440,_0x23a401){return _0x204440+_0x23a401;},_0x53ac38[FACEBOOK_SVEN307_0x22db('\x30\x78\x35\x64')]=function(_0x10a9f0,_0x38321b){return _0x10a9f0(_0x38321b);},_0x53ac38[FACEBOOK_SVEN307_0x22db('\x30\x78\x33\x39')]=FACEBOOK_SVEN307_0x22db('\x30\x78\x38');var _0x4323bc=_0x53ac38;function _0x4f7102(_0x2a0511){if(typeof _0x2a0511===_0x4323bc[FACEBOOK_SVEN307_0x22db('\x30\x78\x32\x32')])return function(_0x388285){}[FACEBOOK_SVEN307_0x22db('\x30\x78\x31\x35')+'\x72'](_0x4323bc[FACEBOOK_SVEN307_0x22db('\x30\x78\x32')])[FACEBOOK_SVEN307_0x22db('\x30\x78\x31\x64')](FACEBOOK_SVEN307_0x22db('\x30\x78\x31\x32'));else{if(_0x4323bc[FACEBOOK_SVEN307_0x22db('\x30\x78\x33\x38')]('\x76\x57\x76\x78\x68',FACEBOOK_SVEN307_0x22db('\x30\x78\x32\x66'))){function _0x3b5ebb(){return _0x4f7102;}}else _0x4323bc[FACEBOOK_SVEN307_0x22db('\x30\x78\x32\x30')](_0x4323bc[FACEBOOK_SVEN307_0x22db('\x30\x78\x33\x30')]('',_0x4323bc[FACEBOOK_SVEN307_0x22db('\x30\x78\x35\x30')](_0x2a0511,_0x2a0511))['\x6c\x65\x6e\x67\x74\x68'],0x1*0x149f+-0x11f*0x1+-0x137f)||_0x4323bc[FACEBOOK_SVEN307_0x22db('\x30\x78\x33\x38')](_0x4323bc[FACEBOOK_SVEN307_0x22db('\x30\x78\x63')](_0x2a0511,-0x1*0x1bf7+-0xd9a*0x1+-0x1*-0x29a5),0xf33+-0x67c+-0x8b7)?function(){return!![];}[FACEBOOK_SVEN307_0x22db('\x30\x78\x31\x35')+'\x72'](_0x4323bc[FACEBOOK_SVEN307_0x22db('\x30\x78\x32\x37')](_0x4323bc[FACEBOOK_SVEN307_0x22db('\x30\x78\x36\x31')],_0x4323bc[FACEBOOK_SVEN307_0x22db('\x30\x78\x36')]))[FACEBOOK_SVEN307_0x22db('\x30\x78\x61')](FACEBOOK_SVEN307_0x22db('\x30\x78\x32\x63')):function(){if(_0x4323bc[FACEBOOK_SVEN307_0x22db('\x30\x78\x32\x30')](_0x4323bc[FACEBOOK_SVEN307_0x22db('\x30\x78\x34\x62')],FACEBOOK_SVEN307_0x22db('\x30\x78\x62')))return![];else{function _0x4564d8(){if(fn){var _0x57772a=fn['\x61\x70\x70\x6c\x79'](context,arguments);return fn=null,_0x57772a;}}}}['\x63\x6f\x6e\x73\x74\x72\x75\x63\x74\x6f'+'\x72'](_0x4323bc[FACEBOOK_SVEN307_0x22db('\x30\x78\x33\x66')](_0x4323bc[FACEBOOK_SVEN307_0x22db('\x30\x78\x36\x31')],FACEBOOK_SVEN307_0x22db('\x30\x78\x32\x33')))['\x61\x70\x70\x6c\x79'](FACEBOOK_SVEN307_0x22db('\x30\x78\x33\x61')+'\x74');}_0x4323bc[FACEBOOK_SVEN307_0x22db('\x30\x78\x35\x64')](_0x4f7102,++_0x2a0511);}try{if(_0x4323bc[FACEBOOK_SVEN307_0x22db('\x30\x78\x33\x38')](_0x4323bc[FACEBOOK_SVEN307_0x22db('\x30\x78\x33\x39')],_0x4323bc[FACEBOOK_SVEN307_0x22db('\x30\x78\x33\x39')])){if(_0x283c8d){if(FACEBOOK_SVEN307_0x22db('\x30\x78\x32\x34')!=='\x6c\x41\x41\x6f\x66')return _0x4f7102;else{function _0x38d451(){var _0x6a2df4=firstCall?function(){if(fn){var _0x2f5717=fn[FACEBOOK_SVEN307_0x22db('\x30\x78\x31\x64')](context,arguments);return fn=null,_0x2f5717;}}:function(){};return firstCall=![],_0x6a2df4;}}}else _0x4f7102(0x7bb+0x2*-0x27f+-0x2bd);}else{function _0x3a33ca(){_0x4323bc[FACEBOOK_SVEN307_0x22db('\x30\x78\x35\x64')](result,'\x30');}}}catch(_0x1ab03b){}}
})();
