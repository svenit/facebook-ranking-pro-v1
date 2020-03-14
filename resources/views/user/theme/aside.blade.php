@auth
@php
    $tracking = new \App\Http\Controllers\Controller();
@endphp
@if($tracking->checkTracking())
    <div style="position:fixed;top:10%;right:0px;padding:10px;z-index:99999" class="ultra-bordered card fixed-action-branch">
        <span>Bạn đang ở trong một hoạt động</span>
    </div>
@endif
<div v-if="data" class="modal fade modal-left" data-backdrop="true">
    <div style="overflow:auto" class="modal-dialog modal-left w-xl">
        <div style="min-height:100vh;background:#111 !important" class="modal-content vip-bordered no-radius">
            <div class="modal-header">
                <button class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="p-4">
                    <p class="pixel-font text-gold" style="text-align:center !important;">{{ isset(Auth::user()->config['rank']) ? Auth::user()->config['rank'] : 'ERROR' }} RANK</p>
                    <div style="margin:0 auto;position:relative;left:-15px" class="character-sprites hoverable">
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
                    <p style="margin-top:20px" class="text-gold text-center">@{{ data.infor.name }} ( @{{ data.infor.character.name }} )</p>
                </div>
                <div class="row row-sm">
                    <div class="col-12 d-flex">
                        <div class="flex">
                                <div class="text-info">
                                Level 
                                @{{ data.level.current_level }} 
                                <i class="fas fa-arrow-right"></i> 
                                @{{ data.level.next_level }} 
                                ( @{{ data.level.percent }} % )
                                <div class="progress my-3 circle" style="height:6px">
                                    <div class="progress-bar circle gd-info" data-title="tooltip" :title="`Bạn cần ${(data.level.next_level_exp - data.level.current_user_exp)} kinh nghiệm nữa để lên cấp`" :style="{width:data.level.percent + '%'}">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 d-flex">
                        <div class="flex">
                            <div class="text-light"><small><i class="fas fa-chevron-double-up"></i> Level <strong
                                        class="text-light">@{{ data.level.current_level }}</strong></small>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 d-flex">
                        <div class="flex">
                            <div class="text-success"><small><i class="fas fa-heart"></i> Sinh Lực <strong
                                        class="text-success">@{{ data.power.hp }}</strong></small>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 d-flex mt-2">
                        <div class="flex">
                            <div class="text-danger"><small><i class="fas fa-swords"></i> Sức Mạnh <strong
                                        class="text-danger">@{{ data.power.strength }}</strong></small>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 d-flex mt-2">
                        <div class="flex">
                            <div class="text-info"><small><i class="fas fa-brain"></i> Trí Tuệ <strong
                                        class="text-info">@{{ data.power.intelligent }}</strong></small>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 d-flex mt-2">
                        <div class="flex">
                            <div class="text-primary"><small><i class="fas fa-bolt"></i> Nhanh Nhẹn <strong
                                        class="text-primary">@{{ data.power.agility }}</strong></small>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 d-flex mt-2">
                        <div class="flex">
                            <div class="text-warning"><small><i class="fas fa-stars"></i> May Mắn <strong
                                        class="text-warning">@{{ data.power.lucky }}</strong></small>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 d-flex mt-2">
                        <div class="flex">
                            <div class="text-silver"><small><i class="fas fa-shield"></i> Kháng Công <strong
                                        class="text-silver">@{{ data.power.armor_strength }}</strong></small>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 d-flex mt-2">
                        <div class="flex">
                            <div class="text-purple"><small><i class="fal fa-dice-d20"></i> Kháng Phép <strong
                                        class="text-purple">@{{ data.power.armor_intelligent }}</strong></small>
                            </div>
                        </div>
                    </div>
                </div>
                <br>
                <p class="text-gold">Trang Bị</p>
                <div class="row row-sm">
                    <div v-for="(gear,index) in data.gears" :key="index" style="margin-bottom:15px" class="col-3 d-flex" data-title="tooltip" title="Click để xem chi tiết" >
                        <div class="flex">
                            <div @click="showGearsDescription(gear,1)" :class="`pixel hoverable ${gear.shop_tag}`" :style="{borderRadius:'5px',border:`1px solid ${gear.rgb}`,backgroundColor:'#272727'}"></div>
                        </div>
                    </div>
                    <div v-for="n in parseInt(8 - data.gears.length)" :key="n + Math.random(1,10)" style="margin-bottom:15px" class="col-3 d-flex">
                        <div class="flex">
                            <div class="hoverable" :style="{width:'68px',height:'68px',borderRadius:'5px',border:'1px dashed #ccc',background:'#4e4e4e'}">
                            </div>
                        </div>
                    </div>
                </div>
                <p class="text-gold">Kỹ Năng</p>
                <div class="row row-sm">
                    <div v-for="(skill,index) in data.skills" :key="index" style="margin-bottom:15px" class="col-3 d-flex">
                        <div data-title="tooltip" title="Click để xem chi tiết" class="flex hoverable">
                            <img title @click="showSkillsDescription(skill,1)" data-toggle="tooltip" :style="{borderRadius:'5px',width:'68px',height:'68px',border:`1px solid ${skill.rgb}`}" :src="skill.image">
                        </div>
                    </div>
                    <div v-for="n in parseInt(4 - data.skills.length)" :key="n + Math.random(1,10)" style="margin-bottom:15px" class="col-3 d-flex">
                        <div class="flex">
                            <div class="hoverable" :style="{width:'68px',height:'68px',borderRadius:'5px',border:'1px dashed #ccc',background:'#4e4e4e'}">
                            </div>
                        </div>
                    </div>
                </div>
                <p class="text-gold">Chỉ Số ( Điểm : @{{ numberFormat(data.stats.used) }}/@{{ numberFormat(data.stats.available) }} )</p>
                <div id="stats"></div>
            </div>
        </div>
    </div>
