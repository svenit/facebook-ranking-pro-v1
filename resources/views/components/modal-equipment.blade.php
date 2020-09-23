<div id="gear" v-if="detailGear.data" class="modal fade gear top-off" data-backdrop="true" aria-hidden="true" style="display: none;">
    <div style="max-width:700px" class="modal-dialog modal-ui">
        <div style="position: relative;" class="lighting-box modal-content">
            @include('components.border')
            <div class="modal-header">
                <span class="modal-text">Trang Bị</span>
                <button class="close" data-dismiss="modal">
                    <img style="width:30px" src="{{ asset('assets/images/icon/Close-Light.png') }}">
                </button>
            </div>
            <div class="modal-body">
                <div class="py-2 px-4">
                    <div class="row tab-content p-1">
                        <div class="col-lg-6 col-md-6 col-sm-12 p-1">
                            <div class="row">
                                <div class="col-12">
                                    <div class="item-preview">
                                        <span style="padding:10px;font-weight:bold">[ @{{ detailGear.data.cates.name }} ]</span>
                                        <img style="position: absolute; right: 5%;width: 40px" class="pixel" src="{{ asset('assets/images/icon/Dark-Badge.png') }}">
                                        <img class="pixel" style="position: absolute; right: 7.5%;width:25px;" :src="asset(`assets/images/class/${detailGear.data.character.avatar}-icon.png`)">
                                        @include('components.border')
                                        <div style="margin:42px auto;background-color: #554334;border-radius: 50%;" :class="[`pixel text-center ${detailGear.data.shop_tag}`]">
                                            <img class="pixel" style="width: 70px;" src="{{ asset('assets/images/icon/Equipment-Frame.png') }}">
                                        </div>
                                        <div v-if="detailGear.permission == 1" class="normal-badge">
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
                        <div class="col-lg-6 col-md-6 col-sm-12 notranslate p-1">
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
                                            <div data-dismiss="modal" style="background-color: #554334;border-radius: 50%;" @click="showGem(gem, detailGear.permission)" :class="`gem ${gem.gem_item.image}`">
                                                <img class="pixel" style="width: 50px;" src="{{ asset('assets/images/icon/Gem-Frame.png') }}">
                                            </div>
                                        </div>
                                        <div v-for="n in parseInt(3 - detailGear.data.gems.length)" :key="n" style="padding:5px" class="col-auto">
                                            <div style="background-color: #554334;border-radius: 50%;" class="">
                                                <img class="pixel" style="width: 50px;" src="{{ asset('assets/images/icon/Gem-Frame.png') }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mx-1" v-else>
                                        <div v-for="n in 3" :key="n" style="padding:5px" class="col-auto">
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
            <div class="modal-footer">
                <div class="row" v-if="detailGear.permission == 1">
                    <div data-dismiss="modal" v-if="detailGear.data.pivot.status == 0" type="button" @click="equipment(detailGear.data)" class="btn-green pixel-btn mr-4" data-dismiss="modal">
                        Trang bị <img style="width:16px" src="{{ asset('assets/images/icon/Equip.png') }}">
                    </div>
                    <div data-dismiss="modal" v-else type="button" @click="removeEquipment(detailGear.data)" class="btn-yellow pixel-btn mr-4">
                        Tháo <img style="width:16px" src="{{ asset('assets/images/icon/Unequip.png') }}">
                    </div>
                    <div data-dismiss="modal" @click="deleteEquipment(detailGear.data)" class="btn-red pixel-btn mr-3">
                        Vứt Bỏ <img style="width:16px" src="{{ asset('assets/images/icon/Delete.png') }}">
                    </div>
                </div>
                <div data-dismiss="modal" class="btn-red pixel-btn mr-4">
                    Đóng <img style="width:16px" src="{{ asset('assets/images/icon/Close-White.png') }}">
                </div>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
</div>