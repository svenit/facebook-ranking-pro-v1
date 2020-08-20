@php
    function showUnit($type) 
    {
        switch ($type) 
        {
            case 0:
                return asset('assets/images/icon-pack/gold.png');
            break;
            case 1:
                return asset('assets/images/icon-pack/diamond.png');
            break;
        }
    }
    $sellerScripts = config('game.sellerScripts');
    $sellerScript = $sellerScripts[rand(0, count($sellerScripts) - 1)];
@endphp
<div style="position:relative">
    <p class="text-dark" class="hide-in-mobile" style="width:165px;position: absolute;top:5px;left:165px;z-index:9">
        {{ $sellerScript }}
    </p>
    <img class="hide-in-mobile" style="width:165px;position: absolute;top:0px;left:160px" src="{{ asset('assets/images/comment.png') }}">
    <img class="pixel" width="160px" src="{{ asset('assets/images/icon/Seller.png') }}">
</div>
<a href="{{ Route('user.shop.index',['cate' => 'items']) }}" class="{{ Request::is("shop/items") ? 'active' : '' }} btn btn-dark">Vật Phẩm</a>
<a href="{{ Route('user.shop.index',['cate' => 'gems']) }}" class="{{ Request::is("shop/gems") ? 'active' : '' }} btn btn-dark">Ngọc Bổ Trợ</a>
@foreach($menuShop as $menu)
    <a href="{{ Route('user.shop.index',['cate' => str_slug($menu->name)]) }}" class="{{ Request::is("shop/".str_slug($menu->name)) ? 'active' : '' }} btn btn-dark">{{ $menu->name }}</a>
@endforeach
<a href="{{ Route('user.shop.index',['cate' => 'pets']) }}" class="{{ Request::is("shop/pets") ? 'active' : '' }} btn btn-dark">Thú Cưỡi</a>
<a href="{{ Route('user.shop.index',['cate' => 'skills']) }}" class="{{ Request::is("shop/skills") ? 'active' : '' }} btn btn-dark">Kỹ Năng</a>