@extends('app')

@section('hero','Vật phẩm')
@section('sub_hero','Kho vật phẩm của bạn')

@section('content')
<div id="list-fight-room">
    <div class="page-content page-container" id="page-content">
        <div class="padding-x">
            @include('user.theme.parameter')
            @include('user.profile.base')
            <div class="vip-bordered row">                    
                <div style="padding:20px" v-if="items.length > 0" v-for="(item,index) in items" :key="index" class="col-3 col-md-2 col-lg-1" data-title="tooltip" title="Click vào để sử dụng" @click="showInforItem(item,1)">
                    <div data-title="tooltip" title="Click vào để xem chi tiết" class="hoverable col-sm-3 col-md-2 col-lg-1">
                        <span style="border:1px solid #eee" class="w-64 avatar gd-dark">
                            <span style="background:transparent;border-color:transparent !important" class="avatar-status b-white avatar-right">
                                x@{{ item.pivot.quantity }}
                            </span> 
                            <div :class="`pixel ${item.class_tag}`"></div>
                        </span>
                    </div>
                </div>
                <div v-if="items.length == 0">
                    <p class="text-center">( Không có vật phẩm nào )</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('js')
<script>
    const page = {
        path:'item.index'
    };
</script>
@endpush