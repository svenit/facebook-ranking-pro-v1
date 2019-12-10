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
            isEnding:false,
            isMatching:false,
            isAttack:false,
            isBuff:false,
            skillAnimation:'',
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
        await this.index();
        this.pvpArea();
    },
    watch:{
        'pvp.isMatching'()
        {
            if(this.pvp.isMatching && document.location.href.includes('pvp'))
            {
                window.addEventListener('beforeunload', function (e) {
                    const confirmationMessage = 'Bạn đang trong trận, điều này có thể ảnh hưởng đến trận đấu :/';
                    (e || window.event).returnValue = confirmationMessage; 
                    return confirmationMessage;                            
                });
            }
        }
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
                                            confirmButtonText:'Thoát',
                                        }).then((result) => {
                                            if(result.value)
                                            {
                                                this.exitMatch();
                                            }
                                        });
                                        this.pvp.isSearching = false;
                                        this.pvp.isEnding = true;
                                        clearInterval(countDown);
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
                                confirmButtonText:'Thoát',
                            }).then((result) => {
                                if(result.value)
                                {
                                    this.exitMatch();
                                }
                            });
                            this.pvp.isSearching = false;
                            this.pvp.isEnding = true;
                            this.pvp.isMatching = false;
                            this.pvp.match.enemy = [];
                            clearInterval(countDown);
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
        showGearsDescription(data,permission)
        {
            Swal.fire({
                title:`<img style="width:80px;height:80px" src="${data.image}">`,
                type:'',
                showConfirmButton:permission == 1 ? true : false,
                confirmButtonText:permission == 1 ? 'Tháo trang bị' : '',
                showCancelButton:true,
                cancelButtonColor:'#333',
                cancelButtonText:'Đóng',
                html:`[ ${data.name} ] <br> ${data.description} 
                    <br> Yêu cầu cấp độ : ${data.level_required} 
                    <br>HP : +${data.health_points}
                    <br> STVL : +${data.strength} 
                    <br> STPT : +${data.intelligent}
                    <br> Nhanh nhẹn : +${data.agility}
                    <br> May mắn : +${data.lucky}`
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
                title:`<img style="width:80px;height:80px" src="${data.image}">`,
                type:'',
                html:`[ ${data.name} - ${data.passive == 1 ? 'Bị động' : 'Chủ động'} ] <br/> ${data.description} <br> Yêu cầu cấp độ : ${data.required_level} <br> MP : ${data.energy} <br> Tỉ lệ thành công : ${data.success_rate}% `
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
        pvpArea()
        {
            if(document.location.href.includes('pvp'))
            {
                this.findEnemy();
            }
        },
        async findEnemy()
        {
            try
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
                        await this.refreshToken(res);
                        switch(res.data.code)
                        {
                            case 200:
                                this.notify(res.data.message);
                                const audio = new Audio(`${config.root}/assets/sound/found_enemy.mp3`);
                                audio.play();
                                this.pvp.isSearching = false;
                                this.pvp.isMatching = true;
                                
                                this.pvp.match.you = res.data.you.basic.original;
                                this.pvp.match.you.hp = res.data.you.hp;
                                this.pvp.match.you.energy = res.data.you.energy;
                                this.pvp.match.you.turn = res.data.you.turn;

                                this.pvp.match.enemy = res.data.enemy.basic.original;
                                this.pvp.match.enemy.hp = res.data.enemy.hp;
                                this.pvp.match.enemy.energy = res.data.enemy.energy;
                                clearInterval(countDown);
                            break;
                            case 404:
                                this.notify(res.data.message);
                                this.pvp.isSearching = false;
                                clearInterval(countDown);
                                this.findEnemy();
                            break;
                            case 300:
                                this.notify(res.data.message);
                                window.location.href = config.root;
                            break;
                            case 201:
                                Swal.fire({
                                    title: !res.data.win ? `<img style='width:100%' src='${config.root}/assets/images/defeat.png'>` : `<img style='width:100%' src='${config.root}/assets/images/victory.png'>`,
                                    focusConfirm: true,
                                    confirmButtonText:'Thoát',
                                }).then((result) => {
                                    if(result.value)
                                    {
                                        this.exitMatch();
                                    }
                                });
                                this.pvp.isSearching = false;
                                this.pvp.isEnding = true;
                                clearInterval(countDown);
                            break;
                            default:
                                this.pvp.isSearching = false;
                                clearInterval(countDown);
                            break;
                        }
                    }
                }
            }
            catch(e)
            {
                this.refreshToken(this.token);
            }
        },
        async hit(skill)
        {
            try
            {
                if(this.pvp.match.you.turn == 0)
                {
                    if(skill.energy <= this.pvp.match.you.energy)
                    {
                        if(skill.passive == 0)
                        {
                            if(skill.effect_to == 1)
                            {
                                this.pvp.isBuff = true;
                            }
                            else
                            {
                                this.pvp.isAttack = true;
                            }
                            let res = await axios.post(`${config.root}/api/v1/pvp/hit`,{
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
                                    this.pvp.skillAnimation = skill.animation;
                                    this.notify(res.data.message);
                                    this.pvp.match.you = res.data.you.basic.original;
                                    this.pvp.match.you.hp = res.data.you.hp;
                                    this.pvp.match.you.energy = res.data.you.energy;
                                    this.pvp.match.you.turn = res.data.you.turn;
            
                                    this.pvp.match.enemy = res.data.enemy.basic.original;
                                    this.pvp.match.enemy.hp = res.data.enemy.hp;
                                    this.pvp.match.enemy.energy = res.data.enemy.energy;
                                    this.pvp.isAttack = false;
                                    this.pvp.isBuff = false;
                                break;
                                case 404:
                                    this.notify(res.data.message);
                                break;
                                case 300:
                                    this.notify(res.data.message);
                                    window.location.href = config.root;
                                break;
                                case 201:
                                    this.pvp.isSearching = false;
                                    this.pvp.isMatching = false;
                                    this.pvp.isEnding = true;
                                    clearInterval(countDown);
                                    Swal.fire({
                                        title: !res.data.win ? `<img style='width:100%' src='${config.root}/assets/images/defeat.png'>` : `<img style='width:100%' src='${config.root}/assets/images/victory.png'>`,
                                        text:res.data.message,
                                        focusConfirm: true,
                                        confirmButtonText:'Thoát',
                                    }).then((result) => {
                                        if(result.value)
                                        {
                                            this.exitMatch();
                                        }
                                    });
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
                    let res = await axios.post(`${config.root}/api/v1/pvp/exit-match`,'',{
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
        }
    },
});
