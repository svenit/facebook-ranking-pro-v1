<a href="{{ Route('user.profile.item.index') }}" class="{{ Request::is("profile/items") ? 'active' : '' }} btn btn-dark">Vật Phẩm</a>
<a href="{{ Route('user.profile.item.index') }}" class="{{ Request::is("profile/gems") ? 'active' : '' }} btn btn-dark">Ngọc Tinh Luyện</a>
<a href="{{ Route('user.profile.inventory.index') }}" class="{{ Request::is("profile/inventories") ? 'active' : '' }} btn btn-dark">Trang Bị</a>
<a href="{{ Route('user.profile.pet.index') }}" class="{{ Request::is("profile/pets") ? 'active' : '' }} btn btn-dark">Thú Cưỡi</a>
<a href="{{ Route('user.profile.skill.index') }}" class="{{ Request::is("profile/skills") ? 'active' : '' }} btn btn-dark">Kỹ Năng</a>
<a href="{{ Route('user.profile.message.index') }}" class="{{ Request::is("profile/messages") ? 'active' : '' }} btn btn-dark">Tin Nhắn @if(isset($notifications) && $notifications['unread'] > 0)<span class="nav-badge"><b class="badge badge-pill gd-warning">{{ $notifications['unread'] ?? 0 }}</b></span>@endif</a>