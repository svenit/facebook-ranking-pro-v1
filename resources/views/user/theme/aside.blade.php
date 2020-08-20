@auth
<div v-if="data" class="modal fade modal-left" data-backdrop="true">
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
                @include('components.border')
                <span class="modal-text">Nhân Vật</span>
                <button class="close" data-dismiss="modal">
                    <img style="width:20px" src="{{ asset('assets/images/icon/Close.png') }}">
                </button>
            </div>
            <div class="modal-body">
                <div class="p-3">
                    <div class="b-b">
                        <div class="nav-active-border b-primary bottom">
                            <ul class="nav" id="myTab" role="tablist">
                                <li data-title="tooltip" title="Tổng quan" class="nav-item">
                                    <a class="nav-link active" id="profile-tab" data-toggle="tab" href="#profile-tab-control" role="tab" aria-controls="" aria-selected="true">
                                        <img class="text-center" style="width:20px;height:20px;object-fit:contain" src="{{ asset('assets/images/icon/Character.png') }}">
                                    </a>
                                </li>
                                <li data-title="tooltip" title="Chỉ số sức mạnh" class="nav-item">
                                    <a class="nav-link" id="skill-tab" data-toggle="tab" href="#skill-tab-control" role="tab" aria-controls="" aria-selected="true">
                                        <img class="text-center" style="width:20px;height:20px;object-fit:contain" src="{{ asset('assets/images/icon/Stats.png') }}">
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="skill-tab" data-toggle="tab" href="#skill-tab-control" role="tab" aria-controls="" aria-selected="true">
                                        <img class="text-center" style="width:20px;height:20px;object-fit:contain" src="{{ asset('assets/images/icon/Skill.png') }}">
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="tab-content">
                        <div class="tab-pane fade show active" id="profile-tab-control" role="tabpanel" aria-labelledby="profile-tab">
                            <div class="row">
                                <div class="pr-1 col-lg-6 col-md-6 col-sm-12">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="item-preview">
                                                <img style="position: absolute; right: 5%;width: 40px" class="pixel" src="{{ asset('assets/images/icon/Dark-Badge.png') }}">
                                                <img class="pixel" data-title="tooltip" :title="data.infor.character.name" style="position: absolute; right: 7.5%;width:25px;" :src="asset(`assets/images/class/${data.infor.character.avatar}-icon.png`)">
                                                @include('components.border')
                                                <div style="margin:0 auto;position:relative;right:-15px;transform:scaleX(-1)" class="character-sprites hoverable">
                                                    <span v-if="data.pet" :class="`Mount_Body_${data.pet.class_tag}`"></span>
                                                    <span style="z-index:2" class="skin_f5a76e up-to-down"></span>
                                                    <span style="z-index:2" class="broad_shirt_black up-to-down"></span>
                                                    <span style="z-index:2" class="head_0 up-to-down"></span>
                                                    <span class=""></span>
                                                    <span v-for="(gear,index) in data.gears" :key="index">
                                                        <span v-if="gear.class_tag.includes(' ')" v-for="e in gear.class_tag.split(' ')" :class="`${e} ${gear.cates.animation} up-to-down`" :style="{zIndex:gear.cates.z_index}"></span>
                                                        <span v-else :class="`${gear.class_tag} ${gear.cates.animation} up-to-down`" :style="{zIndex:gear.cates.z_index}"></span>
                                                    </span>
                                                    <span v-if="data.pet" style="z-index:50" :class="`Mount_Head_${data.pet.class_tag}`"></span>
                                                </div>
                                                <div style="margin-bottom:60px" v-if="data.pet"></div>
                                                <div class="normal-badge">
                                                    <img class="pixel" src="{{ asset('assets/images/icon/Normal-Badge.png') }}">
                                                    <span data-title="tooltip" :title="`${data.rank.brand} Rank`" class="pixel-font small-font">@{{ data.rank.brand }}</span>
                                                </div>
                                                <div class="footer">
                                                    <div style="font-size:15px" class="modal-text item-name modal-title text-md text-center">
                                                        <img style="width:17px; height:17px;transform:scaleX(-1)" class="mr-1 pixel" src="{{ asset('assets/images/icon/Bar.png') }}">
                                                        @{{ data.infor.name }}
                                                        <img style="width:17px; height:17px" class="ml-1 pixel" src="{{ asset('assets/images/icon/Bar.png') }}">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12 mt-2">
                                            <div style="position: relative;">
                                                @include('components.border')
                                                <div style="height:158px;background:#212121" class="item-description">
                                                    <img style="width:50px;display:block;margin:10px auto" src="{{ asset('assets/images/icon/Border-Top.png') }}">
                                                    <div class="row row-sm p-3">
                                                        <div v-for="(gear,index) in data.gears" :key="index" style="margin-bottom:15px" class="col-3 d-flex" data-title="tooltip" title="Click để xem chi tiết" >
                                                            <div class="flex">
                                                                <div @click="showGearsDescription(gear,1)" style="background-color: #292828;border-radius: 50%;" :class="[`pixel text-center ${gear.shop_tag}`]">
                                                                    <img class="pixel" style="width: 70px;" src="{{ asset('assets/images/icon/Item-Frame.png') }}">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div v-for="n in parseInt(8 - data.gears.length)" :key="n + Math.random(1,10)" style="margin-bottom:15px" class="col-3 d-flex">
                                                            <div class="flex">
                                                                <div style="background-color: #292828;border-radius: 50%;" class="pixel text-center">
                                                                    <img class="pixel" style="width: 70px;" src="{{ asset('assets/images/icon/Item-Frame.png') }}">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="pl-1 col-lg-6 col-md-6 col-sm-12 notranslate">
                                    <div class="stats-preview">
                                        @include('components.border')
                                        <div class="item">
                                            <div class="flex">
                                                <div class="text-silver row justify-content-between">
                                                    <div class="col-auto pixel-font small-font">Level</div>
                                                    <div class="col-auto"><strong class="text-warning pixel-font small-font">LV@{{ data.level.current_level }} ( @{{ data.level.percent }} % )</strong></div>
                                                </div>
                                                <div @click="notify(`Bạn cần ${numberFormatDetail(data.level.next_level_exp - data.level.current_user_exp)} kinh nghiệm nữa để lên cấp`)" class="progress my-3 circle" style="height:12px;border-radius:0px;">
                                                    <div class="progress-bar pixel-font" style="background:#ffdd44;border-radius:0px;color:#333;height:12px" data-title="tooltip" :title="`Bạn cần ${numberFormatDetail(data.level.next_level_exp - data.level.current_user_exp)} kinh nghiệm nữa để lên cấp`" :style="{width:data.level.percent + '%'}">
                                                        <span style="font-size:6px;margin-bottom:3px">@{{ data.level.next_level_exp }}/@{{ data.level.current_user_exp }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="item mt-2">
                                            <div class="flex">
                                                <div class="text-silver row justify-content-between">
                                                    <div class="col-auto pixel-font small-font">Class</div>
                                                    <div class="col-auto">
                                                        <img class="pixel" style="width:25px;" :src="asset(`assets/images/class/${data.infor.character.avatar}-icon.png`)">
                                                        <strong class="text-warning pixel-font small-font">
                                                            @{{ data.infor.character.name }}
                                                        </strong>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="item mt-2">
                                            <div class="flex">
                                                <div class="text-silver row justify-content-between">
                                                    <div data-title="tooltip" title="Sinh lực" class="col-auto pixel-font small-font">HP</div>
                                                    <div class="col-auto"><strong class="text-warning pixel-font small-font">@{{ data.raw_power.hp }} <span class="text-success">( +@{{ data.power.hp - data.raw_power.hp }} )</span></strong></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="item mt-2">
                                            <div class="flex">
                                                <div class="text-silver row justify-content-between">
                                                    <div data-title="tooltip" title="Sát thương vật lý" class="col-auto pixel-font small-font">STR</div>
                                                    <div class="col-auto"><strong class="text-warning pixel-font small-font">@{{ data.raw_power.strength }} <span class="text-success">( +@{{ data.power.strength - data.raw_power.strength }} )</span></strong></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="item mt-2">
                                            <div class="flex">
                                                <div class="text-silver row justify-content-between">
                                                    <div data-title="tooltip" title="Sát thương phép thuật" class="col-auto pixel-font small-font">INT</div>
                                                    <div class="col-auto"><strong class="text-warning pixel-font small-font">@{{ data.raw_power.intelligent }} <span class="text-success">( +@{{ data.power.intelligent - data.raw_power.intelligent }} )</span></strong></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="item mt-2">
                                            <div class="flex">
                                                <div class="text-silver row justify-content-between">
                                                    <div data-title="tooltip" title="Nhanh nhẹn" class="col-auto pixel-font small-font">AGI</div>
                                                    <div class="col-auto"><strong class="text-warning pixel-font small-font">@{{ data.raw_power.agility }} <span class="text-success">( +@{{ data.power.agility - data.raw_power.agility }} )</span></strong></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="item mt-2">
                                            <div class="flex">
                                                <div class="text-silver row justify-content-between">
                                                    <div data-title="tooltip" title="May mắn" class="col-auto pixel-font small-font">LUK</div>
                                                    <div class="col-auto"><strong class="text-warning pixel-font small-font">@{{ data.raw_power.lucky }} <span class="text-success">( +@{{ data.power.lucky - data.raw_power.lucky }} )</span></strong></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="item mt-2">
                                            <div class="flex">
                                                <div class="text-silver row justify-content-between">
                                                    <div data-title="tooltip" title="Kháng sát thương vật lý" class="col-auto pixel-font small-font">DEF</div>
                                                    <div class="col-auto"><strong class="text-warning pixel-font small-font">@{{ data.raw_power.armor_strength }} <span class="text-success">( +@{{ data.power.armor_strength - data.raw_power.armor_strength }} )</span></strong></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="item mt-2">
                                            <div class="flex">
                                                <div class="text-silver row justify-content-between">
                                                    <div data-title="tooltip" title="Kháng phép" class="col-auto pixel-font small-font">AM</div>
                                                    <div class="col-auto"><strong class="text-warning pixel-font small-font">@{{ data.raw_power.armor_intelligent }} <span class="text-success">( +@{{ data.power.armor_intelligent - data.raw_power.armor_intelligent }} )</span></strong></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="skill-tab-control" role="tabpanel" aria-labelledby="skill-tab">
                            <div class="row">
                                <div class="col-12 mb-1">
                                    <div class="item-preview">
                                        @include('components.border')
                                        <p class="px-3 pt-3">Tăng điểm chỉ số sức mạnh của bạn</p>
                                    </div>
                                </div>
                                <div class="pr-1 col-lg-6 col-md-6 col-sm-12">
                                    <div style="background: #343521;" class="item-preview">
                                        <img style="position: absolute; right: 5%;width: 40px" class="pixel" src="{{ asset('assets/images/icon/Dark-Badge.png') }}">
                                        <img class="pixel" data-title="tooltip" :title="data.infor.character.name" style="position: absolute; right: 7.5%;width:25px;" :src="asset(`assets/images/class/${data.infor.character.avatar}-icon.png`)">
                                        @include('components.border')
                                        <img width="60%" style="display:block;margin:0 auto" src="{{ asset('assets/images/icon/Stats-Point.png') }}">
                                        <div class="normal-badge" style="margin-bottom:5rem">
                                            <img style="width:150px;height:60px" src="{{ asset('assets/images/icon/Red-Ribon.png') }}" class="pixel">
                                            <span data-title="tooltip" title="Điểm chỉ số dư" style="top:18px" class="text-light pixel-font small-font">
                                                @{{ data.stats.available }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="pl-1 col-lg-6 col-md-6 col-sm-12 notranslate">
                                    <div class="stats-preview">
                                        @include('components.border')
                                        <div class="item mt-2">
                                            <div class="flex">
                                                <div class="text-silver row justify-content-between">
                                                    <div data-title="tooltip" title="Sinh lực" class="col-auto pixel-font small-font">HP</div>
                                                    <div class="col-auto">
                                                        <strong class="text-warning pixel-font small-font">
                                                            @{{ data.stats.data.health_points }}
                                                            <span class="text-success">( x3 )</span>
                                                        </strong>
                                                        <img @click="incrementStat('health_points')" style="width:17px" class="ml-2" src="{{ asset('assets/images/icon/Add.png') }}">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="item mt-2">
                                            <div class="flex">
                                                <div class="text-silver row justify-content-between">
                                                    <div data-title="tooltip" title="Sát thương vật lý" class="col-auto pixel-font small-font">STR</div>
                                                    <div class="col-auto">
                                                        <strong class="text-warning pixel-font small-font">
                                                            @{{ data.stats.data.strength }}
                                                            <span class="text-success">( x1.5 )</span>
                                                        </strong>
                                                        <img @click="incrementStat('strength')" style="width:17px" class="ml-2" src="{{ asset('assets/images/icon/Add.png') }}">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="item mt-2">
                                            <div class="flex">
                                                <div class="text-silver row justify-content-between">
                                                    <div data-title="tooltip" title="Sát thương phép thuật" class="col-auto pixel-font small-font">INT</div>
                                                    <div class="col-auto">
                                                        <strong class="text-warning pixel-font small-font">
                                                            @{{ data.stats.data.intelligent }}
                                                            <span class="text-success">( x1.5 )</span>
                                                        </strong>
                                                        <img @click="incrementStat('intelligent')" style="width:17px" class="ml-2" src="{{ asset('assets/images/icon/Add.png') }}">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="item mt-2">
                                            <div class="flex">
                                                <div class="text-silver row justify-content-between">
                                                    <div data-title="tooltip" title="Nhanh nhẹn" class="col-auto pixel-font small-font">AGI</div>
                                                    <div class="col-auto">
                                                        <strong class="text-warning pixel-font small-font">
                                                            @{{ data.stats.data.agility }}
                                                            <span class="text-success">( x1 )</span>
                                                        </strong>
                                                        <img @click="incrementStat('agility')" style="width:17px" class="ml-2" src="{{ asset('assets/images/icon/Add.png') }}">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="item mt-2">
                                            <div class="flex">
                                                <div class="text-silver row justify-content-between">
                                                    <div data-title="tooltip" title="May mắn" class="col-auto pixel-font small-font">LUK</div>
                                                    <div class="col-auto">
                                                        <strong class="text-warning pixel-font small-font">
                                                            @{{ data.stats.data.lucky }}
                                                            <span class="text-success">( x1 )</span>
                                                        </strong>
                                                        <img @click="incrementStat('lucky')" style="width:17px" class="ml-2" src="{{ asset('assets/images/icon/Add.png') }}">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="item mt-2">
                                            <div class="flex">
                                                <div class="text-silver row justify-content-between">
                                                    <div data-title="tooltip" title="Kháng sát thương vật lý" class="col-auto pixel-font small-font">DEF</div>
                                                    <div class="col-auto">
                                                        <strong class="text-warning pixel-font small-font">
                                                            @{{ data.stats.data.armor_strength }} 
                                                            <span class="text-success">( x1 )</span>
                                                        </strong>
                                                        <img @click="incrementStat('armor_strength')" style="width:17px" class="ml-2" src="{{ asset('assets/images/icon/Add.png') }}">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="item mt-2">
                                            <div class="flex">
                                                <div class="text-silver row justify-content-between">
                                                    <div data-title="tooltip" title="Kháng phép" class="col-auto pixel-font small-font">AM</div>
                                                    <div class="col-auto">
                                                        <strong class="text-warning pixel-font small-font">
                                                            @{{ data.stats.data.armor_intelligent }}
                                                            <span class="text-success">( x1 )</span>
                                                         </strong>
                                                        <img @click="incrementStat('armor_intelligent')" style="width:17px" class="ml-2" src="{{ asset('assets/images/icon/Add.png') }}">
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
@endauth
<div id="gear" v-if="detailGear.data" class="modal fade gear top-off" data-backdrop="true" aria-hidden="true" style="display: none;">
    <div style="max-width:700px" class="modal-dialog modal-ui">
        <div class="lighting-box modal-content">
            <div style="position: relative;" class="modal-header">
                @include('components.border')
                <span class="modal-text">Trang Bị</span>
                <button class="close" data-dismiss="modal">
                    <img style="width:20px" src="{{ asset('assets/images/icon/Close.png') }}">
                </button>
            </div>
            <div class="modal-body">
                <div class="p-3">
                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <div class="row">
                                <div class="col-12">
                                    <div class="item-preview">
                                        <span style="padding:10px;font-weight:bold">[ @{{ detailGear.data.cates.name }} ]</span>
                                        <img style="position: absolute; right: 5%;width: 40px" class="pixel" src="{{ asset('assets/images/icon/Dark-Badge.png') }}">
                                        <img class="pixel" style="position: absolute; right: 7.5%;width:25px;" :src="asset(`assets/images/class/${detailGear.data.character.avatar}-icon.png`)">
                                        @include('components.border')
                                        <div style="margin:42px auto;background-color: #554334;border-radius: 50%;" :class="[`pixel text-center ${detailGear.data.shop_tag}`]">
                                            <img class="pixel" style="width: 70px;" src="{{ asset('assets/images/icon/Item-Frame.png') }}">
                                        </div>
                                        <div class="normal-badge">
                                            <img class="pixel" src="{{ asset('assets/images/icon/Normal-Badge.png') }}">
                                            <span class="pixel-font small-font">0</span>
                                        </div>
                                        <div class="footer">
                                            <div style="font-size:15px" class="modal-text item-name modal-title text-md text-center">
                                                <img style="width:17px; height:17px;transform:scaleX(-1)" class="mr-1 pixel" src="{{ asset('assets/images/icon/Bar.png') }}">
                                                @{{ detailGear.data.name }}
                                                <img style="width:17px; height:17px" class="ml-1 pixel" src="{{ asset('assets/images/icon/Bar.png') }}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 mt-2">
                                    <div class="item-description">
                                        @include('components.border')
                                        <img style="width:50px;display:block;margin:10px auto" src="{{ asset('assets/images/icon/Border-Top.png') }}">
                                        <p style="color:#706753;font-size:12px;margin:10px">@{{ detailGear.data.description ?? 'Không có mô tả nào về trang bị này' }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12 notranslate">
                            <div class="stats-preview">
                                @include('components.border')
                                <div class="item">
                                    <div class="flex">
                                        <div class="text-silver row justify-content-between">
                                            <div data-title="tooltip" title="Cấp độ yêu cầu" class="col-auto pixel-font small-font">Level</div>
                                            <div class="col-auto"><strong class="text-warning pixel-font small-font">LV@{{ detailGear.data.level_required }}</strong></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="item mt-2">
                                    <div class="flex">
                                        <div class="text-silver row justify-content-between">
                                            <div data-title="tooltip" title="Sinh lực" class="col-auto pixel-font small-font">HP</div>
                                            <div class="col-auto"><strong class="text-warning pixel-font small-font">@{{ detailGear.data.health_points.default }} <span class="text-success">( +@{{ detailGear.data.health_points.percent }}% )</span></strong></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="item mt-2">
                                    <div class="flex">
                                        <div class="text-silver row justify-content-between">
                                            <div data-title="tooltip" title="Sát thương vật lý" class="col-auto pixel-font small-font">STR</div>
                                            <div class="col-auto"><strong class="text-warning pixel-font small-font">@{{ detailGear.data.strength.default }} <span class="text-success">( +@{{ detailGear.data.strength.percent }}% )</span></strong></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="item mt-2">
                                    <div class="flex">
                                        <div class="text-silver row justify-content-between">
                                            <div data-title="tooltip" title="Sát thương phép thuật" class="col-auto pixel-font small-font">INT</div>
                                            <div class="col-auto"><strong class="text-warning pixel-font small-font">@{{ detailGear.data.intelligent.default }} <span class="text-success">( +@{{ detailGear.data.intelligent.percent }}% )</span></strong></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="item mt-2">
                                    <div class="flex">
                                        <div class="text-silver row justify-content-between">
                                            <div data-title="tooltip" title="Nhanh nhẹn" class="col-auto pixel-font small-font">AGI</div>
                                            <div class="col-auto"><strong class="text-warning pixel-font small-font">@{{ detailGear.data.agility.default }} <span class="text-success">( +@{{ detailGear.data.agility.percent }}% )</span></strong></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="item mt-2">
                                    <div class="flex">
                                        <div class="text-silver row justify-content-between">
                                            <div data-title="tooltip" title="May mắn" class="col-auto pixel-font small-font">LUK</div>
                                            <div class="col-auto"><strong class="text-warning pixel-font small-font">@{{ detailGear.data.lucky.default }} <span class="text-success">( +@{{ detailGear.data.lucky.percent }}% )</span></strong></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="item mt-2">
                                    <div class="flex">
                                        <div class="text-silver row justify-content-between">
                                            <div data-title="tooltip" title="Kháng sát thương vật lý" class="col-auto pixel-font small-font">DEF</div>
                                            <div class="col-auto"><strong class="text-warning pixel-font small-font">@{{ detailGear.data.armor_strength.default }} <span class="text-success">( +@{{ detailGear.data.armor_strength.percent }}% )</span></strong></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="item mt-2">
                                    <div class="flex">
                                        <div class="text-silver row justify-content-between">
                                            <div data-title="tooltip" title="Kháng phép" class="col-auto pixel-font small-font">AM</div>
                                            <div class="col-auto"><strong class="text-warning pixel-font small-font">@{{ detailGear.data.armor_intelligent.default }} <span class="text-success">( +@{{ detailGear.data.armor_intelligent.percent }}% )</span></strong></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="item mt-2">
                                    <div class="row mx-1" v-if="detailGear.permission == 1">
                                        <div v-for="(gem, index) in detailGear.data.gems" :key="index" style="padding:5px" class="col-auto">
                                            <div style="background-color: #554334;border-radius: 50%;" @click="showGem(gem, detailGear.permission)" :class="`gem ${gem.gem_item.image}`">
                                                <img class="pixel" style="width: 50px;" src="{{ asset('assets/images/icon/Gem-Frame.png') }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mx-1" v-else>
                                        <div v-for="n in 4" :key="n" style="padding:5px" class="col-auto">
                                            <div style="background-color: #554334;border-radius: 50%;" class="">
                                                <img class="pixel" style="width: 50px;" src="{{ asset('assets/images/icon/Gem-Frame.png') }}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div v-if="detailGear.permission == 1" class="modal-footer">
                <div v-if="detailGear.data.pivot.status == 0" type="button" @click="equipment(detailGear.data)" class="btn-green pixel-btn mr-4" data-dismiss="modal">
                    Trang bị <img style="width:16px" src="{{ asset('assets/images/icon/Equip.png') }}">
                </div>
                <div v-else type="button" @click="removeEquipment(detailGear.data)" class="btn-yellow pixel-btn mr-4">
                    Tháo <img style="width:16px" src="{{ asset('assets/images/icon/Unequip.png') }}">
                </div>
                <div @click="deleteEquipment(detailGear.data)" class="btn-red pixel-btn mr-4">
                    Vứt Bỏ <img style="width:16px" src="{{ asset('assets/images/icon/Delete.png') }}">
                </div>
                <div data-dismiss="modal" class="btn-red pixel-btn mr-4">
                    Đóng <img style="width:16px" src="{{ asset('assets/images/icon/Close-White.png') }}">
                </div>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
</div>
<div id="gem" v-if="detailGem.data" class="modal fade gear top-off" data-backdrop="true" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content bg-dark">
            <div class="modal-header">
                <button class="close" data-dismiss="modal">×</button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-4">
                        <center>
                            <div :class="`pixel text-center gem ${detailGem.data.image}`" :style="{border:`1px solid ${detailGem.data.rgb}`,margin:'0 auto'}" width="60px"></div>
                        </center>
                        <p :style="{fontSize:'14px',color:`${detailGem.data.rgb}`,marginTop:'20px'}" class="modal-title text-md text-center">@{{ detailGem.data.name }}</p>
                    </div>
                    <div class="col-8">
                        <div class="row">
                            <div class="col-6 d-flex">
                                <div class="flex">
                                    <div class="text-light"><small><i class="fas fa-chevron-double-up"></i> Level yêu cầu : <strong
                                        class="text-light">@{{ detailGem.data.level_required }}</strong></small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6 d-flex">
                                <div class="flex">
                                    <div class="text-success"><small><i class="fas fa-heart"></i> Sinh Lực <strong
                                        class="text-success">+ @{{ detailGem.data.health_points }}</strong></small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6 d-flex mt-2">
                                <div class="flex">
                                    <div class="text-danger"><small><i class="fas fa-swords"></i> Sức Mạnh <strong
                                        class="text-danger">+ @{{ detailGem.data.strength }}</strong></small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6 d-flex mt-2">
                                <div class="flex">
                                    <div class="text-info"><small><i class="fas fa-brain"></i> Trí Tuệ <strong
                                        class="text-info">+ @{{ detailGem.data.intelligent }}</strong></small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6 d-flex mt-2">
                                <div class="flex">
                                    <div class="text-primary"><small><i class="fas fa-bolt"></i> Nhanh Nhẹn <strong
                                        class="text-primary">+ @{{ detailGem.data.agility }}</strong></small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6 d-flex mt-2">
                                <div class="flex">
                                    <div class="text-warning"><small><i class="fas fa-stars"></i> May Mắn <strong
                                        class="text-warning">+ @{{ detailGem.data.lucky }}</strong></small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6 d-flex mt-2">
                                <div class="flex">
                                    <div class="text-silver"><small><i class="fas fa-shield"></i> Kháng Công <strong
                                        class="text-silver">+ @{{ detailGem.data.armor_strength }}</strong></small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6 d-flex mt-2">
                                <div class="flex">
                                    <div class="text-purple"><small><i class="fal fa-dice-d20"></i> Kháng Phép <strong
                                        class="text-purple">+ @{{ detailGem.data.armor_intelligent }}</strong></small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div style="margin:20px 10px" class="col-12">
                        <p>@{{ detailGem.data.description }}</p>
                    </div>
                </div>
            </div>
            <div v-if="detailGem.permission == 1" class="modal-footer">
                <button type="button" @click="deleteGem(detailGem.data)" class="btn bg-danger-lt" data-dismiss="modal">
                    Vứt Bỏ
                </button>
                <button v-if="detailGem.data.pivot.status == 1" type="button" @click="removeGem(detailGem.data)" class="btn btn-secondary" data-dismiss="modal">
                    Tháo
                </button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
</div>
<div id="skill" v-if="detailSkill.data" class="modal fade gear top-off" data-backdrop="true" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content bg-dark">
            <div class="modal-header">
                <button class="close" data-dismiss="modal">×</button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-4">
                        <center>
                            <img :src="detailSkill.data.image" class="pixel text-center" :style="{border:`1px solid ${detailSkill.data.rgb}`,margin:'0 auto'}" width="60px">
                        </center>
                        <p :style="{fontSize:'14px',color:`${detailSkill.data.rgb}`,marginTop:'20px'}" class="modal-title text-md text-center">@{{ detailSkill.data.name }}</p>
                    </div>
                    <div class="col-8">
                        <div class="row">
                            <div class="col-12 d-flex">
                                <div class="flex">
                                    <div class="text-light"><small><i class="fas fa-chevron-double-up"></i> Level yêu cầu: <strong
                                        class="text-light">@{{ detailSkill.data.required_level }}</strong></small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 d-flex mt-1">
                                <div class="flex">
                                    <div class="text-warning"><small><i class="fas fa-helmet-battle"></i> Class: <strong
                                    class="text-warning">@{{ detailSkill.character }}</strong></small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 d-flex mt-1">
                                <div class="flex">
                                    <div class="text-info"><small><i class="fas fa-tint"></i> Mana: <strong
                                    class="text-info">@{{ detailSkill.data.options.energy }}</strong></small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 d-flex mt-1">
                                <div class="flex">
                                    <div class="text-success"><small><i class="fas fa-hourglass-half"></i> Thời gian hồi chiêu: <strong
                                    class="text-success">@{{ detailSkill.data.options.coolDown }}</strong></small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div style="margin:20px 10px" class="col-12">
                        <p style="font-size:13px" class="text-muted" v-html="detailSkill.data.description"></p>
                    </div>
                </div>
            </div>
            <div v-if="detailSkill.permission == 1" class="modal-footer">
                <button type="button" @click="deleteSkill(detailSkill.data.id)" class="btn bg-danger-lt" data-dismiss="modal">
                    Vứt Bỏ
                </button>
                <button v-if="detailSkill.data.pivot.status == 1" type="button" @click="removeSkill(detailSkill.data.id)" class="btn btn-secondary" data-dismiss="modal">
                    Tháo
                </button>
                <button v-else type="button" @click="useSkill(detailSkill.data.id)" class="btn btn-success" data-dismiss="modal">
                    Sử Dụng
                </button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
</div>
<div id="pet" v-if="detailPet.data" class="modal fade pet top-off" data-backdrop="true" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content bg-dark">
            <div class="modal-header">
                <p :style="{fontSize:'14px',color:`${detailPet.data.rgb}`}">@{{ detailPet.data.name }}</p>
                <button class="close" data-dismiss="modal">×</button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-4">
                        <div class="character-sprites" :style="{margin:'0 auto',width:'68px',height:'68px'}">
                            <span :class="[`text-center mount Mount_Body_${detailPet.data.class_tag}`]"></span>
                            <span :class="[`text-center mount Mount_Head_${detailPet.data.class_tag}`]"></span>
                        </div>
                    </div>
                    <div class="col-8">
                        <div class="row">
                            <div class="col-6 d-flex">
                                <div class="flex">
                                    <div class="text-light"><small><i class="fas fa-chevron-double-up"></i> Level yêu cầu : <strong
                                        class="text-light">@{{ detailPet.data.level_required }}</strong></small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6 d-flex">
                                <div class="flex">
                                    <div class="text-success"><small><i class="fas fa-heart"></i> Sinh Lực <strong
                                        class="text-success">+ @{{ detailPet.data.health_points }}</strong></small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6 d-flex mt-2">
                                <div class="flex">
                                    <div class="text-danger"><small><i class="fas fa-swords"></i> Sức Mạnh <strong
                                        class="text-danger">+ @{{ detailPet.data.strength }}</strong></small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6 d-flex mt-2">
                                <div class="flex">
                                    <div class="text-info"><small><i class="fas fa-brain"></i> Trí Tuệ <strong
                                        class="text-info">+ @{{ detailPet.data.intelligent }}</strong></small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6 d-flex mt-2">
                                <div class="flex">
                                    <div class="text-primary"><small><i class="fas fa-bolt"></i> Nhanh Nhẹn <strong
                                        class="text-primary">+ @{{ detailPet.data.agility }}</strong></small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6 d-flex mt-2">
                                <div class="flex">
                                    <div class="text-warning"><small><i class="fas fa-stars"></i> May Mắn <strong
                                        class="text-warning">+ @{{ detailPet.data.lucky }}</strong></small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6 d-flex mt-2">
                                <div class="flex">
                                    <div class="text-silver"><small><i class="fas fa-shield"></i> Kháng Công <strong
                                        class="text-silver">+ @{{ detailPet.data.armor_strength }}</strong></small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6 d-flex mt-2">
                                <div class="flex">
                                    <div class="text-purple"><small><i class="fal fa-dice-d20"></i> Kháng Phép <strong
                                        class="text-purple">+ @{{ detailPet.data.armor_intelligent }}</strong></small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div style="margin:20px 10px" class="col-12">
                        <p>@{{ detailPet.data.description || '( Không có thông tin thêm về thú cưỡi này )' }}</p>
                    </div>
                </div>
            </div>
            <div v-if="detailPet.permission == 1" class="modal-footer">
                <button type="button" @click="dropPet(detailPet.data)" class="btn bg-danger-lt" data-dismiss="modal">
                    Thả
                </button>
                <button v-if="detailPet.data.pivot.status == 0" type="button" @click="ridingPet(detailPet.data)" class="btn btn-success" data-dismiss="modal">
                    Cưỡi
                </button>
                <button v-else type="button" @click="petDown(detailPet.data)" class="btn btn-secondary" data-dismiss="modal">
                    Xuống
                </button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
</div>
<div id="item" v-if="detailItem.data" class="modal fade pet top-off" data-backdrop="true" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content bg-dark">
            <div class="modal-header">
                <p :style="{fontSize:'14px'}">@{{ detailItem.data.name }}</p>
                <button class="close" data-dismiss="modal">×</button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-4">
                        <div class="character-sprites" :style="{margin:'0 auto',width:'68px',height:'68px',border:'1px solid #cd8e2c'}">
                            <div :class="`pixel ${detailItem.data.class_tag}`"></div>
                        </div>
                    </div>
                    <div class="col-8">
                        <p class="text-success">Tỉ lệ thành công : @{{ detailItem.data.success_rate }}%</p>
                        <p class="text-warning">Sử dụng : Ai cũng có thể sử dụng</p>
                    </div>
                    <div style="margin:20px 10px" class="col-12">
                        <p>@{{ detailItem.data.description || '( Không có thông tin thêm về vật phẩm này )' }}</p>
                    </div>
                </div>
            </div>
            <div v-if="detailItem.permission == 1" class="modal-footer">
                <button type="button" @click="deleteItem(detailItem.data)" class="btn bg-danger-lt" data-dismiss="modal">
                    Vứt bỏ
                </button>
                <button type="button" @click="useItem(detailItem.data)" class="btn btn-success" data-dismiss="modal">
                    Dùng
                </button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
</div>
<div v-if="user" class="modal fade modal-right" data-backdrop="true">
    <div style="overflow:auto" class="modal-dialog modal-right w-xl">
        <div style="min-height:100vh;background:#111 !important" class="modal-content vip-bordered no-radius">
            <div class="modal-header">
                <button class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="p-4 text-center">
                    <div title="Nhấp vào để xem thông số" style="margin:0px 10px 35px 0px;position:relative" class="character-sprites hoverable">
                        <span v-if="user.pet" :class="`Mount_Body_${user.pet.class_tag}`"></span>
                        <span style="z-index:2" class="skin_f5a76e up-to-down"></span>
                        <span style="z-index:2" class="broad_shirt_black up-to-down"></span>
                        <span style="z-index:2" class="head_0 up-to-down"></span>
                        <span class=""></span>
                        <span v-for="(gear,index) in user.gears" :key="index">
                            <span v-if="gear.class_tag.includes(' ')" v-for="e in gear.class_tag.split(' ')" :class="`${e} ${gear.cates.animation} up-to-down`" :style="{zIndex:gear.cates.z_index}"></span>
                            <span v-else :class="`${gear.class_tag} ${gear.cates.animation} up-to-down`" :style="{zIndex:gear.cates.z_index}"></span>
                        </span>
                        <span v-if="user.pet" style="z-index: 50" :class="`Mount_Head_${user.pet.class_tag}`"></span>
                    </div>
                    <div style="margin-bottom:60px" v-if="user.pet"></div>
                    <p style="margin-top:20px" class="text-gold">@{{ user.infor.name }} ( @{{ user.infor.character.name }})</p>
                </div>
                <div class="row row-sm">
                    <div class="col-12 d-flex">
                        <div class="flex">
                                <div class="text-info">
                                Level 
                                @{{ user.level.current_level }} 
                                <i class="fas fa-arrow-right"></i> 
                                @{{ user.level.next_level }} 
                                ( @{{ user.level.percent }} % )
                                <div class="progress my-3 circle" style="height:6px">
                                    <div class="progress-bar circle gd-info"
                                        :title="'Người này cần '+ (user.level.next_level_exp - user.level.current_user_exp) +' kinh nghiệm nữa để lên cấp'" :style="{width:user.level.percent + '%'}">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 d-flex">
                        <div class="flex">
                            <div class="text-light"><small><i class="fas fa-chevron-double-up"></i> Level <strong
                                        class="text-light">@{{ user.level.current_level }}</strong></small>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 d-flex">
                        <div class="flex">
                            <div class="text-success"><small><i class="fas fa-heart"></i> Sinh Lực <strong
                                        class="text-success">@{{ user.power.hp }}</strong></small>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 d-flex mt-2">
                        <div class="flex">
                            <div class="text-danger"><small><i class="fas fa-swords"></i> Sát Thương <strong
                                        class="text-danger">@{{ user.power.strength }}</strong></small>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 d-flex mt-2">
                        <div class="flex">
                            <div class="text-info"><small><i class="fas fa-brain"></i> Trí Tuệ <strong
                                        class="text-info">@{{ user.power.intelligent }}</strong></small>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 d-flex mt-2">
                        <div class="flex">
                            <div class="text-primary"><small><i class="fas fa-bolt"></i> Nhanh Nhẹn <strong
                                        class="text-primary">@{{ user.power.agility }}</strong></small>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 d-flex mt-2">
                        <div class="flex">
                            <div class="text-warning"><small><i class="fas fa-stars"></i> May Mắn <strong
                                        class="text-warning">@{{ user.power.lucky }}</strong></small>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 d-flex mt-2">
                        <div class="flex">
                            <div class="text-silver"><small><i class="fas fa-shield"></i> Kháng Công <strong
                                        class="text-silver">@{{ user.power.armor_strength }}</strong></small>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 d-flex mt-2">
                        <div class="flex">
                            <div class="text-purple"><small><i class="fal fa-dice-d20"></i> Kháng Phép <strong
                                        class="text-purple">@{{ user.power.armor_intelligent }}</strong></small>
                            </div>
                        </div>
                    </div>
                </div>
                <br>
                <p class="text-gold">Trang Bị</p>
                <div class="row row-sm">
                    <div v-for="(gear,index) in user.gears" :key="index" style="margin-bottom:15px" class="hoverable col-3 d-flex">
                        <div class="flex">
                            <div @click="showGearsDescription(gear,0)" :class="`pixel ${gear.shop_tag}`" :style="{borderRadius:'5px',border:`1px solid ${gear.rgb}`}"></div>
                        </div>
                    </div>
                    <div v-for="n in parseInt(8 - user.gears.length)" :key="n + Math.random(1,10)" style="margin-bottom:15px" class="col-3 d-flex">
                        <div class="flex hoverable">
                            <div class="hoverable" :style="{width:'68px',height:'68px',borderRadius:'5px',border:'1px dashed #ccc',background:'#4e4e4e'}">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="global-chat" style="z-index: 99999999" class="modal global-chat fade modal-right" data-backdrop="true">
    <div style="overflow:auto" class="modal-dialog modal-right w-xl">
        <div style="min-height:100vh;background:#111 !important" class="modal-content vip-bordered no-radius">
            <div class="modal-header">
                <button class="close" data-dismiss="modal">&times;</button>
            </div>
            <div style="padding:0; margin:10px 0px" class="modal-body">
                <div class="scrollable hover" id="chat-box" style="height:80vh">
                    <div class="list">
                        <div>
                            <div v-if="chat.messages.length == 0" class="text-center">
                                <svg width="48" height="48" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M21.1641 38.997C23.6931 40.262 26.7301 41 30.0001 41C31.1791 41 32.3261 40.898 33.4321 40.716L42.0001 45V36.919C44.4821 34.805 46.0001 32.038 46.0001 29C46.0001 27.962 45.8241 26.958 45.4941 26.001" stroke="#808080" stroke-width="2" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                                    <path d="M22 2C10.954 2 2 9.163 2 18C2 21.594 3.499 24.9 6 27.571V38L15.665 33.167C17.658 33.7 19.783 34 22 34C33.046 34 42 26.837 42 18C42 9.163 33.046 2 22 2Z" fill="#F2F2F2" stroke="#808080" stroke-width="2" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                                <p style="margin-top:20px">( Trống )</p>
                            </div>
                            <div v-else class="chat-list">
                                <div v-for="(msg,index) in chat.messages" :key="index" class="chat-item hoverable" v-if="msg.message && msg.id && msg.name && msg.time" data-sr-id="32" style="margin-bottom: 5px;padding:5px 0px;visibility: visible; transform: none; opacity: 1; transition: transform 0.5s cubic-bezier(0.6, 0.2, 0.1, 1) 0s, opacity 0.5s cubic-bezier(0.6, 0.2, 0.1, 1) 0s;">
                                    <div class="chat-body">
                                        <table class="mdl-data-table mdl-js-data-table" style="width:100%;border:0;">
                                            <tbody id="chatArea">
                                                <tr>
                                                    <th style="padding:0;width:20px;vertical-align:middle;padding-left:10px">
                                                        <div class="avatar-container">
                                                            <img style="width:50px;height:50px;object-fit:cover" class="mr-2 avatar avatar-circle" :src="`http://graph.facebook.com/${msg.id}/picture?type=normal`">
                                                        </div>
                                                    </th>
                                                    <th style="text-align:left;white-space:initial;word-break:break-word;line-height:18px;padding-top:5px;padding-bottom:5px;">
                                                        <span>
                                                            <span class="text-gold" style="font-size:12px;font-weight: initial;">@{{ msg.name }}</span>
                                                        </span>
                                                        <br> 
                                                        <small style="font-size:10px;">@{{ timeAgo(msg.time) }}</small>
                                                        <br>
                                                        <span style="font-size: 13px;font-weight: initial;" class="text-muted">@{{ msg.message }}</span>
                                                    </th>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mt-auto b-t" id="chat-form">
                    <div class="p-2">
                        <div class="input-group">
                            <input @keyup.enter="sendMessage('text','global')" v-model="chat.text" type="text" class="form-control p-3 no-shadow no-border" placeholder="Nhập tin nhắn..." id="newField">
                            <button @click="sendMessage('text','global')" class="btn btn-icon btn-rounded gd-success" type="button" id="newBtn">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-up">
                                    <line x1="12" y1="19" x2="12" y2="5"></line>
                                    <polyline points="5 12 12 5 19 12"></polyline>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@if(!request()->is('pvp/room/*'))
    {{-- @include('user.theme.menu') --}}
@endif
@if(!request()->is('admin/*'))
{{-- <div v-if="loading" id="modal-sm" class="modal fade show" data-backdrop="true" style="display: block;" aria-modal="true">
    <div class="modal-dialog modal-sm">
        <div style="background:transparent !important" class="modal-content">
            <div class="modal-body">
                <div class="text-center">
                    <div style="margin:0 auto" class="loading"></div>
                </div>
            </div>
        </div>
    </div>
</div> --}}
@push('js')
    @auth
    {{-- <script>
        $(document).ready(() => {
            var options = {
                chart: {
                    sparkline: {
                        enabled:!1
                    },
                    height:250,
                    type:"radar",
                    toolbar:{
                        show:!1
                    }
                },
                yaxis:{
                    show:!1
                },
                dataLabels: {
                    enabled:!0,
                    background:{
                        enabled:!0,
                        borderRadius:2
                    }
                },
                fill:{
                    type:"gradient",
                    gradient:{
                        shade:"dark",
                        type:"horizontal",
                        shadeIntensity:.5,
                        inverseColors:!0,
                        opacityFrom:1,
                        opacityTo:.8,
                        stops:[0,50,100],
                        colorStops:[]
                    }
                },
                theme:{
                    mode:"dark",
                    palette:"palette1",
                    monochrome:{
                        enabled:!1,
                        color:"#333",
                        shadeTo:"dark",
                        shadeIntensity:1
                    }
                },
                series: [{
                    name: 'Chỉ số',
                    data: [{{ Auth::user()->stats()['strength'] }}, {{ Auth::user()->stats()['intelligent'] }}, {{ Auth::user()->stats()['agility'] }}, {{ Auth::user()->stats()['lucky'] }}, {{ Auth::user()->stats()['armor_strength'] }}, {{ Auth::user()->stats()['armor_intelligent'] }}],
                    label: ['Sức Mạnh', 'Trí Tuệ', 'Nhanh Nhẹn', 'May Mắn', 'Kháng Công', 'Kháng Phép']
                }]
            };
            var chart = new ApexCharts(document.querySelector("#stats"),options);
            chart.render();
        });
    </script> --}}
    @endauth
	<script async src="{{ mix('js/bundle.min.js') }}"></script>
@endpush
@endif
<button class="btn btn-white btn-block mb-2" style="display:none" id="trigger-gear" data-toggle="modal" data-target="#gear"></button>
<button class="btn btn-white btn-block mb-2" style="display:none" id="trigger-pet" data-toggle="modal" data-target="#pet"></button>
<button class="btn btn-white btn-block mb-2" style="display:none" id="trigger-item" data-toggle="modal" data-target="#item"></button>
<button class="btn btn-white btn-block mb-2" style="display:none" id="trigger-gem" data-toggle="modal" data-target="#gem"></button>
<button class="btn btn-white btn-block mb-2" style="display:none" id="trigger-skill" data-toggle="modal" data-target="#skill"></button>
<button id="show-infor-user" style="display:none" data-toggle="modal" data-target=".modal-right" data-toggle-class="modal-open-aside" data-target="body"></button>
<button id="show-profile" style="display:none" data-toggle="modal" data-target=".modal-left" data-toggle-class="modal-open-aside" data-target="body"></button>
