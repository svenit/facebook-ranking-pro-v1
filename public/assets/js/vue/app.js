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
            isSearching:false,
            isMatching:false,
            timeOut:20,
            status:'Tìm Đối Thủ <i class="fas fa-swords"></i>',
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
                    hp:1
                },
                enemy:{
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
                    hp:1
                }
            }
        }
    },
    async created()
    {
        this.token = await this.sha256($('meta[name="csrf-token"]').attr('content'));
        this.index();
        this.pvpArea();
    },
    watch: {
        'pvp.match.you.turn'()
        {
            if(this.pvp.match.you.turn == 0)
            {
                this.pvp.timeOut = 15;
                countDown = setInterval(() => {
                    if(this.pvp.match.you.turn == 0)
                    {
                        this.pvp.timeOut--;
                        this.pvp.status = `Lượt của bạn..( ${this.pvp.timeOut}s )`;
                        if(this.pvp.timeOut == 0)
                        {
                            this.pvp.status = 'Hết giờ <i class="fas fa-swords"></i>';
                            axios.post(`${config.root}/api/v1/pvp/turn-time-out`,'',{
                                headers:{
                                    pragma:this.token
                                }
                            }).then((res) => {
                                switch(res.data.code)
                                {
                                    case 200:
                                        this.pvp.match.you = res.data.you.basic.original;
                                        this.pvp.match.you.hp = res.data.you.hp;
                                        this.pvp.match.enemy = res.data.enemy.basic.original;
                                        this.pvp.match.enemy.hp = res.data.enemy.hp;
                                        this.pvp.match.you.turn = res.data.you.turn;
                                        this.pvp.timeOut = 15;
                                        clearInterval(countDown);
                                    break;
                                    case 404:
                                        Swal.fire('',res.data.message,res.data.status);
                                    break;
                                    case 300:
                                        location.reload();
                                    break;
                                }
                            });
                        }
                    }
                },1000);
            }
            else
            {
                this.pvp.status = `Đang đợi đối thủ ra đòn...( 15s )`;
                axios.post(`${config.root}/api/v1/pvp/listen-action`,'',{
                    headers:{
                        pragma:this.token
                    }
                }).then((res) => {
                    switch(res.data.code)
                    {
                        case 200:
                            this.pvp.match.you = res.data.you.basic.original;
                            this.pvp.match.you.hp = res.data.you.hp;
                            this.pvp.match.enemy = res.data.enemy.basic.original;
                            this.pvp.match.enemy.hp = res.data.enemy.hp;
                            this.pvp.match.you.turn = res.data.you.turn;
                            this.pvp.timeOut = 15;
                            clearInterval(countDown);
                        break;
                        case 404:
                            Swal.fire('',res.data.message,res.data.status);
                        break;
                        case 300:
                            location.reload();
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
                this.data = res.data;
                this.refreshToken(res);
                this.loading = false;
            }
            catch(e)
            {
                console.error(e);
                this.loading = false;
            }
        },
        showDescription(description)
        {
            Swal.fire('',description,'info');
        },
        async showUserInfor(id)
        {
            this.loading = true;
            let res = await axios.get(`${config.root}/api/v1/user/${id}`,{
                headers:{
                    pragma:this.token
                }
            });
            this.user = res.data;
            this.refreshToken(res);
            this.loading = false;
            $('#show-infor-user').click();
        },
        pvpArea()
        {
            if(document.location.href.includes('pvp'))
            {
                this.findEnemy();
            }
        },
        async findEnemy()
        {
            if(this.pvp.isMatching)
            {
                Swal.fire('','Bạn đang trong trận','warning');
            }
            else
            {
                if(this.pvp.isSearching)
                {
                    Swal.fire('','Đang tìm kiếm trận','warning');
                    return false;
                }
                else
                {
                    if(!this.isMatching)
                    {
                        this.pvp.isSearching = true;
                        var countDown = setInterval(() => {
                            this.pvp.timeOut--;
                            this.pvp.status = `Đang tìm trận..( ${this.pvp.timeOut}s )`;
                            if(this.pvp.timeOut == 0)
                            {
                                this.pvp.status = 'Tìm Trận <i class="fas fa-swords"></i>';
                                clearInterval(countDown);
                                this.pvp.isSearching = false;
                                this.pvp.timeOut = 20;
                            }
                        },1000);
                        this.isSearching = false;
                    }
                    let res = await axios.post(`${config.root}/api/v1/pvp/find-enemy`,'',{
                        headers:{
                            pragma:this.token
                        }
                    });
                    Swal.fire('',res.data.message,res.data.status);
                    switch(res.data.code)
                    {
                        case 200:
                            this.pvp.isSearching = false;
                            this.pvp.isMatching = true;
                            this.pvp.match.you = res.data.you.basic.original;
                            this.pvp.match.you.hp = res.data.you.hp;
                            this.pvp.match.enemy = res.data.enemy.basic.original;
                            this.pvp.match.enemy.hp = res.data.enemy.hp;
                            this.pvp.match.you.turn = res.data.you.turn;
                            clearInterval(countDown);
                        break;
                        case 404:
                            Swal.fire('',res.data.message,res.data.status);
                            this.pvp.isSearching = false;
                            clearInterval(countDown);
                            this.findEnemy();
                        break;
                        case 300:
                            location.reload();
                        break;
                        default:
                            return this.findEnemy();
                        break;
                    }
                }
            }
        },
        async hit()
        {
            let res = await axios.post(`${config.root}/api/v1/pvp/hit`,'',{
                headers:{
                    pragma:this.token
                }
            });
            switch(res.data.code)
            {
                case 200:
                    this.pvp.match.you = res.data.you.basic.original;
                    this.pvp.match.you.hp = res.data.you.hp;
                    this.pvp.match.enemy = res.data.enemy.basic.original;
                    this.pvp.match.enemy.hp = res.data.enemy.hp;
                    this.pvp.match.you.turn = res.data.you.turn;
                break;
                case 404:
                    Swal.fire('',res.data.message,res.data.status);
                break;
                case 300:
                    location.reload();
                break;
                default:
                    Swal.fire('','Đã có lỗi xảy ra xin vui lòng thử lại','error');
                break;
            }
        },
        async exitMatch()
        {
            let res = await axios.post(`${config.root}/api/v1/pvp/exit-match`,'',{
                headers:{
                    pragma:this.token
                }
            });
            if(res.data.code == 200)
            {
                Swal.fire('',res.data.message,res.data.status);
                window.location.href = config.root;
            } 
        },
        async refreshToken(auth)
        {
            return this.token = await this.sha256(auth.headers.authorization);
        },
        async sha256(message) 
        {
            message = (message+'VYDEPTRAI').split('').reverse().join('');
            message = this.encode(message);
            const msgBuffer = new TextEncoder('utf-8').encode(message);                    
            const hashBuffer = await crypto.subtle.digest('SHA-256', msgBuffer);
            const hashArray = Array.from(new Uint8Array(hashBuffer));              
            const hashHex = hashArray.map(b => ('00' + b.toString(16)).slice(-2)).join('');
            return hashHex;
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
        }
    },
});
if(document.location.href.includes('pvp'))
{
    window.onbeforeunload = function (e) {
        e = e || window.event;

        // For IE and Firefox prior to version 4
        if (e) {
            e.returnValue = 'Sure?';
        }

        // For Safari
        return 'Sure?';
    };
}