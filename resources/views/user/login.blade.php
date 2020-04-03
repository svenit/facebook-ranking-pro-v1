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

<body style="background:#25293e" class="layout-row">
    <div id="ajax-content" class="dark h-v d-flex flex align-items-center">
        <div style="border-radius:5px;width:600px;margin:30px" class="bg-dark mx-auto w-xl w-auto-xs animate fadeIn text-center">
            <div style="padding-top:40px">
                <div class="mb-3"><img style="width:150px" src="{{ asset('assets/images/app.png') }}" class="">
                <div class="animated flash infinite slower text-warning mt-3 font-bold">Addictive Text-Based Fantasy MMORPG!</div>
                </div>
                <div class="mb-3"><img style="width:300px" src="{{ asset('assets/images/logo.png') }}">
                </div>
                <div class="mt-15" style="margin-top:60px;">
                    <a href="{{ Route('oauth.login') }}" class="btn btn-rounded bg-primary">
                        <i class="fas fa-swords"></i>
                        <span class="mx-2">Tham Gia Ngay </span>
                    </a>
                </div>
                <div onclick="showIntroduce()" class="mt-3">
                    <a href="#" class="btn btn-rounded bg-dark">
                        <span class="mx-2">Giới Thiệu</span>
                    </a>
                </div>
            </div>
            <div class="footer">
                <img width="100%" src="data:image/png;base64,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">
            </div>
        </div>
    </div>
</body>
<style>
    a:hover{
        color: #fff !important;
    }
</style>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@8.18.2/dist/sweetalert2.all.min.js"></script>
@if(session('message'))
    <script>
        Swal.fire('',"{{ session('message') }}","{{ session('status') }}");
    </script>
@endif
<script>
    function showIntroduce()
    {
        Swal.fire('',"<div style='margin-bottom:20px'><img src='{{ asset('assets/images/app.png') }}'></div>{!! $content !!}",'');
    }
</script>
</html>