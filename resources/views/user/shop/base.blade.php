<a href="{{ Route('user.shop.index',['cate' => 'items']) }}" class="{{ Request::is("shop/items") ? 'active' : '' }} btn btn-dark">Vật Phẩm</a>
<a href="{{ Route('user.shop.index',['cate' => 'gems']) }}" class="{{ Request::is("shop/gems") ? 'active' : '' }} btn btn-dark">Ngọc Bổ Trợ</a>
@foreach($menuShop as $menu)
    <a href="{{ Route('user.shop.index',['cate' => str_slug($menu->name)]) }}" class="{{ Request::is("shop/".str_slug($menu->name)) ? 'active' : '' }} btn btn-dark">{{ $menu->name }}</a>
@endforeach
<a href="{{ Route('user.shop.index',['cate' => 'pets']) }}" class="{{ Request::is("shop/pets") ? 'active' : '' }} btn btn-dark">Thú Cưỡi</a>
<a href="{{ Route('user.shop.index',['cate' => 'skills']) }}" class="{{ Request::is("shop/skills") ? 'active' : '' }} btn btn-dark">Kỹ Năng</a>