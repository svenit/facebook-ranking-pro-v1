@extends('app')

@section('hero','Ngọc Tinh Luyện')
@section('sub_hero','Ngọc Tinh Luyện')

@section('content')
<div id="list-fight-room">
    <div class="page-content page-container" id="page-content">
        <div class="padding-x">
            @include('user.theme.parameter')
            <div class="card vip-bordered">
                <div style="padding:20px 20px 0px 20px" class="row">
                    <div class="col-4">
                        <div class="row" style="">
                            <div v-for="(gem, index) in gems" title="Click vào ngọc bổ trở"class="hoverable col-auto">
                                <div id="draggable" class="card">
                                    <span :style="{border:`1px solid ${gem.rgb}`}" class="w-64 avatar gd-dark">
                                        <span class="avatar-status on b-white avatar-right"></span> 
                                        <img style="width:40px" :src="gem.image" class="pixel">
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="row">
                            <div class="col-6">
                                1
                            </div>
                            <div class="col-6">
                                2
                            </div>
                        </div>
                    </div>
                    <div class="col-4" style="max-height:300px;overflow:auto">
                        <div class="row">
                            <div v-for="(gear, index) in gears" data-tooltip="toggle" title="Click vào trang bị mà bạn muốn khảm" id="droppable" class="hoverable col-auto">
                                <div class="card">
                                    <span :style="{border:`1px solid ${gear.rgb}`}" class="w-64 avatar gd-dark">
                                        <div :class="`pixel ${gear.shop_tag}`"></div>
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
<div id="droppable" class="ui-widget-header">
    <p>Drop here</p>
</div>
   
@endsection
@push('js')
    @if($errors->any())
        <script>
            Swal.fire('',"{{ $errors->first() }}",'error');
        </script>
    @endif
    <script>
        const page = {
            path:'oven.gem'
        };
    </script>
@endpush