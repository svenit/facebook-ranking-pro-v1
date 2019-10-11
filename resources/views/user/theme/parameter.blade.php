@auth
<div class="row row-sm sr">
    <div class="col-md-12 col-lg-12">
        <div class="row row-sm">
            <div class="col-md-12">
                <div class="row row-sm">
                    <div class="col-12">
                        <div class="card vip-bordered" style="padding-top:50px;">
                            <h2 class="ribbon"> <button style="background:transparent;border:none" data-toggle="modal" data-target="#modal-left" data-toggle-class="modal-open-aside" data-target="body">{{ Auth::user()->name }}</button></h2>
                            <div class="card-body">
                                <div class="row row-sm">
                                    <div class="col-3">
                                        <div class="d-flex align-items-center text-hover-success">
                                            <div class="px-4 flex">
                                                <small class="text-gold">Xếp Hạng</small>
                                                <div class="text-gold-2 mt-2"><i class="fas fa-trophy"></i>
                                                    {{ $user->rankCoin() }}</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-3">
                                        <div class="d-flex align-items-center text-hover-warning">
                                            <div class="px-4 flex">
                                                <small class="text-gold">Lực Chiến</small>
                                                <div class="text-gold-2 mt-2"><i class="fas fa-usd-circle"></i>
                                                    {{ $user->fullPower() }}</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-3">
                                        <div class="d-flex align-items-center text-hover-warning">
                                            <div class="px-4 flex">
                                                <small class="text-gold">Xu</small>
                                                <div class="text-gold-2 mt-2"><i class="fas fa-usd-circle"></i>
                                                    {{ $user->demicalCoins() }}</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-3"><small class="text-gold">Vàng
                                        </small>
                                        <div class="mt-2 text-gold-2"><i class="fas fa-coins"></i>
                                            {{ $user->demicalGold() }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<span class="ch ch1">
    <a href="#my-character"><img title="Nhấp vào để xem thông số" data-toggle="modal" data-target="#modal-left" data-toggle-class="modal-open-aside" data-target="body" width="100px" alt="" src="{{ $user->character()->avatar }}" class="animated pulse infinite fast"></a>
</span>
@endauth
