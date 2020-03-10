@auth
<div class="row row-sm sr">
    <div class="col-md-12 col-lg-12">
        <div class="row row-sm">
            <div class="col-md-12">
                <div class="row row-sm">
                    <div class="col-12">
                        <div class="card vip-bordered" style="padding-top:50px;">
                            <h2 data-title="tooltip" title="Click để xem thông số" class="ribbon"> <button @click="index()" style="background:transparent;border:none" data-toggle="modal" data-target=".modal-left" data-toggle-class="modal-open-aside" data-target="body">{{ Auth::user()->name }}</button></h2>
                            <div class="card-body">
                                <div class="row row-sm">
                                    <div class="col-sm-6 col-md-6 col-lg-3">
                                        <div class="d-flex align-items-center text-hover-success">
                                            <div class="text-center px-4 flex">
                                                <small class="text-gold">Xếp Hạng LC</small>
                                                <div class="text-gold-2 mt-2"><i class="fas fa-trophy"></i>
                                                    @{{ numberFormatDetail(data.rank.power) }}</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-md-6 col-lg-3">
                                        <div class="d-flex align-items-center text-hover-warning">
                                            <div class="text-center px-4 flex">
                                                <small class="text-gold">Lực Chiến</small>
                                                <div data-title="tooltip" :title="numberFormatDetail(data.power.total)" class="text-gold-2 mt-2"><i class="fas fa-fist-raised"></i>
                                                    @{{ numberFormat(data.power.total) }}</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-md-6 col-lg-3">
                                        <div class="d-flex align-items-center text-hover-warning">
                                            <div class="text-center px-4 flex">
                                                <small class="text-gold">Vàng</small>
                                                <div data-title="tooltip" :title="numberFormatDetail(data.infor.coins)" class="text-gold-2 mt-2"><i class="fas fa-usd-circle"></i>
                                                    @{{ numberFormat(data.infor.coins) }}</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-md-6 col-lg-3">
                                        <div class="d-flex align-items-center text-hover-warning">
                                            <div class="text-center px-4 flex">
                                                <small class="text-gold">Kim Cương</small>
                                                <div data-title="tooltip" :title="numberFormatDetail(data.infor.gold)" class="text-gold-2 mt-2"><i class="fas fa-gem"></i>
                                                    @{{ numberFormat(data.infor.gold) }}</div>
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
<div @click="index()"  data-title="tooltip" title="Click để xem thông số" data-toggle="modal" data-target=".modal-left" data-toggle-class="modal-open-aside" data-target="body" style="margin:0px 10px 35px 0px" class="character-sprites hoverable {{ Auth::user()->isVip == 1 ? 'vip-2' : '' }}">
    <span v-if="data.pet" :class="`Mount_Body_${data.pet.class_tag}`"></span>
    <span style="z-index:2" class="skin_f5a76e"></span>
    <span style="z-index:2" class="broad_shirt_black"></span>
    <span style="z-index:2" class="head_0"></span>
    <span class=""></span>
    <span v-for="(gear,index) in data.gears" :key="index">
        <span v-if="gear.class_tag.includes(' ')" v-for="e in gear.class_tag.split(' ')" :class="e" :style="{zIndex:gear.cates.z_index}"></span>
        <span v-else :class="gear.class_tag" :style="{zIndex:gear.cates.z_index}"></span>
    </span>
    <span v-if="data.pet" style="z-index:50" :class="`Mount_Head_${data.pet.class_tag}`"></span>
</div>
<div style="margin-bottom:60px" v-if="data.pet"></div>
@endauth