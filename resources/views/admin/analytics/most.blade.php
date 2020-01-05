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
                    <div id="chart"></div>
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
                name: 'Lượt Xem',
                data: [
                    @foreach($analytics as $analytic)
                    "{{ $analytic['pageViews'] }}",
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
                    @foreach($analytics as $analytic)
                        "{{ $analytic['pageTitle'] }}",
                    @endforeach
                ]
            },
            tooltip: {
                
            },
        };

        var chart = new ApexCharts(document.querySelector("#chart"), options);
        chart.render();
    });

</script>
@endpush
