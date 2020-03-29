@extends('app')

@section('hero','Trang bị')
@section('sub_hero','Kho trang bị của bạn')

@section('content')
<div id="list-fight-room">
    <div class="page-content page-container" id="page-content">
        <div class="padding-x">
            @include('user.theme.parameter')
            @include('user.profile.base')
            <div class="card vip-bordered">
                <div class="b-b">
                    <div class="nav-active-border b-danger bottom">
                        <ul class="nav" id="myTab" role="tablist">
                            @foreach($cates as $key => $menu)
                                <li class="nav-item"><a class="nav-link {{ $key == 0 ? 'active' : '' }}" id="{{ str_slug($menu->name) }}-tab" data-toggle="tab" href="#home{{ str_slug($menu->name) }}" role="tab" aria-controls="home{{ str_slug($menu->name) }}" aria-selected="{{ $key == 0 ? 'true' : 'false' }}">{{ $menu->name }}</a></li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <div class="tab-content p-3">
                    @foreach($cates as $key => $menu)
                        <div class="tab-pane fade {{ $key == 0 ? 'show active' : '' }}" id="home{{ str_slug($menu->name) }}" role="tabpanel" aria-labelledby="{{ str_slug($menu->name) }}-tab">
                            <div style="padding-top:20px" v-if="inventory['{{ str_slug($menu->name) }}']" class="row">
                                <div v-for="(inven,index) in inventory['{{ str_slug($menu->name) }}']" @click="showGearsDescription(inven,1)" :key="index" data-title="tooltip" title="Click vào để xem chi tiết" class="hoverable col-auto">
                                    <div class="card">
                                        <span :style="{border:`1px solid ${inven.rgb}`}" class="w-64 avatar gd-dark">
                                            <span :class="`avatar-status ${inven.pivot.status == 1 ? 'on' : 'away'} b-white avatar-right`"></span> 
                                            <div :class="`pixel ${inven.shop_tag}`"></div>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
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
        path:'inventory.index'
    };
</script>
@endpush