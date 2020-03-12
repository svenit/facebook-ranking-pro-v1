@extends('app')

@section('hero','Chỉ số')
@section('sub_hero','')

@section('content')
<div id="list-fight-room">
    <div class="page-content page-container" id="page-content">
        <div class="padding-x">
            @include('user.theme.parameter')
            @include('user.profile.base')
            <div style="padding:20px" class="card vip-bordered">
                <div style="font-size:12px;padding:4px 10px" class="bg bg-dark">
                    Bấm vào <button class="btn btn-dark"><i class="fas fa-arrow-up"></i></button>
                    để chọn chỉ số bạn muốn tăng.
                </div>
                <div class="text-gold" style="margin: 20px">
                    Điểm : <strong>@{{ numberFormat(data.stats.available) }}</strong>
                </div>
                <div class="row">
                    <div class="col-lg-5 col-md-12 col-sm-12">
                        <div id="stats-infor"></div>
                    </div>
                    <div style="padding:20px 50px" class="ultra-bordered card col-lg-7 col-md-12 col-sm-12">
                        <p style="margin-top:15px" class="text-gold"><strong>CHỈ SỐ THUỘC TÍNH</strong></p>
                        <div class="row">
                            <div class="col-6 d-flex mt-2">
                                <div class="flex">
                                    <div class="text-success">
                                        <small><i class="fas fa-heart"></i> Sinh Lực 
                                            <strong class="text-success">+ @{{ data.stats.data.health_points }}</strong>
                                            <button @click="incrementStat('health_points')" class="btn btn-dark ml-2"><i class="fas fa-arrow-up"></i></button>
                                        </small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6 d-flex mt-2">
                                <div class="flex">
                                    <div class="text-danger"><small><i class="fas fa-swords"></i> Sức Mạnh <strong
                                        class="text-danger">+ @{{ data.stats.data.strength }}</strong>
                                        <button @click="incrementStat('strength')" class="btn btn-dark ml-2"><i class="fas fa-arrow-up"></i></button></small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6 d-flex mt-2">
                                <div class="flex">
                                    <div class="text-info"><small><i class="fas fa-brain"></i> Trí Tuệ <strong
                                        class="text-info">@{{ data.stats.data.intelligent }}</strong>
                                        <button @click="incrementStat('intelligent')" class="btn btn-dark ml-2"><i class="fas fa-arrow-up"></i></button></small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6 d-flex mt-2">
                                <div class="flex">
                                    <div class="text-primary"><small><i class="fas fa-bolt"></i> Nhanh Nhẹn <strong
                                        class="text-primary">+ @{{ data.stats.data.agility }}</strong>
                                        <button @click="incrementStat('agility')" class="btn btn-dark ml-2"><i class="fas fa-arrow-up"></i></button></small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6 d-flex mt-2">
                                <div class="flex">
                                    <div class="text-warning"><small><i class="fas fa-stars"></i> May Mắn <strong
                                        class="text-warning">+ @{{ data.stats.data.lucky }}</strong>
                                        <button @click="incrementStat('lucky')" class="btn btn-dark ml-2"><i class="fas fa-arrow-up"></i></button></small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6 d-flex mt-2">
                                <div class="flex">
                                    <div class="text-silver"><small><i class="fas fa-shield"></i> Kháng Công <strong
                                        class="text-silver">+ @{{ data.stats.data.armor_strength }}</strong>
                                        <button @click="incrementStat('armor_strength')" class="btn btn-dark ml-2"><i class="fas fa-arrow-up"></i></button></small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6 d-flex mt-2">
                                <div class="flex">
                                    <div class="text-purple"><small><i class="fal fa-dice-d20"></i> Kháng Phép <strong
                                        class="text-purple">+ @{{ data.stats.data.armor_intelligent }}</strong>
                                        <button @click="incrementStat('armor_intelligent')" class="btn btn-dark ml-2"><i class="fas fa-arrow-up"></i></button></small>
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
@endsection
@push('js')
    @if($errors->any())
        <script>
            Swal.fire('',"{{ $errors->first() }}",'error');
        </script>
    @endif
    <script>
        const page = {
            path:'profile.stat'
        };
    </script>
@endpush