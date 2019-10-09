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
                <div class="row row-sm">
                    <div class="col-4 d-flex">
                        <div class="card flex">
                            <div class="card-body"><small>Profile complete: <strong
                                        class="text-primary">65%</strong></small>
                                <div class="progress my-3 circle" style="height:6px">
                                    <div class="progress-bar circle gd-primary"
                                        data-toggle="tooltip" title="65%" style="width: 65%">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-4 d-flex">
                        <div class="card flex">
                            <div class="card-body"><small>Payment process: <strong
                                        class="text-primary">25%</strong></small>
                                <div class="progress my-3 circle" style="height:6px">
                                    <div class="progress-bar circle gd-warning"
                                        data-toggle="tooltip" title="25%" style="width: 25%">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-4 d-flex">
                        <div class="card flex">
                            <div class="card-body"><small>Payment process: <strong
                                        class="text-primary">25%</strong></small>
                                <div class="progress my-3 circle" style="height:6px">
                                    <div class="progress-bar circle gd-danger"
                                        data-toggle="tooltip" title="25%" style="width: 25%">
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