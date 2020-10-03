<template>
    <div v-if="data" class="modal fade modal-world-map" data-backdrop="true">
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
                <div class="modal-header">
                    <border></border>
                    <span class="modal-text">Bản Đồ Dungeon</span>
                    <button class="close" data-dismiss="modal">
                        <img style="width:30px" :src="$parent.asset('assets/images/icon/Close-Light.png')">
                    </button>
                </div>
                <div class="modal-body">
                    <GmapMap
                        ref="map"
                        :center="center"
                        :zoom="zoom"
                        style="width: 100%; height: 500px"
                    >
                        <GmapMarker
                            v-for="(gate, index) in gates"
                            :key="index"
                            :position="gate.position"
                            :clickable="true"
                            :draggable="true"
                            @click="mapGotoPosition(gate)"
                            :icon="{
                                url: $parent.asset(gate.icon),
                                scaledSize: gate.size,
                            }"
                        >
                        <GmapInfoWindow
                            @closeclick="gate.showPopup = false"
                            :opened="gate.showPopup"
                            :position="gate.position"
                        >
                            <strong class="text-dark">[ {{ gate.positionName }} ]</strong> <span :class="`${gate.type}-gate`">Cổng {{ gateMappingType(gate.type) }} ( {{ gate.rank }} Rank )</span>
                        </GmapInfoWindow>
                        </GmapMarker>
                    </GmapMap>
                </div>
                <div class="modal-footer">
                    <div data-dismiss="modal" class="btn-green pixel-btn mr-4">
                        Vị trí của tôi
                    </div>
                    <div data-dismiss="modal" class="btn-red pixel-btn mr-4">
                        Đóng <img style="width:16px" :src="$parent.asset('assets/images/icon/Close-White.png')">
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<style scoped>
    .red-gate {
        color: rgb(231, 64, 35);
        font-weight: bold;
    }
    .blue-gate {
        color: rgb(83, 106, 202);
        font-weight: bold;
    }
</style>
<script>

export default {
    data() {
        return {
            zoom: 6,
            center: {
                lat: 21.02,
                lng: 105.84
            },
            gates: [
                {
                    positionName: 'Hồ Hoàn Kiếm',
                    type: 'blue',
                    rank: 'E',
                    showPopup: false,
                    icon: 'assets/images/icon/Blue-Gate.gif',
                    position: {
                        lat: 21.0287797,
                        lng: 105.850176
                    },
                    size: {
                        width: 30,
                        height: 30
                    }
                },
                {
                    positionName: 'Hồ Tây',
                    type: 'red',
                    rank: 'S',
                    showPopup: true,
                    icon: 'assets/images/icon/Red-Gate.gif',
                    position: {
                        lat: 21.0580712,
                        lng: 105.8063123
                    },
                    size: {
                        width: 60,
                        height: 60
                    }
                }
            ]
        }
    },
    computed: {
        data() {
            return this.$parent.data;
        }
    },
    methods: {
        mapGotoPosition(gate) {
            this.center = gate.position;
            gate.showPopup = true;
            this.zoom = 15;
        },
        gateMappingType(type) {
            let types = {
                red: 'Đỏ',
                blue: 'Xanh'
            }
            return types[type];
        }
    }
}
</script>