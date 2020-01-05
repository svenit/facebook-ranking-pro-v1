@extends('app')
@section('content')

@section('hero',"$detail->name")
@section('sub_hero',"Xem thông tin của $detail->name")
<div id="content" class="flex">
    <div id="ranking" class="">
        <div class="page-content page-container" id="page-content">
            <div class="padding-x">
                <div class="row row-sm sr vip-bordered">
                    <div class="col-2">
                        <div style="margin:0px 10px 35px 0px;padding:20px" class="character-sprites hoverable {{ $detail->isVip == 1 ? 'vip-2' : '' }}">
                            <span class="{{ $detail->using_pet ? "Mount_Head_$detail->using_pet" : '' }}"></span>
                            <span class="hair_flower_3"></span>
                            <span class="chair_none"></span>
                            <span class=""></span>
                            <span class="skin_f5a76e"></span>
                            <span class="broad_shirt_black"></span>
                            <span class="head_0"></span>
                            <span class="broad_armor_base_0"></span>
                            <span class=""></span>
                            <span class="hair_bangs_0_black"></span>
                            <span class="hair_base_0_black"></span>
                            <span class="hair_mustache_0_black"></span>
                            <span class="hair_beard_0_black"></span>
                            <span class=""></span>
                            <span class="eyewear_base_0"></span>
                            <span class="head_base_0"></span>
                            <span class=""></span>
                            <span class="hair_flower_0"></span>
                            <span class="shield_base_0"></span>
                            <span class=""></span>
                            @foreach($detail->using_gears as $gear)
                                <span class="{{ $gear->class_tag }}"></span>
                            @endforeach
                            <span class="{{ $detail->using_pet ? "Mount_Body_$detail->using_pet" : '' }}"></span>
                        </div>
                    </div>
                    <div style="margin-top:10px;padding:20px" class="col-4">
                        <div class="row">
                            <div class="col-12 d-flex">
                                <div class="flex">
                                        <div class="text-info">
                                        Level 
                                        {{ $detail->level['current_level'] }}
                                        <i class="fas fa-arrow-right"></i> 
                                        {{ $detail->level['next_level'] }}
                                        ( {{ $detail->exp }} EXP - {{ $detail->level['percent'] }} % )
                                        <div class="progress my-3 circle" style="height:6px">
                                            <div class="progress-bar circle gd-info" data-title="tooltip" style="width:{{ $detail->level['percent'] }}%">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6 d-flex">
                                <div class="flex">
                                    <div class="text-light"><small><i class="fas fa-chevron-double-up"></i> Level <strong
                                                class="text-light">{{ $detail->level['current_level'] }}</strong></small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6 d-flex">
                                <div class="flex">
                                    <div class="text-info"><small><i class="fas fa-heart"></i> Sinh Lực <strong
                                                class="text-info"> {{ $detail->power()['health_points'] }}</strong></small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6 d-flex mt-2">
                                <div class="flex">
                                    <div class="text-danger"><small><i class="fas fa-swords"></i> Sức Mạnh <strong
                                                class="text-danger">{{ $detail->power()['strength'] }}</strong></small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6 d-flex mt-2">
                                <div class="flex">
                                    <div class="text-success"><small><i class="fas fa-brain"></i> Trí Tuệ <strong
                                                class="text-success">{{ $detail->power()['intelligent'] }}</strong></small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6 d-flex mt-2">
                                <div class="flex">
                                    <div class="text-primary"><small><i class="fas fa-bolt"></i> Nhanh Nhẹn <strong
                                                class="text-primary">{{ $detail->power()['agility'] }}</strong></small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6 d-flex mt-2">
                                <div class="flex">
                                    <div class="text-warning"><small><i class="fas fa-stars"></i> May Mắn <strong
                                                class="text-warning">{{ $detail->power()['lucky'] }}</strong></small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6 d-flex mt-2">
                                <div class="flex">
                                    <div class="text-silver"><small><i class="fas fa-shield"></i> Kháng Công <strong
                                                class="text-silver">{{ $detail->power()['armor_strength'] }}</strong></small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6 d-flex mt-2">
                                <div class="flex">
                                    <div class="text-purple"><small><i class="fal fa-dice-d20"></i> Kháng Phép <strong
                                                class="text-purple">{{ $detail->power()['armor_intelligent'] }}</strong></small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div style="margin-top:10px;padding:20px;" class="col-6 ultra-bordered">
                        <div class="row">
                            <div class="col-6  mt-2">
                                <span class="text-danger">LC : {{ number_format($detail->fullPower($detail->id)) }}</span>
                            </div>
                            <div class="col-6  mt-2">
                                <span class="text-danger">Xác Thực : {{ $detail->provider_id ? 'OK' : 'Chưa' }}</span>
                            </div>
                            <div class="col-6  mt-2">
                                <span class="text-success">Trạng Thái : {{ $detail->status == 1 ? 'Hoạt Động' : 'Đã Khóa' }}</span>
                            </div>
                            <div class="col-6  mt-2">
                                <span class="text-success">Sức Khỏe : {{ number_format($detail->energy) }}</span>
                            </div>
                            <div class="col-6  mt-2">
                                <span class="text-gold">Vé PVP : {{ number_format($detail->pvp_times) }}</span>
                            </div>
                            <div class="col-6  mt-2">
                                <span class="text-gold">Vé Chat : {{ number_format($detail->chat_with_strangers_times) }}</span>
                            </div>
                            <div class="col-6  mt-2">
                                <span class="text-info">Bài Viết : {{ number_format($detail->posts) }}</span>
                            </div>
                            <div class="col-6  mt-2">
                                <span class="text-info">Biểu Cảm : {{ number_format($detail->reactions) }}</span>
                            </div>
                            <div class="col-6  mt-2">
                                <span class="text-info">Bình Luận : {{ number_format($detail->comments) }}</span>
                            </div>
                            <div class="col-6  mt-2">
                                <span class="text-warning">Điểm Hoạt Động : {{ number_format($detail->coins) }}</span>
                            </div>
                            <div class="col-6  mt-2">
                                <span class="text-warning">Điểm Thưởng : {{ number_format($detail->income_coins) }}</span>
                            </div>
                            <div class="col-6  mt-2">
                                <span class="text-warning">Điểm Hạng : {{ number_format($detail->pvp_points) }}</span>
                            </div>
                            <div class="col-6  mt-2">
                                <span class="text-primary">Kim Cương : {{ number_format($detail->gold) }}</span>
                            </div>
                            <div class="col-6  mt-2">
                                <span class="text-silver">Lat : {{ $detail->lat }}</span>
                            </div>
                            <div class="col-6  mt-2">
                                <span class="text-silver">Lng : {{ $detail->lng }}</span>
                            </div>
                            <div class="col-6  mt-2">
                                <span class="text-success">ID : <a target="_blank" class="text-success" href="https://facebook.com/{{ $detail->user_id }}">{{ $detail->user_id }}</a></span>
                            </div>
                            <div class="col-6  mt-2">
                                <span class="text-success">Provider : {{ $detail->provider_id }}</span>
                            </div>
                            <div class="col-6  mt-2">
                                <span class="text-silver">Tracking : {{ $detail->tracking->path ?? '' }} ( {{ $detail->tracking->route ?? '' }} ) </span>
                            </div>
                        </div>
                    </div>
                    <div style="margin:20px" class="b-b">
                        <div class="nav-active-border b-primary bottom">
                            <ul class="nav" id="myTab" role="tablist">
                                <li class="nav-item"><a class="nav-link active" id="index-tab" data-toggle="tab" href="#home-gear" role="tab" aria-controls="home-gear" aria-selected="true">Trang Bị</a></li>
                                <li class="nav-item"><a class="nav-link" id="mobile-tab" data-toggle="tab" href="#home-skill" role="tab" aria-controls="home-skill" aria-selected="false">Kỹ Năng</a></li>
                                <li class="nav-item"><a class="nav-link" id="browser-tab" data-toggle="tab" href="#home-pet" role="tab" aria-controls="home-pet" aria-selected="false">Thú Cưỡi</a></li>
                                <li class="nav-item"><a class="nav-link" id="country-tab" data-toggle="tab" href="#home-item" role="tab" aria-controls="home-item" aria-selected="false">Vật Phẩm</a></li>
                                <li class="nav-item"><a class="nav-link" id="country-tab" data-toggle="tab" href="#home-edit" role="tab" aria-controls="home-edit" aria-selected="false">Sửa</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="tab-content p-3">
                        <div class="tab-pane fade show active" id="home-index" role="tabpanel" aria-labelledby="index-tab">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('js')

@endpush
