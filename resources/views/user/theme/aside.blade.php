@include('components.modal-profile')
@include('components.modal-profile-item')
@include('components.modal-profile-equipment')
@include('components.modal-fame')
@include('components.modal-equipment')
@include('components.modal-shop')
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
<button id="show-infor-user" style="display:none" data-toggle="modal" data-target=".modal-right" data-toggle-class="modal-open-aside" data-target="body"></button>
<button id="show-profile" style="display:none" data-toggle="modal" data-target=".modal-left" data-toggle-class="modal-open-aside" data-target="body"></button>
