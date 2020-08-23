@extends('app')

@section('hero','Ngọc Tinh Luyện')
@section('sub_hero','Ngọc Tinh Luyện')

@section('content')
<div id="list-fight-room">
    <div class="page-content page-container" id="page-content">
        <div class="padding-x">
            @include('user.profile.base')
            <div class="card vip-bordered">
                <div style="padding:20px 20px 0px 20px" class="row">
                    <div v-for="(gem, index) in gems" data-title="tooltip" @click="showGem(gem,1)" title="Click vào để xem chi tiết" class="hoverable col-auto">
                        <div class="card">
                            <span :style="{border:`1px solid ${gem.rgb}`}" class="w-64 avatar gd-dark">
                                <span class="avatar-status on b-white avatar-right"></span> 
                                <div style="width:40px" :class="`gem ${gem.image}`" class="pixel"></div>
                            </span>
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
        path:'gem.index'
    };
</script>
@endpush