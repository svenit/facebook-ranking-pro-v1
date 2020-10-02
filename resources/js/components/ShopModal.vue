<template>
    <div v-if="data" class="modal fade modal-shop" data-backdrop="true">
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
                    <span class="modal-text">Cửa Hàng</span>
                    <div style="position: absolute;top:55%;right:8%" class="row">
                        <li class="shop-icon-badge icon-badge row justify-content-between mr-4">
                            <div class="col-auto">
                                <div class="row">
                                    <div class="col-auto">
                                        <img style="width:17px" :src="$parent.asset('assets/images/icon-pack/pvp-point.png')">
                                    </div>
                                    <div class="col-auto">
                                        <strong class="pixel-font small-font notranslate"> {{ $parent.numberFormat(data.infor.pvp_points) }}</strong>
                                    </div>
                                </div>
                            </div>
                            <div class="col-auto p-0">
                                <img style="width:17px" :src="$parent.asset('assets/images/icon/Question.png')">
                            </div>
                        </li>
                        <li class="shop-icon-badge icon-badge row justify-content-between mr-4">
                            <div class="col-auto">
                                <div class="row">
                                    <div class="col-auto">
                                        <img style="width:17px" :src="$parent.asset('assets/images/icon-pack/gold.png')">
                                    </div>
                                    <div class="col-auto">
                                        <strong class="pixel-font small-font notranslate"> {{ $parent.numberFormat(data.infor.coins) }}</strong>
                                    </div>
                                </div>
                            </div>
                            <div class="col-auto p-0">
                                <img style="width:17px" :src="$parent.asset('assets/images/icon/Add.png')">
                            </div>
                        </li>
                        <li class="shop-icon-badge icon-badge row justify-content-between">
                            <div class="col-auto">
                                <div class="row">
                                    <div class="col-auto">
                                        <img style="width:17px" :src="$parent.asset('assets/images/icon-pack/diamond.png')">
                                    </div>
                                    <div class="col-auto">
                                        <strong class="pixel-font small-font notranslate"> {{ $parent.numberFormat(data.infor.gold) }}</strong>
                                    </div>
                                </div>
                            </div>
                            <div class="col-auto p-0">
                                <img style="width:17px" :src="$parent.asset('assets/images/icon/Add.png')">
                            </div>
                        </li>
                    </div>
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
                                        <div class="col-lg-2 col-md-3 col-sm-12 shop-menu p-2" style="padding-top:10px !important">
                                            <div class="nav nav-pills list-item-responsive" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                                                <div @click="$parent.loadShop('item', true)" class="nav-link nav-link-white active" id="v-pills-item-tab" data-toggle="pill" href="#v-pills-item" role="tab" aria-controls="v-pills-item" aria-selected="true">
                                                    <img width="25px" :src="$parent.asset('assets/images/icon/Shop-Item.png')" class="mr-2 align-middle"> Vật Phẩm
                                                </div>
                                                <div v-for="(menu, index) in menuShop" :key="index" @click="$parent.loadShop($parent.strSlug(menu.name), true)" class="nav-link nav-link-white" id="v-pills-equipment-tab" data-toggle="pill" href="#v-pills-equipment" role="tab" aria-controls="v-pills-equipment" aria-selected="false">
                                                    <img width="25px" :src="$parent.asset('assets/images/icon/Shop-Equipment.png')" class="mr-2 align-middle"> {{ menu.name }}
                                                </div>
                                                <div @click="$parent.loadShop('skill', true)" class="nav-link nav-link-white" id="v-pills-skill-tab" data-toggle="pill" href="#v-pills-skill" role="tab" aria-controls="v-pills-skill" aria-selected="true">
                                                    <img width="25px" :src="$parent.asset('assets/images/icon/Skill.png')" class="mr-2 align-middle"> Kỹ Năng
                                                </div>
                                                <div @click="$parent.loadShop('pet', true)" class="nav-link nav-link-white" id="v-pills-pet-tab" data-toggle="pill" href="#v-pills-pet" role="tab" aria-controls="v-pills-pet" aria-selected="true">
                                                    <img width="25px" :src="$parent.asset('assets/images/icon/Pet.png')" class="mr-2 align-middle"> Pet
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-10 col-md-9 col-sm-12 p-2">
                                            <div style="background-color: #554839;padding:0px" class="tab-content" id="v-pills-tabContent">
                                                <div class="tab-pane fade show active" id="v-pills-item" role="tabpanel" aria-labelledby="v-pills-item-tab">
                                                    <div class="b-b">
                                                        <div class="nav-active-border b-primary bottom">
                                                            <ul class="nav" id="myTab" role="tablist">
                                                                <li @click="$parent.loadShop('item' ,true)" data-title="tooltip" title="Hot" class="nav-item">
                                                                    <a class="nav-link active" id="hot-item-tab" data-toggle="tab" href="#hot-item-tab-control" role="tab" aria-controls="" aria-selected="true">
                                                                        Hot
                                                                    </a>
                                                                </li>
                                                                <li @click="$parent.loadShop('item' ,true)" data-title="tooltip" title="Tất Cả" class="nav-item">
                                                                    <a class="nav-link" id="total-item-tab" data-toggle="tab" href="#total-item-tab-control" role="tab" aria-controls="" aria-selected="true">
                                                                        Vật Phẩm
                                                                    </a>
                                                                </li>
                                                                <li @click="$parent.loadShop('gems' , true)" data-title="tooltip" title="Đá Bổ Trợ" class="nav-item">
                                                                    <a class="nav-link" id="gems-item-tab" data-toggle="tab" href="#gems-item-tab-control" role="tab" aria-controls="" aria-selected="true">
                                                                        Đá Bổ Trợ
                                                                    </a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                    <div class="tab-content">
                                                        <div class="tab-pane fade show active" id="hot-item-tab-control" role="tabpanel" aria-labelledby="hot-item-tab">
                                                            <div class="row p-2">
                                                                <div class="p-1 col-12">
                                                                    <div class="item-preview px-3 pt-3 shop-background pixel">
                                                                        <border></border>
                                                                        <img class="pixel" width="120px" :src="$parent.asset('assets/images/icon/Seller.png')">
                                                                    </div>
                                                                </div>
                                                                <div class="p-1 col-12">
                                                                    <div style="background: #33301d" class="item-preview">
                                                                        <border></border>
                                                                        <div style="max-height:330px;overflow:auto" class="row px-4 py-2">
                                                                            <div v-for="(item, index) in $parent.shop" :key="index" v-if="item.hot" class="col-ui col-ui-divide spotlight-item special-item">
                                                                                <img style="position: absolute;top:0;left:0;width:40px" :src="$parent.asset('assets/images/icon/Hot-Ribbon.png')">
                                                                                <img style="width:50px;display:block;margin:7px auto" :src="$parent.asset('assets/images/icon/Border-Top.png')">
                                                                                <p class="text-light text-center" style="font-size:13px">{{ item.name }}</p>
                                                                                <div style="height:50px;display:block;margin:10% auto 80px auto;object-fit:contain;" @click="$parent.showInforItem(item ,0)" :class="`pixel ${item.class_tag}`"></div>
                                                                                <div @click="$parent.buyItem(item ,$event)" class="pixel-font text-warning small-font pixel-btn m-3 btn-dark mt-5 text-center" style="padding:6px">
                                                                                    <img width="17px" class="mr-2" :src="$parent.asset(`assets/images/icon-pack/${$parent.getCurrency(item.price_type)}.png`)">{{ $parent.numberFormatDetail(item.price) }}
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="tab-pane fade" id="total-item-tab-control" role="tabpanel" aria-labelledby="total-item-tab">
                                                            <div class="row p-2">
                                                                <div class="p-1 col-12">
                                                                    <div class="item-preview px-3 pt-3 pixel shop-background">
                                                                        <border></border>
                                                                        <img class="pixel" width="120px" :src="$parent.asset('assets/images/icon/Seller.png')">
                                                                    </div>
                                                                </div>
                                                                <div class="p-1 col-12">
                                                                    <div style="background: #33301d" class="item-preview">
                                                                        <border></border>
                                                                        <div style="max-height:330px;overflow:auto" class="row px-4 py-2">
                                                                            <div v-for="(item, index) in $parent.shop" :key="index" class="col-ui col-ui-divide softlight-item item">
                                                                                <img style="width:50px;display:block;margin:7px auto" :src="$parent.asset('assets/images/icon/Border-Top.png')">
                                                                                <p class="text-light text-center" style="font-size:13px">{{ item.name }}</p>
                                                                                <div class="mb-3" style="height:50px;display:block;margin:15% auto 0px auto;object-fit:contain;" @click="$parent.showInforItem(item ,0)" :class="`pixel ${item.class_tag}`"></div>
                                                                                <div @click="$parent.buyItem(item ,$event)" class="pixel-font text-warning small-font pixel-btn m-3 btn-dark mt-5 text-center" style="padding:6px">
                                                                                    <img width="17px" class="mr-2" :src="$parent.asset(`assets/images/icon-pack/${$parent.getCurrency(item.price_type)}.png`)">{{ $parent.numberFormatDetail(item.price) }}
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="tab-pane fade" id="gems-item-tab-control" role="tabpanel" aria-labelledby="gems-item-tab">
                                                            <div class="row p-2">
                                                                <div class="p-1 col-12">
                                                                    <div class="item-preview px-3 pt-3 pixel shop-background">
                                                                        <border></border>
                                                                        <img class="pixel" width="120px" :src="$parent.asset('assets/images/icon/Seller.png')">
                                                                    </div>
                                                                </div>
                                                                <div class="p-1 col-12">
                                                                    <div style="background: #33301d" class="item-preview">
                                                                        <border></border>
                                                                        <div style="max-height:330px;overflow:auto" class="row px-4 py-2">
                                                                            <div v-for="(gem, index) in $parent.shop" :key="index" class="col-ui col-ui-divide softlight-item item">
                                                                                <img style="width:50px;display:block;margin:7px auto" :src="$parent.asset('assets/images/icon/Border-Top.png')">
                                                                                <p class="text-light text-center" style="font-size:13px">{{ gem.name }}</p>
                                                                                <div class="mb-3" style="height:50px;display:block;margin:20% auto 0px auto;object-fit:contain;" @click="$parent.showGem(gem ,0)" :class="`pixel gem ${gem.image}`"></div>
                                                                                <div @click="$parent.buyGem(gem ,$event)" class="pixel-font text-warning small-font pixel-btn m-3 btn-dark mt-5 text-center" style="padding:6px">
                                                                                    <img width="17px" class="mr-2" :src="$parent.asset(`assets/images/icon-pack/${$parent.getCurrency(gem.price_type)}.png`)">{{ $parent.numberFormatDetail(gem.price) }}
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="tab-pane fade" id="v-pills-equipment" role="tabpanel" aria-labelledby="v-pills-equipment-tab">
                                                    <div class="b-b">
                                                        <div class="nav-active-border b-primary bottom">
                                                            <ul class="nav" id="myTab" role="tablist">
                                                                <li v-for="(character, index) in characters" :key="index" data-title="tooltip" :title="character.name" class="nav-item">
                                                                    <a class="nav-link" :class="{'active': character.id == data.infor.character.id}" :id="`character-${character.avatar}-tab`" data-toggle="tab" :href="`#character-${character.avatar}-tab-control`" role="tab" aria-controls="" aria-selected="true">
                                                                        <img class="pixel" style="width:20px;height:20px;object-fit:contain" :src="$parent.asset(`assets/images/class/${character.avatar}.png`)">
                                                                    </a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                    <div class="tab-content">
                                                        <div v-for="(character, index) in characters" :key="index" class="tab-pane fade" :class="{'show active': character.id == data.infor.character.id}" :id="`character-${character.avatar}-tab-control`" role="tabpanel" :aria-labelledby="`character-${character.avatar}-tab`">
                                                            <div class="row p-2">
                                                                <div class="p-1 col-12">
                                                                    <div class="item-preview px-3 pt-3 pixel shop-background">
                                                                        <border></border>
                                                                        <img class="pixel" width="120px" :src="$parent.asset('assets/images/icon/Seller.png')">
                                                                    </div>
                                                                </div>
                                                                <div class="p-1 col-12">
                                                                    <div style="background: #33301d" class="item-preview">
                                                                        <border></border>
                                                                        <div style="max-height:330px;overflow:auto" class="row px-4 py-2">
                                                                            <div v-for="(item, i) in $parent.shop[character.avatar]" :key="i" class="col-ui col-ui-divide softlight-item item">
                                                                                <img style="width:50px;display:block;margin:7px auto" :src="$parent.asset('assets/images/icon/Border-Top.png')">
                                                                                <p class="text-light text-center" style="font-size:13px">{{ item.name }}</p>
                                                                                <div @click="$parent.showGearsDescription(item, 0)" class="mb-3" style="height:50px;display:block;margin:15% auto 0px auto;object-fit:contain;" :class="`pixel ${item.shop_tag}`"></div>
                                                                                <div @click="$parent.buyEquip(item ,$event)" data-title="tooltip" title="Mua" class="pixel-font text-warning small-font pixel-btn m-3 btn-dark mt-5 text-center" style="padding:6px">
                                                                                    <img width="17px" class="mr-2" :src="$parent.asset(`assets/images/icon-pack/${$parent.getCurrency(item.price_type)}.png`)">{{ $parent.numberFormatDetail(item.price) }}
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="tab-pane fade" id="v-pills-skill" role="tabpanel" aria-labelledby="v-pills-skill-tab">
                                                    <div class="b-b">
                                                        <div class="nav-active-border b-primary bottom">
                                                            <ul class="nav" id="myTab" role="tablist">
                                                                <li v-for="(character, index) in characters" :key="index" data-title="tooltip" :title="character.name" class="nav-item">
                                                                    <a class="nav-link" :class="{'active': character.id == data.infor.character.id}" :id="`character-skill-${character.avatar}-tab`" data-toggle="tab" :href="`#character-skill-${character.avatar}-tab-control`" role="tab" aria-controls="" aria-selected="true">
                                                                        <img class="pixel" style="width:20px;height:20px;object-fit:contain" :src="$parent.asset(`assets/images/class/${character.avatar}.png`)">
                                                                    </a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                    <div class="tab-content">
                                                        <div v-for="(character, index) in characters" :key="index" class="tab-pane fade" :class="{'show active': character.id == data.infor.character.id}" :id="`character-skill-${character.avatar}-tab-control`" role="tabpanel" :aria-labelledby="`character-skill-${character.avatar}-tab`">
                                                            <div class="row p-2">
                                                                <div class="p-1 col-12">
                                                                    <div class="item-preview px-3 pt-3 pixel shop-background">
                                                                        <border></border>
                                                                        <img class="pixel" width="120px" :src="$parent.asset('assets/images/icon/Seller.png')">
                                                                    </div>
                                                                </div>
                                                                <div class="p-1 col-12">
                                                                    <div style="background: #33301d" class="item-preview">
                                                                        <border></border>
                                                                        <div style="max-height:330px;overflow:auto" class="row px-4 py-2">
                                                                            <div v-for="(skill, index) in $parent.shop[character.avatar]" :key="index" class="col-ui col-ui-divide softlight-item item">
                                                                                <img style="width:50px;display:block;margin:7px auto" :src="$parent.asset('assets/images/icon/Border-Top.png')">
                                                                                <p class="text-light text-center" style="font-size:13px">{{ skill.name }}</p>
                                                                                <img :src="skill.image" @click="$parent.showSkillsDescription(skill, 0, skill.name)" class="mb-3" style="height:50px;display:block;margin:15% auto 0px auto;object-fit:contain;">
                                                                                <div @click="$parent.buySkill(skill ,$event)" data-title="tooltip" title="Mua" class="pixel-font text-warning small-font pixel-btn m-3 btn-dark mt-5 text-center" style="padding:6px">
                                                                                    <img width="17px" class="mr-2" :src="$parent.asset(`assets/images/icon-pack/${$parent.getCurrency(skill.price_type)}.png`)">{{ $parent.numberFormatDetail(skill.price) }}
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="tab-pane fade" id="v-pills-pet" role="tabpanel" aria-labelledby="v-pills-pet-tab">
                                                    <div class="b-b">
                                                        <div class="nav-active-border b-primary bottom">
                                                            <ul class="nav" id="myTab" role="tablist">
                                                                <li data-title="tooltip" title="Tất Cả" class="nav-item">
                                                                    <a class="nav-link active" id="all-pet-tab" data-toggle="tab" href="#all-pet-tab-control" role="tab" aria-controls="" aria-selected="true">
                                                                        Tất Cả
                                                                    </a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                    <div class="tab-content">
                                                        <div class="tab-pane fade show active" id="all-pet-tab-control" role="tabpanel" aria-labelledby="all-pet-tab">
                                                            <div class="row p-2">
                                                                <div class="p-1 col-12">
                                                                    <div class="item-preview px-3 pt-3 shop-background pixel">
                                                                        <border></border>
                                                                        <img class="pixel" width="120px" :src="$parent.asset('assets/images/icon/Seller.png')">
                                                                    </div>
                                                                </div>
                                                                <div class="p-1 col-12">
                                                                    <div style="background: #33301d" class="item-preview">
                                                                        <border></border>
                                                                        <div style="max-height:330px;overflow:auto" class="row px-4 py-2">
                                                                            <div v-for="(pet, index) in $parent.shop" :key="index" class="col-ui col-ui-divide softlight-item item">
                                                                                <img style="width:50px;display:block;margin:7px auto" :src="$parent.asset('assets/images/icon/Border-Top.png')">
                                                                                <p class="text-light text-center" style="font-size:13px">{{ pet.name }}</p>
                                                                                <div class="mb-3" style="height:75px;display:block;margin:15% auto 0px auto;object-fit:contain;" @click="$parent.showInforPet(pet ,0)" :class="`pixel Mount_Icon_${pet.class_tag}`"></div>
                                                                                <div @click="$parent.buyPet(pet ,$event)" class="pixel-font text-warning small-font pixel-btn m-3 btn-dark mt-5 text-center" style="padding:6px">
                                                                                    <img width="17px" class="mr-2" :src="$parent.asset(`assets/images/icon-pack/${$parent.getCurrency(pet.price_type)}.png`)">{{ $parent.numberFormatDetail(pet.price) }}
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
        },
        characters() {
            return this.$parent.app.characters;
        }
    },
}
</script>