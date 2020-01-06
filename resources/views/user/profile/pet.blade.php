@extends('app')

@section('hero','Thú Cưỡi')
@section('sub_hero','Con gì nuôi mà chả để cưỡi')

@section('content')
<div id="list-fight-room">
    <div class="page-content page-container" id="page-content">
        <div class="padding-x">
            @include('user.theme.parameter')
            @include('user.profile.base')
            <div class="card vip-bordered">
                <div class="b-b">
                    <div class="nav-active-border b-primary bottom">
                        <ul class="nav" id="myTab" role="tablist">
                            <li v-if="data.pet" class="nav-item"><a :class="[`nav-link ${data.pet ? 'active' : ''}`]" id="current-pet-tab" data-toggle="tab" href="#home-current-pet" role="tab" aria-controls="home-current-pet" aria-selected="true">@{{ data.pet.name }}</a></li>
                            <li class="nav-item"><a :class="[`nav-link ${!data.pet ? 'active' : ''}`]" id="list-pet-tab" data-toggle="tab" href="#home-list-pet" role="tab" aria-controls="home-list-pet" aria-selected="true">Thú Cưỡi</a></li>
                        </ul>
                    </div>
                </div>
                <div class="tab-content p-3">
                    <div v-if="data.pet" :class="[`tab-pane fade ${data.pet ? 'show active' : ''}`]" id="home-current-pet" role="tabpanel" aria-labelledby="current-pet-tab">
                        <div class="row">
                            <div class="col-lg-3 col-md-6 col-sm-12">
                                <p :style="{color:data.pet.rgb}" class="text-center">@{{ data.pet.name }}</p>
                                <div @click="showInforPet(data.pet,1)" style="margin-top:10px;margin:0 auto" class="character-sprites hoverable">
                                    <span style="bottom:0%" :class="`Mount_Body_${data.pet.class_tag}`"></span>
                                    <span style="bottom:0%" :class="`Mount_Head_${data.pet.class_tag}`"></span>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                            <div class="col-lg-4 col-md-6 col-sm-12">
                                <div class="row">
                                    <div class="col-6 d-flex">
                                        <div class="flex">
                                            <div class="text-light"><small><i class="fas fa-chevron-double-up"></i> Level yêu cầu : <strong
                                                class="text-light">@{{ data.pet.level_required }}</strong></small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6 d-flex">
                                        <div class="flex">
                                            <div class="text-info"><small><i class="fas fa-heart"></i> Sinh Lực <strong
                                                class="text-info">+ @{{ data.pet.health_points }}</strong></small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6 d-flex mt-2">
                                        <div class="flex">
                                            <div class="text-danger"><small><i class="fas fa-swords"></i> Sức Mạnh <strong
                                                class="text-danger">+ @{{ data.pet.strength }}</strong></small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6 d-flex mt-2">
                                        <div class="flex">
                                            <div class="text-success"><small><i class="fas fa-brain"></i> Trí Tuệ <strong
                                                class="text-success">@{{ data.pet.intelligent }}</strong></small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6 d-flex mt-2">
                                        <div class="flex">
                                            <div class="text-primary"><small><i class="fas fa-bolt"></i> Nhanh Nhẹn <strong
                                                class="text-primary">+ @{{ data.pet.agility }}</strong></small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6 d-flex mt-2">
                                        <div class="flex">
                                            <div class="text-warning"><small><i class="fas fa-stars"></i> May Mắn <strong
                                                class="text-warning">+ @{{ data.pet.lucky }}</strong></small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6 d-flex mt-2">
                                        <div class="flex">
                                            <div class="text-silver"><small><i class="fas fa-shield"></i> Kháng Công <strong
                                                class="text-silver">+ @{{ data.pet.armor_strength }}</strong></small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6 d-flex mt-2">
                                        <div class="flex">
                                            <div class="text-purple"><small><i class="fal fa-dice-d20"></i> Kháng Phép <strong
                                                class="text-purple">+ @{{ data.pet.armor_intelligent }}</strong></small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-5 col-md-6 col-sm-12">
                                <p>@{{ data.pet.description || '( Không có thông tin thêm về thú cưỡi này )' }}</p>
                            </div>
                        </div>
                    </div>
                    <div :class="[`tab-pane fade ${!data.pet ? 'show active' : ''}`]" id="home-list-pet" role="tabpanel" aria-labelledby="list-pet-tab">
                        <div style="padding-top:20px" v-if="pets.length > 0" class="row">
                            <div v-for="(pet,index) in pets" :key="index" data-title="tooltip" title="Click vào để xem chi tiết" class="hoverable col-sm-3 col-md-2 col-lg-1">
                                <div class="card">
                                    <span :style="{border:`1px solid ${pet.rgb}`}" class="w-64 avatar gd-dark">
                                        <span :class="`avatar-status ${pet.pivot.status == 1 ? 'on' : 'away'} b-white avatar-right`"></span> 
                                        <div @click="showInforPet(pet,1)" :class="[`pixel mount Mount_Icon_${pet.class_tag}`]"></div>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div v-else>
                            <p class="text-center">( Không có thú cưỡi nào )</p>
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
        path:'pet.index'
    };
</script>
@endpush