@extends('app')

@section('hero','PVP Arena')
@section('sub_hero','Vinh quang chỉ dành cho người chiến thắng')

@section('content')
<div class="page-content page-container" id="page-content">
    <div class="padding-x">
        @include('user.theme.parameter')
        <div style="position:relative;top:-80px">
            <center><img width="100%" style="width:200px;position: relative;top:40px;z-index:999;margin:0 auto" src="{{ asset('assets/images/app.png') }}"></center>
            <center>
                <div v-if="pvp.isMatching" style="width:200px;position: relative;top:40px;z-index:999;margin:0 auto">
                    <div class="animated infinite heartBeat pixel-font text-warning">@{{ pvp.timeRemaining }}s</div>
                </div>
            </center>
            <div style="background-image:url('{{ asset('assets/images/icon-pack/pvp-background.png') }}') !important;background-position:center top !important;height:650px;background-attachment: fixed;" class="row vip-bordered">
                <div style="position:absolute;bottom:0;z-index:999" class="pvp-button">
                    <button id='fight-button' v-if="pvp.enemyJoined" style="width:300px" @click="toggleReady()" v-if="!pvp.isEnding && pvp.enemyJoined" class="vip-bordered" v-html="pvp.status"></button>
                    <button id='fight-button' v-if="!pvp.isMatching && !pvp.enemyJoined && pvp.match.master == {{ Auth::id() }}" style="width:100px" id="trigger-invite" @click="searchPvpEnemy" data-toggle="modal" data-target="#invite" class="vip-bordered">Mời</button>
                    <button id='fight-button' v-if="!pvp.isMatching && pvp.enemyJoined && pvp.match.master == {{ Auth::id() }}" style="width:100px" @click="kickEnemy()" class="vip-bordered">Kick</button>
                    <button id='fight-button' style="width:100px;" v-if="pvp.enemyJoined"  data-toggle="modal" data-target=".modal-right-pvp" data-toggle-class="modal-open-aside" data-target="body" class="vip-bordered">Chat </button>
                    <button id='fight-button' v-if="pvp.isMatching && pvp.match.you.turn == 1" style="width:100px" @click="turnOut()" class="vip-bordered">Bỏ Lượt</button>
                    <button id='fight-button' v-if="!pvp.isMatching || pvp.isEnding" style="width:100px" @click="exitMatch()" class="vip-bordered">Thoát</button>
                </div>
                <div style="position:absolute;top:40%;left:10%;z-index:0;" class="pvp-button">
                    <img style="width:60px;" src="{{ asset('assets/images/fire.gif') }}">
                    <div class="shadow-pet" style="width: 70px;left: -10%;top: 60%;z-index: -1;"></div>
                </div>
                <div style="position:absolute;top:48%;right:5%;z-index:0;" class="pvp-button">
                    <img style="width:150px;height:100px;" src="{{ asset('assets/images/stone.png') }}">
                    <div class="shadow-pet" style="width: 110px;left: -5%;top: 80%;z-index: -1;"></div>
                </div>
                <div class="col-6 col-auto">
                    <div class="">
                        <div class="">
                            <div @click="index()" :class="[pvp.yourAttack ? 'animated fadeOutRight' : '',pvp.yourBuff || pvp.enemyAttack ? 'animated shake' : '']" :style="{position:'absolute',bottom:`${data.pet ? '32%' : '28%'}`,right:'30%'}" title="Nhấp vào để xem thông số" data-toggle="modal" data-target=".modal-left" data-toggle-class="modal-open-aside" data-target="body" style="margin:0px 10px 35px 0px" class="character-sprites hoverable">
                                <span v-if="data.pet" style="z-index: 1" :class="`Mount_Body_${data.pet.class_tag}`"></span>
                                <span style="z-index:2" class="skin_f5a76e"></span>
                                <span style="z-index:2" class="broad_shirt_black"></span>
                                <span style="z-index:2" class="head_0"></span>
                                <span class=""></span>
                                <span v-for="(gear,index) in data.gears" :key="index">
                                    <span v-if="gear.class_tag.includes(' ')" v-for="e in gear.class_tag.split(' ')" :class="e" :style="{zIndex:gear.cates.z_index}"></span>
                                    <span v-else :class="gear.class_tag" :style="{zIndex:gear.cates.z_index}"></span>
                                </span>
                                <span v-if="data.pet" style="z-index:50" :class="`Mount_Head_${data.pet.class_tag}`"></span>
                                <div :class="`${data.pet ? 'shadow-pet' : 'shadow-character'} animated infinite pulse`"></div>
                                <div v-if="pvp.enemyAttack" :style="{backgroundImage:`url(${pvp.enemySkillAnimation})`,backgroundSize:'110%',position:'absolute',backgroundPosition:'center',width: '150%',height: '150%',bottom: `${data.pet ? '-60px' : '-20px'}`,left: 0,zIndex: '9999'}"></div>
                                <div v-if="pvp.match.you.turn == 1 && pvp.isMatching" :class="`${data.pet ? 'has-pvp-turn-with-pet' : 'has-pvp-turn-no-pet'}`"></div>
                                <div v-if="pvp.enemyAttackDamage" class="enemy-decrement-hp infinite animated slideOutUp pixel-font text-warning text-center slow">- @{{ numberFormatDetail(pvp.enemyAttackDamage) }} HP</div>
                                <div v-if="pvp.enemyAttack" :class="`${data.pet ? 'has-pvp-broken-with-pet' : 'has-pvp-broken-no-pet'}`"></div>
                                <div v-for="(effected, index) in pvp.yourEffected">
                                    <div v-if="effected" :class="`${data.pet ? 'has-pvp-effect-with-pet' : 'has-pvp-effect-no-pet'}`" :class="`${index || ''}animated flash infinite`"></div>
                                </div>
                            </div>
                        </div>
                        <div style="margin-top:5px;" class="row" v-if="pvp.enemyJoined">
                            <div class="col-12">
                                <img class="avatar-bordered" :src="`http://graph.facebook.com/${pvp.match.you.infor.facebook_id}/picture?type=normal`">
                                <p class="card-title text-gold">
                                    @{{ pvp.match.you.infor.name }} ( @{{ pvp.match.you.infor.character.name }} )
                                </p>
                                <div class="progress no-bg mt-2 align-items-center circle" style="height:8px">
                                    <div style="padding:5px" class="progress-bar progress-bar-striped progress-bar-animated circle gd-success" :style="{width:(pvp.match.you.hp/pvp.match.you.power.hp)*100 + '%'}">@{{ numberFormat(pvp.match.you.hp) }}/@{{ numberFormat(pvp.match.you.power.hp) }}</div>                        
                                </div>
                                <div class="progress no-bg mt-2 align-items-center circle" style="height:8px">
                                    <div style="padding:5px" class="progress-bar circle gd-primary" :style="{width:(pvp.match.you.energy/pvp.match.you.power.energy)*100 + '%'}">@{{ numberFormat(pvp.match.you.energy) }}/@{{ numberFormat(pvp.match.you.power.energy)  }}</div>                        
                                </div>
                                <br>
                            </div>
                            <div class="col-12" v-if="pvp.isMatching">
                                <div class="row row-sm">
                                    <div style="z-index:1" v-for="(skill,index) in pvp.match.you.skills" :key="index" class="mr-2 col-auto">
                                        <span :class="`avatar w-56 ${countdown.countdown !== 0 || pvp.match.you.energy < skill.energy ? 'loading not-allow' : ''}`" v-for="(countdown,index) in pvp.yourCountDown" v-if="skill.id == countdown.id" :key="index">
                                            <img :style="{filter: pvp.match.you.turn == 1 && pvp.match.you.energy >= skill.energy && countdown.countdown == 0 ? '' : 'grayscale(100%)',position:'relative'}" @click="hit(skill)" width="100%" :src="skill.image" alt=".">
                                            <span v-if="countdown.countdown !== 0" class="pixel-font" style="position:absolute;left:43%;top:28%;color:#fff">@{{ countdown.countdown }}</span>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div style="float:right" class="col-6 col-auto">
                    <div class="">
                        <div :class="[pvp.enemyAttack ? 'animated fadeOutLeft' : '',pvp.enemyBuff || pvp.yourAttack ? 'animated shake' : '']" class="character-sprites hoverable" v-if="pvp.enemyJoined && !pvp.isEnding" :style="{position:'absolute',bottom:`${pvp.match.enemy.pet ? '35%' : '25%'}`,left:'30%',zIndex:999}"  @click="showUserInfor(pvp.match.enemy.infor.facebook_id)" title="Nhấp vào để xem thông số" data-toggle="modal" data-target=".modal-right" data-toggle-class="modal-open-aside" data-target="body" style="margin:0px 10px 35px 0px">
                            <span style="z-index: 1" v-if="pvp.match.enemy.pet" :class="`Mount_Body_${pvp.match.enemy.pet.class_tag}`"></span>
                            <span style="z-index:2" class="skin_f5a76e"></span>
                            <span style="z-index:2" class="broad_shirt_black"></span>
                            <span style="z-index:2" class="head_0"></span>
                            <span class=""></span>
                            <span v-for="(gear,index) in pvp.match.enemy.gears" :key="index">
                                <span v-if="gear.class_tag.includes(' ')" v-for="e in gear.class_tag.split(' ')" :class="e" :style="{zIndex:gear.cates.z_index}"></span>
                                <span v-else :class="gear.class_tag" :style="{zIndex:gear.cates.z_index}"></span>
                            </span>
                            <span v-if="pvp.match.enemy.pet" style="z-index:50" :class="`Mount_Head_${pvp.match.enemy.pet.class_tag}`"></span>
                            <div :class="`${pvp.match.enemy.pet ? 'shadow-pet' : 'shadow-character'} animated infinite pulse`"></div>
                            <div v-if="pvp.yourAttack" :style="{backgroundImage:`url(${pvp.yourSkillAnimation})`,backgroundSize:'110%',position:'absolute',backgroundPosition:'center',width: '150%',height: '150%',bottom: `${pvp.match.enemy.pet ? '-60px' : '-20px'}`,left: 0,zIndex: '9999'}"></div>
                            <div v-if="pvp.match.you.turn == 0 && pvp.isMatching" :class="`${pvp.match.enemy.pet ? 'has-pvp-turn-with-pet' : 'has-pvp-turn-no-pet'}`"></div>
                            <div v-if="pvp.yourAttackDamage" class="enemy-decrement-hp infinite animated slideOutUp pixel-font text-warning text-center slow">- @{{ numberFormatDetail(pvp.yourAttackDamage) }} HP</div>
                            <div v-if="pvp.yourAttack" :class="`${pvp.match.enemy.pet ? 'has-pvp-broken-with-pet' : 'has-pvp-broken-no-pet'}`"></div>
                            <div v-for="(effected, index) in pvp.enemyEffected">
                                <div v-if="effected" :class="`${pvp.match.enemy.pet ? 'has-pvp-effect-with-pet' : 'has-pvp-effect-no-pet'} ${index}`" class="animated flash infinite"></div>
                            </div>
                        </div>
                        <div style="margin-top:5px;" class="row" v-if="pvp.enemyJoined">
                            <div class="col-12">
                                <img style="float:right;margin-left:10px;" class="avatar-bordered" :src="`http://graph.facebook.com/${pvp.match.enemy.infor.facebook_id}/picture?type=normal`">
                                <p style="text-align: right" class="card-title text-gold">
                                    @{{ pvp.match.enemy.infor.name }} ( @{{ pvp.match.enemy.infor.character.name }} )
                                </p>
                                <div class="">
                                    <div class="progress no-bg mt-2 align-items-center circle" style="height:8px">
                                        <div style="padding:5px" class="progress-bar circle gd-success" :style="{width:(pvp.match.enemy.hp/pvp.match.enemy.power.hp)*100 + '%'}">@{{ numberFormat(pvp.match.enemy.hp) }}/@{{ numberFormat(pvp.match.enemy.power.hp)  }}</div>                        
                                    </div>
                                    <div class="progress no-bg mt-2 align-items-center circle" style="height:8px">
                                        <div style="padding:5px" class="progress-bar circle gd-primary" :style="{width:(pvp.match.enemy.energy/pvp.match.enemy.power.energy)*100 + '%'}">@{{ numberFormat(pvp.match.enemy.energy) }}/@{{ numberFormat(pvp.match.enemy.power.energy)  }}</div>                        
                                    </div>
                                </div>
                                <br>
                            </div>
                            <div class="col-12" v-if="pvp.isMatching">
                                <div style="float:right"  class="row row-sm text-right">
                                    <div style="z-index:1;" v-for="(skill,index) in pvp.match.enemy.skills" :key="index" class="col-auto mr-2">
                                        <span :class="`avatar w-56 ${countdown.countdown !== 0 || pvp.match.enemy.energy < skill.energy ? 'loading not-allow' : ''}`" v-for="(countdown,index) in pvp.enemyCountDown" v-if="skill.id == countdown.id" :key="index">
                                            <img :style="{filter: pvp.match.enemy.turn == 1 && pvp.match.enemy.energy >= skill.energy && countdown.countdown == 0 ? '' : 'grayscale(100%)',position:'relative'}" @click="showSkillsDescription(skill)" :src="skill.image" alt=".">
                                            <span v-if="countdown.countdown !== 0" class="pixel-font" style="position:absolute;left:43%;top:28%;color:#fff">@{{ countdown.countdown }}</span>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                </div>
                <div class="pvp-comment hide-in-mobile" style="width:300px;height:60px;top: 12%;left: 10%;">
                    {!! $comments[rand(0,count($comments) - 1)] !!}
                </div>
                <div class="pvp-comment hide-in-mobile" style="width:300px;height:65px;top: 12%;right: 0%;">
                    <span>
                        {!! $comments[rand(0,count($comments) - 1)] !!}</p>
                    </span>
                </div>
            </div>
            <img style="width:100%;height:100%;position:relative;bottom:50px;z-index:0;" src="https://img.itch.zone/aW1nLzE1MTg1NTQuZ2lm/original/mc%2F7UB.gif">
        </div>
    </div>
    <div style="display:none" class="preload-skills">
        <div v-for="(skill,index) in pvp.match.you.skills" :key="index + 'you'" class="col-3">
            <img :src="skill.animation" alt=".">
        </div>
        <div v-for="(skill,index) in pvp.match.enemy.skills" :key="index + 'enemy'" class="col-3">
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
    </div>
</div>
@endsection
@push('js')
<script>
    const page = {
        room:{
            name:"{{ Auth::user()->name }}",
            me:parseInt("{{ Auth::id() }}"),
            id:"{{ $checkRoom->name }}",
            master:parseInt("{{ $checkRoom->user_create_id }}"),
            is_fighting:parseInt("{{ $checkRoom->is_fighting }}"),
            created_at:"{{ $checkRoom->created_at }}",
            people:parseInt("{{ $checkRoom->people }}"),
            is_ready:parseInt("{{ $checkSession->is_ready }}"),
        },
        path:'pvp.room'
    }
</script>
@endpush