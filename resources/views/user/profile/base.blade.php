<a href="{{ Route('user.profile.item.index') }}" class="{{ Request::is("profile/items") ? 'active' : '' }} btn btn-dark">Vật Phẩm</a>
<a href="{{ Route('user.profile.inventory.index') }}" class="{{ Request::is("profile/inventories") ? 'active' : '' }} btn btn-dark">Trang Bị</a>
<a href="{{ Route('user.profile.pet.index') }}" class="{{ Request::is("profile/pets") ? 'active' : '' }} btn btn-dark">Thú Cưỡi</a>
<a href="{{ Route('user.profile.skill.index') }}" class="{{ Request::is("profile/skills") ? 'active' : '' }} btn btn-dark">Kỹ Năng</a>