@extends('app')

@section('hero','Chọn nhân vật')
@section('sub_hero','Vui lòng chọn nhân vật để bắt đầu')

@section('content')
<div class="page-content page-container" id="page-content">
    <div class="padding-x">
        <div class="row row-sm sr">
            @foreach($characters as $key => $character)
                <div class="col-auto">
                    <div class="card">
                        <div style="position:relative;left:28%" class="character-sprites hoverable">
                            <span class="hair_flower_3"></span>
                            <span class="chair_none"></span>
                            <span class=""></span>
                            <span class="skin_f5a76e"></span>
                            <span class="broad_shirt_black"></span>
                            <span class="head_0"></span>
                            <span class="broad_armor_base_0"></span>
                            <span class=""></span>
                            <span class="hair_bangs_0_black"></span>
                            <span class="hair_base_0_black"></span>
                            <span class="hair_mustache_0_black"></span>
                            <span class="hair_beard_0_black"></span>
                            <span class=""></span>
                            <span class="eyewear_base_0"></span>
                            <span class="head_base_0"></span>
                            <span class=""></span>
                            <span class="hair_flower_0"></span>
                            <span class="shield_base_0"></span>
                            <span class=""></span>
                        </div>
                        <div class="card-body">
                            <p class="card-title text-gold text-center">{{ $character->name }}</p>
                            <div id="{{ str_slug($character->name) }}"></div>
                            <center><a class="text-center" onclick="return confirm('Bạn có chắc chắn muốn chọn nhân vật này ?')" style="margin-left:-10px" href="{{ Route('user.character.set',['id' => $character->id]) }}">
                                <button class="btn w-sm mb-1 bg-dark"><span class="mx-1">Chọn</span></button>
                            </a>
                            </center>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
@push('js')
    <style>
        .apexcharts-canvas.dark
        {
            background: transparent;
        }
    </style>
    <script src="https://cdn.jsdelivr.net/npm/apexcharts@latest"></script>
    <script>
        $(document).ready(() => {
            @foreach($characters as $key => $character)
                var options = {
                    chart: {
                        sparkline: {
                            enabled: false,
                        },
                        height: 250,
                        type: 'radar',
                        toolbar:{
                            show:false
                        }
                    },
                    fill: {
                        type: 'gradient',
                        gradient: {
                            shade: 'dark',
                            type: "horizontal",
                            shadeIntensity: 0.5,
                            gradientToColors: undefined, // optional, if not defined - uses the shades of same color in series
                            inverseColors: true,
                            opacityFrom: 1,
                            opacityTo: 0.8,
                            stops: [0, 50, 100],
                            colorStops: []
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
                    series: [{
                        name: 'Chỉ Số',
                        data: [{{ $character->strength }}, {{ $character->intelligent }}, {{ $character->agility }}, {{ $character->lucky }}, {{ $character->armor_strength }}, {{ $character->armor_intelligent }},{{ $character->health_points/10 }},{{ $character->default_energy/10 }}],
                    }],
                    labels: ['Sức Mạnh', 'Trí Tuệ', 'Nhanh Nhẹn', 'May Mắn', 'Thủ Công', 'Thủ Phép','Sinh Lực','Mana']
                }

                var chart = new ApexCharts(
                    document.querySelector("#{{ str_slug($character->name) }}"),
                    options
                );
                chart.render();
            @endforeach
        })
    </script>
@endpush