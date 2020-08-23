<div id="footer" style="position:absolute;bottom:0;left:5%" copyright-id="{{ config('services.crypto.salt') }}" class="copyright page-footer row">
    <div class="col-auto">
        <img class="text-center footer-icon" src="{{ asset('assets/images/icon/Character.png') }}">
        <p class="text-center mt-2">Nhân Vật</p>
    </div>
    <div class="col-auto">
        <img @click="loadShop('item' ,false)" data-toggle="modal" data-target=".modal-shop" data-toggle-class="modal-open-aside" data-target="body" class="text-center footer-icon" src="{{ asset('assets/images/icon/Shop.png') }}">
        <p class="text-center mt-2">Cửa Hàng</p>
    </div>
    <div class="col-auto">
        <img class="text-center footer-icon" src="{{ asset('assets/images/icon/Quest.png') }}">
        <p class="text-center mt-2">Nhiệm Vụ</p>
    </div>
    <div class="col-auto">
        <img class="text-center footer-icon" src="{{ asset('assets/images/icon/Rank.png') }}">
        <p class="text-center mt-2">Xếp Hạng</p>
    </div>
    <div class="col-auto">
        <img class="text-center footer-icon" src="{{ asset('assets/images/icon/Guild.png') }}">
        <p class="text-center mt-2">Bang Hội</p>
    </div>
    <div class="col-auto">
        <img class="text-center footer-icon" src="{{ asset('assets/images/icon/Casino.png') }}">
        <p class="text-center mt-2">Casino</p>
    </div>
    <div class="col-auto">
        <img class="text-center footer-icon" src="{{ asset('assets/images/icon/Back.png') }}">
        <p class="text-center mt-2">Trở Lại</p>
    </div>
</div>