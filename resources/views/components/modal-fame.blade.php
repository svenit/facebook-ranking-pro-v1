<div v-if="data" class="modal fade modal-fame" data-backdrop="true">
    <div style="max-width:700px" class="modal-dialog modal-ui">
        <div class="modal-content" style="position: relative">
            <div v-if="loading" class="loading-in-component loading-spinner-box">
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
                <span class="modal-text">Danh Tiếng</span>
                <button class="close" data-dismiss="modal">
                    <img style="width:30px" src="{{ asset('assets/images/icon/Close-Light.png') }}">
                </button>
            </div>
            <div class="modal-body">
                <div class="py-3 px-2">
                    <div class="b-b">
                        <div class="nav-active-border b-primary bottom">
                            <ul class="nav" id="myTab" role="tablist">
                                <li data-title="tooltip" title="Danh Tiếng" class="nav-item">
                                    <a class="nav-link active" id="fame-tab" data-toggle="tab" href="#fame-tab-control" role="tab" aria-controls="" aria-selected="true">
                                        <img class="text-center" style="width:20px;height:20px;object-fit:contain" src="{{ asset('assets/images/icon/Gold-Award.png') }}">
                                    </a>
                                </li>
                                <li @click="loadUserUtil('all-fames', true)" data-title="tooltip" title="Thông Tin" class="nav-item">
                                    <a class="nav-link" id="fame-info-tab" data-toggle="tab" href="#fame-info-tab-control" role="tab" aria-controls="" aria-selected="true">
                                        <img class="text-center" style="width:20px;height:20px;object-fit:contain" src="{{ asset('assets/images/icon/Infor.png') }}">
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="tab-content">
                        <div class="tab-pane fade show active" id="fame-tab-control" role="tabpanel" aria-labelledby="fame-tab">
                            <div class="row p-2">
                                <div class="p-1 col-12">
                                    <div style="background: #33301d" class="item-preview">
                                        <border></border>
                                        <div class="row p-3">
                                            <div class="col-lg-2 col-md-2 col-sm-12 text-center mb-3">
                                                <img style="position:absolute;width:62px" class="pixel" :src="asset(`assets/images/pvp-ranks/${data.rank.fame.icon}.png`)">
                                                <img style="width:60px" class="circle" src="http://graph.facebook.com/{{ Auth::user()->provider_id }}/picture?type=normal" alt="...">
                                            </div>
                                            <div class="pl-2 col-lg-8 col-md-8 col-sm-12 ui-center mb-3">
                                                <div class="ui-center-inside w-100 ml-2">
                                                    <div class="pixel-btn p-3 btn-brown">
                                                        <div class="row justify-content-between">
                                                            <div class="col-4">
                                                                <span style="font-size:16px !important">Danh Tiếng</span>
                                                            </div>
                                                            <div style="background:#524a3a;border-radius:3px" class="col-8">
                                                                <span style="font-size:12px" class="pixel-font text-warning">
                                                                    @{{ numberFormatDetail(data.infor.fame) }}
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-2 col-md-2 col-sm-12 text-center mb-3">
                                                <img class="pixel" style="position:absolute;width:62px" :src="asset(`assets/images/pvp-ranks/${data.rank.fame.next.icon}.png`)">
                                                <img style="width:60px" class="circle" src="http://graph.facebook.com/{{ Auth::user()->provider_id }}/picture?type=normal" alt="...">
                                            </div>
                                            <div class="col-12 mt-3">
                                                <div class="row justify-content-center">
                                                    <div class="col-lg-2 col-md-3 col-sm-3 pixel-font small-font text-warning text-center-inside">
                                                        @{{ numberFormatDetail(data.rank.fame.point) }}
                                                    </div>
                                                    <div class="col-lg-8 col-md-6 col-sm-6">
                                                        <div @click="notify(`Bạn cần ${numberFormatDetail(data.rank.fame.next.point - data.infor.fame > 0 ? data.rank.fame.next.point - data.infor.fame : 0)} điểm nữa để lên cấp`)" class="progress my-3 circle" style="height:6px;border-radius:0px;">
                                                            <div class="progress-bar pixel-font" style="background:#ffdd44;border-radius:0px;color:#333;height:6px" data-title="tooltip" :title="`Bạn cần ${numberFormatDetail(data.rank.fame.next.point - data.infor.fame > 0 ? data.rank.fame.next.point - data.infor.fame : 0)} điểm nữa để lên cấp`" :style="{width: getFamePercent() + '%'}"></div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-2 col-md-3 col-sm-3 pixel-font small-font text-warning text-center-inside">
                                                        @{{ numberFormatDetail(data.rank.fame.next.point) }}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="fame-info-tab-control" role="tabpanel" aria-labelledby="fame-info-tab">
                            <div class="row p-0">
                                <div class="px-3 py-0 col-12">
                                    <div style="background: #33301d" class="item-preview">
                                        <border></border>
                                        <div style="max-height:350px;overflow:auto" class="row px-4 py-2">
                                            <div v-for="(fame, index) in userUtil" :key="index" class="col-ui softlight-item item" :class="{'special-item': fame.icon == data.rank.fame.icon}">
                                                <img style="width:50px;display:block;margin:7px auto" src="{{ asset('assets/images/icon/Border-Top.png') }}">
                                                <img class="mb-3 pixel" style="width:50px;height:50px;display:block;margin:0 auto;object-fit:contain;transform: translate(0%, 50%);" :src="asset(`assets/images/pvp-ranks/${fame.icon}.png`)">
                                                <div class="pixel-font text-warning small-font pixel-btn m-3 btn-dark mt-5 text-center" style="padding:6px">
                                                    @{{ numberFormatDetail(fame.point) }}
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
                    Đóng <img style="width:16px" src="{{ asset('assets/images/icon/Close-White.png') }}">
                </div>
            </div>
        </div>
    </div>
</div>