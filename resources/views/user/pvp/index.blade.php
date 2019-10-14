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
                    <div class="media media-4x4">
                        <a class="media-content" style="background-image:url({{ $user->character()->avatar}});background-size:50%;background-color:transparent"></a>
                    </div>
                    <div class="card-body">
                        <h5 class="card-title"></h5>
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
                    <div class="media media-4x4">
                        <a class="media-content" style="background-image:url();background-size:50%;background-color:transparent"></a>
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">3</h5>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
