@extends('app')
@section('content')

@section('hero','Tổng Quan')


<div id="content" class="flex">
    <div id="ranking" class="">
        <div class="page-content page-container" id="page-content">
            <div class="padding-x">
                <div class="col-12">
                    <div class="row">
                        <div class="col-12">
                            <div id="current-online"></div>
                        </div>
                    </div>
                    <div class="row row-sm">
                        <div class="col-8">
                            <div class="row row-sm">
                                <div class="col-12">
                                    <div class="card vip-bordered" data-sr-id="31"
                                        style="visibility: visible; transform: none; opacity: 1; transition: none 0s ease 0s;">
                                        <div class="card-body">
                                            <div class="row row-sm">
                                                <div class="col-4"><small class="text-muted">Trạng Thái</small>
                                                    <div class="mt-2 font-weight-500"><span class="{{ $config->maintaince == 0 ? 'text-success' : 'text-danger' }}">{{ $config->maintaince == 0 ? 'Hoạt Động' : 'Bảo Trì' }}</span></div>
                                                </div>
                                                <div class="col-4"><small class="text-muted">Người Dùng</small>
                                                    <div class="text-gold mt-2 font-weight-500">{{ $usersActive }}/{{ $users->count() }}</div>
                                                </div>
                                                <div class="col-4"><small class="text-muted">Ngày Bắt Đầu</small>
                                                    <div class="text-warning mt-2 font-weight-500">{{ $config->started_day }} ( {{ \Carbon\Carbon::parse($config->started_day)->diffForHumans() }} )</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row row-sm">
                                <div class="col-6 d-flex">
                                    <div class="card flex vip-bordered" data-sr-id="32"
                                        style="visibility: visible; transform: none; opacity: 1; transition: none 0s ease 0s;">
                                        <div class="card-body"><small>Đang Online : <strong
                                                    class="text-success">{{ $users->allOnline()->count() }}</strong></small>
                                            <div class="progress my-3 circle" style="height:6px">
                                                <div class="progress-bar circle gd-success" data-toggle="tooltip"
                                                    title="" style="width: {{ ($users->allOnline()->count()/$users->count())*100 }}%" data-original-title="65%"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6 d-flex">
                                    <div class="card flex vip-bordered" data-sr-id="33"
                                        style="visibility: visible; transform: none; opacity: 1; transition: none 0s ease 0s;">
                                        <div class="card-body"><small>Online Gần Nhất : <strong
                                                    class="text-warning">{{ $users->leastRecentOnline()->count() }}</strong></small>
                                            <div class="progress my-3 circle" style="height:6px">
                                                <div class="progress-bar circle gd-warning" data-toggle="tooltip"
                                                    title="" style="width: {{ ($users->leastRecentOnline()->count()/$users->count())*100 }}%" data-original-title="25%"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-4 d-flex">
                            <div class="card flex vip-bordered" data-sr-id="34"
                                style="visibility: visible; transform: none; opacity: 1; transition: none 0s ease 0s;">
                                <div class="card-body text-center">
                                    <div class="pt-3">
                                        <div style="height: 120px" class="pos-rlt">
                                            <div class="chartjs-size-monitor"
                                                style="position: absolute; left: 0px; top: 0px; right: 0px; bottom: 0px; overflow: hidden; pointer-events: none; visibility: hidden; z-index: -1;">
                                                <div class="chartjs-size-monitor-expand"
                                                    style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;">
                                                    <div
                                                        style="position:absolute;width:1000000px;height:1000000px;left:0;top:0">
                                                    </div>
                                                </div>
                                                <div class="chartjs-size-monitor-shrink"
                                                    style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;">
                                                    <div style="position:absolute;width:200%;height:200%;left:0; top:0">
                                                    </div>
                                                </div>
                                            </div>
                                            <div
                                                class="pos-abt w-100 h-100 d-flex align-items-center justify-content-center">
                                                <div>
                                                    <div class="text-highlight text-md"><span>{{ number_format($users->sum('coins')) }}</span></div><small
                                                        class="text-muted">Tương Tác</small>
                                                </div>
                                            </div><canvas id="chart-pie-1" width="394" height="240"
                                                class="chartjs-render-monitor"
                                                style="display: block; height: 120px; width: 197px;"></canvas>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-7">
                            <div class="card vip-bordered" data-sr-id="48" style="visibility: visible; transform: none; opacity: 1; transition: none 0s ease 0s;">
                                <div class="p-3-4">
                                    <div class="d-flex">
                                        <div>
                                            <div class="text-success">Đang Hoạt Động</div>
                                        </div>
                                    </div>
                                </div>
                                <table class="table table-theme v-middle m-0">
                                    <tbody>
                                        @foreach($users->allOnline() as $key => $user)
                                            <tr class="" data-id="15">
                                                <td style="min-width:30px;text-align:center">{{ $key + 1 }}</td>
                                                <td>
                                                    <div class="avatar-group">
                                                        <a href="#" class="avatar ajax w-32" data-toggle="tooltip" title="" data-pjax-state="" data-original-title="Lobortis"><img src="http://graph.facebook.com/{{ $user->provider_id }}/picture?type=normal" alt="."></a>
                                                    </div>
                                                </td>
                                                <td class="flex"><a href="#" class="text-gold item-company ajax h-1x" data-pjax-state="">{{ $user->name }}</a>
                                                </td>
                                                <td><span class="item-amount d-none d-sm-block text-sm">{{ number_format($user->getCoins()) }}$</span></td>
                                                <td>
                                                    <span class="item-amount d-none d-sm-block text-sm">{{ $user->character->name }}</span>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="col-md-5">
                            <form method="POST" action="{{ Route('admin.dashboard.exceute-query') }}">
                                @csrf
                                <div class="card vip-bordered">
                                    <div class="card-header text-info"><strong>Câu Truy Vấn Nhanh ( SQL )</strong></div>
                                    <div class="card-body">
                                        <div class="md-form-group">
                                            <textarea name="command" class="md-input" rows="4">{{ old('query') }}</textarea>
                                            <label>Nhập câu truy vấn SQL</label>
                                        </div>
                                        <button class="btn btn-success">Thực Thi</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('js')
    <script>
      $(document).ready(() => {
            var options = {
                chart: {
                    sparkline: {
                        enabled:!1
                    },
                    height:250,
                    type:"area",
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
                labels: [],
                series: [{
                    name: 'Realtime User Tracking',
                    data: []
                }]
            };
            window.currentOnlineChart = new ApexCharts(document.querySelector("#current-online"),options);
            window.currentOnlineChart.render();
        });
    </script>
    <script src="{{ asset('assets/js/vue/app.js') }}"></script>
@endpush
