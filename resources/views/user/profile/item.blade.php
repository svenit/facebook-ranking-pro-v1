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
                <div v-if="items.length > 0" v-for="(item,index) in items" :key="index" class="col-4 col-md-3 col-lg-2" data-title="tooltip" title="Click vào để sử dụng" @click="showInforItem(item,1)">
                    <div class="card">
                        <div class="text-center hoverable">
                            <div style="margin:0 auto !important" :class="item.class_tag"></div>
                            <p class="text-gold" :style="{marginTop:'10px'}">@{{ item.name }}</p>
                        </div>
                        <div class="btn-group">
                            <button type="button" class="btn btn-secondary active">
                                x @{{ item.pivot.quantity }}
                            </button> 
                        </div>
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