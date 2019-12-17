app = new Vue({
    el:'#app',
    data:{
        loading:true,
        token:'',
        data:{
            infor:{
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
            rank:{
                power:'Đang tải...',
                rich:0
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
            gears:[],
            skills:[]
        },
        user:{
            infor:{
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
            rank:{
                power:'Đang tải...',
                rich:0
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
            gears:[],
            skills:[]
        },
        pvp:{
            rooms:[],
            isSearching:false,
            isEnding:false,
            isMatching:false,
            isReady:false,
            enemyJoined:false,

            yourAttack:false,
            yourBuff:false,
            yourSkillAnimation:'',

            enemyAttack:false,
            enemyBuff:false,
            enemySkillAnimation:'',

            timeOut:20,
            status:'',
            match:{
                you:{
                    turn:'',
                    infor:{
                        name:'',
                        character: {
                            name: "",
                            avatar: ""
                        },
                    },
                    power:{
                        hp:1
                    },
                    hp:1,
                    energy:1
                },
                enemy:{
                    infor:{
                        name:'',
                        character: {
                            name: "",
                            avatar: null
                        },
                    },
                    power:{
                        hp:1
                    },
                    hp:1,
                    energy:1
                }
            }
        }
    },
    async created()
    {
        this.token = await this.sha256($('meta[name="csrf-token"]').attr('content'));
        if(config.auth)
        {
            await this.index();
            if(typeof page != "undefined" || page != null)
            {
                switch(page.path)
                {
                    case 'pvp.list':
                        this.listFightRoom();
                    break;
                    case 'pvp.room':
                        this.pvp.isReady = page.room.is_ready == 1 ? true : false;
                        this.pvp.status = this.pvp.isReady ? 'Hủy' : 'Sẵn Sàng <i class="fas fa-swords"></i>';
                        const self = this;
                        Pusher.logToConsole = true;
                        var pusher = new Pusher(page.pusher.key, {
                            cluster: 'ap1',
                            forceTLS: true
                        });
                        var joinRoom = pusher.subscribe('channel-pvp-joined-room');
                        var hitEnemy =  pusher.subscribe('channel-pvp-hit-enemy');
                        joinRoom.bind(`event-pvp-joined-room-${page.room.id}-${page.room.me}`, function(res) {
                            const audio = new Audio(`${config.root}/assets/sound/found_enemy.mp3`);
                            audio.play();
                            self.notify(`${res.data.enemy.name} đã vào phòng`);
                            self.findEnemy();
                            if(self.pvp.isReady)
                            {
                                self.findMatch();
                            }
                        });
                        hitEnemy.bind(`event-pvp-hit-enemy-${page.room.id}-${page.room.me}`, function(res) {
                            self.notify(res.data.data.message);
                            if(res.data.data.effectTo == 0)
                            {
                                self.pvp.enemyAttack = true;
                                self.pvp.enemyBuff = true;
                                self.pvp.enemySkillAnimation = res.data.data.skillAnimation;

                                setTimeout(() => {
                                    self.pvp.enemyAttack = false;
                                    self.pvp.enemyBuff = false;
                                },1000);
                            }
                        });
                        if(page.room.people == 2)
                        {
                            this.pvp.enemyJoined = true;
                            if(page.room.is_fighting == 1)
                            {
                                this.findMatch();
                            }
                            else
                            {
                                this.findEnemy();
                            }
                        }
                    break;
                }
            }
        }
        this.loading = false;
    },
    watch:{
        'pvp.isReady'()
        {
            this.pvp.status = this.pvp.isReady ? 'Hủy' : 'Sẵn Sàng <i class="fas fa-swords"></i>';
        },
        'pvp.isMatching'()
        {
            if(this.pvp.isMatching && page.path == 'pvp.room')
            {
                window.addEventListener('beforeunload', function (e) {
                    const confirmationMessage = 'Bạn đang trong trận, điều này có thể ảnh hưởng đến trận đấu :/';
                    (e || window.event).returnValue = confirmationMessage; 
                    return confirmationMessage;                            
                });
            }
        },
        'pvp.match.you.turn'()
        {
            if(this.pvp.match.you.turn == 1)
            {
                this.pvp.timeOut = 15;
                countDown = setInterval(() => {
                    if(this.pvp.match.you.turn == 1)
                    {
                        this.pvp.timeOut--;
                        this.pvp.status = `Lượt của bạn..( ${this.pvp.timeOut}s )`;
                        if(this.pvp.timeOut == 0)
                        {
                            this.pvp.match.you.turn = 0;
                            this.pvp.status = 'Hết giờ <i class="fas fa-swords"></i>';
                            axios.post(`${config.root}/api/v1/pvp/turn-time-out`,'',{
                                headers:{
                                    pragma:this.token
                                }
                            }).then(async (res) => {
                                await this.refreshToken(res);
                                switch(res.data.code)
                                {
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
                                        Swal.fire('',res.data.message,res.data.status);
                                    break;
                                    case 300:
                                        Swal.fire('',res.data.message,res.data.status);
                                        window.location.href = config.root;
                                    break;
                                    case 201:
                                        Swal.fire({
                                            title: !res.data.win ? `<img style='width:100%' src='${config.root}/assets/images/defeat.png'>` : `<img style='width:100%' src='${config.root}/assets/images/victory.png'>`,
                                            focusConfirm: true,
                                            confirmButtonText:'OK',
                                        });
                                        this.resetPvp();
                                        clearInterval(countDown);
                                    break;
                                }
                            });
                        }
                    }
                },1000);
            }
            else if(this.pvp.match.you.turn == 0)
            {
                this.pvp.status = `Đang đợi đối thủ ra đòn...( 15s )`;
                axios.post(`${config.root}/api/v1/pvp/listen-action`,'',{
                    headers:{
                        pragma:this.token
                    }
                }).then(async (res) => {
                    await this.refreshToken(res);
                    switch(res.data.code)
                    {
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
                            Swal.fire('',res.data.message,res.data.status);
                        break;
                        case 300:
                            Swal.fire('',res.data.message,res.data.status);
                            window.location.href = config.root;
                        break;
                        case 201:
                            Swal.fire({
                                title: !res.data.win ? `<img style='width:100%' src='${config.root}/assets/images/defeat.png'>` : `<img style='width:100%' src='${config.root}/assets/images/victory.png'>`,
                                focusConfirm: true,
                                confirmButtonText:'OK',
                            });
                            this.resetPvp();
                            this.findEnemy();
                        break;
                    }
                });
            }
        }
    },
    methods:{
        async index()
        {
            try
            {
                this.loading = true;
                let res = await axios.get(`${config.root}/api/v1/user/profile`,{
                    headers:{
                        pragma:this.token
                    }
                });
                await this.refreshToken(res);
                this.data = res.data;
                this.loading = false;
            }
            catch(e)
            {
                this.loading = false;
                this.notify('Đã có lỗi xảy ra');
            }
        },
        async listFightRoom()
        {
            this.loading = true;
            let res = await axios.get(`${config.root}/api/v1/pvp/list-room`,{
                headers:{
                    pragma:this.token
                }
            });
            this.pvp.rooms = res.data.rooms || this.pvp.rooms;
            await this.refreshToken(res);
            this.loading = false;
        },
        showGearsDescription(data,permission)
        {
            Swal.fire({
                title:`<img style="width:80px;height:80px;border:1px solid ${data.rgb};border-radius:5px" src="${data.image}">`,
                type:'',
                showConfirmButton:permission == 1 ? true : false,
                confirmButtonText:permission == 1 ? 'Tháo trang bị' : '',
                showCancelButton:true,
                cancelButtonColor:'#333',
                cancelButtonText:'Đóng',
                html:`<p>[ ${data.name} ]</p><p>${data.description}</p>
                    <p>Yêu cầu cấp độ : ${data.level_required}</p>
                    <p>Sinh Lực : +${data.health_points}</p>
                    <p> Sức Mạnh : +${data.strength} </p>
                    <p> Trí Tuệ : +${data.intelligent}</p>
                    <p> Nhanh nhẹn : +${data.agility}</p>
                    <p> May mắn : +${data.lucky}</p>
                    <p> Kháng Công : +${data.armor_strength}</p>
                    <p> Kháng Phép : +${data.armor_intelligent}</p>`
            }).then((result) => {
                if(result.value)
                {
                    alert(1);
                }
            });
        },
        showSkillsDescription(data)
        {
            Swal.fire({
                title:`<img style="width:80px;height:80px;border-radius:5px;border:1px solid ${data.rgb}" src="${data.image}">`,
                type:'',
                html:`<p>[ ${data.name} - ${data.passive == 1 ? 'Bị động' : 'Chủ động'} ] <p/> <p>${data.description} </p> <p>Yêu cầu cấp độ : ${data.required_level} </p> <p>MP : ${data.energy} </p> <p>Tỉ lệ thành công : ${data.success_rate}% </p>`
            });
        },
        async showUserInfor(id)
        {
            try
            {
                this.loading = true;
                let res = await axios.get(`${config.root}/api/v1/user/${id}`,{
                    headers:{
                        pragma:this.token
                    }
                });
                await this.refreshToken(res);
                this.user = res.data;
                this.loading = false;
                $('#show-infor-user').click();
            }
            catch(e)
            {
                this.loading = false;
                this.notify('Đã có lỗi xảy ra, xin vui lòng thử lại');
                this.refreshToken(this.token);
            }
        },
        async findEnemy()
        {
            let res = await axios.get(`${config.root}/api/v1/pvp/find-enemy`,{
                params:{
                    name:page.room.id,
                    master:page.room.master,
                    people:page.room.people,
                    is_fighting:page.room.is_fighting,
                },
                headers:{
                    pragma:this.token
                }
            });
            await this.refreshToken(res);

            this.pvp.match.you = res.data.you.basic.original || [];
            this.pvp.match.you.hp = res.data.you.hp || [];
            this.pvp.match.you.energy = res.data.you.energy || [];

            switch(res.data.code)
            {
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
        async toggleReady()
        {
            if(!this.pvp.isMatching)
            {
                this.pvp.isReady = !this.pvp.isReady;
                let res = await axios.post(`${config.root}/api/v1/pvp/toggle-ready`,{
                    room:page.room.id,
                    status:this.pvp.isReady ? 1 : 0
                },{
                    headers:{
                        pragma:this.token
                    }
                });
                await this.refreshToken(res);
                this.notify(res.data.message);
                if(res.status == 200 && res.data.code == 200)
                {
                    if(this.pvp.isReady)
                    {
                        this.findMatch();
                    }
                }
                else
                {
                    this.pvp.isReady = false;
                }
            }
        },
        async findMatch()
        {
            try
            {
                let res = await axios.post(`${config.root}/api/v1/pvp/find-match`,{
                    room:page.room.id
                },{
                    headers:{
                        pragma:this.token
                    }
                });
                await this.refreshToken(res);
                switch(res.data.code)
                {
                    case 200:
                        this.notify(res.data.message);
                        const audio = new Audio(`${config.root}/assets/sound/found_enemy.mp3`);
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
                    break;
                    case 201:
                        Swal.fire({
                            title: !res.data.win ? `<img style='width:100%' src='${config.root}/assets/images/defeat.png'>` : `<img style='width:100%' src='${config.root}/assets/images/victory.png'>`,
                            focusConfirm: true,
                            confirmButtonText:'OK',
                        });
                        this.resetPvp();
                    break;
                    default:
                        this.pvp.isSearching = false;
                    break;
                }
            }
            catch(e)
            {
                this.notify('Đã có lỗi xảy ra');
            }
        },
        async hit(skill)
        {
            try
            {
                if(this.pvp.match.you.turn == 1)
                {
                    if(skill.energy <= this.pvp.match.you.energy)
                    {
                        if(skill.passive == 0)
                        {
                            if(skill.effect_to == 1)
                            {
                                this.pvp.yourBuff = true;
                            }
                            else
                            {
                                this.pvp.yourSkillAnimation = skill.animation;
                                this.pvp.yourAttack = true;
                            }
                            let res = await axios.post(`${config.root}/api/v1/pvp/hit`,{
                                room:page.room.id,
                                skill:skill.id
                            },{
                                headers:{
                                    pragma:this.token
                                }
                            });
                            await this.refreshToken(res);
                            switch(res.data.code)
                            {
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
                                    window.location.href = config.root;
                                break;
                                case 201:
                                    clearInterval(countDown);
                                    Swal.fire({
                                        title: !res.data.win ? `<img style='width:100%' src='${config.root}/assets/images/defeat.png'>` : `<img style='width:100%' src='${config.root}/assets/images/victory.png'>`,
                                        text:res.data.message,
                                        focusConfirm: true,
                                        confirmButtonText:'OK',
                                    });
                                    this.index();
                                    this.resetPvp();
                                    this.findEnemy();
                                break;
                                default:
                                    this.notify('Đã có lỗi xảy ra xin vui lòng thử lại hoặc tải lại trang');
                                break;
                            }
                        }
                        else
                        {
                            this.notify('Bạn không thể sử dụng kĩ năng bị động');
                        }
                    }
                    else
                    {
                        this.notify('Bạn không đủ MP để sử dụng kĩ năng này');
                    }
                }
                else
                {
                    this.notify('Vui lòng chờ đến lượt của bạn !');
                }
            }
            catch(e)
            {
                this.notify('Đã có lỗi xảy ra, xin vui lòng tải lại trang');
                this.refreshToken(this.token);
            }
        },
        async exitMatch()
        {
            try
            {
                if(confirm('Rời rận đấu ?'))
                {
                    let res = await axios.post(`${config.root}/api/v1/pvp/exit-match`,{
                        room:page.room.id
                    },{
                        headers:{
                            pragma:this.token
                        }
                    });
                    await this.refreshToken(res);
                    if(res.data.code == 200)
                    {
                        Swal.fire('',res.data.message,res.data.status);
                        window.location.href = config.root;
                    } 
                }
            }
            catch(e)
            {
                this.notify('Đã có lỗi xảy ra');
                this.refreshToken(this.token);
            }
        },
        notify(message)
        {
            Toastify({
                text: message,
                duration: 5000,
                newWindow: true,
                gravity: "top",
                position: 'right',
                className: "vip-bordered",
                stopOnFocus: true,
                onClick: function(){}
            }).showToast();
        },
        async refreshToken(auth)
        {
            this.token = await this.sha256(auth.headers.authorization);
        },
        async sha256(ascii) 
        {
            ascii = (ascii+'VYDEPTRAI').split('').reverse().join('');
            ascii = await this.encode(ascii);
            return sha256(ascii);
        },
        encode(message)
        {
            message = message.replace(/1/gi,"^");
            message = message.replace(/2/gi,"+");
            message = message.replace(/3/gi,"#");
            message = message.replace(/4/gi,"*");
            message = message.replace(/5/gi,"<");
            message = message.replace(/6/gi,"%");
            message = message.replace(/7/gi,"!");
            message = message.replace(/8/gi,"_");
            message = message.replace(/9/gi,"=");
            return message;
        },
        resetPvp()
        {
            this.pvp.timeOut = 20;
            this.pvp.isSearching = false;
            this.pvp.isEnding = false;
            this.pvp.isMatching = false;
            this.pvp.yourAttack = false;
            this.pvp.yourBuff = false;
            this.pvp.isReady = false;
            this.pvp.status = 'Sẵn Sàng <i class="fas fa-swords"></i>';
        }
    },
});
