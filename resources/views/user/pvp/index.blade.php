@extends('app')

@section('hero','Chọn nhân vật')
@section('sub_hero','Vui lòng chọn nhân vật để bắt đầu')

@section('content')
<div class="page-content page-container" id="page-content">
    <div class="padding-x">
        @include('user.theme.parameter')
        <button id='fight-button' style="width:300px" @click="findEnemy()" v-if="!pvp.isEnding" class="vip-bordered" v-html="pvp.status">Tìm Đối Thủ</button>
        <button id='fight-button' v-if="!pvp.isMatching || pvp.isEnding" style="width:100px" @click="exitMatch()" class="vip-bordered">Thoát</button>
        <div class="row row-sm sr">
            <div class="col-md-4 col-lg-4 col-sm-4">
                <div class="">
                    <div class="media media-4x4">
                        <img v-if="pvp.match.you.turn == 0 && pvp.isMatching && !pvp.isEnding" style="position:absolute;width:100%" src="https://i.imgur.com/xjA4khR.gif">
                        <a id="your-character" class="media-content your-character" style="background-image:url({{ $user->character()->avatar}});background-size:50%;background-color:transparent"></a>
                    </div>
                    <div v-if="pvp.isMatching && !pvp.isEnding">
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
                        <div class="card-body vip-bordered">
                            <div class="row row-sm">
                                <div v-for="(skill,index) in pvp.match.you.skills" :key="index" class="col-3">
                                    <img @click="hit(skill.id)" style="width:100%;border-radius:5px" :src="skill.image">
                                    <br>
                                    <center><p class="align-items-center text-gold">@{{ skill.energy }} <i class="fas fa-bolt"></i></p></center>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-lg-3 col-sm-3">
                <div style="position:relative;top:15%;background:transparent !important" class="card">
                    <img style="width:100%" src="https://i.imgur.com/my7u02o.png">
                </div>
            </div>
            <div class="col-md-4 col-lg-4 col-sm-4">
                <div class="">
                    <img v-if="pvp.match.you.turn != 0 && pvp.isMatching" style="position:absolute;width:100%" src="https://i.imgur.com/xjA4khR.gif">
                    <div v-if="!pvp.isSearching && !pvp.isEnding" class="media media-4x4">
                        <a class="media-content" :style="{backgroundImage:'url('+pvp.match.enemy.infor.character.avatar+')',backgroundSize:'50%',backgroundColor:'transparent'}"></a>
                    </div>
                    <div v-else class="media media-4x4">
                        <a class="media-content" :style="{backgroundImage:'url(https://vignette.wikia.nocookie.net/crusadersquest/images/5/56/UnknownSkill.png/revision/latest?cb=20150102055528)',backgroundSize:'50%',backgroundColor:'transparent'}"></a>
                    </div>
                    <div v-if="pvp.isMatching && !pvp.isEnding">
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
                        <div class="card-body vip-bordered">
                            <div class="row row-sm">
                                <div v-for="(skill,index) in pvp.match.enemy.skills" :key="index" class="col-3">
                                    <img @click="showDescription(skill)" style="width:100%;border-radius:5px" :src="skill.image">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
