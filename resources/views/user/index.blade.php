@extends('app')
@section('content')

@section('hero','Trang Chủ')
@section('sub_hero',"Xin chào, $welcome")

<div style="height:100%" class="page-content page-container" id="page-content">
    <div class="padding-x">
        {{-- <div style="overflow:hidden;height:100%;position:relative" id="map-view" class="vip-bordered">
            <div onclick="openFullscreen()" class="full-screen">Full</div>
            <table style="border: none;height:auto;border-collapse: collapse;" cellspacing="0" valign="center" cellpadding="0">
                <tbody>
                    <tr v-for="i in map.rows">
                        <td v-for="j in map.cols" v-html="drawMap(map.data[i - 1][j - 1],i,j)" :class="cloneMap[i - 1][j - 1].background" @click="moveToPosition(i,j)" :id="`map-${i}-${j}`" :style="{width:'60px',height:'60px',padding:0,position:cloneMap[i - 1][j - 1].relative ? 'relative' : ''}"></td>
                    </tr>
                </tbody>
            </table>
            <div class="entity" style="position:fixed;bottom:0%;left:0%;background:#fff;z-index:999">
                1
            </div>
        </div> --}}
        @include('user.theme.parameter')
        <div class="row row-sm sr">
            <div class="col-md-12 col-lg-12">
                <div class="row row-sm">
                    <div class="col-md-12">
                        <div class="row row-sm">
                            <div class="col-12">
                                <div class="card vip-bordered" style="margin-top:20px;">
                                    <div class="card-body">
                                        <div class="row row-sm text-center">
                                            <div class="col-md-4 col-lg-2 col-sm-6">
                                                <div class="d-flex align-items-center text-hover-success">
                                                    <div class="px-4 flex">
                                                        <a href="{{ Route('user.guild.lobby') }}"><img src="{{ asset('assets/images/Guild.png') }}"></a>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4 col-lg-2 col-sm-6">
                                                <div class="d-flex align-items-center text-hover-success">
                                                    <div class="px-4 flex">
                                                        <a href="{{ Route('user.pvp.index') }}"><img src="{{ asset('assets/images/PVP_Icon.png') }}"></a>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4 col-lg-2 col-sm-6">
                                                <div class="d-flex align-items-center text-hover-success">
                                                    <div class="px-4 flex">
                                                        <a href="#"><img src="{{ asset('assets/images/Quest.png') }}"></a>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4 col-lg-2 col-sm-6">
                                                <div class="d-flex align-items-center text-hover-success">
                                                    <div class="px-4 flex">
                                                        <a href="{{ Route('user.shop.item') }}"><img src="{{ asset('assets/images/Shop.png') }}"></a>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4 col-lg-2 col-sm-6">
                                                <div class="d-flex align-items-center text-hover-success">
                                                    <div class="px-4 flex">
                                                        <a href="{{ Route('user.events.wheel') }}"><img src="{{ asset('assets/images/Casino.png') }}"></a>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4 col-lg-2 col-sm-6">
                                                <div class="d-flex align-items-center text-hover-success">
                                                    <div class="px-4 flex">
                                                        <a href="{{ Route('user.oven.gem') }}"><img src="{{ asset('assets/images/Smith.png') }}"></a>
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
        <div style="margin-top:25px;" class="block p-3 normal-bordered">
            <div id="carouselCaptions" class="carousel slide" data-ride="carousel">
                <ol class="carousel-indicators">
                    <li data-target="#carouselCaptions" data-slide-to="0" class="active"></li>
                    <li data-target="#carouselCaptions" data-slide-to="1" class="active"></li>
                </ol>
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <div class="media media-16x9 gd-info">
                            <div class="media-content" style="background-image:url(https://images2.alphacoders.com/104/1042143.jpg)"></div>
                        </div>
                        <div class="carousel-caption text-align-auto"><span class="badge badge-outline">POPULAR</span>
                            <h2 class="text-white display-5 font-weight-500 my-4">Popular front-end library.</h2>
                            <p class="text-fade d-none d-md-block">Quickly prototype your ideas or build your entire app
                                with prebuilt components.</p>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <div class="media media-16x9 gd-primary">
                            <div class="media-content" style="background-image:url(https://vectormienphi.com/wp-content/uploads/2020/01/T%E1%BB%95ng-h%E1%BB%A3p-h%C3%ACnh-%E1%BA%A3nh-Solo-Leveling-%C4%91%E1%BA%B9p-nh%E1%BA%A5t-1.jpg)"></div>
                        </div>
                        <div class="carousel-caption text-align-auto"><span class="badge badge-outline">MỚI</span>
                            <h2 class="text-white display-5 font-weight-500 my-4">Mùa 1 đã bắt đầu
                            </h2>
                            <p class="text-fade d-none d-md-block">Nhanh chân</p>
                        </div>
                    </div>
                </div>
                <a class="carousel-control-prev" href="#carouselCaptions" role="button" data-slide="prev"><span
                        class="carousel-control-prev-icon" aria-hidden="true"></span> <span
                        class="sr-only">Previous</span> </a><a class="carousel-control-next" href="#carouselCaptions"
                    role="button" data-slide="next"><span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                </a>
            </div>
            <div class="corner corner-top-left"></div> 
            <div class="corner corner-top-right"></div> 
            <div class="corner corner-bottom-left"></div> 
            <div class="corner corner-bottom-right">
        </div>
    </div>
</div>
@endsection

@push('js')
    @if(session('message'))
    <script>
        Swal.fire('', "{{ session('message') }}", "{{ session('status') }}");
    </script>
    @endif
    <script>
        const page = {
            path:'map',
            map:"hometown"
        };
    </script>
@endpush
