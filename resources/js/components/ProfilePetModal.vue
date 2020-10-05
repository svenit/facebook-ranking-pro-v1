<template>
    <div v-if="data" class="modal fade modal-profile-pet" data-backdrop="true">
        <div class="modal-dialog modal-ui modal-xl">
            <div class="modal-content" style="position: relative">
                <div v-if="$parent.loading" class="loading-in-component loading-spinner-box">
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
                <div style="position: relative" class="modal-header">
                    <border></border>
                    <span class="modal-text">Thú Cưỡi</span>
                    <currency></currency>
                    <button class="close" data-dismiss="modal">
                        <img style="width:30px" :src="$parent.asset('assets/images/icon/Close-Light.png')">
                    </button>
                </div>
                <div class="modal-body">
                    <div class="p-1">
                        <div class="p-1">
                            <div style="background: #f5efd9" class="p-1">
                                <div class="p-2" style="background: #554839">
                                    <div style="padding:10px" class="row">
                                        <div class="col-lg-3 col-md-3 col-sm-3 shop-menu p-2 hide-in-mobile" style="position: relative;padding-top:10px !important">
                                            <div style="margin:0 auto;position: absolute;left: 40%;transform:scaleX(-1)" :style="data.pet ? 'bottom: 27%' : 'bottom: 18%'" class="character-sprites hoverable">
                                                <span v-if="data.pet" :class="`Mount_Body_${data.pet.class_tag}`"></span>
                                                <span style="z-index:2" class="skin_f5a76e up-to-down"></span>
                                                <span style="z-index:2" class="broad_shirt_black up-to-down"></span>
                                                <span style="z-index:2" class="head_0 up-to-down"></span>
                                                <span class=""></span>
                                                <span v-for="(gear,index) in data.gears" :key="index">
                                                    <span v-if="gear.class_tag.includes(' ')"><span v-for="(e, i) in gear.class_tag.split(' ')" :key="i" :class="`${e} ${gear.cates.animation} up-to-down`" :style="{zIndex:gear.cates.z_index}"></span></span>
                                                    <span v-else :class="`${gear.class_tag} ${gear.cates.animation} up-to-down`" :style="{zIndex:gear.cates.z_index}"></span>
                                                </span>
                                                <span v-if="data.pet" style="z-index:50" :class="`Mount_Head_${data.pet.class_tag}`"></span>
                                            </div>
                                            <img style="width:100%;height:100%;object-fit:cover" :src="$parent.asset('assets/images/icon/User-Item-Background.png')">
                                        </div>
                                        <div class="col-lg-9 col-md-9 col-sm-9 p-2">
                                            <div style="background-color: #554839;padding:0px" class="tab-content" id="v-pills-pet">
                                                <div class="tab-pane fade show active" role="tabpanel">
                                                    <div class="b-b">
                                                        <div class="nav-active-border b-primary bottom">
                                                            <ul class="nav" id="myTab" role="tablist">
                                                                <li data-title="tooltip" title="Đã trang bị" class="nav-item">
                                                                    <a class="nav-link active" id="total-user-pet-tab" data-toggle="tab" href="#total-user-pet-tab-control" role="tab" aria-controls="" aria-selected="true">
                                                                        Tất Cả
                                                                    </a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                    <div class="tab-content">
                                                        <div class="tab-pane fade show active" id="total-user-pet-tab-control" role="tabpanel" aria-labelledby="total-user-pet-tab">
                                                            <div class="row p-2">
                                                                <div class="p-1 col-12">
                                                                    <div style="background: rgb(199, 188, 152)" class="item-preview">
                                                                        <div style="max-height:400px;overflow:auto" class="row px-4 py-2">
                                                                            <div v-for="(item, index) in $parent.profileInventory" :key="index" @click="$parent.showInforPet(item, 1)" style="position:relative; background: rgb(82, 74, 60);margin: 10px; border-radius:3px" class="p-0 col-auto">
                                                                                <div :class="[`pixel Mount_Icon_${item.class_tag}`]"></div>
                                                                                <span style="position: absolute;bottom: 5px; right: 5px" class="pixel-font small-font">
                                                                                    <span v-if="item.pivot" :class="`avatar-status ${item.pivot.status == 1 ? 'on' : 'away'} b-white avatar-right`"></span>
                                                                                </span>
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
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div data-dismiss="modal" class="btn-red pixel-btn mr-4">
                        Đóng <img style="width:16px" :src="$parent.asset('assets/images/icon/Close-White.png')">
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import Border from './Border';
import Currency from './Currency';
export default {
    components: {
        Border
    },
    computed: {
        data() {
            return this.$parent.data;
        },
        menuShop() {
            return this.$parent.app.cateGears;
        }
    },
}
</script>