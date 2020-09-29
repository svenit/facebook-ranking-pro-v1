<div v-if="data" style="z-index: 99999" class="modal fade modal-profile" id="user-modal-profile" data-backdrop="true">
    <div style="max-width:700px" class="modal-dialog modal-ui">
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
            <div class="modal-header">
                <border></border>
                <span class="modal-text">@{{ user.infor.name }}</span>
                <button class="close" data-dismiss="modal">
                    <img style="width:30px" src="{{ asset('assets/images/icon/Close-Light.png') }}">
                </button>
            </div>
            <div class="modal-body">
                <div class="py-3 px-2">
                    <div class="b-b">
                        <div class="nav-active-border b-primary bottom">
                            <ul class="nav" id="myTab" role="tablist">
                                <li data-title="tooltip" title="Cơ bản" class="nav-item">
                                    <a class="nav-link active" id="user-basic-tab" data-toggle="tab" href="#user-basic-tab-control" role="tab" aria-controls="" aria-selected="true">
                                        <img class="text-center pixel" style="width:20px;height:20px;object-fit:contain" src="{{ asset('assets/images/icon/Infor.png') }}">
                                    </a>
                                </li>
                                <li data-title="tooltip" title="Tổng quan" class="nav-item">
                                    <a class="nav-link" id="user-profile-tab" data-toggle="tab" href="#user-profile-tab-control" role="tab" aria-controls="" aria-selected="true">
                                        <img class="text-center pixel" style="width:20px;height:20px;object-fit:contain" src="{{ asset('assets/images/icon/Character.png') }}">
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="tab-content">
                        <div class="tab-pane fade show active" id="user-basic-tab-control" role="tabpanel" aria-labelledby="user-basic-tab">
                            <div class="row p-2">
                                <div class="p-1 col-12">
                                    <div style="background: #33301d" class="item-preview">
                                        <border></border>
                                        <div class="row p-3">
                                            <div class="col-lg-6 col-md-6 col-sm-12 mb-3">
                                                <div class="row">
                                                    <div class="col-3 pr-0">
                                                        <img class="pixel" style="position:absolute;width:62px" :src="asset(`assets/images/pvp-ranks/${user.rank.fame.icon}.png`)">
                                                        <img style="width:60px" class="circle mr-3" :src="`http://graph.facebook.com/${user.infor.provider_id}/picture?type=normal`" alt="...">
                                                    </div>
                                                    <div style="border-right: 2px solid #4c4534" class="pl-2 col-9">
                                                        <span class="pixel-font small-font pr-5" style="color:#37a8d8">LV@{{ user.level.current_level }}</span>
                                                        <div class="mt-1 mb-2" style="height: 3px;background:#534738">
                                                            <div :style="{width:user.level.percent + '%', height:'3px', backgroundColor: '#37a8d8'}"></div>
                                                        </div>
                                                        <span style="background:#544431;padding:3px 10px;border-radius:3px;font-size:12px;">
                                                            @{{ user.infor.name }}
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-sm-12 ui-center">
                                                <div class="ui-center-inside w-100 ml-2">
                                                    <div class="pixel-btn p-3 btn-brown">
                                                        <div class="row justify-content-between">
                                                            <div class="col-4">
                                                                <span style="font-size:16px !important">Danh Tiếng</span>
                                                            </div>
                                                            <div style="background:#524a3a;border-radius:3px" class="col-8">
                                                                <span style="font-size:12px" class="pixel-font text-warning">
                                                                    @{{ numberFormatDetail(user.infor.fame) }}
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="p-1 col-12">
                                    <div style="background: #d9c8a6">
                                        <div class="row px-3 py-0">
                                            <div class="col-ui spotlight-item item">
                                                <border></border>
                                                <img style="width:50px;display:block;margin:10px auto" src="{{ asset('assets/images/icon/Border-Top.png') }}">
                                                <p class="text-light pixel-font text-center" style="font-size:11px">Rank</p>
                                                <h2 class="text-center text-light pixel-font mb-3" style="height:50px">@{{ user.rank.brand }}</h2>
                                                <div class="pixel-btn m-3 btn-dark mt-5 text-center" style="padding:6px">
                                                    @{{ user.rank.brand }} Rank
                                                </div>
                                            </div>
                                            <div class="col-ui spotlight-item item">
                                                <border></border>
                                                <img style="width:50px;display:block;margin:10px auto" src="{{ asset('assets/images/icon/Border-Top.png') }}">
                                                <p class="text-light pixel-font text-center" style="font-size:11px">PVP</p>
                                                <img class="mb-3" style="width:50px;height:50px;display:block;margin:0 auto" :src="asset(`assets/images/icon/${user.rank.pvp.group}.png`)">
                                                <div class="pixel-btn m-3 btn-dark mt-5 text-center" style="padding:6px">
                                                    @{{ user.rank.pvp.name }}
                                                </div>
                                            </div>
                                            <div class="col-ui spotlight-item item">
                                                <border></border>
                                                <img style="width:50px;display:block;margin:10px auto" src="{{ asset('assets/images/icon/Border-Top.png') }}">
                                                <p class="text-light pixel-font text-center" style="font-size:11px">Top LC</p>
                                                <img class="mb-3" style="width:50px;height:50px;display:block;margin:0 auto;object-fit:contain" src="{{ asset('assets/images/icon/Rank.png') }}">
                                                <div class="pixel-btn m-3 btn-dark mt-5 text-center" style="padding:6px">
                                                    Top @{{ user.top.power }}
                                                </div>
                                            </div>
                                            <div class="col-ui spotlight-item item">
                                                <border></border>
                                                <img style="width:50px;display:block;margin:10px auto" src="{{ asset('assets/images/icon/Border-Top.png') }}">
                                                <p class="text-light pixel-font text-center" style="font-size:11px">Top Level</p>
                                                <img class="mb-3" style="width:50px;height:50px;display:block;margin:0 auto;object-fit:contain" src="{{ asset('assets/images/icon/Red-Crown.png') }}">
                                                <div class="pixel-btn m-3 btn-dark mt-5 text-center" style="padding:6px">
                                                    Top @{{ user.top.level }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="user-profile-tab-control" role="tabpanel" aria-labelledby="user-profile-tab">
                            <div class="row p-2">
                                <div class="p-1 col-lg-6 col-md-6 col-sm-12">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="item-preview" style="height: 222px;">
                                                <img style="position: absolute; right: 5%;width: 40px" class="pixel" src="{{ asset('assets/images/icon/Dark-Badge.png') }}">
                                                <img class="pixel" data-title="tooltip" :title="user.infor.character.name" style="position: absolute; right: 7.5%;width:25px;" :src="asset(`assets/images/class/${user.infor.character.avatar}-icon.png`)">
                                                <border></border>
                                                <div style="margin:30px auto;position:relative;right:-15px;transform:scaleX(-1)" class="character-sprites hoverable">
                                                    <span v-if="user.pet" :class="`Mount_Body_${user.pet.class_tag}`"></span>
                                                    <span style="z-index:2" class="skin_f5a76e up-to-down"></span>
                                                    <span style="z-index:2" class="broad_shirt_black up-to-down"></span>
                                                    <span style="z-index:2" class="head_0 up-to-down"></span>
                                                    <span class=""></span>
                                                    <span v-for="(gear,index) in user.gears" :key="index">
                                                        <span v-if="gear.class_tag.includes(' ')" v-for="e in gear.class_tag.split(' ')" :class="`${e} ${gear.cates.animation} up-to-down`" :style="{zIndex:gear.cates.z_index}"></span>
                                                        <span v-else :class="`${gear.class_tag} ${gear.cates.animation} up-to-down`" :style="{zIndex:gear.cates.z_index}"></span>
                                                    </span>
                                                    <span v-if="user.pet" style="z-index:50" :class="`Mount_Head_${user.pet.class_tag}`"></span>
                                                </div>
                                                <div style="margin-bottom:60px" v-if="user.pet"></div>
                                                <div class="footer" style="bottom: 0;position: absolute;width: 100%;">
                                                    <div style="font-size:15px" class="modal-text item-name modal-title text-md text-center">
                                                        <img style="width:17px; height:17px;transform:scaleX(-1)" class="mr-1 pixel" src="{{ asset('assets/images/icon/Bar.png') }}">
                                                        <span class="text-light">@{{ user.infor.name }}</span>
                                                        <img style="width:17px; height:17px" class="ml-1 pixel" src="{{ asset('assets/images/icon/Bar.png') }}">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12 mt-2">
                                            <div style="position: relative;">
                                                <border></border>
                                                <div style="height:158px;background:#514a38" class="item-description">
                                                    <img style="width:50px;display:block;margin:10px auto" src="{{ asset('assets/images/icon/Border-Top.png') }}">
                                                    <div class="row row-sm p-3">
                                                        <div v-for="(gear,index) in user.gears" :key="index" style="margin-bottom:15px" class="col-3 d-flex" data-title="tooltip" title="Click để xem chi tiết" >
                                                            <div class="flex">
                                                                <div @click="showGearsDescription(gear,1)" style="background-color: #2f2d21;border-radius: 50%;" :class="[`pixel text-center ${gear.shop_tag}`]">
                                                                    <img class="pixel" style="width: 70px;" src="{{ asset('assets/images/icon/Equipment-Frame.png') }}">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div v-for="n in parseInt(8 - user.gears.length)" :key="n + Math.random(1,10)" style="margin-bottom:15px" class="col-3 d-flex">
                                                            <div class="flex">
                                                                <div style="background-color: #2f2d21;border-radius: 50%;width:68px;height:68px" class="pixel text-center">
                                                                    <img class="pixel" style="width: 70px;" src="{{ asset('assets/images/icon/Equipment-Frame.png') }}">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="p-1 col-lg-6 col-md-6 col-sm-12 notranslate">
                                    <div class="stats-preview">
                                        <border></border>
                                        <div class="item">
                                            <div class="flex">
                                                <div class="text-silver row justify-content-between">
                                                    <div class="col-auto pixel-font small-font">Level</div>
                                                    <div class="col-auto"><strong class="text-warning pixel-font small-font">LV@{{ user.level.current_level }} ( @{{ user.level.percent }} % )</strong></div>
                                                </div>
                                                <div @click="notify(`${user.infor.name} cần ${numberFormatDetail(user.level.next_level_exp - user.level.current_user_exp)} kinh nghiệm nữa để lên cấp`)" class="progress my-3 circle" style="height:12px;border-radius:0px;">
                                                    <div class="progress-bar pixel-font" style="background:#ffdd44;border-radius:0px;color:#333;height:12px" data-title="tooltip" :title="`${user.infor.name} cần ${numberFormatDetail(user.level.next_level_exp - user.level.current_user_exp)} kinh nghiệm nữa để lên cấp`" :style="{width:user.level.percent + '%'}">
                                                        <span style="font-size:6px;margin-bottom:3px">@{{ user.level.current_user_exp }}/@{{ user.level.next_level_exp }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="item mt-2">
                                            <div class="flex">
                                                <div class="text-silver row justify-content-between">
                                                    <div class="col-auto pixel-font small-font">Class</div>
                                                    <div class="col-auto">
                                                        <img class="pixel" style="width:25px;" :src="asset(`assets/images/class/${user.infor.character.avatar}-icon.png`)">
                                                        <strong class="text-warning pixel-font small-font">
                                                            @{{ user.infor.character.name }}
                                                        </strong>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="item mt-2">
                                            <div class="flex">
                                                <div class="text-silver row justify-content-between">
                                                    <div data-title="tooltip" title="Sinh lực" class="col-auto pixel-font small-font">HP</div>
                                                    <div class="col-auto"><strong class="text-warning pixel-font small-font">@{{ user.power.hp }} ( <span class="text-gold">@{{ user.raw_power.hp }}</span> + <span class="text-success">@{{ user.power.hp - user.raw_power.hp }} )</span></strong></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="item mt-2">
                                            <div class="flex">
                                                <div class="text-silver row justify-content-between">
                                                    <div data-title="tooltip" title="Sát thương vật lý" class="col-auto pixel-font small-font">STR</div>
                                                    <div class="col-auto"><strong class="text-warning pixel-font small-font">@{{ user.power.strength }} ( <span class="text-gold">@{{ user.raw_power.strength }}</span> + <span class="text-success">@{{ user.power.strength - user.raw_power.strength }} )</span></strong></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="item mt-2">
                                            <div class="flex">
                                                <div class="text-silver row justify-content-between">
                                                    <div data-title="tooltip" title="Sát thương phép thuật" class="col-auto pixel-font small-font">INT</div>
                                                    <div class="col-auto"><strong class="text-warning pixel-font small-font">@{{ user.power.intelligent }} ( <span class="text-gold">@{{ user.raw_power.intelligent }}</span> + <span class="text-success">@{{ user.power.intelligent - user.raw_power.intelligent }} )</span></strong></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="item mt-2">
                                            <div class="flex">
                                                <div class="text-silver row justify-content-between">
                                                    <div data-title="tooltip" title="Nhanh nhẹn" class="col-auto pixel-font small-font">AGI</div>
                                                    <div class="col-auto"><strong class="text-warning pixel-font small-font">@{{ user.power.agility }} ( <span class="text-gold">@{{ user.raw_power.agility }}</span> + <span class="text-success">@{{ user.power.agility - user.raw_power.agility }} )</span></strong></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="item mt-2">
                                            <div class="flex">
                                                <div class="text-silver row justify-content-between">
                                                    <div data-title="tooltip" title="May mắn" class="col-auto pixel-font small-font">LUK</div>
                                                    <div class="col-auto"><strong class="text-warning pixel-font small-font">@{{ user.power.lucky }} ( <span class="text-gold">@{{ user.raw_power.lucky }}</span> + <span class="text-success">@{{ user.power.lucky - user.raw_power.lucky }} )</span></strong></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="item mt-2">
                                            <div class="flex">
                                                <div class="text-silver row justify-content-between">
                                                    <div data-title="tooltip" title="Kháng sát thương vật lý" class="col-auto pixel-font small-font">DEF</div>
                                                    <div class="col-auto"><strong class="text-warning pixel-font small-font">@{{ user.power.armor_strength }} ( <span class="text-gold">@{{ user.raw_power.armor_strength }}</span> + <span class="text-success">@{{ user.power.armor_strength - user.raw_power.armor_strength }} )</span></strong></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="item mt-2">
                                            <div class="flex">
                                                <div class="text-silver row justify-content-between">
                                                    <div data-title="tooltip" title="Kháng phép" class="col-auto pixel-font small-font">AM</div>
                                                    <div class="col-auto"><strong class="text-warning pixel-font small-font">@{{ user.power.armor_intelligent }} ( <span class="text-gold">@{{ user.raw_power.armor_intelligent }}</span> + <span class="text-success">@{{ user.power.armor_intelligent - user.raw_power.armor_intelligent }} )</span></strong></div>
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