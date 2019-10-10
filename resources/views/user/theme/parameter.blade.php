@auth
<div class="row row-sm sr">
    <div class="col-md-12 col-lg-12">
        <div class="row row-sm">
            <div class="col-md-12">
                <div class="row row-sm">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="row row-sm">
                                    <div class="col-4">
                                        <div class="d-flex align-items-center text-hover-success">
                                            <div class="px-4 flex">
                                                    <small class="text-muted">Xếp Hạng</small>
                                                <div class="text-primary mt-2"><i class="fas fa-trophy"></i> {{ $user->rank() }}</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="d-flex align-items-center text-hover-warning">
                                            <div class="px-4 flex">
                                                <small class="text-muted">Xu</small>
                                                <div class="text-secondary mt-2"><i class="fas fa-usd-circle"></i> {{ $user->demicalCoins() }}</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-4"><small class="text-muted">Vàng
                                            </small>
                                        <div class="mt-2 text-warning"><i class="fas fa-coins"></i> {{ $user->demicalGold() }}</div>
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
@endauth