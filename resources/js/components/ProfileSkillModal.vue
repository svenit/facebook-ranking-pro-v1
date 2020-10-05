<template>
    <div v-if="data" class="modal fade modal-profile-skill" data-backdrop="true">
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
                    <span class="modal-text">Kỹ Năng</span>
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
                                        <div class="col-lg-3 col-md-3 col-sm-3 shop-menu p-2 hide-in-mobile" style="padding-top:10px !important">
                                            <img style="width:100%;height:100%;object-fit:cover" :src="$parent.asset('assets/images/icon/User-Item-Background.png')">
                                        </div>
                                        <div class="col-lg-9 col-md-9 col-sm-9 p-2">
                                            <div style="background-color: #554839;padding:0px" class="tab-content" id="v-pills-tabContent">
                                                <div class="tab-pane fade show active" id="v-pills-user-skill" role="tabpanel" aria-labelledby="v-pills-user-skill-tab">
                                                    <div class="b-b">
                                                        <div class="nav-active-border b-primary bottom">
                                                            <ul class="nav" id="myTab" role="tablist">
                                                                <li data-title="tooltip" title="Đã trang bị" class="nav-item">
                                                                    <a class="nav-link active" @click="$parent.loadProfile('skill', true)" id="user-skill-tab" data-toggle="tab" href="#user-skill-tab-control" role="tab" aria-controls="" aria-selected="true">
                                                                        Đã Trang Bị
                                                                    </a>
                                                                </li>
                                                                <li data-title="tooltip" title="Tất cả" class="nav-item">
                                                                    <a class="nav-link" @click="$parent.loadProfile('skill', true)" id="total-user-skill-tab" data-toggle="tab" href="#total-user-skill-tab-control" role="tab" aria-controls="" aria-selected="true">
                                                                        Tất Cả
                                                                    </a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                    <div class="tab-content">
                                                        <div class="tab-pane fade show active" id="user-skill-tab-control" role="tabpanel" aria-labelledby="user-skill-tab">
                                                            <div class="row p-2">
                                                                <div class="p-1 col-12">
                                                                    <div style="background: rgb(199, 188, 152)" class="item-preview">
                                                                        <div style="max-height:400px;overflow:auto" class="row px-4 py-2">
                                                                            <div v-for="(item, index) in $parent.profileInventory" :key="index" v-if="item.pivot.status == 1" @click="$parent.showSkillsDescription(item, 1)" style="position:relative; background: rgb(82, 74, 60);margin: 10px; border-radius:3px" class="p-0 col-auto">
                                                                                <img class="w-56" :src="item.image" alt=".">
                                                                                <span style="position: absolute;bottom: 5px; right: 5px" class="pixel-font small-font">
                                                                                    <span :class="`avatar-status ${item.pivot.status == 1 ? 'on' : 'away'} b-white avatar-right`"></span>
                                                                                </span>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="tab-pane fade" id="total-user-skill-tab-control" role="tabpanel" aria-labelledby="total-user-skill-tab">
                                                            <div class="row p-2">
                                                                <div class="p-1 col-12">
                                                                    <div style="background: rgb(199, 188, 152)" class="item-preview">
                                                                        <div style="max-height:400px;overflow:auto" class="row px-4 py-2">
                                                                            <div v-for="(item, index) in $parent.profileInventory" :key="index" @click="$parent.showSkillsDescription(item, 1)" style="position:relative; background: rgb(82, 74, 60);margin: 10px; border-radius:3px" class="p-0 col-auto">
                                                                                <img class="w-56" :src="item.image" alt=".">
                                                                                <span style="position: absolute;bottom: 5px; right: 5px" class="pixel-font small-font">
                                                                                    <span :class="`avatar-status ${item.pivot.status == 1 ? 'on' : 'away'} b-white avatar-right`"></span>
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
        }
    },
}
</script>