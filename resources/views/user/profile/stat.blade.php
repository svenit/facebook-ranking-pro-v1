@extends('app')

@section('hero','Chỉ số')
@section('sub_hero','Điểm chỉ số sức mạnh')

@section('content')
<div id="list-fight-room">
    <div class="page-content page-container" id="page-content">
        <div class="padding-x">
            @include('user.theme.parameter')
            @include('user.profile.base')
            <div style="padding:20px" class="card vip-bordered">
                <div style="font-size:12px;padding:4px 10px" class="bg bg-dark">
                    Bấm vào <button class="btn btn-dark"><i class="fas fa-plus"></i></button>
                    để chọn chỉ số bạn muốn tăng.
                </div>
                <div class="text-gold" style="margin: 20px 5px">
                    Điểm dư: <strong>@{{ numberFormat(data.stats.available) }}</strong>
                </div>
                <div class="row">
                    <div style="padding:10px 20px" class="card col-lg-12 col-md-12 col-sm-12">
                        <div class="row">
                            <div class="col-auto d-flex mt-2">
                                <div class="flex">
                                    <div class="text-success">
                                        <small><img data-toggle="tooltip" title="OK" style="width:26px" class="mr-1" src="{{ asset('assets/images/effects/buff-hp.png') }}"> HP
                                            <strong class="text-success">+ @{{ data.stats.data.health_points }}</strong>
                                            <button @click="incrementStat('health_points')" class="btn btn-dark ml-2"><i class="fas fa-plus"></i></button>
                                        </small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-auto d-flex mt-2">
                                <div class="flex">
                                    <div class="text-danger"><small><img style="width:26px" class="mr-1" src="{{ asset('assets/images/effects/buff-strength.png') }}"> STR<strong
                                        class="text-danger">+ @{{ data.stats.data.strength }}</strong>
                                        <button @click="incrementStat('strength')" class="btn btn-dark ml-2"><i class="fas fa-plus"></i></button></small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-auto d-flex mt-2">
                                <div class="flex">
                                    <div class="text-info"><small><img style="width:26px" class="mr-1" src="{{ asset('assets/images/effects/buff-intelligent.png') }}"> INT<strong
                                        class="text-info">+ @{{ data.stats.data.intelligent }}</strong>
                                        <button @click="incrementStat('intelligent')" class="btn btn-dark ml-2"><i class="fas fa-plus"></i></button></small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-auto d-flex mt-2">
                                <div class="flex">
                                    <div class="text-primary"><small><img style="width:26px" class="mr-1" src="{{ asset('assets/images/effects/buff-agility.png') }}"> AGI<strong
                                        class="text-primary">+ @{{ data.stats.data.agility }}</strong>
                                        <button @click="incrementStat('agility')" class="btn btn-dark ml-2"><i class="fas fa-plus"></i></button></small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-auto d-flex mt-2">
                                <div class="flex">
                                    <div class="text-warning"><small><img style="width:26px" class="mr-1" src="{{ asset('assets/images/effects/buff-lucky.png') }}"> LUK <strong
                                        class="text-warning">+ @{{ data.stats.data.lucky }}</strong>
                                        <button @click="incrementStat('lucky')" class="btn btn-dark ml-2"><i class="fas fa-plus"></i></button></small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-auto d-flex mt-2">
                                <div class="flex">
                                    <div class="text-silver"><small><img style="width:26px" class="mr-1" src="{{ asset('assets/images/effects/buff-def.png') }}"> DEF <strong
                                        class="text-silver">+ @{{ data.stats.data.armor_strength }}</strong>
                                        <button @click="incrementStat('armor_strength')" class="btn btn-dark ml-2"><i class="fas fa-plus"></i></button></small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-auto d-flex mt-4">
                                <div class="flex">
                                    <div class="text-purple"><small><img style="width:26px" class="mr-1" src="{{ asset('assets/images/effects/buff-am.png') }}"> AM <strong
                                        class="text-purple">+ @{{ data.stats.data.armor_intelligent }}</strong>
                                        <button @click="incrementStat('armor_intelligent')" class="btn btn-dark ml-2"><i class="fas fa-plus"></i></button></small>
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
        var page = {
            path:'profile.stat'
        };
    </script>
@endpush