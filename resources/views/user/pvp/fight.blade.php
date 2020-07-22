@extends('app')

@section('hero','PVP Arena')
@section('sub_hero','Vinh quang chỉ dành cho người chiến thắng')

@section('content')
<div class="page-content page-container" id="page-content">
    <div class="padding-x">
        @include('user.theme.parameter')
        <div style="position:relative;top:-80px">
            <center><img width="100%" style="width:200px;position: relative;top:20px;z-index:999;margin:0 auto" src="{{ asset('assets/images/app.png') }}"></center>
            <center v-if="pvp.match.status == 'FIGHTING'">
                <div style="width:200px;border-bottom-left-radius:25px;border-bottom-right-radius:25px;background: #0b0e12;height:32px;position: relative;top:32px;z-index:999;margin:0 auto;border: 2px solid #936b37">
                    <div class="pixel-font animated infinite heartBeat normal text-warning">@{{ moment(pvp.match.room.timeRemaining).format('mm:ss') }}</div>
                </div>
            </center>
            <div style="background-image:url('{{ asset('assets/images/pvp-bg-3.png') }}') !important;background-position:bottom !important;height:620px;background-repeat: no-repeat !important;background-position: bottom !important;background-size: cover !important;" class="row vip-bordered">
                <div style="position:absolute;bottom:0;z-index:999;width:100%" class="pvp-button">
                    <div class="row" v-if="pvp.match.status == 'CONNECT_ENEMY'">
                        <div class="col-9">
                            <div :class="`s-button red-button ${pvp.match.isReady ? '' : 'animated infinite pulse normal'}`" :style="{width:'300px', filter: pvp.match.isReady ? 'grayscale(1)' : 'hue-rotate(85deg)'}" @click="toggleReady()">@{{ pvp.match.isReady ? 'Cancel' : 'Ready' }}</div>
                        </div>
                        <div class="col-3">
                            Chat
                        </div>
                    </div>
                </div>
                <div class="col-6 col-auto">
                    <div class="">
                        <div class="">
                            <div @click="index()" :style="{transform: 'scaleX(-1)',position:'absolute',bottom:`${data.pet ? '11%' : '5%'}`,right:'30%'}" title="Nhấp vào để xem thông số" data-toggle="modal" data-target=".modal-left" data-toggle-class="modal-open-aside" data-target="body" style="margin:0px 10px 35px 0px" class="character-sprites hoverable">
                                <span v-if="data.pet" style="z-index:1" :class="`Mount_Body_${data.pet.class_tag}`"></span>
                                <span style="z-index:2" class="skin_f5a76e up-to-down"></span>
                                <span style="z-index:2" class="broad_shirt_black up-to-down"></span>
                                <span style="z-index:2" class="head_0 up-to-down"></span>
                                <span class=""></span>
                                <span v-for="(gear,index) in data.gears" :key="index">
                                    <span v-if="gear.class_tag.includes(' ')" v-for="e in gear.class_tag.split(' ')" :class="`${e} ${gear.cates.animation} up-to-down`" :style="{zIndex:gear.cates.z_index}"></span>
                                    <span v-else :class="`${gear.class_tag} ${gear.cates.animation} up-to-down`" :style="{zIndex:gear.cates.z_index}"></span>
                                </span>
                                <span v-if="data.pet" style="z-index:50" :class="`Mount_Head_${data.pet.class_tag}`"></span>
                                <div :class="`${data.pet ? 'shadow-pet' : 'shadow-character'} animated slow infinite pulse`"></div>
                                <div v-if="pvp.match.me.uid == pvp.match.room.turnIndex" :class="`${data.pet ? 'has-pvp-turn-with-pet' : 'has-pvp-turn-no-pet'}`"></div>
                            </div>
                        </div>
                        <div v-if="pvp.match.status == 'FIGHTING'" style="margin-top:5px;" class="row">
                            <div class="col-lg-8 col-md-8 col-sm-10 row" style="height:50px;padding: 0px;margin-left: 10px;border-bottom-right-radius: 50px;background:rgb(0,0,0,.8);border: 2px solid #936b37;border-top-left-radius: 25px;border-bottom-left-radius: 25px">
                                <img class="circle col-auto" style="width:46px;height:46px;padding:0px" :src="`http://graph.facebook.com/${data.infor.facebook_id}/picture?type=normal`">
                                <div class="col-9">
                                    <div class="progress no-bg mt-2 align-items-center circle" style="height:8px;">
                                        <div style="padding:5px;" :style="{width:(pvp.match.me.status.hp/pvp.match.me.playerInfo.power.hp)*100 + '%'}" class="progress-bar progress-bar-striped progress-bar-animated circle gd-success">@{{ numberFormat(pvp.match.me.status.hp) }}/@{{ numberFormat(pvp.match.me.playerInfo.power.hp) }}</div>                        
                                    </div>
                                    <div class="progress no-bg mt-2 align-items-center circle" style="height:8px">
                                        <div style="padding:5px;" :style="{width:(pvp.match.me.status.energy/pvp.match.me.playerInfo.power.energy)*100 + '%'}" class="progress-bar circle gd-primary">@{{ numberFormat(pvp.match.me.status.energy) }}/@{{ numberFormat(pvp.match.me.playerInfo.power.energy) }}</div>                        
                                    </div>
                                </div>
                                <br>
                            </div>
                            {{-- <div class="col-12">
                                <div class="row row-sm">
                                    <div style="z-index:1" v-for="(skill,index) in pvp.match.me.playerInfo.skills" :key="index" class="mr-2 col-auto">
                                        <span v-for="(countdown,index) in pvp.yourCountDown" v-if="skill.id == index" :class="`avatar w-56 ${countdown !== 0 || pvp.match.me.status.energy < skill.energy ? 'loading not-allow' : ''}`" :key="index">
                                            <img :style="{filter: pvp.match.you.turn == 1 && pvp.match.you.energy >= skill.energy && countdown == 0 ? '' : 'grayscale(100%)',position:'relative'}" @click="hit(skill)" width="100%" :src="skill.image" alt=".">
                                            <span v-if="countdown !== 0" class="pixel-font" style="position:absolute;left:43%;top:28%;color:#fff">@{{ countdown }}</span>
                                        </span>
                                    </div>
                                </div>
                            </div> --}}
                        </div>
                    </div>
                </div>
                <div v-if="pvp.match.status == 'CONNECT_ENEMY' || pvp.match.status == 'FIGHTING'" style="float:right" class="col-6 col-auto">
                    <div class="">
                        <div class="character-sprites hoverable" :style="{position:'absolute',bottom:`${pvp.match.enemy.playerInfo.pet ? '11%' : '5%'}`,left:'30%',zIndex:999,filter: (pvp.match.enemy.isReady || pvp.match.status == 'FIGHTING') && pvp.match.enemy.isConnect ? 'none' : 'grayscale(1)'}"  @click="showUserInfor(pvp.match.enemy.playerInfo.infor.facebook_id)" title="Nhấp vào để xem thông số" data-toggle="modal" data-target=".modal-right" data-toggle-class="modal-open-aside" data-target="body" style="margin:0px 10px 35px 0px">
                            <span style="z-index: 1"  v-if="pvp.match.enemy.playerInfo.pet" :class="`Mount_Body_${pvp.match.enemy.playerInfo.pet.class_tag}`"></span>
                            <span style="z-index:2" class="skin_f5a76e up-to-down"></span>
                            <span style="z-index:2" class="broad_shirt_black up-to-down"></span>
                            <span style="z-index:2" class="head_0 up-to-down"></span>
                            <span class=""></span>
                            <span v-for="(gear,index) in pvp.match.enemy.playerInfo.gears" :key="index">
                                <span v-if="gear.class_tag.includes(' ')" v-for="e in gear.class_tag.split(' ')" :class="`${e} ${gear.cates.animation} up-to-down`" :style="{zIndex:gear.cates.z_index}"></span>
                                <span v-else :class="`${gear.class_tag} ${gear.cates.animation} up-to-down`" :style="{zIndex:gear.cates.z_index}"></span>
                            </span>
                            <span v-if="pvp.match.enemy.playerInfo.pet" style="z-index:50" :class="`Mount_Head_${pvp.match.enemy.playerInfo.pet.class_tag}`"></span>
                            <div :class="`${pvp.match.enemy.playerInfo.pet ? 'shadow-pet' : 'shadow-character'} animated slow infinite pulse`"></div>
                            <div v-if="pvp.match.enemy.isReady && pvp.match.status == 'CONNECT_ENEMY'" style="position: absolute; left:30%;text-shadow: 1px 1px 10px #333, 1px 1px 10px #333;top:-15%" class="animated tada infinite slower pixel-font text-warning text-center slow">READY!</div>
                            <div v-if="!pvp.match.enemy.isConnect" style="position: absolute;top:-10%;font-size: 12px;filter: drop-shadow(2px 4px 6px black);" class="enemy-decrement-hp animated flash infinite slower pixel-font text-center slower">DISCONNECTED...</div>
                            <div v-if="pvp.match.enemy.uid == pvp.match.room.turnIndex" :class="`${pvp.match.enemy.playerInfo.pet ? 'has-pvp-turn-with-pet' : 'has-pvp-turn-no-pet'}`"></div>
                            {{-- <div v-if="pvp.yourAttack" :style="{backgroundImage:`url(${pvp.yourSkillAnimation})`,backgroundSize:'110%',position:'absolute',backgroundPosition:'center',width: '150%',height: '150%',bottom: `${pvp.match.enemy.playerInfo.pet ? '-60px' : '-20px'}`,left: 0,zIndex: '9999'}"></div>
                            <div v-if="pvp.yourAttackDamage" class="enemy-decrement-hp infinite animated slideOutUp pixel-font text-warning text-center slow">- @{{ numberFormatDetail(pvp.yourAttackDamage) }} HP</div>
                            <div v-if="pvp.yourAttack" :class="`${pvp.match.enemy.playerInfo.pet ? 'has-pvp-broken-with-pet' : 'has-pvp-broken-no-pet'}`"></div>
                            <div v-for="(effected, index) in pvp.enemyEffected">
                                <div v-if="effected" :class="`${pvp.match.enemy.playerInfo.pet ? 'has-pvp-effect-with-pet' : 'has-pvp-effect-no-pet'} ${index}`" class="animated flash"></div>
                            </div>
                            <div v-for="(buff, index) in pvp.enemySkillBuff">
                                <div v-if="buff > 0" :class="`${pvp.match.enemy.playerInfo.pet ? 'has-pvp-effect-with-pet' : 'has-pvp-effect-no-pet'} ${index}`" class="animated flash infinite"></div>
                            </div> --}}
                        </div>
                        <div style="margin-top:5px;" class="row" v-if="pvp.enemyJoined">
                            <div class="col-12">
                                <img style="float:right;margin-left:10px;" class="avatar-bordered" :src="`http://graph.facebook.com/${pvp.match.enemy.playerInfo.infor.facebook_id}/picture?type=normal`">
                                <p style="text-align: right" class="card-title text-gold">
                                    @{{ pvp.match.enemy.playerInfo.infor.name }} ( @{{ pvp.match.enemy.playerInfo.infor.character.name }} )
                                </p>
                                <div class="">
                                    <div class="progress no-bg mt-2 align-items-center circle" style="height:8px">
                                        <div style="padding:5px" class="progress-bar circle gd-success" :style="{width:(pvp.match.enemy.playerInfo.hp/pvp.match.enemy.playerInfo.power.hp)*100 + '%'}">@{{ numberFormat(pvp.match.enemy.playerInfo.hp) }}/@{{ numberFormat(pvp.match.enemy.playerInfo.power.hp)  }}</div>                        
                                    </div>
                                    <div class="progress no-bg mt-2 align-items-center circle" style="height:8px">
                                        <div style="padding:5px" class="progress-bar circle gd-primary" :style="{width:(pvp.match.enemy.playerInfo.energy/pvp.match.enemy.playerInfo.power.energy)*100 + '%'}">@{{ numberFormat(pvp.match.enemy.playerInfo.energy) }}/@{{ numberFormat(pvp.match.enemy.playerInfo.power.energy)  }}</div>                        
                                    </div>
                                </div>
                                <br>
                            </div>
                            {{-- <div class="col-12" v-if="pvp.isMatching">
                                <div style="float:right"  class="row row-sm text-right">
                                    <div style="z-index:1;" v-for="(skill,index) in pvp.match.enemy.playerInfo.skills" :key="index" class="col-auto mr-2">
                                        <span :class="`avatar w-56 ${countdown !== 0 || pvp.match.enemy.playerInfo.energy < skill.energy ? 'loading not-allow' : ''}`" v-for="(countdown,index) in pvp.enemyCountDown" v-if="skill.id == index" :key="index">
                                            <img :style="{filter: pvp.match.enemy.playerInfo.turn == 1 && pvp.match.enemy.playerInfo.energy >= skill.energy && countdown == 0 ? '' : 'grayscale(100%)',position:'relative'}" @click="showSkillsDescription(skill)" :src="skill.image" alt=".">
                                            <span v-if="countdown !== 0" class="pixel-font" style="position:absolute;left:43%;top:28%;color:#fff">@{{ countdown }}</span>
                                        </span>
                                    </div>
                                </div>
                            </div> --}}
                        </div>
                        
                    </div>
                </div>
            </div>
            <img style="width:100%;height:100%;position:relative;bottom:50px;z-index:0;" src="https://img.itch.zone/aW1nLzE1MTg1NTQuZ2lm/original/mc%2F7UB.gif">
        </div>
    </div>
    {{-- <div style="display:none" class="preload-skills">
        <div v-for="(skill,index) in pvp.match.you.skills" :key="index + 'you'" class="col-3">
            <img :src="skill.animation" alt=".">
        </div>
        <div v-for="(skill,index) in pvp.match.enemy.playerInfo.skills" :key="index + 'enemy'" class="col-3">
            <img :src="skill.animation" alt=".">
        </div>
    </div>
    <div style="z-index: 9999999" class="modal fade modal-right-pvp" data-backdrop="true">
        <div style="overflow:auto" class="modal-dialog modal-bottom modal-right w-xl">
            <div style="min-height:100vh;background:#111 !important" class="modal-content vip-bordered no-radius">
                <div class="modal-header">
                    Kênh Chat
                    <span @click="pvp.receiveMessage = !pvp.receiveMessage" class="px-2">
                        <i v-if="pvp.receiveMessage" data-feather="bell"></i>
                        <i v-else data-feather="bell-off"></i>
                    </span>
                    <button class="close" data-dismiss="modal">&times;</button>
                </div>
                <div style="max-height:80vh;overflow:auto;" id="chat-pvp-box" class="modal-body">
                    <div id="message-box">
                        <p v-for="(message, index) in pvp.messages" :key="index">
                            <span :class="message.sender.id == {{ Auth::id() }} ? 'text-gold' : 'text-muted'">@{{ message.sender.name }} : </span>
                            <span class="text-muted">@{{ message.body }} </span>
                        </p>
                    </div>
                </div>
                <div class="modal-footer">
                    <input autofocus v-model="pvp.text" type="text" @change="sendPvpMessage" placeholder="Nhập tin nhắn của bạn" class="form-control">
                </div>
            </div>
        </div>
    </div>
    <div id="invite" v-if="!pvp.isMatching && !pvp.enemyJoined && pvp.match.master == {{ Auth::id() }}" class="modal fade gear top-off" data-backdrop="true" aria-hidden="true" style="display: none;">
        <div class="modal-dialog">
            <div class="modal-content bg-dark">
                <div class="modal-header">
                    Tìm kiếm đối thủ <button class="close" data-dismiss="modal">×</button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <input v-model='pvp.search.text' @change="searchPvpEnemy" type="text" placeholder="Nhập tên hoặc mã ID rồi Enter để tìm kiếm..." class="form-control">
                    </div>
                    <span class="text-gold" v-if="pvp.search.data.length > 0">
                        Tìm thấy @{{ pvp.search.data.length }} thợ săn
                    </span>
                    <span v-else class="text-danger">
                        Không tìm thấy thợ săn nào
                    </span>
                    <div style="max-height:400px;overflow:auto" class="row list list-row">
                        <div v-for="(enemy, index) in pvp.search.data" :key="index" class="list-item col-12" data-id="1">
                            <div>
                                <a href="#" data-pjax-state="">
                                    <span class="w-40 avatar gd-primary">
                                        <img :src="`http://graph.facebook.com/${enemy.user_id}/picture?type=normal`" alt=".">
                                    </span>
                                </a>
                            </div>
                            <div class="flex">
                                <a href="#" class="item-author text-color" data-pjax-state="">@{{ enemy.name }}</a>
                                <div class="item-except text-muted text-sm h-1x">LC : @{{ enemy.full_power }}</div>
                            </div>
                            <div>
                                <button :id="`hunter-${enemy.id}`" @click="inviteToPvp(enemy,'{{ Route('user.pvp.joined-room',['id' => $checkRoom->name]) }}', $event)" style="padding:10px 20px" class="item-amount d-lg-block badge badge-pill gd-success">Mời</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
    </div> --}}
</div>
@endsection
@push('js')
<script>
    var page = {
        room:{
            userName: "{{ Auth::user()->name }}",
            userId: parseInt("{{ Auth::id() }}"),
            roomId: "{{ $checkRoom->name }}",
            createdAt: "{{ $checkRoom->created_at }}",
        },
        path: 'pvp.room'
    }
</script>
@endpush