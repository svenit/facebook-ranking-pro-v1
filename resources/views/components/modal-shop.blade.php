<div v-if="data" class="modal fade modal-shop" data-backdrop="true">
    <div class="modal-dialog modal-ui modal-xl">
        <div class="modal-content" style="position: relative">
            <div v-if="loading" class="loading-in-component loading-spinner-box">
                <div class="loading-component">
                    <div class="cube">
                        <div class="side"></div>
                        <div class="side"></div>
                        <div class="side"></div>
                        <div class="side"></div>
                        <div class="side"></div>
                    </div>
                    <div class="loading-spinner-ment">
                        <p notranslate class="mt-5 pixel-font notranslate">Loading...</p>
                    </div>
                </div>
            </div>
            <div style="position: relative" class="modal-header">
                @include('components.border')
                <span class="modal-text">Cửa Hàng</span>
                <div style="position: absolute;top:55%;right:8%" class="row">
                    <li class="shop-icon-badge icon-badge row justify-content-between mr-4">
                        <div class="col-auto">
                            <div class="row">
                                <div class="col-auto">
                                    <img style="width:17px" src="{{ asset('assets/images/icon-pack/pvp-point.png') }}">
                                </div>
                                <div class="col-auto">
                                    <strong class="pixel-font small-font notranslate"> @{{ numberFormat(data.infor.pvp_points) }}</strong>
                                </div>
                            </div>
                        </div>
                        <div class="col-auto p-0">
                            <img style="width:17px" src="{{ asset('assets/images/icon/Question.png') }}">
                        </div>
                    </li>
                    <li class="shop-icon-badge icon-badge row justify-content-between mr-4">
                        <div class="col-auto">
                            <div class="row">
                                <div class="col-auto">
                                    <img style="width:17px" src="{{ asset('assets/images/icon-pack/gold.png') }}">
                                </div>
                                <div class="col-auto">
                                    <strong class="pixel-font small-font notranslate"> @{{ numberFormat(data.infor.coins) }}</strong>
                                </div>
                            </div>
                        </div>
                        <div class="col-auto p-0">
                            <img style="width:17px" src="{{ asset('assets/images/icon/Add.png') }}">
                        </div>
                    </li>
                    <li class="shop-icon-badge icon-badge row justify-content-between">
                        <div class="col-auto">
                            <div class="row">
                                <div class="col-auto">
                                    <img style="width:17px" src="{{ asset('assets/images/icon-pack/diamond.png') }}">
                                </div>
                                <div class="col-auto">
                                    <strong class="pixel-font small-font notranslate"> @{{ numberFormat(data.infor.gold) }}</strong>
                                </div>
                            </div>
                        </div>
                        <div class="col-auto p-0">
                            <img style="width:17px" src="{{ asset('assets/images/icon/Add.png') }}">
                        </div>
                    </li>
                </div>
                <button class="close" data-dismiss="modal">
                    <img style="width:30px" src="{{ asset('assets/images/icon/Close-Light.png') }}">
                </button>
            </div>
            <div class="modal-body">
                <div class="p-1">
                    <div class="p-1">
                        <div style="background: #f5efd9" class="p-1">
                            <div class="p-2" style="background: #554839">
                                <div style="padding:10px" class="row">
                                    <div class="col-lg-2 col-md-3 col-sm-12 shop-menu p-2" style="padding-top:10px !important">
                                        <div class="nav nav-pills list-item-responsive" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                                            <div @click="loadShop('item', true)" class="nav-link nav-link-white active" id="v-pills-item-tab" data-toggle="pill" href="#v-pills-item" role="tab" aria-controls="v-pills-item" aria-selected="true">
                                                <img width="25px" src="{{ asset('assets/images/icon/Shop-Item.png') }}" class="mr-2 align-middle"> Vật Phẩm
                                            </div>
                                            @foreach($menuShop as $menu)
                                                <div @click="loadShop('{{ str_slug($menu->name) }}', true)" class="nav-link nav-link-white" id="v-pills-equipment-tab" data-toggle="pill" href="#v-pills-equipment" role="tab" aria-controls="v-pills-equipment" aria-selected="false">
                                                    <img width="25px" src="{{ asset('assets/images/icon/Shop-Equipment.png') }}" class="mr-2 align-middle"> {{ $menu->name }}
                                                </div>
                                            @endforeach
                                            <div @click="loadShop('skill', true)" class="nav-link nav-link-white" id="v-pills-skill-tab" data-toggle="pill" href="#v-pills-skill" role="tab" aria-controls="v-pills-skill" aria-selected="true">
                                                <img width="25px" src="{{ asset('assets/images/icon/Skill.png') }}" class="mr-2 align-middle"> Kỹ Năng
                                            </div>
                                            <div @click="loadShop('pet', true)" class="nav-link nav-link-white" id="v-pills-pet-tab" data-toggle="pill" href="#v-pills-pet" role="tab" aria-controls="v-pills-pet" aria-selected="true">
                                                <img width="25px" src="{{ asset('assets/images/icon/Pet.png') }}" class="mr-2 align-middle"> Pet
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-10 col-md-9 col-sm-12 p-2">
                                        <div style="background-color: #554839;padding:0px" class="tab-content" id="v-pills-tabContent">
                                            <div class="tab-pane fade show active" id="v-pills-item" role="tabpanel" aria-labelledby="v-pills-item-tab">
                                                <div class="b-b">
                                                    <div class="nav-active-border b-primary bottom">
                                                        <ul class="nav" id="myTab" role="tablist">
                                                            <li @click="loadShop('item' ,true)" data-title="tooltip" title="Hot" class="nav-item">
                                                                <a class="nav-link active" id="hot-item-tab" data-toggle="tab" href="#hot-item-tab-control" role="tab" aria-controls="" aria-selected="true">
                                                                    Hot
                                                                </a>
                                                            </li>
                                                            <li @click="loadShop('item' ,true)" data-title="tooltip" title="Tất Cả" class="nav-item">
                                                                <a class="nav-link" id="total-item-tab" data-toggle="tab" href="#total-item-tab-control" role="tab" aria-controls="" aria-selected="true">
                                                                    Vật Phẩm
                                                                </a>
                                                            </li>
                                                            <li @click="loadShop('gems' , true)" data-title="tooltip" title="Đá Bổ Trợ" class="nav-item">
                                                                <a class="nav-link" id="gems-item-tab" data-toggle="tab" href="#gems-item-tab-control" role="tab" aria-controls="" aria-selected="true">
                                                                    Đá Bổ Trợ
                                                                </a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <div class="tab-content">
                                                    <div class="tab-pane fade show active" id="hot-item-tab-control" role="tabpanel" aria-labelledby="hot-item-tab">
                                                        <div class="row p-2">
                                                            <div class="p-1 col-12">
                                                                <div class="item-preview px-3 pt-3 shop-background pixel">
                                                                    @include('components.border')
                                                                    <img class="pixel" width="120px" src="{{ asset('assets/images/icon/Seller.png') }}">
                                                                </div>
                                                            </div>
                                                            <div class="p-1 col-12">
                                                                <div style="background: #33301d" class="item-preview">
                                                                    @include('components.border')
                                                                    <div style="max-height:330px;overflow:auto" class="row px-4 py-2">
                                                                        <div v-for="(item, index) in shop" :key="index" v-if="item.hot" class="col-ui col-ui-divide spotlight-item special-item">
                                                                            <img style="position: absolute;top:0;left:0;width:40px" src="{{ asset('assets/images/icon/Hot-Ribbon.png') }}">
                                                                            <img style="width:50px;display:block;margin:7px auto" src="{{ asset('assets/images/icon/Border-Top.png') }}">
                                                                            <p class="text-light text-center" style="font-size:13px">@{{ item.name }}</p>
                                                                            <div style="height:50px;display:block;margin:10% auto 80px auto;object-fit:contain;" @click="showInforItem(item ,0)" style="margin:0 auto !important" :class="`pixel ${item.class_tag}`"></div>
                                                                            <div @click="buyItem(item ,$event)" class="pixel-font text-warning small-font pixel-btn m-3 btn-dark mt-5 text-center" style="padding:6px">
                                                                                <img width="17px" class="mr-2" :src="asset(`assets/images/icon-pack/${getCurrency(item.price_type)}.png`)">@{{ numberFormatDetail(item.price) }}
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="tab-pane fade" id="total-item-tab-control" role="tabpanel" aria-labelledby="total-item-tab">
                                                        <div class="row p-2">
                                                            <div class="p-1 col-12">
                                                                <div class="item-preview px-3 pt-3 pixel shop-background">
                                                                    @include('components.border')
                                                                    <img class="pixel" width="120px" src="{{ asset('assets/images/icon/Seller.png') }}">
                                                                </div>
                                                            </div>
                                                            <div class="p-1 col-12">
                                                                <div style="background: #33301d" class="item-preview">
                                                                    @include('components.border')
                                                                    <div style="max-height:330px;overflow:auto" class="row px-4 py-2">
                                                                        <div v-for="(item, index) in shop" :key="index" class="col-ui col-ui-divide softlight-item item">
                                                                            <img style="width:50px;display:block;margin:7px auto" src="{{ asset('assets/images/icon/Border-Top.png') }}">
                                                                            <p class="text-light text-center" style="font-size:13px">@{{ item.name }}</p>
                                                                            <div class="mb-3" style="height:50px;display:block;margin:15% auto 0px auto;object-fit:contain;" @click="showInforItem(item ,0)" style="margin:0 auto !important" :class="`pixel ${item.class_tag}`"></div>
                                                                            <div @click="buyItem(item ,$event)" class="pixel-font text-warning small-font pixel-btn m-3 btn-dark mt-5 text-center" style="padding:6px">
                                                                                <img width="17px" class="mr-2" :src="asset(`assets/images/icon-pack/${getCurrency(item.price_type)}.png`)">@{{ numberFormatDetail(item.price) }}
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="tab-pane fade" id="gems-item-tab-control" role="tabpanel" aria-labelledby="gems-item-tab">
                                                        <div class="row p-2">
                                                            <div class="p-1 col-12">
                                                                <div class="item-preview px-3 pt-3 pixel shop-background">
                                                                    @include('components.border')
                                                                    <img class="pixel" width="120px" src="{{ asset('assets/images/icon/Seller.png') }}">
                                                                </div>
                                                            </div>
                                                            <div class="p-1 col-12">
                                                                <div style="background: #33301d" class="item-preview">
                                                                    @include('components.border')
                                                                    <div style="max-height:330px;overflow:auto" class="row px-4 py-2">
                                                                        <div v-for="(gem, index) in shop" :key="index" class="col-ui col-ui-divide softlight-item item">
                                                                            <img style="width:50px;display:block;margin:7px auto" src="{{ asset('assets/images/icon/Border-Top.png') }}">
                                                                            <p class="text-light text-center" style="font-size:13px">@{{ gem.name }}</p>
                                                                            <div class="mb-3" style="height:50px;display:block;margin:20% auto 0px auto;object-fit:contain;" @click="showGem(gem ,0)" style="margin:0 auto !important" :class="`pixel gem ${gem.image}`"></div>
                                                                            <div @click="buyGem(gem ,$event)" class="pixel-font text-warning small-font pixel-btn m-3 btn-dark mt-5 text-center" style="padding:6px">
                                                                                <img width="17px" class="mr-2" :src="asset(`assets/images/icon-pack/${getCurrency(gem.price_type)}.png`)">@{{ numberFormatDetail(gem.price) }}
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="tab-pane fade" id="v-pills-equipment" role="tabpanel" aria-labelledby="v-pills-equipment-tab">
                                                <div class="b-b">
                                                    <div class="nav-active-border b-primary bottom">
                                                        <ul class="nav" id="myTab" role="tablist">
                                                            @foreach($characters as $key => $character)
                                                            <li data-title="tooltip" title="{{ $character->name }}" class="nav-item">
                                                                <a class="nav-link {{ $character->id == Auth::user()->character->id ? 'active' : '' }}" id="character-{{ $character->avatar }}-tab" data-toggle="tab" href="#character-{{ $character->avatar }}-tab-control" role="tab" aria-controls="" aria-selected="true">
                                                                    <img class="pixel" style="width:20px;height:20px;object-fit:contain" src="{{ asset("assets/images/class/{$character->avatar}.png") }}">
                                                                </a>
                                                            </li>
                                                            @endforeach
                                                        </ul>
                                                    </div>
                                                </div>
                                                <div class="tab-content">
                                                    @foreach($characters as $key => $character)
                                                    <div class="tab-pane fade {{ $character->id == Auth::user()->character->id ? 'show active' : '' }}" id="character-{{ $character->avatar }}-tab-control" role="tabpanel" aria-labelledby="character-{{ $character->avatar }}-tab">
                                                        <div class="row p-2">
                                                            <div class="p-1 col-12">
                                                                <div class="item-preview px-3 pt-3 pixel shop-background">
                                                                    @include('components.border')
                                                                    <img class="pixel" width="120px" src="{{ asset('assets/images/icon/Seller.png') }}">
                                                                </div>
                                                            </div>
                                                            <div class="p-1 col-12">
                                                                <div style="background: #33301d" class="item-preview">
                                                                    @include('components.border')
                                                                    <div style="max-height:330px;overflow:auto" class="row px-4 py-2">
                                                                        <div v-for="(item, index) in shop.{{ $character->avatar }}" :key="index" class="col-ui col-ui-divide softlight-item item">
                                                                            <img style="width:50px;display:block;margin:7px auto" src="{{ asset('assets/images/icon/Border-Top.png') }}">
                                                                            <p class="text-light text-center" style="font-size:13px">@{{ item.name }}</p>
                                                                            <div @click="showGearsDescription(item, 0)" class="mb-3" style="height:50px;display:block;margin:15% auto 0px auto;object-fit:contain;" style="margin:0 auto !important" :class="`pixel ${item.shop_tag}`"></div>
                                                                            <div @click="buyEquip(item ,$event)" data-title="tooltip" title="Mua" class="pixel-font text-warning small-font pixel-btn m-3 btn-dark mt-5 text-center" style="padding:6px">
                                                                                <img width="17px" class="mr-2" :src="asset(`assets/images/icon-pack/${getCurrency(item.price_type)}.png`)">@{{ numberFormatDetail(item.price) }}
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                            <div class="tab-pane fade" id="v-pills-skill" role="tabpanel" aria-labelledby="v-pills-skill-tab">
                                                <div class="b-b">
                                                    <div class="nav-active-border b-primary bottom">
                                                        <ul class="nav" id="myTab" role="tablist">
                                                            @foreach($characters as $key => $character)
                                                            <li data-title="tooltip" title="{{ $character->name }}" class="nav-item">
                                                                <a class="nav-link {{ $character->id == Auth::user()->character->id ? 'active' : '' }}" id="character-skill-{{ $character->avatar }}-tab" data-toggle="tab" href="#character-skill-{{ $character->avatar }}-tab-control" role="tab" aria-controls="" aria-selected="true">
                                                                    <img class="pixel" style="width:20px;height:20px;object-fit:contain" src="{{ asset("assets/images/class/{$character->avatar}.png") }}">
                                                                </a>
                                                            </li>
                                                            @endforeach
                                                        </ul>
                                                    </div>
                                                </div>
                                                <div class="tab-content">
                                                    @foreach($characters as $key => $character)
                                                    <div class="tab-pane fade {{ $character->id == Auth::user()->character->id ? 'show active' : '' }}" id="character-skill-{{ $character->avatar }}-tab-control" role="tabpanel" aria-labelledby="character-skill-{{ $character->avatar }}-tab">
                                                        <div class="row p-2">
                                                            <div class="p-1 col-12">
                                                                <div class="item-preview px-3 pt-3 pixel shop-background">
                                                                    @include('components.border')
                                                                    <img class="pixel" width="120px" src="{{ asset('assets/images/icon/Seller.png') }}">
                                                                </div>
                                                            </div>
                                                            <div class="p-1 col-12">
                                                                <div style="background: #33301d" class="item-preview">
                                                                    @include('components.border')
                                                                    <div style="max-height:330px;overflow:auto" class="row px-4 py-2">
                                                                        <div v-for="(skill, index) in shop.{{ $character->avatar }}" :key="index" class="col-ui col-ui-divide softlight-item item">
                                                                            <img style="width:50px;display:block;margin:7px auto" src="{{ asset('assets/images/icon/Border-Top.png') }}">
                                                                            <p class="text-light text-center" style="font-size:13px">@{{ skill.name }}</p>
                                                                            <img :src="skill.image" @click="showSkillsDescription(skill, 0, skill.name)" class="mb-3" style="height:50px;display:block;margin:15% auto 0px auto;object-fit:contain;" style="margin:0 auto !important">
                                                                            <div @click="buySkill(skill ,$event)" data-title="tooltip" title="Mua" class="pixel-font text-warning small-font pixel-btn m-3 btn-dark mt-5 text-center" style="padding:6px">
                                                                                <img width="17px" class="mr-2" :src="asset(`assets/images/icon-pack/${getCurrency(skill.price_type)}.png`)">@{{ numberFormatDetail(skill.price) }}
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                            <div class="tab-pane fade" id="v-pills-pet" role="tabpanel" aria-labelledby="v-pills-pet-tab">
                                                <div class="b-b">
                                                    <div class="nav-active-border b-primary bottom">
                                                        <ul class="nav" id="myTab" role="tablist">
                                                            <li data-title="tooltip" title="Tất Cả" class="nav-item">
                                                                <a class="nav-link active" id="all-pet-tab" data-toggle="tab" href="#all-pet-tab-control" role="tab" aria-controls="" aria-selected="true">
                                                                    Tất Cả
                                                                </a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <div class="tab-content">
                                                    <div class="tab-pane fade show active" id="all-pet-tab-control" role="tabpanel" aria-labelledby="all-pet-tab">
                                                        <div class="row p-2">
                                                            <div class="p-1 col-12">
                                                                <div class="item-preview px-3 pt-3 shop-background pixel">
                                                                    @include('components.border')
                                                                    <img class="pixel" width="120px" src="{{ asset('assets/images/icon/Seller.png') }}">
                                                                </div>
                                                            </div>
                                                            <div class="p-1 col-12">
                                                                <div style="background: #33301d" class="item-preview">
                                                                    @include('components.border')
                                                                    <div style="max-height:330px;overflow:auto" class="row px-4 py-2">
                                                                        <div v-for="(pet, index) in shop" :key="index" class="col-ui col-ui-divide softlight-item item">
                                                                            <img style="width:50px;display:block;margin:7px auto" src="{{ asset('assets/images/icon/Border-Top.png') }}">
                                                                            <p class="text-light text-center" style="font-size:13px">@{{ pet.name }}</p>
                                                                            <div class="mb-3" style="height:75px;display:block;margin:15% auto 0px auto;object-fit:contain;" @click="showInforPet(pet ,0)" style="margin:0 auto !important" :class="`pixel Mount_Icon_${pet.class_tag}`"></div>
                                                                            <div @click="buyPet(pet ,$event)" class="pixel-font text-warning small-font pixel-btn m-3 btn-dark mt-5 text-center" style="padding:6px">
                                                                                <img width="17px" class="mr-2" :src="asset(`assets/images/icon-pack/${getCurrency(pet.price_type)}.png`)">@{{ numberFormatDetail(pet.price) }}
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
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <div data-dismiss="modal" class="btn-red pixel-btn mr-4">
                    Đóng <img style="width:16px" src="{{ asset('assets/images/icon/Close-White.png') }}">
                </div>
            </div>
        </div>
    </div>
</div>