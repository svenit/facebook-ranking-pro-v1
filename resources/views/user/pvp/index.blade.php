@extends('app')

@section('hero','PVP')
@section('sub_hero','Vinh quang chỉ dành cho người chiến thắng')

@section('content')
<div id="list-fight-room">
    <div class="page-content page-container" id="page-content">
        <div class="padding-x">
            @include('user.theme.parameter')
            <a class="text-gold" href="{{ Route('user.pvp.create') }}">
                <button id='fight-button' style="width:300px" class="vip-bordered">Tạo Phòng</button>
            </a>
            <div class="row">
                <div v-for="(room,index) in pvp.rooms" :key="index" class="col-6 col-md-4 col-lg-3">
                    <a :href="`pvp/join/${room.name}`">
                        <div class="card vip-bordered">
                            <div class="media media-4x3 gd-dark">
                                <a class="media-content" style="background-image:url(https://steamuserimages-a.akamaihd.net/ugc/100603690261205174/4A7D4ACE46F6C0799A9758C3F8BE4B2A1F562B50/)">
                                    <i v-if="room.people == 2" data-feather="users"></i>
                                    <i v-if="room.people == 1" data-feather="user"></i>
                                </a>
                            </div>
                            <a :href="`pvp/join/${room.name}`"><button>Tham Gia</button></a>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('js')
<script>
    const page = {
        path:'pvp.list'
    };
</script>
@endpush