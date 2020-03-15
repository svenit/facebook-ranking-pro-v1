@extends('app')

@section('hero','PVP')
@section('sub_hero','Vinh quang chỉ dành cho người chiến thắng')

@section('content')
<div class="page-content page-container" id="page-content">
    <div class="padding-x">
        @include('user.theme.parameter')
        <button id='fight-button' v-if="pvp.enemyJoined" style="width:300px" @click="toggleReady()" v-if="!pvp.isEnding && pvp.enemyJoined" class="vip-bordered" v-html="pvp.status"></button>
        <button id='fight-button' v-if="!pvp.isMatching && pvp.enemyJoined && pvp.match.master == {{ Auth::id() }}" style="width:100px" @click="kickEnemy()" class="vip-bordered">Kick</button>
        <button id='fight-button' style="width:100px" v-if="pvp.enemyJoined"  data-toggle="modal" data-target=".modal-right-pvp" data-toggle-class="modal-open-aside" data-target="body" class="vip-bordered">Chat</button>
        <button id='fight-button' v-if="pvp.isMatching && pvp.match.you.turn == 1" style="width:100px" @click="turnOut()" class="vip-bordered">Bỏ Lượt</button>
        <button id='fight-button' v-if="pvp.isMatching" style="width:200px" class="vip-bordered">Kết Thúc Sau : @{{ pvp.timeRemaining }}s</button>
        <button id='fight-button' v-if="!pvp.isMatching || pvp.isEnding" style="width:100px" @click="exitMatch()" class="vip-bordered">Thoát</button>
        <div style="margin-top:20px" class="row">
            <div :class="[pvp.yourAttack ? 'animated fadeOutRight' : '',pvp.yourBuff || pvp.enemyAttack ? 'animated shake' : '']" class="col-lg-4 col-md-4 col-sm-4 col-auto">
                <div class="">
                    <div class="">
                        <img v-if="pvp.match.you.turn == 1 && pvp.isMatching && !pvp.isEnding" style="position:absolute;width:50%;left:20%;top:10%" src="https://i.imgur.com/xjA4khR.gif">
                        <img v-if="pvp.enemyAttack" style="position:absolute;width:100%;z-index:9999999" :src="pvp.enemySkillAnimation">
                        <div @click="index()" style="position:absolute;bottom:30%;left:30%" title="Nhấp vào để xem thông số" data-toggle="modal" data-target=".modal-left" data-toggle-class="modal-open-aside" data-target="body" style="margin:0px 10px 35px 0px" class="character-sprites hoverable">
                            <span v-if="data.pet" :class="`Mount_Body_${data.pet.class_tag}`"></span>
                            <span style="z-index:2" class="skin_f5a76e"></span>
                            <span style="z-index:2" class="broad_shirt_black"></span>
                            <span style="z-index:2" class="head_0"></span>
                            <span class=""></span>
                            <span v-for="(gear,index) in data.gears" :key="index">
                                <span v-if="gear.class_tag.includes(' ')" v-for="e in gear.class_tag.split(' ')" :class="e" :style="{zIndex:gear.cates.z_index}"></span>
                                <span v-else :class="gear.class_tag" :style="{zIndex:gear.cates.z_index}"></span>
                            </span>
                            <span v-if="data.pet" style="z-index:50" :class="`Mount_Head_${data.pet.class_tag}`"></span>
                        </div>
                    </div>
                    <div v-if="pvp.enemyJoined">
                        <p class="card-title text-gold text-center">
                            @{{ pvp.match.you.infor.name }} ( @{{ pvp.match.you.infor.character.name }} )
                        </p>
                        <div class="progress no-bg mt-2 align-items-center circle" style="height:8px">
                            <span class="mx-2">@{{ pvp.match.you.hp }}/@{{ pvp.match.you.power.hp  }}</span>
                            <div class="progress-bar circle gd-success" :style="{width:(pvp.match.you.hp/pvp.match.you.power.hp)*100 + '%'}"></div>                        
                        </div>
                        <div class="progress no-bg mt-2 align-items-center circle" style="height:8px">
                            <span class="mx-2">@{{ pvp.match.you.energy }}/@{{ pvp.match.you.power.energy  }}</span>
                            <div class="progress-bar circle gd-primary" :style="{width:(pvp.match.you.energy/pvp.match.you.power.energy)*100 + '%'}"></div>                        
                        </div>
                        <br>
                        <div v-if="pvp.isMatching">
                            <div class="row row-sm">
                                <div v-for="(skill,index) in pvp.match.you.skills" :key="index" class="col-1">
                                    <span @click="hit(skill)" class="w-32 avatar gd-primary" :class="[pvp.match.you.energy >= skill.energy ? '' : 'loading not-allow']">
                                        <span class="avatar-status b-white avatar-right" :class="[pvp.match.you.energy >= skill.energy ? 'on' : 'away']"></span> 
                                        <img :src="skill.image" alt=".">
                                    </span>
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-3 hide-in-mobile">
                <div style="position:relative;top:15%;background:transparent !important" class="card">
                    <img style="width:100%" src="https://i.imgur.com/my7u02o.png">
                </div>
            </div>
            <div style="float:right" :class="[pvp.enemyAttack ? 'animated fadeOutLeft' : '',pvp.enemyBuff || pvp.yourAttack ? 'animated shake' : '']" class="col-lg-4 col-md-4 col-sm-4 col-auto">
                <div class="">
                    <img v-if="pvp.match.you.turn != 1 && pvp.isMatching" style="position:absolute;width:50%;left:20%;top:10%" src="https://i.imgur.com/xjA4khR.gif">
                    <img v-if="pvp.yourAttack" style="position:absolute;width:100%;z-index:9999999" :src="pvp.yourSkillAnimation">
                    <div v-if="pvp.enemyJoined && !pvp.isEnding" style="position:absolute;bottom:30%;left:30%" @click="showUserInfor(pvp.match.enemy.infor.facebook_id)" title="Nhấp vào để xem thông số" data-toggle="modal" data-target=".modal-right" data-toggle-class="modal-open-aside" data-target="body" style="margin:0px 10px 35px 0px" class="character-sprites hoverable">
                        <span v-if="pvp.match.enemy.pet" :class="`Mount_Body_${pvp.match.enemy.pet.class_tag}`"></span>
                        <span style="z-index:2" class="skin_f5a76e"></span>
                        <span style="z-index:2" class="broad_shirt_black"></span>
                        <span style="z-index:2" class="head_0"></span>
                        <span class=""></span>
                        <span v-for="(gear,index) in pvp.match.enemy.gears" :key="index">
                            <span v-if="gear.class_tag.includes(' ')" v-for="e in gear.class_tag.split(' ')" :class="e" :style="{zIndex:gear.cates.z_index}"></span>
                            <span v-else :class="gear.class_tag" :style="{zIndex:gear.cates.z_index}"></span>
                        </span>
                        <span v-if="pvp.match.enemy.pet" style="z-index:50" :class="`Mount_Head_${pvp.match.enemy.pet.class_tag}`"></span>
                    </div>
                    <div v-if="pvp.enemyJoined">
                        <p class="card-title text-gold text-center">
                            @{{ pvp.match.enemy.infor.name }} ( @{{ pvp.match.enemy.infor.character.name }} )
                        </p>
                        <div class="progress no-bg mt-2 align-items-center circle" style="height:8px">
                            <span class="mx-2">@{{ pvp.match.enemy.hp }}/@{{ pvp.match.enemy.power.hp  }}</span>
                            <div class="progress-bar circle gd-success" :style="{width:(pvp.match.enemy.hp/pvp.match.enemy.power.hp)*100 + '%'}"></div>                        
                        </div>
                        <div class="progress no-bg mt-2 align-items-center circle" style="height:8px">
                            <span class="mx-2">@{{ pvp.match.enemy.energy }}/@{{ pvp.match.enemy.power.energy  }}</span>
                            <div class="progress-bar circle gd-primary" :style="{width:(pvp.match.enemy.energy/pvp.match.enemy.power.energy)*100 + '%'}"></div>                        
                        </div>
                        <br>
                        <div v-if="pvp.isMatching">
                            <div class="row row-sm">
                                <div v-for="(skill,index) in pvp.match.enemy.skills" :key="index" class="col-1">
                                    <span @click="showSkillsDescription(skill)" class="w-32 avatar gd-primary" :class="[pvp.match.enemy.energy >= skill.energy ? '' : 'loading']">
                                        <span class="avatar-status b-white avatar-right" :class="[pvp.match.enemy.energy >= skill.energy ? 'on' : 'away']"></span> 
                                        <img :src="skill.image" alt=".">
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div v-else class="media media-4x4">
                        <a class="media-content" :style="{backgroundImage:'url(https://vignette.wikia.nocookie.net/crusadersquest/images/5/56/UnknownSkill.png/revision/latest?cb=20150102055528)',backgroundSize:'50%',backgroundColor:'transparent'}"></a>
                    </div>
                </div>
            </div>
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