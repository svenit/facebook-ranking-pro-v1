@extends('app')

@section('hero','Tiệm Rèn Ngọc Tinh Luyện')
@section('sub_hero','Tinh luyện ngọc bổ trợ vào trang bị của bạn, giúp trang bị của bạn đột phá hơn')

@section('content')
<div id="list-fight-room">
    <div class="page-content page-container" id="page-content">
        <div class="padding-x">
            @include('user.theme.parameter')
            <div style="padding:10px;background-image:url(https://i.pinimg.com/originals/48/03/80/4803801198a61516931d72be78ec4b01.gif) !important;" class="card vip-bordered">
                <div style="padding: 10px 0px 10px 30px;" class="row">
                    <div style="margin-bottom:10px" class="col-lg-6 col-md-12 col-sm-12">
                        <div style="background:#191818;padding:10px;border-radius:10px;border:1px solid #000;width:100%" class="row">
                            <div class="col-4">
                                <span @click="oven.gear = {}" v-if="oven.gear.id" :style="{border:`1px solid ${oven.gear.rgb}`}" :class="`w-64 avatar gd-dark ${oven.action ? 'animated fadeOutRight' : ''}`">
                                    <span class="avatar-status on b-white avatar-right"></span> 
                                    <div :class="`pixel ${oven.gear.shop_tag}`"></div>
                                </span>
                                <span v-else style="border:1px dashed #f2f2f2" class="w-64 avatar gd-dark">
                                    <span class="avatar-status on b-white avatar-right"></span> 
                                </span>
                            </div>
                            <div class="col-4">
                                <img v-if="oven.gem.id && oven.gear.id" class="pixel animated flash infinite slow" width="100%" src="https://darktown.itam.store/_nuxt/img/d9490a6.png">
                            </div>
                            <div class="col-4">
                                <span @click="oven.gem = {}" v-if="oven.gem.id" :style="{border:`1px solid ${oven.gem.rgb}`,float:'right'}" :class="`w-64 avatar gd-dark ${oven.action ? 'animated fadeOutLeft' : ''}`">
                                    <span class="avatar-status on b-white avatar-right"></span> 
                                    <div style="width:40px" :class="`gem ${oven.gem.image}`" class="pixel"></div>
                                </span>
                                <span v-else style="border:1px dashed #f2f2f2;float:right" class="w-64 avatar gd-dark">
                                    <span class="avatar-status on b-white avatar-right"></span> 
                                </span>
                            </div>
                            <div v-if="oven.gem.id && oven.gear.id" class="col-12 text-center">
                                <button @click="insertGemToGear()" type="button" class="btn-pixel"><span>KHẢM</span></button>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12">
                        <div class="row" style="width:100%">
                            <div class="col-12" style="max-height:300px;overflow:auto">
                                <div style="background:#191818;padding:10px;border-radius:10px;border:1px solid #000" class="row">
                                    <div v-for="(gear, index) in gears" @click="oven.gear = gear" data-tooltip="toggle" title="Click vào trang bị mà bạn muốn khảm" id="droppable" class="hoverable col-auto">
                                        <div style="background:transparent !important" class="card">
                                            <span :style="{border:`1px solid ${gear.rgb}`}" :class="`w-64 avatar gd-dark ${oven.gear == gear ? 'loading' : ''}`">
                                                <span v-if="oven.gear == gear" class="avatar-status on b-white avatar-right"></span> 
                                                <div :class="`pixel ${gear.shop_tag}`"></div>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12" style="max-height:300px;overflow:auto;margin-top:10px">
                                <div style="background:#191818;padding:10px;border-radius:10px;border:1px solid #000" class="row">
                                    <div v-for="(gem, index) in gems" @click="oven.gem = gem" data-tooltip="toggle" title="Click vào ngọc bổ trợ mà bạn muốn khảm" id="droppable" class="hoverable col-auto">
                                        <div style="background:transparent !important" class="card">
                                            <span :style="{border:`1px solid ${gem.rgb}`}" :class="`w-64 avatar gd-dark ${oven.gem == gem ? 'loading' : ''}`">
                                                <span v-if="oven.gem == gem" class="avatar-status on b-white avatar-right"></span> 
                                                <div style="width:40px" :class="`gem ${gem.image}`" class="pixel"></div>
                                            </span>
                                        </div>
                                    </div>
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
@push('js')
    @if($errors->any())
        <script>
            Swal.fire('',"{{ $errors->first() }}",'error');
        </script>
    @endif
    <script>
        var page = {
            path:'oven.gem'
        };
    </script>
@endpush