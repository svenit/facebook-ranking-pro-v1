{{-- @auth
@if(!request()->is(config('game.hiddenCharacter')))
<div data-step="1" data-intro="Đây là nhân vật của bạn, nhấp vào để xem thông tin nhân vật" id="character" ref="character" @click="index()"  style="margin:10px 0px 20px 10px;position:relative;transform:scaleX(-1) scale(.8)" data-title="tooltip" title="Click để xem thông số" data-toggle="modal" data-target=".modal-left" data-toggle-class="modal-open-aside" data-target="body" class="character-sprites hoverable">
    <span v-if="data.pet" style="z-index:2" :class="`Mount_Body_${data.pet.class_tag}`"></span>
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
@endif
@endauth --}}