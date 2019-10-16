@extends('app')

@section('hero','Chọn nhân vật')
@section('sub_hero','Vui lòng chọn nhân vật để bắt đầu')

@section('content')
<div class="page-content page-container" id="page-content">
    <div class="padding-x">
        @include('user.theme.parameter')
        <button id='fight-button' style="width:300px" @click="findEnemy()" class="vip-bordered" v-html="pvp.status">Tìm Đối Thủ</button>
        <div class="row row-sm sr">
            <div class="col-md-4 col-lg-4 col-sm-4 vip-bordered">
                <div class="card">
                    <p class="card-title text-gold">
                        @{{ pvp.match.you.infor.name }} ( @{{ pvp.match.you.infor.character.name }} )
                    </p>
                    <div class="media media-4x4">
                        <img v-if="pvp.match.you.turn == 0" style="position:absolute;width:100%" src="https://media2.giphy.com/media/xUA7aXJY46jN2P6gGk/source.gif">
                        <a class="media-content" style="background-image:url({{ $user->character()->avatar}});background-size:50%;background-color:transparent"></a>
                    </div>
                    <div class="card-body">
                        <div class="row row-sm">
                            <div v-for="(skill,index) in pvp.match.you.skills" :key="index" class="col-3">
                                <img style="width:100%;border-radius:5px" :src="skill.image">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-lg-3 col-sm-3 vip-bordered">
                <div class="card">
                    <div class="media media-4x4">
                        <a  class="media-content" style="background-image:url(https://i.imgur.com/oRZI0I2.png);background-size:50%;background-color:transparent"></a>
                    </div>
                </div>
            </div>
            <div class="col-md-4 col-lg-4 col-sm-4 vip-bordered">
                <div class="card">
                    <img v-if="pvp.match.you.turn != 0 && pvp.isMatching" style="position:absolute;width:100%" src="https://media2.giphy.com/media/xUA7aXJY46jN2P6gGk/source.gif">
                    <p class="card-title text-gold">
                        @{{ pvp.match.enemy.infor.name }} ( @{{ pvp.match.enemy.infor.character.name }} )
                    </p>
                    <div class="media media-4x4">
                        <a class="media-content" :style="{backgroundImage:'url('+pvp.match.enemy.infor.character.avatar+')',backgroundSize:'50%',backgroundColor:'transparent'}"></a>
                    </div>
                    <div class="card-body">
                        <div class="row row-sm">
                            <div v-for="(skill,index) in pvp.match.enemy.skills" :key="index" class="col-3">
                                <img style="width:100%;border-radius:5px" :src="skill.image">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
