@auth
{{-- <div class="row row-sm sr">
    <div class="col-md-12 col-lg-12">
        <div class="row row-sm">
            <div class="col-md-12">
                <div class="row row-sm">
                    <div class="col-12">
                        <div class="card vip-bordered" style="padding-top:50px;">
                            <h2 data-title="tooltip" title="Click để xem thông số" class="ribbon"> <button @click="index()" style="background:transparent;border:none" data-toggle="modal" data-target=".modal-left" data-toggle-class="modal-open-aside" data-target="body">{{ Auth::user()->name }}</button></h2>
                            <div class="card-body">
                                <div class="row row-sm" style="margin:0 auto">
                                    <div class="my-2 col-sm-6 col-md-6 col-lg-2">
                                        <div class="d-flex align-items-center text-hover-success">
                                            <div class="text-center px-4 flex">
                                                <small class="text-gold">TOP</small>
                                                <div class="text-gold-2 mt-2"><i class="fas fa-trophy"></i>
                                                    @{{ numberFormatDetail(data.rank.power) }}</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="my-2 col-sm-6 col-md-6 col-lg-2">
                                        <div class="d-flex align-items-center text-hover-warning">
                                            <div class="text-center px-4 flex">
                                                <small class="text-gold">Lực Chiến</small>
                                                <div data-title="tooltip" :title="numberFormatDetail(data.power.total)" class="text-gold-2 mt-2"><i class="fas fa-fist-raised"></i>
                                                    @{{ numberFormat(data.power.total) }}</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="my-2 col-sm-6 col-md-6 col-lg-2">
                                        <div class="d-flex align-items-center text-hover-success">
                                            <div class="text-center px-4 flex">
                                                <small class="text-gold">Xếp Hạng</small>
                                                <div class="text-gold-2 mt-2">
                                                    {{ isset(Auth::user()->config['rank']) ? Auth::user()->config['rank'] : 'ERROR' }} Rank
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="my-2 col-sm-6 col-md-6 col-lg-2">
                                        <div class="d-flex align-items-center text-hover-warning">
                                            <div class="text-center px-4 flex">
                                                <small class="text-gold">Vàng</small>
                                                <div data-title="tooltip" :title="numberFormatDetail(data.infor.coins)" class="text-gold-2 mt-2"><i class="fas fa-usd-circle"></i>
                                                    @{{ numberFormat(data.infor.coins) }}</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="my-2 col-sm-6 col-md-6 col-lg-2">
                                        <div class="d-flex align-items-center text-hover-warning">
                                            <div class="text-center px-4 flex">
                                                <small class="text-gold">Kim Cương</small>
                                                <div data-title="tooltip" :title="numberFormatDetail(data.infor.gold)" class="text-gold-2 mt-2"><i class="fas fa-gem"></i>
                                                    @{{ numberFormat(data.infor.gold) }}</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="my-2 col-sm-6 col-md-6 col-lg-2">
                                        <div class="d-flex align-items-center text-hover-warning">
                                            <div class="text-center px-4 flex">
                                                <small class="text-gold">Điểm PVP</small>
                                                <div data-title="tooltip" :title="numberFormatDetail(data.infor.pvp_points)" class="text-gold-2 mt-2"><i class="fas fa-khanda"></i>
                                                    @{{ numberFormat(data.infor.pvp_points) }}</div>
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
</div> --}}
@if(isset(Auth::user()->config['relife']) && Auth::user()->config['relife'])
    <div 
        onclick="Swal.fire('',`<p class='text-gold'><strong>NGƯỜI VƯỢT LÊN TỪ NGHỊCH CẢNH</strong></p><p>Trải qua mọi khó khăn và nguy hiểm nhưng bạn vẫn giữ được sự bình tĩnh và sự quyết đoán trong từng hành động, danh hiệu này xứng đáng dành cho bạn</p><p class='text-success'>Tất cả chỉ số x2</p><p class='text-success'>Hệ thống Quest ẩn</p><p class='text-success'>+2 điểm chỉ số mỗi level</p><p style='font-size:11px'><i>* Chỉ có bạn mới có thể nhìn thấy thông báo này</i></p>`)" 
        class="text-gold" style="font-weight:inherit;font-size:11px">Vượt Lên Từ Nghịch Cảnh
    </div>
@endif
<div @click="index()"  style="margin:10px 0px 20px 10px" data-title="tooltip" title="Click để xem thông số" data-toggle="modal" data-target=".modal-left" data-toggle-class="modal-open-aside" data-target="body" style="margin:0px 10px 35px 0px" class="character-sprites hoverable">
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