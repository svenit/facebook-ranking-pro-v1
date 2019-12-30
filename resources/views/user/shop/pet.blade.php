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
            <div class="vip-bordered row">                    
                @if($pets->count() > 0)
                    @foreach($pets as $key => $pet)
                        <div class="col-6 col-md-4 col-lg-3">
                            <div class="card vip-bordered">
                                <div @click="showInforPet({{ json_encode($pet) }},0)" class="text-center hoverable">
                                    <div style="margin:0 auto !important" class="mount Mount_Icon_{{ $pet->class_tag }}"></div>
                                    <p style="margin-top:10px;color:{{ $pet->rgb }}">{{ $pet->name }}</p>
                                </div>
                                <div class="btn-group">
                                    <button type="button" class="btn btn-secondary active">
                                        {{ number_format($pet->price) }} {{ $pet->price_type == 0 ? 'Vàng' : 'KC' }}
                                    </button> 
                                    <button @click="buyPet({{ $pet->id }},$event)" style="border-top-left-radius:0px;border-bottom-left-radius:0px" type="button" class="btn btn-secondary">Mua</button>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <p class="text-center">( Chưa có mặt hàng nào )</p>
                @endif
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