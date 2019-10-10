@extends('app')
@section('content')

@section('hero','Trang Chủ')
@section('sub_hero',"Xin chào, $welcome")


<div class="page-content page-container" id="page-content">
    <div class="padding-x">
        @include('user.theme.parameter')
        <button class="btn btn-white btn-block mb-2" data-toggle="modal" data-target="#modal-left" data-toggle-class="modal-open-aside" data-target="body">Left</button>
        <div class="block p-3">
            <div id="carouselCaptions" class="carousel slide" data-ride="carousel">
                <ol class="carousel-indicators">
                    <li data-target="#carouselCaptions" data-slide-to="0" class="active"></li>
                    <li data-target="#carouselCaptions" data-slide-to="1"></li>
                    <li data-target="#carouselCaptions" data-slide-to="2"></li>
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
                            <div class="media-content" style="background-image:url()"></div>
                        </div>
                        <div class="carousel-caption text-align-auto"><span class="badge badge-outline">POPULAR</span>
                            <h2 class="text-white display-5 font-weight-500 my-4">Popular front-end library.</h2>
                            <p class="text-fade d-none d-md-block">Quickly prototype your ideas or build your entire app
                                with prebuilt components.</p>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <div class="media media-16x9 gd-dark">
                            <div class="media-content" style="background-image:url()"></div>
                        </div>
                        <div class="carousel-caption text-align-auto"><span class="badge badge-outline">JQUERY</span>
                            <h2 class="text-white display-5 font-weight-500 my-4">Powerful plugins built on jQuery</h2>
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
        </div>
    </div>
</div>
@endsection

@section('js')
@if(session('message'))
<script>
    Swal.fire('', "{{ session('message') }}", "{{ session('status') }}");
</script>
@endif
@endsection
