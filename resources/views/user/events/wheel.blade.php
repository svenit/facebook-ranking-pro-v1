@extends('app')
@section('content')

@section('hero','Vòng Quay May Mắn')
@section('sub_hero','Quay càng nhiều vận may càng tới')
<div class="page-content page-container" style="margin-bottom:400px" id="page-content">
    <div class="padding-x">
        @include('user.theme.parameter')
        <div class="row row-sm sr">
            <div class="col-md-12 col-lg-12">        
                <div class="wheelContainer">
                    <svg style="transform:translate(-50%, 0%) matrix(1, 0, 0, 1, 0, 0)" class="wheelSVG" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" text-rendering="optimizeSpeed">
                        <defs>
                            <filter id="shadow" x="-100%" y="-100%" width="550%" height="550%">
                                <feOffset in="SourceAlpha" dx="0" dy="0" result="offsetOut"></feOffset>
                                <feGaussianBlur stdDeviation="9" in="offsetOut" result="drop" />
                                <feColorMatrix in="drop" result="color-out" type="matrix" values="0 0 0 0   0
                            0 0 0 0   0 
                            0 0 0 0   0 
                            0 0 0 .3 0" />
                                <feBlend in="SourceGraphic" in2="color-out" mode="normal" />
                            </filter>
                        </defs>
                        <g class="mainContainer">
                            <g class="wheel">
                                <!-- <image  xlink:href="http://example.com/images/wheel_graphic.png" x="0%" y="0%" height="100%" width="100%"></image> -->
                            </g>
                        </g>
                        <g class="centerCircle">
                            
                        </g>
                        <g class="wheelOutline" />
                        <g class="pegContainer" opacity="1">
                            <path class="peg" fill="#EEEEEE" d="M22.139,0C5.623,0-1.523,15.572,0.269,27.037c3.392,21.707,21.87,42.232,21.87,42.232 s18.478-20.525,21.87-42.232C45.801,15.572,38.623,0,22.139,0z" />
                        </g>
                        <g class="valueContainer" />
                    </svg>
                    <div id="spinBtn" @click="checkWheel()" class="toast">
                        <p/>
                    </div>
                    <div style="display:none" class="spinBtn"></div> 
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('css')
    <link rel="stylesheet" href="{{ asset('assets/css/wheel.css') }}">
@endpush
@push('js')
    <script>
        const page = {
            path:'wheel.index',
        }
    </script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/gsap/1.20.2/TweenMax.min.js'></script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/gsap/1.20.2/utils/Draggable.min.js'></script>
    <script src="{{ asset('assets/js/wheel/throw.min.js') }}"></script>
    <script src="{{ asset('assets/js/wheel/wheel.js') }}"></script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/gsap/latest/plugins/TextPlugin.min.js'></script>
    <script src="{{ asset('assets/js/wheel/index.js') }}"></script>
@endpush