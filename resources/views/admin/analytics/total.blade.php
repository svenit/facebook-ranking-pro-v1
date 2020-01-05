@extends('app')
@section('content')

@section('hero','Truy Cập')
@section('sub_hero','Lượt truy cập theo giờ')

<div id="content" class="flex">
    <div id="ranking" class="">
        <div class="page-content page-container" id="page-content">
            <div class="padding-x">
                <div class="col-12 vip-bordered">
                    <div class="d-inline-flex mb-4 toolbar">
                        <div class="dropdown mb-2"><button class="btn btn-white dropdown-toggle" data-toggle="dropdown"
                                aria-expanded="false">Biểu Đồ</button>
                            <div class="dropdown-menu bg-dark" role="menu" x-placement="bottom-start"
                                style="position: absolute; transform: translate3d(0px, 34px, 0px); top: 0px; left: 0px; will-change: transform;">
                                <a onclick="setView('area')" class="dropdown-item">Area</a>
                                <a onclick="setView('line')" class="dropdown-item">Line </a>
                                <a onclick="setView('bar')" class="dropdown-item">Bar</a>
                            </div>
                        </div>
                    </div>
                    <div class="b-b">
                        <div class="nav-active-border b-primary bottom">
                            <ul class="nav" id="myTab" role="tablist">
                                <li class="nav-item"><a class="nav-link active" id="index-tab" data-toggle="tab" href="#home-index" role="tab" aria-controls="home-index" aria-selected="true">Tổng Quan</a></li>
                                <li class="nav-item"><a class="nav-link" id="mobile-tab" data-toggle="tab" href="#home-mobile" role="tab" aria-controls="home-mobile" aria-selected="false">Hệ Điều Hành</a></li>
                                <li class="nav-item"><a class="nav-link" id="browser-tab" data-toggle="tab" href="#home-browser" role="tab" aria-controls="home-browser" aria-selected="false">Trình Duyệt</a></li>
                                <li class="nav-item"><a class="nav-link" id="country-tab" data-toggle="tab" href="#home-country" role="tab" aria-controls="home-country" aria-selected="false">Quốc Gia</a></li>
                                <li class="nav-item"><a class="nav-link" id="refer-tab" data-toggle="tab" href="#home-refer" role="tab" aria-controls="home-refer" aria-selected="false">Chuyển Hướng</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="tab-content p-3">
                        <div class="tab-pane fade show active" id="home-index" role="tabpanel" aria-labelledby="index-tab">
                            <div class="row">
                                <div class="col-12">
                                    <div class="card" data-sr-id="31"
                                        style="visibility: visible; transform: none; opacity: 1; transition: none 0s ease 0s;">
                                        <div class="card-body">
                                            <div class="row row-sm">
                                                <div class="col-3"><small class="text-muted">Người Dùng </small>
                                                    <div class="mt-2 font-weight-500"><span class="text-success">{{ $total['activeVisitors'] }}</span></div>
                                                </div>
                                                <div class="col-3"><small class="text-muted">Số Phiên </small>
                                                    <div class="mt-2 font-weight-500"><span class="text-info">{{ $total['ga:sessions'] }}</span></div>
                                                </div>
                                                <div class="col-3"><small class="text-muted">Lượt Xem</small>
                                                    <div class="text-gold mt-2 font-weight-500">{{ $total['ga:pageviews'] }}</div>
                                                </div>
                                                <div class="col-3"><small class="text-muted">Thời Gian Phiên</small>
                                                    <div class="text-warning mt-2 font-weight-500">{{ $total['ga:sessionDuration']/1000 }}s</div>
                                                </div>
                                                <div class="col-3"><small class="text-muted">Tỉ Lệ Thoát</small>
                                                    <div class="text-silver mt-2 font-weight-500">{{ $total['ga:exits'] }}</div>
                                                </div>
                                                <div class="col-3"><small class="text-muted">Bounce</small>
                                                    <div class="text-danger mt-2 font-weight-500">{{ $total['ga:bounces'] }}</div>
                                                </div>
                                                @foreach($types as $type)
                                                    <div class="col-3"><small class="text-muted">{{ $type['type'] }}</small>
                                                        <div class="text-purple mt-2 font-weight-500">{{ $type['sessions'] }}</div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="home-mobile" role="tabpanel" aria-labelledby="mobile-tab">
                            <div id="os-chart"></div>
                        </div>
                        <div class="tab-pane fade" id="home-browser" role="tabpanel" aria-labelledby="browser-tab">
                            <div id="browser-chart"></div>
                        </div>
                        <div class="tab-pane fade" id="home-country" role="tabpanel" aria-labelledby="country-tab">
                            <div id="country-chart"></div>
                        </div>
                        <div class="tab-pane fade" id="home-refer" role="tabpanel" aria-labelledby="refer-tab">
                            <div id="refer-chart"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('js')
