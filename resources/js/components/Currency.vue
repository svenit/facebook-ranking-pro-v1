<template>
    <div style="position: absolute;top:55%;right:8%" class="row">
        <li class="shop-icon-badge icon-badge row justify-content-between mr-4">
            <div class="col-auto">
                <div class="row">
                    <div class="col-auto">
                        <img style="width:17px" :src="$parent.asset('assets/images/icon-pack/pvp-point.png')">
                    </div>
                    <div class="col-auto">
                        <strong class="pixel-font small-font notranslate"> {{ $parent.numberFormat($parent.data.infor.pvp_points) }}</strong>
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
                        <strong class="pixel-font small-font notranslate"> {{ $parent.numberFormat($parent.data.infor.coins) }}</strong>
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
                        <strong class="pixel-font small-font notranslate"> {{ $parent.numberFormat($parent.data.infor.gold) }}</strong>
                    </div>
                </div>
            </div>
            <div class="col-auto p-0">
                <img style="width:17px" :src="$parent.asset('assets/images/icon/Add.png')">
            </div>
        </li>
    </div>
</template>