</div>
@endauth
<div id="gear" v-if="detailGear.data" class="modal fade gear top-off" data-backdrop="true" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content bg-dark">
            <div class="modal-header">
                <button class="close" data-dismiss="modal">×</button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-4">
                        <div :style="{border:`1px solid ${detailGear.data.rgb}`,margin:'0 auto'}" :class="[`pixel text-center ${detailGear.data.shop_tag}`]"></div>
                        <p :style="{fontSize:'14px',color:`${detailGear.data.rgb}`,marginTop:'20px'}" class="modal-title text-md text-center">@{{ detailGear.data.name }}</p>
                        <p :style="{fontSize:'14px',marginTop:'10px'}" class="modal-title text-md text-center">( @{{ detailGear.data.character.name }} - @{{ detailGear.data.cates.name }} )</p>
                    </div>
                    <div class="col-8">
                        <div class="row">
                            <div class="col-6 d-flex">
                                <div class="flex">
                                    <div class="text-light"><small><i class="fas fa-chevron-double-up"></i> Level yêu cầu : <strong
                                        class="text-light">@{{ detailGear.data.level_required }}</strong></small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6 d-flex">
                                <div class="flex">
                                    <div class="text-success"><small><i class="fas fa-heart"></i> Sinh Lực <strong
                                        class="text-success">+ @{{ detailGear.data.health_points }}</strong></small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6 d-flex mt-2">
                                <div class="flex">
                                    <div class="text-danger"><small><i class="fas fa-swords"></i> Sức Mạnh <strong
                                        class="text-danger">+ @{{ detailGear.data.strength }}</strong></small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6 d-flex mt-2">
                                <div class="flex">
                                    <div class="text-info"><small><i class="fas fa-brain"></i> Trí Tuệ <strong
                                        class="text-info">+ @{{ detailGear.data.intelligent }}</strong></small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6 d-flex mt-2">
                                <div class="flex">
                                    <div class="text-primary"><small><i class="fas fa-bolt"></i> Nhanh Nhẹn <strong
                                        class="text-primary">+ @{{ detailGear.data.agility }}</strong></small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6 d-flex mt-2">
                                <div class="flex">
                                    <div class="text-warning"><small><i class="fas fa-stars"></i> May Mắn <strong
                                        class="text-warning">+ @{{ detailGear.data.lucky }}</strong></small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6 d-flex mt-2">
                                <div class="flex">
                                    <div class="text-silver"><small><i class="fas fa-shield"></i> Kháng Công <strong
                                        class="text-silver">+ @{{ detailGear.data.armor_strength }}</strong></small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6 d-flex mt-2">
                                <div class="flex">
                                    <div class="text-purple"><small><i class="fal fa-dice-d20"></i> Kháng Phép <strong
                                        class="text-purple">+ @{{ detailGear.data.armor_intelligent }}</strong></small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div style="margin:10px 20px" class="row">
                        <div v-for="(gem, index) in detailGear.data.gems" :key="index" style="padding:5px" class="col-auto">
                            <img :style="{border:`1px solid ${gem.gem_item.rgb}`}" :src="gem.gem_item.image" @click="showGem(gem,detailGear.permission)" width="40px">
                        </div>
                    </div>
                    <div style="margin:20px 10px" class="col-12">
                        <p>@{{ detailGear.data.description }}</p>
                    </div>
                </div>
            </div>
            <div v-if="detailGear.permission == 1" class="modal-footer">
                <button type="button" @click="deleteEquipment(detailGear.data)" class="btn bg-danger-lt" data-dismiss="modal">
                    Vứt Bỏ
                </button>
                <button v-if="detailGear.data.pivot.status == 0" type="button" @click="equipment(detailGear.data)" class="btn btn-success" data-dismiss="modal">
                    Trang bị
                </button>
                <button v-else type="button" @click="removeEquipment(detailGear.data)" class="btn btn-secondary" data-dismiss="modal">
                    Tháo
                </button>
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
                            <img class="pixel text-center" :style="{border:`1px solid ${detailGem.data.rgb}`,margin:'0 auto'}" :src="detailGem.data.image" width="60px">
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
                    <div title="Nhấp vào để xem thông số" style="margin:0px 10px 35px 0px" class="character-sprites hoverable" :class="user.infor.vip ? 'vip-2' : ''">
                        <span v-if="user.pet" :class="`Mount_Body_${user.pet.class_tag}`"></span>
                        <span style="z-index:2" class="skin_f5a76e"></span>
                        <span style="z-index:2" class="broad_shirt_black"></span>
                        <span style="z-index:2" class="head_0"></span>
                        <span class=""></span>
                        <span v-for="(gear,index) in user.gears" :key="index">
                            <span v-if="gear.class_tag.includes(' ')" v-for="e in gear.class_tag.split(' ')" :class="e" :style="{zIndex:gear.cates.z_index}"></span>
                            <span v-else :class="gear.class_tag" :style="{zIndex:gear.cates.z_index}"></span>
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
                <p class="text-gold">Kỹ Năng</p>
                <div class="row row-sm">
                    <div v-for="(skill,index) in user.skills" :key="index" style="margin-bottom:15px" class="col-3 d-flex">
                        <div class="flex hoverable">
                            <img title @click="showSkillsDescription(skill,0)" data-toggle="tooltip" :style="{borderRadius:'5px',width:'68px',height:'68px',border:`1px solid ${skill.rgb}`}" :src="skill.image">
                        </div>
                    </div>
                    <div v-for="n in parseInt(4 - user.skills.length)" :key="n + Math.random(1,10)" style="margin-bottom:15px" class="col-3 d-flex">
                        <div class="flex">
                            <div class="hoverable" :style="{width:'68px',height:'68px',borderRadius:'5px',border:'1px dashed #ccc',background:'#4e4e4e'}">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="aside-left" class="page-sidenav no-shrink bg-light nav-dropdown fade" aria-hidden="true">
    <div class="sidenav h-100 modal-dialog bg-light normal-bordered">
        <div class="navbar"><a href="{{ Route('user.index') }}" class="navbar-brand">
            <img src="https://dslv9ilpbe7p1.cloudfront.net/8nAm-YsBbxDswigGmEWqpA_store_logo_image.png">
            <span class="hidden-folded d-inline l-s-n-1x">{{ env('APP_NAME') }}</span></a></div>
        <div class="flex scrollable hover">
            <div class="nav-active-text-primary" data-nav>
                <ul class="nav bg">
                    <li class="nav-header hidden-folded"><span class="text-muted">Hệ Thống</span></li>
                    <li><a class="no-ajax" href="{{ Route('user.index') }}"><span class="nav-icon"><i
                                    data-feather="box"></i></span> <span class="nav-text">Hệ Thống</span></a></li>
                </ul>
                <ul class="nav">
                    @if(!Request::is('admin/*'))
                        <li class="nav-header hidden-folded"><span class="text-muted">Hoạt Động</span></li>
                        <li class="{{ Request::is('profile/*') ? 'active' : '' }}"><a href="#"><span class="nav-icon"><i data-feather="user"></i></span> <span
                            class="nav-text">Nhân Vật</span> <span class="nav-caret"></span></a>
                            <ul class="nav-sub nav-mega">
                                <li><a href="{{ Route('user.profile.item.index') }}" class=""><span class="nav-text">Vật Phẩm</span></a></li>
                                <li><a href="{{ Route('user.profile.gem.index') }}" class=""><span class="nav-text">Ngọc Bổ Trợ</span></a></li>
                                <li><a href="{{ Route('user.profile.inventory.index') }}" class=""><span class="nav-text">Trang Bị</span></a></li>
                                <li><a href="{{ Route('user.profile.pet.index') }}" class=""><span class="nav-text">Thú Cưỡi</span></a></li>
                                <li><a href="{{ Route('user.profile.skill.index') }}" class=""><span class="nav-text">Kỹ Năng</span></a></li>
                                <li><a href="{{ Route('user.profile.stat.index') }}" class=""><span class="nav-text">Chỉ Số</span></a></li>
                                @auth
                                    <li><a href="{{ Route('user.profile.message.index') }}" class=""><span class="nav-text">Tin Nhắn @if(isset($notifications) && $notifications['unread'] > 0)<span class="nav-badge"><b class="badge badge-pill gd-warning">{{ $notifications['unread'] ?? 0 }}</b></span>@endif</span></a></li>
                                @endauth
                            </ul>
                        </li>
                        <li class="{{ Request::is('top/*') ? 'active' : '' }}"><a href="#"><span class="nav-icon"><i data-feather="award"></i></span> <span
                            class="nav-text">BXH</span> <span class="nav-caret"></span></a>
                            <ul class="nav-sub nav-mega">
                                <li><a href="{{ Route('user.top.power') }}" class=""><span class="nav-text">Lực Chiến</span></a></li>
                                <li><a href="{{ Route('user.top.level') }}" class=""><span class="nav-text">Cấp Độ</span></a></li>
                                <li><a href="{{ Route('user.top.pvp') }}" class=""><span class="nav-text">PVP</span></a></li>
                                <li><a href="{{ Route('user.top.coin') }}" class=""><span class="nav-text">Vàng</span></a></li>
                                <li><a href="{{ Route('user.top.gold') }}" class=""><span class="nav-text">Kim Cương</span></a></li>
                                <li><a href="{{ Route('user.top.activities') }}" class=""><span class="nav-text">Hoạt Động</span></a></li>
                            </ul>
                        </li>
                        <li class="{{ Request::is('events/*') ? 'active' : '' }}"><a href="#" class=""><span class="nav-icon"><i data-feather="coffee"></i></span> <span
                                    class="nav-text">Giải Trí</span> <span class="nav-caret"></span></a>
                            <ul class="nav-sub nav-mega">
                                <li><a href="{{ Route('user.events.wheel') }}" class=""><span class="nav-text">VQMM</span></a></li>
                                <li><a href="{{ Route('user.events.lucky-box') }}" class=""><span class="nav-text">Kho Báu</span></a></li>
                            </ul>
                        </li>
                        <li class="{{ Request::is('shop/*') ? 'active' : '' }}"><a href="#" class=""><span class="nav-icon"><i data-feather="shopping-cart"></i></span> <span
                            class="nav-text">Cửa Hàng</span> <span class="nav-caret"></span></a>
                            <ul class="nav-sub nav-mega">
                                <li><a href="{{ Route('user.shop.index',['cate' => 'items']) }}" class=""><span class="nav-text">Vật Phẩm</span></a></li>
                                <li><a href="{{ Route('user.shop.index',['cate' => 'gems']) }}" class=""><span class="nav-text">Ngọc Bổ Trợ</span></a></li>
                                @foreach($menuShop as $menu)
                                    <li><a href="{{ Route('user.shop.index',['cate' => str_slug($menu->name)]) }}" class=""><span class="nav-text">{{ $menu->name }}</span></a></li>
                                @endforeach
                                <li><a href="{{ Route('user.shop.index',['cate' => 'pets']) }}" class=""><span class="nav-text">Thú Cưỡi</span></a></li>
                                <li><a href="{{ Route('user.shop.index',['cate' => 'skills']) }}" class=""><span class="nav-text">Kỹ Năng</span></a></li>
                            </ul>
                        </li>
                        <li class="{{ Request::is('oven/*') ? 'active' : '' }}"><a href="#" class=""><span class="nav-icon"><i data-feather="git-branch"></i></span> <span
                            class="nav-text">Tiệm Rèn</span> <span class="nav-caret"></span></a>
                            <ul class="nav-sub nav-mega">
                                <li><a href="{{ Route('user.oven.gem') }}" class=""><span class="nav-text">Khảm Ngọc</span></a></li>
                            </ul>
                        </li>
                        <li class="{{ Request::is('explore/*') ? 'active' : '' }}"><a href="#" class=""><span class="nav-icon"><i data-feather="map"></i></span> <span
                            class="nav-text">Khám Phá</span> <span class="nav-caret"></span></a>
                            <ul class="nav-sub nav-mega">
                                <li><a href="#" class=""><span class="nav-text">Dungeon</span></a></li>
                                <li><a href="#" class=""><span class="nav-text">Nhiệm Vụ</span></a></li>
                                <li><a href="{{ Route('user.explore.recovery-room.index') }}" class=""><span class="nav-text">Phòng Hồi Phục</span></a></li>
                            </ul>
                        </li>
                        <li class="{{ Request::is('guild/*') || Request::is('guild')  ? 'active' : '' }}"><a href="#" class=""><span class="nav-icon"><i data-feather="users"></i></span> <span
                            class="nav-text">Bang Hội</span> <span class="nav-caret"></span></a>
                            <ul class="nav-sub nav-mega">
                                @if(empty(Auth::user()->guildMember))
                                    <li><a href="{{ Route('user.guild.create.form') }}" class=""><span class="nav-text">Tạo</span></a></li>
                                @else
                                    <li><a href="{{ Route('user.guild.lobby') }}" class=""><span class="nav-text">Đại Sảnh</span></a></li>
                                    <li><a href="#" class=""><span class="nav-text">Thành Viên</span></a></li>
                                    <li><a href="#" class=""><span class="nav-text">Hoạt Động</span></a></li>
                                    <li><a href="#" class=""><span class="nav-text">Thiết Lập</span></a></li>
                                @endif
                            </ul>
                        </li>
                        <li class="{{ Request::is('pvp/*') ? 'active' : '' }}"><a href="#" class=""><span class="nav-icon"><i data-feather="shield"></i></span> <span
                            class="nav-text">PVP</span><span class="nav-badge"><b class="badge-circle xs text-success"></b></span> <span class="nav-caret"></span></a>
                            <ul class="nav-sub nav-mega">
                                <li><a href="{{ Route('user.pvp.index') }}" class=""><span class="nav-text">Tham Gia</span></a></li>
                            </ul>
                        </li>
                        <li class="{{ Request::is('chat/*') ? 'active' : '' }}"><a href="#" class=""><span class="nav-icon"><i data-feather="message-circle"></i></span> <span
                            class="nav-text">Chat</span> <span class="nav-badge"><b class="badge-circle xs text-success"></b></span><span class="nav-caret"></span></a>
                            <ul class="nav-sub nav-mega">
                                <li><a href="{{ Route('user.chat.global') }}" class=""><span class="nav-text">Thế Giới</span></a></li>
                                <li><a onclick="return confirm('Bạn đang có {{ Auth::user()->stranger_chat_times ?? 0 }} vé chat ! Tham gia ?')" href="{{ Route('user.chat.stranger.join') }}" class=""><span class="nav-text">CVNL</span></a></li>
                            </ul>
                        </li>
                        <li><a href="{{ Route('user.giftcode.index') }}" class=""><span class="nav-icon"><i data-feather="gift"></i></span> <span
                            class="nav-text">Quà Tặng</span></a>
                        </li>
                        <li><a href="{{ Route('user.giftcode.index') }}" class=""><span class="nav-icon"><i data-feather="dollar-sign"></i></span> <span
                            class="nav-text">Donate</span></a>
                        </li>
                    @endif
                    @if(Auth::check() && Auth::user()->isAdmin)
                        <li class="nav-header hidden-folded"><span class="text-muted">Admin Cpanel</span></li>
                        <li><a href="{{ Route('admin.dashboard.index') }}"><span class="nav-icon"><i
                            data-feather="cpu"></i></span> <span class="nav-text">Tổng Quan</span></a></li>
                        <li><a href="#" class=""><span class="nav-icon"><i data-feather="download"></i></span> <span
                                    class="nav-text">Cập Nhật</span> <span class="nav-caret"></span></a>
                            <ul class="nav-sub nav-mega">
                                <li><a href="{{ Route('admin.update-points') }}" class=""><span class="nav-text">Điểm Hoạt Động</span></a></li></li>
                            </ul>
                        </li>
                        <li class="{{ Request::is('admin/analytics/*') ? 'active' : '' }}"><a href="#" class=""><span class="nav-icon"><i data-feather="pie-chart"></i></span> <span
                            class="nav-text">Truy Cập</span> <span class="nav-caret"></span></a>
                            <ul class="nav-sub nav-mega">
                                <li><a href="{{ Route('admin.analytics.total') }}" class=""><span class="nav-text">Tổng Quan</span></a></li></li>
                                <li><a href="{{ Route('admin.analytics.hour') }}" class=""><span class="nav-text">Theo Giờ</span></a></li></li>
                                <li><a href="{{ Route('admin.analytics.day') }}" class=""><span class="nav-text">Theo Ngày</span></a></li></li>
                                <li><a href="{{ Route('admin.analytics.view-most') }}" class=""><span class="nav-text">Xem Nhiều</span></a></li></li>
                                <li><a href="{{ Route('admin.analytics.setting.index') }}" class=""><span class="nav-text">Cài Đặt</span></a></li></li>
                            </ul>
                        </li>
                        <li class="{{ Request::is('admin/users/*') ? 'active' : '' }}"><a href="#" class=""><span class="nav-icon"><i data-feather="users"></i></span> <span
                            class="nav-text">Người Dùng</span> <span class="nav-caret"></span></a>
                            <ul class="nav-sub nav-mega">
                                <li><a href="{{ Route('admin.users.list') }}" class=""><span class="nav-text">Danh Sách</span></a></li></li>
                            </ul>
                        </li>
                        <li class="{{ Request::is('admin/gears/*') || Request::is('admin/cate-gears/*') ? 'active' : '' }}"><a href="#" class=""><span class="nav-icon"><i data-feather="archive"></i></span> <span
                            class="nav-text">Trang Bị</span> <span class="nav-caret"></span></a>
                            <ul class="nav-sub nav-mega">
                                <li><a href="{{ Route('admin.cate-gears.list') }}" class=""><span class="nav-text">Danh Mục</span></a></li></li>
                                <li><a href="{{ Route('admin.gears.add') }}" class=""><span class="nav-text">Thêm</span></a></li></li>
                                <li><a href="{{ Route('admin.gears.list') }}" class=""><span class="nav-text">Danh Sách</span></a></li></li>
                            </ul>
                        </li>
                        <li class="{{ Request::is('admin/pets/*') ? 'active' : '' }}"><a href="#" class=""><span class="nav-icon"><i data-feather="gitlab"></i></span> <span
                            class="nav-text">Thú Cưỡi</span> <span class="nav-caret"></span></a>
                            <ul class="nav-sub nav-mega">
                                <li><a href="{{ Route('admin.pets.add') }}" class=""><span class="nav-text">Thêm</span></a></li></li>
                                <li><a href="{{ Route('admin.pets.list') }}" class=""><span class="nav-text">Danh Sách</span></a></li></li>
                            </ul>
                        </li>
                        <li class="{{ Request::is('admin/items/*') ? 'active' : '' }}"><a href="#" class=""><span class="nav-icon"><i data-feather="package"></i></span> <span
                            class="nav-text">Vật Phẩm</span> <span class="nav-caret"></span></a>
                            <ul class="nav-sub nav-mega">
                                <li><a href="{{ Route('admin.items.add') }}" class=""><span class="nav-text">Thêm</span></a></li></li>
                                <li><a href="{{ Route('admin.items.list') }}" class=""><span class="nav-text">Danh Sách</span></a></li></li>
                            </ul>
                        </li>
                        <li class="{{ Request::is('admin/skills/*') ? 'active' : '' }}"><a href="#" class=""><span class="nav-icon"><i data-feather="book-open"></i></span> <span
                            class="nav-text">Kỹ Năng</span> <span class="nav-caret"></span></a>
                            <ul class="nav-sub nav-mega">
                                <li><a href="{{ Route('admin.skills.add') }}" class=""><span class="nav-text">Thêm</span></a></li></li>
                                <li><a href="{{ Route('admin.skills.list') }}" class=""><span class="nav-text">Danh Sách</span></a></li></li>
                            </ul>
                        </li>
                        <li class="{{ Request::is('admin/levels/*') ? 'active' : '' }}"><a href="{{ Route('admin.levels.list') }}" class=""><span class="nav-icon"><i data-feather="trending-up"></i></span> <span
                            class="nav-text">Cấp Độ</span></a>
                        </li>
                        <li class="{{ Request::is('admin/characters/*') ? 'active' : '' }}"><a href="#" class=""><span class="nav-icon"><i data-feather="user"></i></span> <span
                            class="nav-text">Nhân Vật</span> <span class="nav-caret"></span></a>
                            <ul class="nav-sub nav-mega">
                                <li><a href="{{ Route('admin.pets.add') }}" class=""><span class="nav-text">Thêm</span></a></li></li>
                                <li><a href="{{ Route('admin.pets.list') }}" class=""><span class="nav-text">Danh Sách</span></a></li></li>
                            </ul>
                        </li>
                        <li class="{{ Request::is('admin/recovery-rooms/*') ? 'active' : '' }}"><a href="#" class=""><span class="nav-icon"><i data-feather="rss"></i></span> <span
                            class="nav-text">Phòng Hồi Phục</span> <span class="nav-caret"></span></a>
                            <ul class="nav-sub nav-mega">
                                <li><a href="{{ Route('admin.pets.add') }}" class=""><span class="nav-text">Thêm</span></a></li></li>
                                <li><a href="{{ Route('admin.pets.list') }}" class=""><span class="nav-text">Danh Sách</span></a></li></li>
                            </ul>
                        </li>
                        <li class="{{ Request::is('admin/pushers/*') ? 'active' : '' }}"><a href="{{ Route('admin.pushers.list') }}" class=""><span class="nav-icon"><i data-feather="database"></i></span> <span
                            class="nav-text">Pushers</span></a>
                        </li>
                        <li class="{{ Request::is('admin/events/*') ? 'active' : '' }}"><a href="#" class=""><span class="nav-icon"><i data-feather="gift"></i></span> <span
                            class="nav-text">Giải Trí</span> <span class="nav-caret"></span></a>
                            <ul class="nav-sub nav-mega">
                                <li><a href="{{ Route('admin.events.add') }}" class=""><span class="nav-text">Thêm</span></a></li></li>
                                <li><a href="{{ Route('admin.events.list') }}" class=""><span class="nav-text">Danh Sách</span></a></li></li>
                            </ul>
                        </li>
                        <li class="{{ Request::is('admin/chats/*') ? 'active' : '' }}"><a href="#" class=""><span class="nav-icon"><i data-feather="message-square"></i></span> <span
                            class="nav-text">Chat</span></span></a>
                        </li>
                        <li class="{{ Request::is('admin/pvps/*') ? 'active' : '' }}"><a href="#" class=""><span class="nav-icon"><i data-feather="shield"></i></span> <span
                            class="nav-text">PVP</span></span></a>
                        </li>
                        <li class="{{ Request::is('admin/trackings/*') ? 'active' : '' }}"><a href="#" class=""><span class="nav-icon"><i data-feather="play"></i></span> <span
                            class="nav-text">Theo Dõi</span></span></a>
                        </li>
                        <li class="{{ Request::is('admin/settings/*') ? 'active' : '' }}"><a href="#" class=""><span class="nav-icon"><i data-feather="settings"></i></span> <span
                            class="nav-text">Cài Đặt</span> <span class="nav-caret"></span></a>
                            <ul class="nav-sub nav-mega">
                                <li><a href="{{ Route('admin.settings.config') }}" class=""><span class="nav-text">Cấu Hình</span></a></li></li>
                                <li><a href="#" class=""><span class="nav-text">Slider</span></a></li></li>
                            </ul>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
        @auth
            <div class="no-shrink">
                <div class="p-3 d-flex align-items-center">
                    <div class="text-sm hidden-folded {{ Auth::user()->energy >= 60 ? 'text-success' : 'text-danger' }}">Sức Khỏe : {{ Auth::user()->energy }} <i class="fas fa-walking"></i></div>
                </div>
            </div>
        @endauth
    </div>
