@auth
<div v-if="data" class="modal fade modal-left" data-backdrop="true">
    <div style="overflow:auto;width:350px;" class="modal-dialog modal-left w-xl">
        <div style="min-height:100vh;background:#111 !important;" class="modal-content vip-bordered no-radius">
            <div class="modal-header">
                <button class="close" data-dismiss="modal">&times;</button>
            </div>
            <div style="overflow:auto;height:200px" class="modal-body">
                <div class="p-4">
                    <p class="pixel-font text-gold" style="text-align:center !important;">{{ isset(Auth::user()->config['rank']) ? Auth::user()->config['rank'] : 'E' }} RANK <img style="width:16px" :src="data.infor.character.avatar"></p>
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
                    <p style="margin-top:20px" class="text-muted text-center">@{{ data.infor.name }} ( @{{ data.infor.character.name }} )</p>
                </div>
                <div class="row row-sm">
                    <div class="col-12 d-flex">
                        <p class="text-gold pixel-font">LC : @{{ numberFormat(data.power.total) }} </p>
                    </div>
                    <div class="col-12 d-flex">
                        <div class="flex">
                                <div class="text-info pixel-font small-font">
                                Level 
                                @{{ data.level.current_level }} 
                                <i class="fas fa-arrow-right"></i> 
                                @{{ data.level.next_level }} 
                                ( @{{ data.level.percent }} % )
                                <div @click="notify(`Bạn cần ${(data.level.next_level_exp - data.level.current_user_exp)} kinh nghiệm nữa để lên cấp`)" class="progress my-3 circle" style="height:6px">
                                    <div class="progress-bar circle gd-info" data-title="tooltip" :title="`Bạn cần ${(data.level.next_level_exp - data.level.current_user_exp)} kinh nghiệm nữa để lên cấp`" :style="{width:data.level.percent + '%'}">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 d-flex">
                        <div class="flex">
                            <div class="text-light pixel-font small-font"><i class="normal-text fas fa-chevron-double-up"></i> Level <strong
                                        class="text-light">@{{ data.level.current_level }}</strong>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 d-flex">
                        <div class="flex">
                            <div class="text-success pixel-font small-font"><i class="normal-text fas fa-heart"></i> HP <strong
                                        class="text-success">@{{ data.power.hp }}</strong>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 d-flex mt-2">
                        <div class="flex">
                            <div class="text-danger pixel-font small-font"><i class="normal-text fas fa-swords"></i> STR <strong
                                        class="text-danger">@{{ data.power.strength }}</strong>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 d-flex mt-2">
                        <div class="flex">
                            <div class="text-info pixel-font small-font"><i class="normal-text fas fa-brain"></i> INT <strong
                                        class="text-info">@{{ data.power.intelligent }}</strong>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 d-flex mt-2">
                        <div class="flex">
                            <div class="text-primary"><small><i class="normal-text fas fa-bolt"></i> AGI <strong
                                        class="text-primary">@{{ data.power.agility }}</strong></small>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 d-flex mt-2">
                        <div class="flex">
                            <div class="text-warning pixel-font small-font"><i class="normal-text fas fa-stars"></i> LUK <strong
                                        class="text-warning">@{{ data.power.lucky }}</strong>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 d-flex mt-2">
                        <div class="flex">
                            <div class="text-silver pixel-font small-font"><i class="normal-text fas fa-shield"></i> DEF <strong
                                        class="text-silver">@{{ data.power.armor_strength }}</strong>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 d-flex mt-2">
                        <div class="flex">
                            <div class="text-purple pixel-font small-font"><i class="normal-text fal fa-dice-d20"></i> AM <strong
                                        class="text-purple">@{{ data.power.armor_intelligent }}</strong>
                            </div>
                        </div>
                    </div>
                </div>
                <br>
                <p class="text-gold">Thông Tin</p>
                <div class="row row-sm">
                    <div class="col-6 d-flex my-2">
                        <div class="flex">
                            <div class="text-muted"><small><img style="width:15px" class="mr-1" src="{{ asset('assets/images/icon-pack/gold.png') }}"> <strong
                                        class="text-muted pixel-font small-font"> @{{ numberFormat(data.infor.coins) }}</strong></small>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 d-flex my-2">
                        <div class="flex">
                            <div class="text-muted"><small><img style="width:15px" class="mr-1" src="{{ asset('assets/images/icon-pack/diamond.png') }}"> <strong
                                        class="text-muted pixel-font small-font"> @{{ numberFormat(data.infor.gold) }}</strong></small>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 d-flex">
                        <div class="flex">
                            <div class="text-muted"><small><img style="width:15px" class="mr-1" src="{{ asset('assets/images/icon-pack/pvp-point.png') }}"> <strong
                                class="text-muted pixel-font small-font"> @{{ numberFormatDetail(data.infor.pvp_points) }}</strong></small>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 d-flex">
                        <div class="flex">
                            <div class="text-muted"><small><img style="width:15px" class="mr-1" src="{{ asset('assets/images/icon-pack/energy.png') }}"> <strong
                                        class="text-muted pixel-font small-font"> @{{ numberFormatDetail(data.infor.energy) }}</strong></small>
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
    <div style="max-width:700px" class="modal-dialog">
        <div class="lighting-box modal-content bg-dark">
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
                                        class="text-success">+ @{{ detailGear.data.health_points.default }} ( +@{{ detailGear.data.health_points.percent }}% )</strong></small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6 d-flex mt-2">
                                <div class="flex">
                                    <div class="text-danger"><small><i class="fas fa-swords"></i> Sức Mạnh <strong
                                        class="text-danger">+ @{{ detailGear.data.strength.default }} ( +@{{ detailGear.data.strength.percent }}% )</strong></small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6 d-flex mt-2">
                                <div class="flex">
                                    <div class="text-info"><small><i class="fas fa-brain"></i> Trí Tuệ <strong
                                        class="text-info">+ @{{ detailGear.data.intelligent.default }} ( +@{{ detailGear.data.intelligent.percent }}% )</strong></small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6 d-flex mt-2">
                                <div class="flex">
                                    <div class="text-primary"><small><i class="fas fa-bolt"></i> Nhanh Nhẹn <strong
                                        class="text-primary">+ @{{ detailGear.data.agility.default }} ( +@{{ detailGear.data.agility.percent }}% )</strong></small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6 d-flex mt-2">
                                <div class="flex">
                                    <div class="text-warning"><small><i class="fas fa-stars"></i> May Mắn <strong
                                        class="text-warning">+ @{{ detailGear.data.lucky.default }} ( +@{{ detailGear.data.lucky.percent }}% )</strong></small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6 d-flex mt-2">
                                <div class="flex">
                                    <div class="text-silver"><small><i class="fas fa-shield"></i> Kháng Công <strong
                                        class="text-silver">+ @{{ detailGear.data.armor_strength.default }} ( +@{{ detailGear.data.armor_strength.percent }}% )</strong></small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6 d-flex mt-2">
                                <div class="flex">
                                    <div class="text-purple"><small><i class="fal fa-dice-d20"></i> Kháng Phép <strong
                                        class="text-purple">+ @{{ detailGear.data.armor_intelligent.default }} ( +@{{ detailGear.data.armor_intelligent.percent }}% )</strong></small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div style="margin:10px 20px" class="row">
                            <div v-for="(gem, index) in detailGear.data.gems" :key="index" style="padding:5px" class="col-auto">
                                <div :style="{border:`1px solid ${gem.gem_item.rgb}`}" :class="`gem ${gem.gem_item.image}`" @click="showGem(gem,detailGear.permission)" width="40px"></div>
                            </div>
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
<div id="aside-left" class="page-sidenav no-shrink bg-light nav-dropdown fade hide" aria-hidden="true">
    <div class="sidenav h-100 modal-dialog bg-light normal-bordered">
        <div class="navbar"><a href="{{ Route('user.index') }}" class="navbar-brand">
            <img src="{{ asset('assets/images/app.png') }}">
            <span style="font-weight:inherit;" class="pixel-font hidden-folded text-warning d-inline l-s-n-1x">{{ env('APP_NAME') }}</span></a></div>
        <div class="flex scrollable hover left-side">
            <div class="nav-active-text-primary" data-nav>
                <ul class="nav bg">
                    <li class="nav-header hidden-folded"><span class="text-muted">Hiệp Hội</span></li>
                    <li><a class="no-ajax" href="{{ Route('user.index') }}"><span class="nav-icon"><i
                                    data-feather="box"></i></span> <span class="nav-text">Hiệp Hội</span></a></li>
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
                                <li><a href="{{ Route('user.top.pvp') }}" class=""><span class="nav-text">PVP Arena</span></a></li>
                                <li><a href="{{ Route('user.top.coin') }}" class=""><span class="nav-text">Vàng</span></a></li>
                                <li><a href="{{ Route('user.top.gold') }}" class=""><span class="nav-text">Kim Cương</span></a></li>
                                <li><a href="{{ Route('user.top.activities') }}" class=""><span class="nav-text">Hoạt Động</span></a></li>
                            </ul>
                        </li>
                        <li class="{{ Request::is('events/*') ? 'active' : '' }}"><a href="#" class=""><span class="nav-icon"><img style="width:20px" src="{{ asset('assets/images/Casino.png') }}"></span> <span
                                    class="nav-text">Cansino</span> <span class="nav-caret"></span></a>
                            <ul class="nav-sub nav-mega">
                                <li><a href="{{ Route('user.events.wheel') }}" class=""><span class="nav-text">VQMM</span></a></li>
                                <li><a href="{{ Route('user.events.lucky-box') }}" class=""><span class="nav-text">Cá Cược</span></a></li>
                            </ul>
                        </li>
                        <li class="{{ Request::is('shop/*') ? 'active' : '' }}"><a href="#" class=""><span class="nav-icon"><img style="width:20px" src="{{ asset('assets/images/Shop.png') }}"></span> <span
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
                        <li class="{{ Request::is('oven/*') ? 'active' : '' }}"><a href="#" class=""><span class="nav-icon"><img style="width:20px" src="{{ asset('assets/images/Smith.png') }}"></span> <span
                            class="nav-text">Tiệm Rèn</span> <span class="nav-caret"></span></a>
                            <ul class="nav-sub nav-mega">
                                <li><a href="{{ Route('user.oven.gem') }}" class=""><span class="nav-text">Khảm Ngọc</span></a></li>
                            </ul>
                        </li>
                        <li class="{{ Request::is('explore/*') ? 'active' : '' }}"><a href="#" class=""><span class="nav-icon"><img style="width:20px" src="{{ asset('assets/images/Quest.png') }}"></span> <span
                            class="nav-text">Nhiệm Vụ</span> <span class="nav-caret"></span></a>
                            <ul class="nav-sub nav-mega">
                                <li><a href="#" class=""><span class="nav-text">Hàng Ngày</span></a></li>
                                <li><a href="#" class=""><span class="nav-text">Thành Tựu</span></a></li>
                                {{-- <li><a href="{{ Route('user.recovery-room.index') }}" class=""><span class="nav-text">Phòng Hồi Phục</span></a></li> --}}
                            </ul>
                        </li>
                        <li class="{{ Request::is('dungeon/*') ? 'active' : '' }}"><a href="#" class=""><span class="nav-icon"><img style="width:20px" src="{{ asset('assets/images/Dungeon.png') }}"></span> <span
                            class="nav-text">Dungeon</span></a>
                        </li>
                        <li class="{{ Request::is('guild/*') || Request::is('guild')  ? 'active' : '' }}"><a href="#" class=""><span class="nav-icon"><img style="width:20px" src="{{ asset('assets/images/Guild.png') }}"></span> <span
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
                        <li class="{{ Request::is('pvp/*') ? 'active' : '' }}"><a href="#" class=""><span class="nav-icon"><img style="width:20px" src="{{ asset('assets/images/PVP_Icon.png') }}"></span> <span
                            class="nav-text">PVP Arena</span><span class="nav-badge"><b class="badge-circle xs text-success"></b></span> <span class="nav-caret"></span></a>
                            <ul class="nav-sub nav-mega">
                                <li><a href="{{ Route('user.pvp.index') }}" class=""><span class="nav-text">Tham Gia</span></a></li>
                            </ul>
                        </li>
                        {{-- <li class="{{ Request::is('chat/*') ? 'active' : '' }}"><a href="#" class=""><span class="nav-icon"><i data-feather="message-circle"></i></span> <span
                            class="nav-text">Chat</span> <span class="nav-badge"><b class="badge-circle xs text-success"></b></span><span class="nav-caret"></span></a>
                            <ul class="nav-sub nav-mega">
                                <li><a href="{{ Route('user.chat.global') }}" class=""><span class="nav-text">Thế Giới</span></a></li>
                                <li><a onclick="return confirm('Bạn đang có {{ Auth::user()->stranger_chat_times ?? 0 }} vé chat ! Tham gia ?')" href="{{ Route('user.chat.stranger.join') }}" class=""><span class="nav-text">CVNL</span></a></li>
                            </ul>
                        </li> --}}
                        <li><a href="{{ Route('user.giftcode.index') }}" class=""><span class="nav-icon"><img style="width:20px" src="{{ asset('assets/images/Gif.png') }}"></span> <span
                            class="nav-text">Quà Tặng</span></a>
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
@endif
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
    <script>
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
    </script>
    @endauth
    <script src="{{ asset('assets/js/vue/app.js') }}"></script>
@endpush
@endif
<button class="btn btn-white btn-block mb-2" style="display:none" id="trigger-gear" data-toggle="modal" data-target="#gear"></button>
<button class="btn btn-white btn-block mb-2" style="display:none" id="trigger-pet" data-toggle="modal" data-target="#pet"></button>
<button class="btn btn-white btn-block mb-2" style="display:none" id="trigger-item" data-toggle="modal" data-target="#item"></button>
<button class="btn btn-white btn-block mb-2" style="display:none" id="trigger-gem" data-toggle="modal" data-target="#gem"></button>
<button class="btn btn-white btn-block mb-2" style="display:none" id="trigger-skill" data-toggle="modal" data-target="#skill"></button>
<button id="show-infor-user" style="display:none" data-toggle="modal" data-target=".modal-right" data-toggle-class="modal-open-aside" data-target="body"></button>
<button id="show-profile" style="display:none" data-toggle="modal" data-target=".modal-left" data-toggle-class="modal-open-aside" data-target="body"></button>
