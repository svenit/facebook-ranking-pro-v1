@extends('app')
@section('content')

@section('hero','Trang Chủ')
@section('sub_hero',"Xin chào, $welcome")


<div class="page-content page-container" id="page-content">
    <div class="padding-x">
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
                                                        <img src="https://vignette.wikia.nocookie.net/tomeofthesun/images/a/ad/Production.png/revision/latest?cb=20160531170704">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4 col-lg-2 col-sm-6">
                                                <div class="d-flex align-items-center text-hover-success">
                                                    <div class="px-4 flex">
                                                        <img src="https://vignette.wikia.nocookie.net/tomeofthesun/images/a/ae/Clan_War.png/revision/latest?cb=20160427183424">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4 col-lg-2 col-sm-6">
                                                <div class="d-flex align-items-center text-hover-success">
                                                    <div class="px-4 flex">
                                                        <img src="https://vignette.wikia.nocookie.net/tomeofthesun/images/8/88/King_of_the_Hill.png/revision/latest?cb=20160427183424">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4 col-lg-2 col-sm-6">
                                                <div class="d-flex align-items-center text-hover-success">
                                                    <div class="px-4 flex">
                                                        <img src="https://vignette.wikia.nocookie.net/tomeofthesun/images/a/a7/Hero%27s_Journey.png/revision/latest?cb=20160427180921">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4 col-lg-2 col-sm-6">
                                                <div class="d-flex align-items-center text-hover-success">
                                                    <div class="px-4 flex">
                                                        <img src="https://vignette.wikia.nocookie.net/tomeofthesun/images/7/73/Adventure_Inn.png/revision/latest?cb=20160427180920">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4 col-lg-2 col-sm-6">
                                                <div class="d-flex align-items-center text-hover-success">
                                                    <div class="px-4 flex">
                                                        <img src="https://vignette.wikia.nocookie.net/tomeofthesun/images/7/7f/Treasure_Forest.png/revision/latest?cb=20160427180922">
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
                        <div class="media media-16x9 gd-primary">
                            <div class="media-content" style="background-image:url(https://www.gamemonday.com/wp-content/uploads/2016/04/ton-000.jpg)"></div>
                        </div>
                        <div class="carousel-caption text-align-auto"><span class="badge badge-outline">MỚI</span>
                            <h2 class="text-white display-5 font-weight-500 my-4">Mùa 1 đã bắt đầu
                            </h2>
                            <p class="text-fade d-none d-md-block">Nhanh chân</p>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <div class="media media-16x9 gd-info">
                            <div class="media-content" style="background-image:url(https://www.gamemonday.com/wp-content/uploads/2016/04/ton-000.jpg)"></div>
                        </div>
                        <div class="carousel-caption text-align-auto"><span class="badge badge-outline">POPULAR</span>
                            <h2 class="text-white display-5 font-weight-500 my-4">Popular front-end library.</h2>
                            <p class="text-fade d-none d-md-block">Quickly prototype your ideas or build your entire app
                                with prebuilt components.</p>
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

@section('after-js')
    @if(session('message'))
    <script>
        Swal.fire('', "{{ session('message') }}", "{{ session('status') }}");
    </script>
    @endif
@endsection
