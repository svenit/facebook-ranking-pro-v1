<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>{{ env('APP_NAME') }} - Đăng Nhập </title>
    <link rel="stylesheet" href="{{ asset('assets/css/site.min.css') }}">
    <link href="{{ asset('cdn/css/all.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/app.min.css') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.7.2/animate.min.css">
</head>

<body style="background: #000" class="layout-row">
    <video muted="muted" id="video1" autoplay style="height:100vh" width="100%">
        <source src="{{ asset('assets/video/gate.mp4') }}" type="video/mp4">
        Your browser does not support HTML video.
    </video>
    <video muted="muted" id="video2" autoplay loop style="height:100vh;display:none" width="100%">
        <source src="{{ asset('assets/video/gate-2.mp4') }}" type="video/mp4">
        Your browser does not support HTML video.
    </video>
    <div id="card" style="display:none;position: absolute;margin:0 auto;left:50%;top:10%;transform:translate(-50%, 0)" id="ajax-content" class="dark">
        <div style="border-radius:5px;width:550px;" class="mx-auto w-xl w-auto-xs animate fadeIn text-center">
            <div style="padding:40px 0px">
                <div class="mb-3"><img style="width:150px" src="{{ asset('assets/images/app.png') }}" class="">
                <div class="animated flash infinite slower text-warning mt-3 font-bold pixel-font">Addictive Text-Based Fantasy MMORPG!</div>
                </div>
                <div class="mb-3"><img style="width:300px" src="{{ asset('assets/images/logo.png') }}">
                </div>
                <div class="mt-15" style="margin-top:60px;">
                    <a href="{{ Route('oauth.login') }}" class="btn btn-rounded btn-outline-warning">
                        <i class="fas fa-swords"></i>
                        <span class="mx-2 pixel-font" style="font-size: 12px;margin-bottom: 6px;">Join Solo Leveling World </span>
                    </a>
                </div>
                <div onclick="showIntroduce()" class="mt-3">
                    <a href="#">
                        <span class="mx-2 text-light pixel-font" style="font-size: 12px;margin-bottom: 6px;">About the game</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</body>
<style>
    a:hover{
        color: #fff !important;
    }
    .btn-outline-warning:hover {
        color: #000 !important;
    }
</style>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@8.18.2/dist/sweetalert2.all.min.js"></script>
@if(session('message'))
    <script>
        Swal.fire('',"{{ session('message') }}","{{ session('status') }}");
    </script>
@endif
<script>
    let video1 = document.getElementById('video1');
    let video2 = document.getElementById('video2');
    video1.playbackRate = 3;
    video2.playbackRate = 2;
    setTimeout(() => {
        document.getElementById('card').style.display = 'block';
        video1.style.display = 'none';
        video2.style.display = 'block';
    }, 15000/3);
    function showIntroduce()
    {
        Swal.fire('',"<div style='margin-bottom:20px'><img src='{{ asset('assets/images/app.png') }}'></div>{!! $content !!}",'');
    }
</script>
</html>