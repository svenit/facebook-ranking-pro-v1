@extends('app')

@section('hero','Kho Đồ')
@section('sub_hero','Kho đồ của bạn')

@section('content')
<div id="list-fight-room">
    <div class="page-content page-container" id="page-content">
        <div class="padding-x">
            @include('user.theme.parameter')
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
                            <div v-if="inventory['{{ str_slug($menu->name) }}']" class="row">
                                <div v-for="(inven,index) in inventory['{{ str_slug($menu->name) }}']" :key="index" class="col-1">
                                    <div class="">
                                        <div class="text-center hoverable">
                                            <div @click="showGearsDescription(inven,1)" :style="{margin:'0 auto',border:`1px solid ${inven.rgb}`}" :class="inven.shop_tag"></div>
                                        </div>
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
    const page = {
        path:'inventory.index'
    };
</script>
@endpush