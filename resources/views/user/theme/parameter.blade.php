@auth
@if(isset(Auth::user()->config['relife']) && Auth::user()->config['relife'])
    <div 
        onclick="Swal.fire('',`<p class='text-gold'><strong>NGƯỜI VƯỢT LÊN TỪ NGHỊCH CẢNH</strong></p><p>Trải qua mọi khó khăn và nguy hiểm nhưng bạn vẫn giữ được sự bình tĩnh và sự quyết đoán trong từng hành động, danh hiệu này xứng đáng dành cho bạn</p><p class='text-success'>Tất cả chỉ số x2</p><p class='text-success'>Hệ thống Quest ẩn</p><p class='text-success'>+2 điểm chỉ số mỗi level</p><p style='font-size:11px'><i>* Chỉ có bạn mới có thể nhìn thấy thông báo này</i></p>`)" 
        class="text-gold" style="font-weight:inherit;font-size:11px">Vượt Lên Từ Nghịch Cảnh
    </div>
@endif
@if(!request()->is('pvp/room/*'))
<div id="character" ref="character" @click="index()"  style="margin:10px 0px 20px 10px;display:none" data-title="tooltip" title="Click để xem thông số" data-toggle="modal" data-target=".modal-left" data-toggle-class="modal-open-aside" data-target="body" style="margin:0px 10px 35px 0px" class="character-sprites hoverable">
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
@endif
@endauth