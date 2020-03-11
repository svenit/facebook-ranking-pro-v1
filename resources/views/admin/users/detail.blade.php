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
                        <div style="margin:0px 10px 35px 0px;padding:20px" class="character-sprites hoverable">
                            <span class="{{ $detail->using_pet ? "Mount_Body_".$detail->using_pet->class_tag : '' }}"></span>
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
                            <span class="{{ $detail->using_pet ? "Mount_Head_".$detail->using_pet->class_tag : '' }}"></span>
                        </div>
                        <p style="margin-top:80px" class="text-center">
                            {{ $detail->name }} ( {{ $detail->character->name }} )
                        </p>
                        <p style="margin:0 auto" class="text-center badge badge-{{ $detail->status == 1 ? 'success' : 'danger' }}">{!! $detail->status == 0 ? 'Đã Khóa' : 'Hoạt Động' !!}</p>
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
                                    <div class="text-success"><small><i class="fas fa-heart"></i> Sinh Lực <strong
                                                class="text-success"> {{ $detail->power()['health_points'] }}</strong></small>
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
                                    <div class="text-info"><small><i class="fas fa-brain"></i> Trí Tuệ <strong
                                                class="text-info">{{ $detail->power()['intelligent'] }}</strong></small>
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
                </div>
                <div style="margin-top:20px" class="vip-bordered">
                    @if($errors->any())
                        <div class="alert bg-danger">
                            @foreach($errors->all() as $error)
                                <div>{{ $error }}</div>
                            @endforeach
                        </div>
                    @endif
                    <div style="margin:20px" class="card b-b">
                        <div class="nav-active-border b-primary bottom">
                            <ul class="nav" id="myTab" role="tablist">
                                <li class="nav-item"><a class="nav-link active" id="gear-tab" data-toggle="tab" href="#home-gear" role="tab" aria-controls="home-gear" aria-selected="true">Trang Bị</a></li>
                                <li class="nav-item"><a class="nav-link" id="mobile-tab" data-toggle="tab" href="#home-skill" role="tab" aria-controls="home-skill" aria-selected="false">Kỹ Năng</a></li>
                                <li class="nav-item"><a class="nav-link" id="browser-tab" data-toggle="tab" href="#home-pet" role="tab" aria-controls="home-pet" aria-selected="false">Thú Cưỡi</a></li>
                                <li class="nav-item"><a class="nav-link" id="country-tab" data-toggle="tab" href="#home-item" role="tab" aria-controls="home-item" aria-selected="false">Vật Phẩm</a></li>
                                <li class="nav-item"><a class="nav-link" id="country-tab" data-toggle="tab" href="#home-edit" role="tab" aria-controls="home-edit" aria-selected="false">Sửa Thông Tin</a></li>
                                <li class="nav-item"><a class="nav-link" id="country-tab" data-toggle="tab" href="#home-add-gear" role="tab" aria-controls="home-add-gear" aria-selected="false"><i data-feather="plus"></i> Trang Bị</a></li>
                                <li class="nav-item"><a class="nav-link" id="country-tab" data-toggle="tab" href="#home-add-skill" role="tab" aria-controls="home-add-skill" aria-selected="false"><i data-feather="plus"></i> Kỹ Năng</a></li>
                                <li class="nav-item"><a class="nav-link" id="country-tab" data-toggle="tab" href="#home-add-pet" role="tab" aria-controls="home-add-pet" aria-selected="false"><i data-feather="plus"></i> Thú Cưỡi</a></li>
                                <li class="nav-item"><a class="nav-link" id="country-tab" data-toggle="tab" href="#home-add-item" role="tab" aria-controls="home-add-item" aria-selected="false"><i data-feather="plus"></i> Vật Phẩm</a></li>
                                <li class="nav-item"><a class="nav-link" id="country-tab" data-toggle="tab" href="#home-add-message" role="tab" aria-controls="home-add-message" aria-selected="false"><i data-feather="plus"></i> Tin Nhắn</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="tab-content p-3">
                        <div class="tab-pane fade show active" id="home-gear" role="tabpanel" aria-labelledby="gear-tab">
                            <div class="row">
                                @if($detail->gears->count() > 0)
                                    @foreach($detail->gears as $key => $item)
                                    <div data-title="tooltip" title="Click vào để xem chi tiết" class="hoverable col-sm-3 col-md-2 col-lg-1">
                                        <div class="card">
                                            <span style="border:1px solid {{ $item->rgb }}" class="w-64 avatar gd-dark">
                                                <span class="avatar-status {{ $item->pivot->status == 1 ? 'on' : 'away' }} b-white avatar-right"></span> 
                                                <div @click="showGearsDescription({{ json_encode($item) }},0,)" class="pixel {{ $item->shop_tag }}"></div>
                                                <a class="text-highlight" onclick="return confirm('Xóa trang bị này ?')" href="{{ Route('admin.users.remove-gear',['id' => $item->pivot->id,'gear' => $item->pivot->gear_id,'user' => $detail->id]) }}"><span style="background:transparent;border-color:transparent !important;top:-5px;" class="avatar-status b-white avatar-botom"><i class="fas fa-trash"></i></span></a> 
                                            </span>
                                        </div>
                                    </div>
                                    @endforeach
                                @else
                                    <p class="text-center">( Không có trang bị nào )</p>
                                @endif
                            </div>
                        </div>
                        <div class="tab-pane fade" id="home-skill" role="tabpanel" aria-labelledby="skill-tab">
                            <div class="row">
                                @if($detail->skills->count() > 0)
                                    @foreach($detail->skills as $key => $item)
                                    <div data-title="tooltip" title="Click vào để xem chi tiết" class="hoverable col-sm-3 col-md-2 col-lg-1">
                                        <span style="border:1px solid {{ $item->rgb }}" class="w-56 avatar gd-dark">
                                            <span class="avatar-status {{ $item->pivot->status == 1 ? 'on' : 'away' }} b-white avatar-right"></span> 
                                            <img @click="showSkillsDescription({{ json_encode($item) }},0,'{{ $item->name }}')" src="{{ $item->image }}" alt=".">
                                            <a class="text-highlight" onclick="return confirm('Xóa kỹ năng này ?')" href="{{ Route('admin.users.remove-skill',['skill' => $item->pivot->skill_id,'user' => $detail->id]) }}"><span style="background:transparent;border-color:transparent !important;top:-5px;" class="avatar-status b-white avatar-botom"><i class="fas fa-trash"></i></span></a> 
                                        </span>
                                    </div>
                                    @endforeach
                                @else
                                    <p class="text-center">( Không có kỹ năng nào )</p>
                                @endif
                            </div>
                        </div>
                        <div class="tab-pane fade" id="home-pet" role="tabpanel" aria-labelledby="pet-tab">
                            <div class="row">
                                @if($detail->pets->count() > 0)
                                    @foreach($detail->pets as $key => $item)
                                        <div data-title="tooltip" title="Click vào để xem chi tiết" class="hoverable col-sm-3 col-md-2 col-lg-1">
                                            <span style="border:1px solid {{ $item->rgb }}" class="w-64 avatar gd-dark">
                                                <span class="avatar-status {{ $item->pivot->status == 1 ? 'on' : 'away' }} b-white avatar-right"></span> 
                                                <div @click="showInforPet({{ json_encode($item) }},0)" class="pixel mount Mount_Icon_{{ $item->class_tag }}"></div>
                                                <a class="text-highlight" onclick="return confirm('Xóa thú cưỡi này ?')" href="{{ Route('admin.users.remove-pet',['id' => $item->pivot->id,'pet' => $item->pivot->pet_id,'user' => $detail->id]) }}"><span style="background:transparent;border-color:transparent !important;top:-5px;" class="avatar-status b-white avatar-botom"><i class="fas fa-trash"></i></span></a> 
                                            </span>
                                        </div>
                                    @endforeach
                                @else
                                    <p class="text-center">( Không có thú cưỡi nào )</p>
                                @endif
                            </div>
                        </div>
                        <div class="tab-pane fade" id="home-item" role="tabpanel" aria-labelledby="item-tab">
                            <div class="row">
                                @if($detail->items->count() > 0)
                                    @foreach($detail->items as $key => $item)
                                        <div data-title="tooltip" title="Click vào để xem chi tiết" class="hoverable col-sm-3 col-md-2 col-lg-1">
                                            <span style="border:1px solid #eee" class="w-64 avatar gd-dark">
                                                <span style="background:transparent;border-color:transparent !important;top:-5px" class="avatar-status b-white avatar-right">
                                                    x{{ $item->pivot->quantity }}
                                                </span> 
                                                <div @click="showInforItem({{ json_encode($item) }},0)" class="pixel {{ $item->class_tag }}"></div>
                                                 <a class="text-highlight" onclick="return confirm('Xóa vật phẩm này ?')" href="{{ Route('admin.users.remove-item',['id' => $item->pivot->id,'item' => $item->pivot->item_id,'user' => $detail->id]) }}"><span style="background:transparent;border-color:transparent !important;top:-5px;" class="avatar-status b-white avatar-botom"><i class="fas fa-trash"></i></span></a> 
                                            </span>
                                        </div>
                                    @endforeach
                                @else
                                    <p class="text-center">( Không có vật phẩm nào )</p>
                                @endif
                            </div>
                        </div>
                        <div class="tab-pane fade" id="home-edit" role="tabpanel" aria-labelledby="edit-tab">
                            <div class="card">
                                <div class="card-body">
                                    <form method="POST" action="{{ Route('admin.users.edit',['id' => $detail->id]) }}" class="row">
                                        @csrf
                                        <div class="form-group col-6">
                                            <label class="text-muted" for="exampleInputEmail1">Provider ID</label>
                                            <input type="text" class="form-control" name="provider_id" value="{{ $detail->provider_id }}" name="name" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="">
                                        </div>
                                        <div class="form-group col-6">
                                            <label class="text-muted" for="exampleInputEmail1">Tên</label>
                                            <input type="text" class="form-control" value="{{ $detail->name }}" name="name" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="">
                                        </div>
                                        <div class="form-group col-6 ">
                                            <label class="text-muted" for="exampleInputEmail1">Hệ Phái</label>
                                            <select class="chosen form-control form-control-sm" name="character_id">
                                                @foreach($characters as $character)
                                                    <option {{ $character->id == $detail->character->id ? 'selected' : '' }} value="{{ $character->id }}">{{ $character->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group col-6">
                                            <label class="text-muted" for="exampleInputEmail1">Tiền Thưởng</label>
                                            <input type="number" class="form-control" value="{{ $detail->income_coins }}" name="income_coins" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="">
                                        </div>
                                        <div class="form-group col-6">
                                            <label class="text-muted" for="exampleInputEmail1">Kim Cương</label>
                                            <input type="number" class="form-control" value="{{ $detail->gold }}" name="gold" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="">
                                        </div>
                                        <div class="form-group col-6">
                                            <label class="text-muted" for="exampleInputEmail1">Kinh Nghiệm</label>
                                            <input type="number" class="form-control" value="{{ $detail->exp }}" name="exp" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="">
                                        </div>
                                        <div class="form-group col-6">
                                            <label class="text-muted" for="exampleInputEmail1">Sức Mạnh</label>
                                            <input type="number" class="form-control" value="{{ $detail->strength }}" name="strength" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="">
                                        </div>
                                        <div class="form-group col-6">
                                            <label class="text-muted" for="exampleInputEmail1">Trí Tuệ</label>
                                            <input type="number" class="form-control" value="{{ $detail->intelligent }}" name="intelligent" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="">
                                        </div>
                                        <div class="form-group col-6">
                                            <label class="text-muted" for="exampleInputEmail1">Nhanh Nhẹn</label>
                                            <input type="number" class="form-control" value="{{ $detail->agility }}" name="agility" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="">
                                        </div>
                                        <div class="form-group col-6">
                                            <label class="text-muted" for="exampleInputEmail1">May Mắn</label>
                                            <input type="number" class="form-control" value="{{ $detail->lucky }}" name="lucky" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="">
                                        </div>
                                        <div class="form-group col-6">
                                            <label class="text-muted" for="exampleInputEmail1">Sinh Lực</label>
                                            <input type="number" class="form-control" value="{{ $detail->health_points }}" name="health_points" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="">
                                        </div>
                                        <div class="form-group col-6">
                                            <label class="text-muted" for="exampleInputEmail1">Kháng Công</label>
                                            <input type="number" class="form-control" value="{{ $detail->armor_strength }}" name="armor_strength" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="">
                                        </div>
                                        <div class="form-group col-6">
                                            <label class="text-muted" for="exampleInputEmail1">Kháng Phép</label>
                                            <input type="number" class="form-control" value="{{ $detail->armor_intelligent }}" name="armor_intelligent" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="">
                                        </div>
                                        <div class="form-group col-6">
                                            <label class="text-muted" for="exampleInputEmail1">Điểm PVP</label>
                                            <input type="number" class="form-control" value="{{ $detail->pvp_points }}" name="pvp_points" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="">
                                        </div>
                                        <div class="form-group col-6">
                                            <label class="text-muted" for="exampleInputEmail1">Admin</label>
                                            <select class="chosen form-control form-control-sm" name="isAdmin">
                                                <option {{ $detail->isAdmin == 0 ? 'selected' : '' }} value="0">Không</option>
                                                <option {{ $detail->isAdmin == 1 ? 'selected' : '' }} value="1">Có</option>
                                            </select>
                                        </div>
                                        <div class="form-group col-6">
                                            <label class="text-muted" for="exampleInputEmail1">Lat</label>
                                            <input type="text" class="form-control" value="{{ $detail->lat }}" name="lat" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="">
                                        </div>
                                        <div class="form-group col-6">
                                            <label class="text-muted" for="exampleInputEmail1">Lng</label>
                                            <input type="text" class="form-control" value="{{ $detail->lng }}" name="lng" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="">
                                        </div>
                                        <div class="form-group col-6">
                                            <label class="text-muted" for="exampleInputEmail1">Sức Khỏe</label>
                                            <input type="number" class="form-control" value="{{ $detail->energy }}" name="energy" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="">
                                        </div>
                                        <div class="form-group col-6">
                                            <label class="text-muted" for="exampleInputEmail1">Vé PVP</label>
                                            <input type="number" class="form-control" value="{{ $detail->pvp_times }}" name="pvp_times" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="">
                                        </div>
                                        <div class="form-group col-6">
                                            <label class="text-muted" for="exampleInputEmail1">Vé CVNL</label>
                                            <input type="number" class="form-control" value="{{ $detail->stranger_chat_times }}" name="stranger_chat_times" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="">
                                        </div>
                                        <div class="form-group col-6">
                                            <label class="text-muted" for="exampleInputEmail1">Trạng Thái</label>
                                            <select class="chosen form-control form-control-sm" name="isAdmin">
                                                <option {{ $detail->status == 0 ? 'selected' : '' }} value="0">Khóa</option>
                                                <option {{ $detail->status == 1 ? 'selected' : '' }} value="1">Hoạt Động</option>
                                            </select>
                                        </div>
                                        <div class="form-group col-6">
                                            <button type="submit" class="btn btn-success">Cập Nhật</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="home-add-gear" role="tabpanel" aria-labelledby="add-gear-tab">
                            <div class="card">
                                <div class="card-body">
                                    <form method="POST" action="{{ Route('admin.users.add-gear',['id' => $detail->id]) }}" class="row">
                                        @csrf
                                        <div class="form-group col-6">
                                            <label class="text-muted" for="exampleInputEmail1">Chọn trang bị</label>
                                            <select placeholder="Chọn trang bị" multiple class="chosen form-control form-control-sm" name="gears[]">
                                                @foreach($gears as $gear)
                                                    <option value="{{ $gear->id }}">{{ $gear->name }} ( {{ $gear->character->name }} )</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group col-12">
                                            <button type="submit" class="btn btn-success">Thêm</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="home-add-skill" role="tabpanel" aria-labelledby="add-skill-tab">
                            <div class="card">
                                <div class="card-body">
                                    <form method="POST" action="{{ Route('admin.users.add-skill',['id' => $detail->id]) }}" class="row">
                                        @csrf
                                        <div class="form-group col-6">
                                            <label class="text-muted" for="exampleInputEmail1">Chọn kỹ năng</label>
                                            <select placeholder="Chọn kỹ năng" multiple class="chosen form-control form-control-sm" name="skills[]">
                                                @foreach($skills as $skill)
                                                    <option value="{{ $skill->id }}">{{ $skill->name }} ( {{ $skill->character->name }} )</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group col-12">
                                            <button type="submit" class="btn btn-success">Thêm</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="home-add-pet" role="tabpanel" aria-labelledby="add-pet-tab">
                            <div class="card">
                                <div class="card-body">
                                    <form method="POST" action="{{ Route('admin.users.add-pet',['id' => $detail->id]) }}" class="row">
                                        @csrf
                                        <div class="form-group col-6">
                                            <label class="text-muted" for="exampleInputEmail1">Chọn thú cưỡi</label>
                                            <select placeholder="Chọn thú cưỡi" multiple class="chosen form-control form-control-sm" name="pets[]">
                                                @foreach($pets as $pet)
                                                    <option value="{{ $pet->id }}">{{ $pet->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group col-12">
                                            <button type="submit" class="btn btn-success">Thêm</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="home-add-item" role="tabpanel" aria-labelledby="add-item-tab">
                            <div class="card">
                                <div class="card-body">
                                    <form method="POST" action="{{ Route('admin.users.add-item',['id' => $detail->id]) }}" class="row">
                                        @csrf
                                        <div class="form-group col-6">
                                            <label class="text-muted" for="exampleInputEmail1">Chọn vật phẩm</label>
                                            <select placeholder="Chọn vật phẩm" class="chosen form-control form-control-sm" name="item">
                                                @foreach($items as $item)
                                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group col-6">
                                            <label class="text-muted" for="exampleInputEmail1">Số Lượng</label>
                                            <input type="number" value="1" class="form-control" name="quantity" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="">
                                        </div>
                                        <div class="form-group col-12">
                                            <button type="submit" class="btn btn-success">Thêm</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="home-add-message" role="tabpanel" aria-labelledby="add-message-tab">
                            <div class="card">
                                <div class="card-body">
                                    <form method="POST" action="{{ Route('admin.users.send-message',['id' => $detail->id]) }}" class="row">
                                        @csrf
                                        <div class="form-group col-12">
                                            <label class="text-muted" for="exampleInputEmail1">Tiêu Đề</label>
                                            <input type="text" class="form-control" name="title" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="">
                                        </div>
                                        <div class="form-group col-12">
                                            <label class="text-muted" for="exampleInputEmail1">Nhập tin nhắn</label>
                                            <textarea id="editor" name="message" class="form-control" rows="7"></textarea>
                                        </div>
                                        <div class="form-group col-12">
                                            <button type="submit" class="btn btn-success">Gửi</button>
                                        </div>
                                    </form>
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
@push('css')
    <link rel="stylesheet" href="{{ asset('assets/css/plugins/chosen.css') }}">
@endpush
@push('js')
    <script src="https://cdn.tiny.cloud/1/p56re1ll6yrfkisr7rvwr2l4vnnya546q555cibp202ritgh/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
    <script src="{{ asset('assets/js/plugins/chosen/chosen.jquery.js') }}"></script>
    <script src="{{ asset('assets/js/vue/app.js') }}"></script>
    <script>
        $(document).ready(function () {
            tinymce.init({
                selector:'textarea',
                skin: 'oxide-dark',
                content_css: 'dark',
                plugins: [
                    'advlist autolink link image lists charmap print preview hr anchor pagebreak spellchecker',
                    'searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking',
                    'table emoticons template paste help'
                ],
                toolbar: 'undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify |' +
                    ' bullist numlist outdent indent | link image | print preview media fullpage | ' +
                    'forecolor backcolor emoticons | help',
                menu: {
                    favs: {title: 'My Favorites', items: 'code visualaid | searchreplace | spellchecker | emoticons'}
                },
                menubar: 'favs file edit view insert format tools table help',
            });
            $('.chosen').chosen({
                width: '100%'
            });
        });
    </script>
@endpush