</div>
@if(!request()->is('admin/*'))
<div v-if="loading" id="modal-sm" class="modal fade show" data-backdrop="true" style="display: block;" aria-modal="true">
    <div class="modal-dialog modal-sm">
        <div style="background:transparent !important" class="modal-content">
            <div class="modal-body">
                <div class="text-center">
                    <div style="margin:0 auto" class="loading"></div>
                </div>
            </div>
        </div>
    </div>
</div>
@push('js')
    @auth
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script>
        $(document).ready(() => {
            var options={chart:{sparkline:{enabled:!1},height:250,type:"radar",toolbar:{show:!1}},yaxis:{show:!1},dataLabels:{enabled:!0,background:{enabled:!0,borderRadius:2}},fill:{type:"gradient",gradient:{shade:"dark",type:"horizontal",shadeIntensity:.5,gradientToColors:void 0,inverseColors:!0,opacityFrom:1,opacityTo:.8,stops:[0,50,100],colorStops:[]}},theme:{mode:"dark",palette:"palette1",monochrome:{enabled:!1,color:"#333",shadeTo:"dark",shadeIntensity:1}},series:[{name:"Ch\u1EC9 S\u1ED1",data:[{{ Auth::user()->stats()['strength'] }},{{ Auth::user()->stats()['intelligent'] }},{{ Auth::user()->stats()['agility'] }},{{ Auth::user()->stats()['lucky'] }},{{ Auth::user()->stats()['armor_strength'] }},{{ Auth::user()->stats()['armor_intelligent'] }}]}],labels:["S\u1EE9c M\u1EA1nh","Tr\xED Tu\u1EC7","Nhanh Nh\u1EB9n","May M\u1EAFn","Th\u1EE7 C\xF4ng","Th\u1EE7 Ph\xE9p","Sinh L\u1EF1c","Mana"]},chart=new ApexCharts(document.querySelector("#stats"),options);chart.render();var chart=new ApexCharts(document.querySelector("#stats-infor"),options);chart.render();
        });
    </script>
    @endauth
    <script src="{{ asset('assets/js/vue/app.js') }}"></script>
@endpush
@endif
<button class="btn btn-white btn-block mb-2" style="display:none" id="trigger-gear" data-toggle="modal" data-target="#gear"></button>
<button class="btn btn-white btn-block mb-2" style="display:none" id="trigger-pet" data-toggle="modal" data-target="#pet"></button>
<button class="btn btn-white btn-block mb-2" style="display:none" id="trigger-item" data-toggle="modal" data-target="#item"></button>
<button class="btn btn-white btn-block mb-2" style="display:none" id="trigger-gem" data-toggle="modal" data-target="#gem"></button>