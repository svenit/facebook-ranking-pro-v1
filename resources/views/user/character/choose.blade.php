@extends('app')

@section('hero','Chọn nhân vật')
@section('sub_hero','Vui lòng chọn nhân vật để bắt đầu')

@section('content')
<div class="page-content page-container" id="page-content">
    <div class="padding-x">
        <div class="row row-sm sr">
            @foreach($characters as $key => $character)
                <div class="col-md-3">
                    <div class="card">
                        <div class="media media-4x4 gd-dark">
                            <a class="media-content" style="background-image:url({{ $character->avatar }});background-size:50%"></a>
                        </div>
                        <div class="card-body">
                            <h5 class="card-title">{{ $character->name }}</h5>
                            <div class="row">
                                <div class="col-md-6">
                                    <small class="mute-text text-danger">Sức mạnh <i class="fas fa-swords"></i></small> 
                                    <div class="progress my-3 circle" style="height:6px">
                                        <div class="progress-bar circle gd-danger"
                                            data-toggle="tooltip" title="{{ ($character->strength/0.25) }}%" style="width: {{ ($character->strength/0.25) }}%">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <small class="mute-text text-success">Trí tuệ <i class="fas fa-brain"></i></small> 
                                    <div class="progress my-3 circle" style="height:6px">
                                        <div class="progress-bar circle gd-success"
                                            data-toggle="tooltip" title="{{ ($character->intelligent/0.25) }}%" style="width: {{ ($character->intelligent/0.25) }}%">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <small class="mute-text text-primary">Nhanh Nhẹn <i class="fas fa-bolt"></i></small> 
                                    <div class="progress my-3 circle" style="height:6px">
                                        <div class="progress-bar circle gd-primary"
                                            data-toggle="tooltip" title="{{ ($character->agility/0.25) }}%" style="width: {{ ($character->agility/0.25) }}%">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <small class="mute-text text-warning">May Mắn <i class="fas fa-stars"></i></small> 
                                    <div class="progress my-3 circle" style="height:6px">
                                        <div class="progress-bar circle gd-warning"
                                            data-toggle="tooltip" title="{{ ($character->lucky/0.25) }}%" style="width: {{ ($character->lucky/0.25) }}%">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <a onclick="return confirm('Bạn có chắc chắn muốn chọn nhân vật này ?')" style="margin-left:-10px" href="{{ Route('user.character.set',['id' => $character->id]) }}">
                                <button class="btn w-sm mb-1 bg-primary-lt"><span class="mx-1">Chọn</span></button>
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
