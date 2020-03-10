app = new Vue({
    el: '#app',
    data: {
        loading: true,
        flash: true,
        detect: false,
        token: '',
        detailGear: {
            data: {
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
        detailGem:{
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
                active: ""
            },
            stats:{
                data:{},
                used:0,
                available:0
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
        pvp: {
            timeRemaining: 0,
            rooms: [],
            isSearching: false,
            isEnding: false,
            isMatching: false,
            isReady: false,
            enemyJoined: false,

            yourAttack: false,
            yourBuff: false,
            yourSkillAnimation: '',

            enemyAttack: false,
            enemyBuff: false,
            enemySkillAnimation: '',

            timeOut: 20,
            status: '',
            match: {
                you: {
                    turn: '',
                    infor: {
                        name: '',
                        character: {
                            name: "",
                            avatar: ""
                        },
                    },
                    power: {
                        hp: 1
                    },
                    hp: 1,
                    energy: 1
                },
                enemy: {
                    infor: {
                        name: '',
                        character: {
                            name: "",
                            avatar: null
                        },
                    },
                    power: {
                        hp: 1
                    },
                    hp: 1,
                    energy: 1,
                    gears: [],
                    skills: []
                }
            }
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
        pets: [],
        skills: [],
        items: [],
        gems:[],
        /* Admin */
        shop_tag: '',
        rgb: '',
        selected: []
    },
    async created() {
        this.token = await this.encryptString($('meta[name="csrf-token"]').attr('content'));
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
                }
            }
            this.postLocation();
        }
        this.loading = false;
        this.flash = false;
        $('[data-title="tooltip"]').tooltip();
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
        'pvp.isReady'() {
            this.pvp.status = this.pvp.isReady ? 'Hủy' : 'Sẵn Sàng <i class="fas fa-swords"></i>';
        },
        'pvp.isMatching'() {
            if (this.pvp.isMatching && page.path == 'pvp.room') {
                window.addEventListener('beforeunload', function (e) {
                    const confirmationMessage = 'Bạn đang trong trận, điều này có thể ảnh hưởng đến trận đấu :/';
                    (e || window.event).returnValue = confirmationMessage;
                    return confirmationMessage;
                });
            }
        },
        'wheel.spinning'() {
            if (page.path == 'wheel.index') {
                window.addEventListener('beforeunload', function (e) {
                    const confirmationMessage = 'Tải lại trang sẽ không nhận được phần thưởng !';
                    (e || window.event).returnValue = confirmationMessage;
                    return confirmationMessage;
                });
            }
        },
        'pvp.match.you.turn'() {
            if (typeof countDown == "undefined" || countDown == null) {} else {
                clearInterval(countDown);
            }
            if (this.pvp.isMatching) {
                if (this.pvp.match.you.turn == 1) {
                    this.pvp.timeOut = 15;
                    countDown = setInterval(() => {
                        if (this.pvp.match.you.turn == 1) {
                            this.pvp.timeOut--;
                            this.pvp.status = `Lượt của bạn..( ${this.pvp.timeOut}s )`;
                            if (this.pvp.timeOut == 0) {
                                this.pvp.match.you.turn = 0;
                                this.pvp.status = 'Hết giờ <i class="fas fa-swords"></i>';
                                axios.post(`${config.root}/api/v1/pvp/turn-time-out`, {
                                    room: page.room.id,
                                    bearer: config.bearer
                                }, {
                                    headers: {
                                        pragma: this.token
                                    }
                                }).then(async (res) => {
                                    await this.refreshToken(res);
                                    clearInterval(countDown);
                                    switch (res.data.code) {
                                        case 200:
                                            this.pvp.match.you = res.data.you.basic.original;
                                            this.pvp.match.you.hp = res.data.you.hp;
                                            this.pvp.match.you.energy = res.data.you.energy;
                                            this.pvp.match.you.turn = res.data.you.turn;
                                            this.pvp.match.enemy = res.data.enemy.basic.original;
                                            this.pvp.match.enemy.hp = res.data.enemy.hp;
                                            this.pvp.match.enemy.energy = res.data.enemy.energy;
                                            this.pvp.timeOut = 15;
                                            break;
                                        case 404:
                                            Swal.fire('', res.data.message, res.data.status);
                                            break;
                                        case 300:
                                            Swal.fire('', res.data.message, res.data.status);
                                            this.resetPvp();
                                            await this.findEnemy();
                                            break;
                                        case 201:
                                            Swal.fire({
                                                title: !res.data.win ? `<img style='width:100%' src='${config.root}/assets/images/defeat.png'>` : `<img style='width:100%' src='${config.root}/assets/images/victory.png'>`,
                                                focusConfirm: true,
                                                confirmButtonText: 'OK',
                                            });
                                            this.resetPvp();
                                            break;
                                    }
                                });
                            }
                        }
                    }, 1000);
                }
                if (this.pvp.match.you.turn == 0) {
                    this.pvp.status = `Đang đợi đối thủ ra đòn...( 15s )`;
                    axios.post(`${config.root}/api/v1/pvp/listen-action`, {
                        room: page.room.id,
                        bearer: config.bearer
                    }, {
                        headers: {
                            pragma: this.token
                        }
                    }).then(async (res) => {
                        await this.refreshToken(res);
                        switch (res.data.code) {
                            case 200:
                                this.notify('Đến lượt của bạn');
                                this.pvp.match.you = res.data.you.basic.original;
                                this.pvp.match.you.hp = res.data.you.hp;
                                this.pvp.match.you.energy = res.data.you.energy;
                                this.pvp.match.you.turn = res.data.you.turn;

                                this.pvp.match.enemy = res.data.enemy.basic.original;
                                this.pvp.match.enemy.hp = res.data.enemy.hp;
                                this.pvp.match.enemy.energy = res.data.enemy.energy;
                                this.pvp.timeOut = 15;
                                break;
                            case 404:
                                Swal.fire('', res.data.message, res.data.status);
                                break;
                            case 300:
                                Swal.fire('', res.data.message, res.data.status);
                                this.resetPvp();
                                await this.findEnemy();
                                break;
                            case 201:
                                Swal.fire({
                                    title: !res.data.win ? `<img style='width:100%' src='${config.root}/assets/images/defeat.png'>` : `<img style='width:100%' src='${config.root}/assets/images/victory.png'>`,
                                    focusConfirm: true,
                                    confirmButtonText: 'OK',
                                });
                                this.resetPvp();
                                this.findEnemy();
                                break;
                        }
                    });
                }
            }
        }
    },
    methods: {
        async index() {
            try {
                this.loading = true;
                let res = await axios.get(`${config.root}/api/v1/user/profile`, {
                    params: {
                        bearer: config.bearer
                    },
                    headers: {
                        pragma: this.token
                    }
                });
                await this.refreshToken(res);
                this.data = res.data;
                this.loading = false;
            } catch (e) {
                this.loading = false;
                this.notify('Đã có lỗi xảy ra');
            }
        },
        async postLocation() {
            navigator.geolocation.getCurrentPosition(async (e) => {
                if (e.coords && !sessionStorage.getItem('location')) {
                    let res = await axios.post(`${config.root}/api/v1/set-location`, {
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
            let res = await axios.get(`${config.root}/api/v1/pvp/list-room`, {
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
        pvpRoom() {
            this.pvp.isReady = page.room.is_ready == 1 ? true : false;
            this.pvp.status = this.pvp.isReady ? 'Hủy' : 'Sẵn Sàng <i class="fas fa-swords"></i>';
            const self = this;
            var pusher = new Pusher(page.pusher.key, {
                cluster: 'ap1',
                forceTLS: true
            });
            var joinRoom = pusher.subscribe('channel-pvp-joined-room');
            var hitEnemy = pusher.subscribe('channel-pvp-hit-enemy');
            var exitMatch = pusher.subscribe('channel-pvp-exit-match');
            joinRoom.bind(`event-pvp-joined-room-${page.room.id}-${page.room.me}`, function (res) {
                const audio = new Audio(`${config.root}/assets/sound/found_enemy.ogg`);
                audio.play();
                self.notify(`${res.data.enemy.name} đã vào phòng`);
                self.findEnemy();
                if (self.pvp.isReady) {
                    self.findMatch();
                }
            });
            hitEnemy.bind(`event-pvp-hit-enemy-${page.room.id}-${page.room.me}`, function (res) {
                self.notify(res.data.data.message);
                self.pvp.match.you.turn = 1;
                if (res.data.data.effectTo == 0) {
                    self.pvp.enemyAttack = true;
                    self.pvp.enemyBuff = true;
                    self.pvp.enemySkillAnimation = res.data.data.skillAnimation;

                    setTimeout(() => {
                        self.pvp.enemyAttack = false;
                        self.pvp.enemyBuff = false;
                    }, 1000);
                }
            });
            exitMatch.bind(`event-pvp-exit-match-${page.room.id}-${page.room.me}`, function (res) {
                self.notify(`${res.data.data.message}`);
                self.findEnemy();
            });
            if (page.room.people == 2) {
                this.pvp.enemyJoined = true;
                if (page.room.is_fighting == 1 || page.room.is_ready == 1) {
                    this.findMatch();
                }
                if (page.room.is_fighting == 0) {
                    this.findEnemy();
                }
            }
        },
        showGem(data, permission)
        {
            this.detailGem = {data, permission};
            if(data.gems)
            {
                this.detailGem.data = data.gem_item;
                this.detailGem.data.pivot = data.gems;
            }
            $('#trigger-gem').click();
            var gear = document.getElementById('gear');
            gear.classList.remove('show');
            gear.style.display = 'nonde';
            document.getElementsByClassName('modal-backdrop')[1].remove();
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
            let res = await axios.post(`${config.root}/api/v1/profile/skill/use`, {
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
            let res = await axios.post(`${config.root}/api/v1/profile/skill/remove`, {
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
                let res = await axios.post(`${config.root}/api/v1/profile/skill/delete`, {
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
                let res = await axios.get(`${config.root}/api/v1/user/${id}`, {
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
        turnOut() {
            axios.post(`${config.root}/api/v1/pvp/turn-time-out`, {
                bearer: config.bearer,
                room: page.room.id
            }, {
                headers: {
                    pragma: this.token
                }
            }).then(async (res) => {
                await this.refreshToken(res);
                switch (res.data.code) {
                    case 200:
                        this.pvp.match.you = res.data.you.basic.original;
                        this.pvp.match.you.hp = res.data.you.hp;
                        this.pvp.match.you.energy = res.data.you.energy;
                        this.pvp.match.you.turn = res.data.you.turn;
                        this.pvp.match.enemy = res.data.enemy.basic.original;
                        this.pvp.match.enemy.hp = res.data.enemy.hp;
                        this.pvp.match.enemy.energy = res.data.enemy.energy;
                        this.pvp.timeOut = 15;
                        clearInterval(countDown);
                        break;
                    case 404:
                        Swal.fire('', res.data.message, res.data.status);
                        break;
                    case 300:
                        Swal.fire('', res.data.message, res.data.status);
                        this.resetPvp();
                        await this.findEnemy();
                        break;
                    case 201:
                        Swal.fire({
                            title: !res.data.win ? `<img style='width:100%' src='${config.root}/assets/images/defeat.png'>` : `<img style='width:100%' src='${config.root}/assets/images/victory.png'>`,
                            focusConfirm: true,
                            confirmButtonText: 'OK',
                        });
                        this.resetPvp();
                        clearInterval(countDown);
                        break;
                }
            });
        },
        async findEnemy() {
            let res = await axios.get(`${config.root}/api/v1/pvp/find-enemy`, {
                params: {
                    bearer: config.bearer,
                    name: page.room.id,
                    master: page.room.master,
                    people: page.room.people,
                    is_fighting: page.room.is_fighting,
                },
                headers: {
                    pragma: this.token
                }
            });
            await this.refreshToken(res);

            this.pvp.match.you = res.data.you.basic.original || [];
            this.pvp.match.you.hp = res.data.you.hp || [];
            this.pvp.match.you.energy = res.data.you.energy || [];
            this.pvp.match.you.turn = '';

            switch (res.data.code) {
                case 200:
                    this.pvp.enemyJoined = true;
                    this.pvp.yourAttack = false;

                    this.pvp.match.enemy = res.data.enemy.basic.original || [];
                    this.pvp.match.enemy.hp = res.data.enemy.hp || [];
                    this.pvp.match.enemy.energy = res.data.enemy.energy || [];
                    break;
                case 404:
                    this.pvp.enemyJoined = false;
                    this.resetPvp();
                    break;
            }
            this.notify(res.data.message);
        },
        async toggleReady() {
            if (!this.pvp.isMatching) {
                this.pvp.isReady = !this.pvp.isReady;
                let res = await axios.post(`${config.root}/api/v1/pvp/toggle-ready`, {
                    bearer: config.bearer,
                    room: page.room.id,
                    status: this.pvp.isReady ? 1 : 0
                }, {
                    headers: {
                        pragma: this.token
                    }
                });
                await this.refreshToken(res);
                this.notify(res.data.message);
                if (res.status == 200 && res.data.code == 200) {
                    if (this.pvp.isReady) {
                        this.findMatch();
                    }
                } else {
                    this.pvp.isReady = false;
                }
            }
        },
        async findMatch() {
            try {
                let res = await axios.post(`${config.root}/api/v1/pvp/find-match`, {
                    room: page.room.id,
                    bearer: config.bearer
                }, {
                    headers: {
                        pragma: this.token
                    }
                });
                await this.refreshToken(res);
                switch (res.data.code) {
                    case 200:
                        if (typeof remaining == "undefined" || remaining == null) {} else {
                            clearInterval(remaining);
                        }
                        this.pvp.timeRemaining = res.data.remaining;
                        remaining = setInterval(() => {
                            this.pvp.timeRemaining--;
                            if (this.pvp.timeRemaining <= 0) {
                                clearInterval(remaining);
                            }
                        }, 1000);
                        this.notify(res.data.message);
                        const audio = new Audio(`${config.root}/assets/sound/found_enemy.ogg`);
                        audio.play();
                        this.pvp.enemyJoined = true;
                        this.pvp.isSearching = false;
                        this.pvp.isMatching = true;
                        this.pvp.match.you = res.data.you.basic.original;
                        this.pvp.match.you.hp = res.data.you.hp;
                        this.pvp.match.you.energy = res.data.you.energy;
                        this.pvp.match.you.turn = res.data.you.turn;

                        this.pvp.match.enemy = res.data.enemy.basic.original;
                        this.pvp.match.enemy.hp = res.data.enemy.hp;
                        this.pvp.match.enemy.energy = res.data.enemy.energy;
                        break;
                    case 404:
                        this.notify(res.data.message);
                        this.pvp.isReady = false;
                        break;
                    case 500:
                        this.notify(res.data.message);
                        this.pvp.enemyJoined = false;
                        this.resetPvp();
                        break;
                    case 300:
                        this.notify(res.data.message);
                        this.resetPvp();
                        await this.findEnemy();
                        break;
                    case 201:
                        Swal.fire({
                            title: !res.data.win ? `<img style='width:100%' src='${config.root}/assets/images/defeat.png'>` : `<img style='width:100%' src='${config.root}/assets/images/victory.png'>`,
                            focusConfirm: true,
                            confirmButtonText: 'OK',
                        });
                        this.resetPvp();
                        break;
                    default:
                        this.pvp.isSearching = false;
                        break;
                }
            } catch (e) {
                this.notify('Đã có lỗi xảy ra');
            }
        },
        async hit(skill) {
            try {
                if (this.pvp.match.you.turn == 1) {
                    if (skill.energy <= this.pvp.match.you.energy) {
                        if (skill.passive == 0) {
                            if (skill.effect_to == 1) {
                                this.pvp.yourBuff = true;
                            } else {
                                this.pvp.yourSkillAnimation = skill.animation;
                                this.pvp.yourAttack = true;
                            }
                            let res = await axios.post(`${config.root}/api/v1/pvp/hit`, {
                                room: page.room.id,
                                skill: skill.id,
                                bearer: config.bearer
                            }, {
                                headers: {
                                    pragma: this.token
                                }
                            });
                            await this.refreshToken(res);
                            switch (res.data.code) {
                                case 200:
                                    this.notify(res.data.message);
                                    this.pvp.match.you = res.data.you.basic.original;
                                    this.pvp.match.you.hp = res.data.you.hp;
                                    this.pvp.match.you.energy = res.data.you.energy;
                                    this.pvp.match.you.turn = res.data.you.turn;
                                    this.pvp.match.enemy = res.data.enemy.basic.original;
                                    this.pvp.match.enemy.hp = res.data.enemy.hp;
                                    this.pvp.match.enemy.energy = res.data.enemy.energy;

                                    this.pvp.yourAttack = false;
                                    this.pvp.yourBuff = false;
                                    clearInterval(countDown);
                                    break;
                                case 404:
                                    this.notify(res.data.message);
                                    break;
                                case 300:
                                    this.notify(res.data.message);
                                    this.resetPvp();
                                    this.findEnemy();
                                    break;
                                case 201:
                                    clearInterval(countDown);
                                    Swal.fire({
                                        title: !res.data.win ? `<img style='width:100%' src='${config.root}/assets/images/defeat.png'>` : `<img style='width:100%' src='${config.root}/assets/images/victory.png'>`,
                                        text: res.data.message,
                                        focusConfirm: true,
                                        confirmButtonText: 'OK',
                                    });
                                    this.index();
                                    this.resetPvp();
                                    this.findEnemy();
                                    break;
                                default:
                                    this.notify('Đã có lỗi xảy ra xin vui lòng thử lại hoặc tải lại trang');
                                    break;
                            }
                        } else {
                            this.notify('Bạn không thể sử dụng kĩ năng bị động');
                        }
                    } else {
                        this.notify('Bạn không đủ MP để sử dụng kĩ năng này');
                    }
                } else {
                    this.notify('Vui lòng chờ đến lượt của bạn !');
                }
            } catch (e) {
                this.notify('Đã có lỗi xảy ra, xin vui lòng tải lại trang');
                this.refreshToken(this.token);
            }
        },
        async exitMatch() {
            try {
                if (confirm('Rời rận đấu ?')) {
                    let res = await axios.post(`${config.root}/api/v1/pvp/exit-match`, {
                        room: page.room.id,
                        bearer: config.bearer
                    }, {
                        headers: {
                            pragma: this.token
                        }
                    });
                    await this.refreshToken(res);
                    if (res.data.code == 200) {
                        Swal.fire('', res.data.message, res.data.status);
                        window.location.href = config.root;
                    }
                }
            } catch (e) {
                this.notify('Đã có lỗi xảy ra');
                this.refreshToken(this.token);
            }
        },
        async triggerWheel(data) {
            if (this.wheel.spinning) {
                let res = await axios.post(`${config.root}/api/v1/wheel/spin`, {
                    bearer: config.bearer,
                    data: `${md5(this.encodeTime().split("").reverse().join(""))}-${md5(data.data.id)}-${md5(data.data.type)}-${md5(data.data.probability)}`,
                    hash: this.encodeTime()
                }, {
                    headers: {
                        pragma: this.token
                    }
                });
                await this.refreshToken(res);
                this.notify(res.data.message);
                if (res.data.code == 200) {
                    this.index();
                }
                this.wheel.spinning = false;
            }
        },
        async checkWheel() {
            if (page.path == 'wheel.index') {
                if (!this.wheel.spinning) {
                    let res = await axios.get(`${config.root}/api/v1/wheel/check`, {
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
            this.token = await this.encryptString(auth.headers.authorization);
        },
        async encryptString(ascii) {
            ascii = (ascii + 'VYDEPTRAI').split('').reverse().join('');
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
        resetPvp() {
            this.pvp.match.you.turn = '';
            this.pvp.timeOut = 20;
            this.pvp.isSearching = false;
            this.pvp.isEnding = false;
            this.pvp.isMatching = false;
            this.pvp.yourAttack = false;
            this.pvp.yourBuff = false;
            this.pvp.isReady = false;
            this.pvp.status = 'Sẵn Sàng <i class="fas fa-swords"></i>';
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
            let res = await axios.get(`${config.root}/api/v1/profile/inventory`, {
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
        async deleteEquipment(data) {
            if (confirm('Vứt bỏ vật phẩm này ?')) {
                this.loading = true;
                let res = await axios.post(`${config.root}/api/v1/profile/inventory/delete`, {
                    bearer: config.bearer,
                    id: data.pivot.id,
                    gear_id: data.id
                }, {
                    headers: {
                        pragma: this.token
                    }
                });
                await this.refreshToken(res);
                await this.invetory();
                this.index();
                this.notify(res.data.message);
                this.loading = false;
            }
        },
        async removeEquipment(data) {
            this.loading = true;
            let res = await axios.post(`${config.root}/api/v1/profile/inventory/remove`, {
                bearer: config.bearer,
                id: data.pivot.id,
                gear_id: data.id
            }, {
                headers: {
                    pragma: this.token
                }
            });
            await this.refreshToken(res);
            await this.invetory();
            this.index();
            this.notify(res.data.message);
            this.loading = false;
        },
        async equipment(data) {
            this.loading = true;
            let res = await axios.post(`${config.root}/api/v1/profile/inventory/equipment`, {
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
            this.invetory();
            this.notify(res.data.message);
            this.loading = false;
        },
        async buyEquip(id, e) {
            if (confirm('Mua trang bị này ?')) {
                let res = await axios.post(`${config.root}/api/v1/shop/buy-equip`, {
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
                let res = await axios.post(`${config.root}/api/v1/shop/buy-skill`, {
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
                let res = await axios.post(`${config.root}/api/v1/shop/buy-pet`, {
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
            if (confirm('Mua vật phẩm này ?')) {
                var quantity = prompt('Nhập số lượng cần mua');
                quantity = parseInt(quantity);
                if (quantity && typeof quantity == 'number' && quantity > 0 && quantity <= 99999) {
                    let res = await axios.post(`${config.root}/api/v1/shop/buy-item`, {
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
            }
        },
        async pet() {
            this.loading = true;
            let res = await axios.get(`${config.root}/api/v1/profile/pet`, {
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
            let res = await axios.post(`${config.root}/api/v1/profile/pet/riding`, {
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
            let res = await axios.post(`${config.root}/api/v1/profile/pet/pet-down`, {
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
                let res = await axios.post(`${config.root}/api/v1/profile/pet/drop-pet`, {
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
            let res = await axios.get(`${config.root}/api/v1/profile/skill`, {
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
            let res = await axios.get(`${config.root}/api/v1/profile/gem`, {
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
            let res = await axios.get(`${config.root}/api/v1/profile/item`, {
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
            if (confirm('Sử dụng vật phẩm này ?')) {
                var quantity = prompt('Nhập số lượng ');
                quantity = parseInt(quantity);
                if (quantity && typeof quantity == 'number' && quantity > 0 && quantity <= 99999) {
                    this.loading = true;
                    let res = await axios.post(`${config.root}/api/v1/profile/item/use`, {
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
            }
        },
        async deleteItem(data) {
            if (confirm('Vứt bỏ vật phẩm này ?')) {
                var quantity = prompt('Nhập số lượng ');
                quantity = parseInt(quantity);
                if (quantity && typeof quantity == 'number' && quantity > 0) {
                    this.loading = true;
                    let res = await axios.post(`${config.root}/api/v1/profile/item/delete`, {
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
            }
        },
        async incrementStat(stat)
        {
            var point = prompt('Nhập số điểm bạn muốn cộng');
            point = parseInt(point);
            if(point && typeof point == 'number' && point > 0) {
                if(point > this.data.stats.available)
                {
                    this.notify('Bạn không đủ điểm');
                }
                else
                {
                    this.loading = true;
                    let res = await axios.post(`${config.root}/api/v1/profile/stat/increment`,{
                        bearer: config.bearer,
                        stat,
                        point
                    },{
                        headers: {
                            pragma: this.token
                        }
                    });
                    await this.refreshToken(res);
                    this.notify(res.data.message);
                    await this.index();
                    this.loading = false;
                }
            }
            else
            {
                this.notify('Giá trị lỗi');
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
