@extends('app')

@section('hero','Cửa Hàng')
@section('sub_hero','Nơi bán những vật phẩm có giá trên trời')

@section('content')
<div id="list-fight-room">
    <div class="page-content page-container" id="page-content">
        <div class="padding-x">
            @include('user.theme.parameter')
            @foreach($menuShop as $menu)
                <a href="{{ Route('user.shop.index',['cate' => str_slug($menu->name)]) }}" class="{{ Request::is("shop/".str_slug($menu->name)) ? 'active' : '' }} btn btn-dark">{{ $menu->name }}</a>
            @endforeach
            <a href="{{ Route('user.shop.index',['cate' => 'pets']) }}" class="{{ Request::is("shop/pets") ? 'active' : '' }} btn btn-dark">Thú Cưỡi</a>
            <a href="{{ Route('user.shop.index',['cate' => 'skills']) }}" class="{{ Request::is("shop/skills") ? 'active' : '' }} btn btn-dark">Kỹ Năng</a>
            <div class="card vip-bordered">
                <div class="b-b">
                    <div class="nav-active-border b-primary bottom">
                        <ul class="nav" id="myTab" role="tablist">
                            @foreach($gears as $key => $character)
                                <li class="nav-item"><a class="nav-link {{ $character->id == Auth::user()->character->id ? 'active' : '' }}" id="{{ $character->id }}-tab" data-toggle="tab" href="#home{{ $character->id }}" role="tab" aria-controls="home{{ $character->id }}" aria-selected="{{ $key == 0 ? 'true' : 'false' }}">{{ $character->name }}</a></li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <div class="tab-content p-3">
                    @foreach($gears as $key => $gear)
                    <div class="tab-pane fade {{ $gear->id == Auth::user()->character->id ? 'show active' : '' }}" id="home{{ $gear->id }}" role="tabpanel" aria-labelledby="{{ $gear->id }}-tab">
                        <div class="row">
                            @if($gear->items->count() > 0)
                                @foreach($gear->items as $key => $item)
                                <div class="col-6 col-md-4 col-lg-3">
                                    <div class="card vip-bordered">
                                        <div @click="showGearsDescription({{ json_encode($item) }},0)" class="text-center hoverable">
                                            <div style="margin:0 auto" class="{{ $item->shop_tag }}"></div>
                                            <p :style="{color:'{{ $item->rgb }}'}">{{ $item->name }}</p>
                                        </div>
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-secondary active">
                                                {{ number_format($item->price) }} {{ $item->price_type == 0 ? 'Vàng' : 'KC' }}
                                            </button> 
                                            <button @click="buyItem({{ $item->id }},$event)" style="border-top-left-radius:0px;border-bottom-left-radius:0px" type="button" class="btn btn-secondary">Mua</button>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            @else
                                <p class="text-center">( Chưa có mặt hàng nào )</p>
                            @endif
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
        path:'shop.index'
    };
</script>
@endpush