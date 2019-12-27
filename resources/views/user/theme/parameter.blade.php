@auth
<div class="row row-sm sr">
    <div class="col-md-12 col-lg-12">
        <div class="row row-sm">
            <div class="col-md-12">
                <div class="row row-sm">
                    <div class="col-12">
                        <div class="card vip-bordered" style="padding-top:50px;">
                            <h2 class="ribbon"> <button @click="index()" style="background:transparent;border:none" data-toggle="modal" data-target=".modal-left" data-toggle-class="modal-open-aside" data-target="body">{{ Auth::user()->name }}</button></h2>
                            <div class="card-body">
                                <div class="row row-sm">
                                    <div class="col-3">
                                        <div class="d-flex align-items-center text-hover-success">
                                            <div class="px-4 flex">
                                                <small class="text-gold">Xếp Hạng</small>
                                                <div class="text-gold-2 mt-2"><i class="fas fa-trophy"></i>
                                                    @{{ data.rank.power }}</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-3">
                                        <div class="d-flex align-items-center text-hover-warning">
                                            <div class="px-4 flex">
                                                <small class="text-gold">Lực Chiến</small>
                                                <div class="text-gold-2 mt-2"><i class="fas fa-fist-raised"></i>
                                                    @{{ data.power.total }}</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-3">
                                        <div class="d-flex align-items-center text-hover-warning">
                                            <div class="px-4 flex">
                                                <small class="text-gold">Vàng</small>
                                                <div class="text-gold-2 mt-2"><i class="fas fa-usd-circle"></i>
                                                    @{{ data.infor.coins }}</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-3"><small class="text-gold">Kim Cương
                                        </small>
                                        <div class="mt-2 text-gold-2"><i class="fas fa-gem"></i></i>
                                            @{{ data.infor.gold }}</div>
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
<div @click="index()" title="Nhấp vào để xem thông số" data-toggle="modal" data-target=".modal-left" data-toggle-class="modal-open-aside" data-target="body" style="margin:0px 10px 35px 0px" class="character-sprites hoverable {{ Auth::user()->isVip == 1 ? 'vip-2' : '' }}">
    <span v-if="data.pet" :class="`Mount_Body_${data.pet.class_tag}`"></span>
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
    <span v-for="(gear,index) in data.gears" :class="gear.class_tag"></span>
    <span v-if="data.pet" :class="`Mount_Head_${data.pet.class_tag}`"></span>
</div>
<br v-if="data.pet">
@endauth