<style>
    .apexcharts-canvas.dark {
        background: transparent;
    }

</style>
<script src="https://cdn.jsdelivr.net/npm/apexcharts@latest"></script>
<script>
    function setView(type)
    {
        localStorage.setItem('analyticsType',type);
        location.reload();
    }
    $(document).ready(() => {
        var options = {
            series: [{
                name: 'Truy Cập',
                data: [
                    @foreach($operatingSystems->rows as $key => $os)
                        "{{ $os[1] }}",
                    @endforeach
                ]
            }],
            chart: {
                height: 550,
                type: localStorage.getItem('analyticsType') || 'area',
                stacked: true,
                sparkline: {
                    enabled: false,
                }
            },
            theme: {
                mode: 'dark',
                palette: 'palette1',
                monochrome: {
                    enabled: false,
                    color: '#333',
                    shadeTo: 'dark',
                    shadeIntensity: 1
                },
            },
            dataLabels: {
                enabled: false
            },
            stroke: {
                curve: 'smooth'
            },
            legend: {
                position: 'top',
                horizontalAlign: 'left'
            },
            xaxis: {
                categories: [
                    @foreach($operatingSystems->rows as $key => $os)
                        "{{ $os[0] }}",
                    @endforeach
                ]
            },
            tooltip: {
                
            },
        };
        var chart = new ApexCharts(document.querySelector("#os-chart"), options);
        chart.render();

        var options = {
            series: [{
                name: 'Phiên',
                data: [
                    @foreach($browers as $key => $brower)
                        "{{ $brower['sessions'] }}",
                    @endforeach
                ]
            }],
            chart: {
                height: 550,
                type: localStorage.getItem('analyticsType') || 'area',
                stacked: true,
                sparkline: {
                    enabled: false,
                }
            },
            theme: {
                mode: 'dark',
                palette: 'palette1',
                monochrome: {
                    enabled: false,
                    color: '#333',
                    shadeTo: 'dark',
                    shadeIntensity: 1
                },
            },
            dataLabels: {
                enabled: false
            },
            stroke: {
                curve: 'smooth'
            },
            legend: {
                position: 'top',
                horizontalAlign: 'left'
            },
            xaxis: {
                categories: [
                    @foreach($browers as $key => $brower)
                        "{{ $brower['browser'] }}",
                    @endforeach
                ]
            },
            tooltip: {
                
            },
        };
        var chart = new ApexCharts(document.querySelector("#browser-chart"), options);
        chart.render();

        var options = {
            series: [{
                name: 'Truy Cập',
                data: [
                    @foreach($countryData->rows as $key => $country)
                        "{{ $country[1] }}",
                    @endforeach
                ]
            }],
            chart: {
                height: 550,
                type: localStorage.getItem('analyticsType') || 'area',
                stacked: true,
                sparkline: {
                    enabled: false,
                }
            },
            theme: {
                mode: 'dark',
                palette: 'palette1',
                monochrome: {
                    enabled: false,
                    color: '#333',
                    shadeTo: 'dark',
                    shadeIntensity: 1
                },
            },
            dataLabels: {
                enabled: false
            },
            stroke: {
                curve: 'smooth'
            },
            legend: {
                position: 'top',
                horizontalAlign: 'left'
            },
            xaxis: {
                categories: [
                    @foreach($countryData->rows as $key => $country)
                        "{{ $country[0] }}",
                    @endforeach
                ]
            },
            tooltip: {
                
            },
        };
        var chart = new ApexCharts(document.querySelector("#country-chart"), options);
        chart.render();

        var options = {
            series: [{
                name: 'Truy Cập',
                data: [
                    @foreach($referrers as $key => $referer)
                        "{{ $referer['pageViews'] }}",
                    @endforeach
                ]
            }],
            chart: {
                height: 550,
                type: localStorage.getItem('analyticsType') || 'area',
                stacked: true,
                sparkline: {
                    enabled: false,
                }
            },
            theme: {
                mode: 'dark',
                palette: 'palette1',
                monochrome: {
                    enabled: false,
                    color: '#333',
                    shadeTo: 'dark',
                    shadeIntensity: 1
                },
            },
            dataLabels: {
                enabled: false
            },
            stroke: {
                curve: 'smooth'
            },
            legend: {
                position: 'top',
                horizontalAlign: 'left'
            },
            xaxis: {
                categories: [
                    @foreach($referrers as $key => $referer)
                        "{{ $referer['url'] }}",
                    @endforeach
                ]
            },
            tooltip: {
                
            },
        };
        var chart = new ApexCharts(document.querySelector("#refer-chart"), options);
        chart.render();
    });
</script>
@endpush
