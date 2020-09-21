<div id="footer" style="position:absolute;bottom:0;left:5%" copyright-id="{{ config('services.crypto.salt') }}" class="copyright page-footer row">
    <div data-step="9" data-intro="{{ $intro[8] }}" class="col-auto dropup">
        <div class="dropdown-menu">
            <div class="text-center dropdown-item-header">Nhân Vật</div>
            <a data-toggle="modal" data-target=".modal-profile" data-toggle-class="modal-open-aside" data-target="body" @click="index()" class="dropdown-item" href="#"><img class="mr-1 pixel baw" width="17px" src="{{ asset('assets/images/icon/Infor.png') }}"> Thông Tin & Chỉ Số</a>
            <a @click="loadProfile('item', false)" data-toggle="modal" data-target=".modal-profile-item" data-toggle-class="modal-open-aside" data-target="body" class="dropdown-item" href="#"><img class="mr-1 pixel baw" width="17px" src="{{ asset('assets/images/icon/Item.png') }}"> Vật Phẩm</a>
            <a @click="loadProfile('equipment', true)" data-toggle="modal" data-target=".modal-profile-equipment" data-toggle-class="modal-open-aside" data-target="body" class="dropdown-item" href="#"><img class="mr-1 pixel baw" width="17px" src="{{ asset('assets/images/icon/Shop-Equipment.png') }}"> Trang Bị</a>
            <a class="dropdown-item" href="#"><img class="mr-1 pixel baw" width="13px" src="{{ asset('assets/images/icon/Skill.png') }}"> Kỹ Năng</a>
            <a class="dropdown-item" href="#"><img class="mr-1 pixel baw" width="17px" src="{{ asset('assets/images/icon/Pet.png') }}"> Pet</a>
        </div>
        <img class="text-center footer-icon pixel dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" src="{{ asset('assets/images/icon/Character.png') }}">
        <p class="text-center mt-2">Nhân Vật</p>
    </div>
    <div data-step="10" data-intro="{{ $intro[9] }}" class="col-auto">
        <img @click="loadShop('item' ,false)" data-toggle="mod
        al" data-target=".modal-shop" data-toggle-class="modal-open-aside" data-target="body" class="text-center footer-icon pixel" src="{{ asset('assets/images/icon/Shop.png') }}">
        <p class="text-center mt-2">Cửa Hàng</p>
    </div>
    <div data-step="11" data-intro="{{ $intro[10] }}" class="col-auto">
        <img class="text-center footer-icon pixel" src="{{ asset('assets/images/icon/Quest.png') }}">
        <p class="text-center mt-2">Nhiệm Vụ</p>
    </div>
    <div data-step="12" data-intro="{{ $intro[11] }}" class="col-auto">
        <img class="text-center footer-icon pixel" src="{{ asset('assets/images/icon/Rank.png') }}">
        <p class="text-center mt-2">Xếp Hạng</p>
    </div>
    <div data-step="13" data-intro="{{ $intro[12] }}" class="col-auto">
        <img class="text-center footer-icon pixel" src="{{ asset('assets/images/icon/Guild.png') }}">
        <p class="text-center mt-2">Bang Hội</p>
    </div>
    <div data-step="14" data-intro="{{ $intro[13] }}" class="col-auto">
        <img class="text-center footer-icon pixel" src="{{ asset('assets/images/icon/Casino.png') }}">
        <p class="text-center mt-2">Casino</p>
    </div>
    <div class="col-auto">
        <img class="text-center footer-icon pixel" src="{{ asset('assets/images/icon/Back.png') }}">
        <p class="text-center mt-2">Trở Lại</p>
    </div>
</div>