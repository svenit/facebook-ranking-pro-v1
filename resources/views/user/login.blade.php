<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Lockme | Basik - Bootstrap 4 Web Application</title>
    <link rel="stylesheet" href="{{ asset('assets/css/site.min.css') }}">
	<link href="{{ asset('cdn/css/all.min.css') }}" rel="stylesheet">
	<meta name="csrf-token" content="{{ csrf_token() }}" />
	<link rel="shortcut icon" href="{{ asset('favicon.ico') }}" />
</head>

<body class="layout-row">
    <div id="ajax-content" class="dark h-v d-flex flex align-items-center">
        <div style="background:#fff;padding:40px;border-radius:5px;" class="mx-auto w-xl w-auto-xs animate fadeIn text-center">
            <div class="mb-3"><img src="https://vignette.wikia.nocookie.net/tomeofthesun/images/4/46/Fury.png/revision/latest?cb=20160614173940" class="w-100 circle">
                <div class="mt-3 font-bold"></div>
            </div>
            <div class="mt-3"><a href="{{ Route('oauth.login') }}" class="btn btn-rounded bg-primary-lt"><i class="fab fa-facebook-square"></i> <span class="mx-2">Đăng nhập với Facebook</span></a></div>
        </div>
    </div>
</body>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@8.18.2/dist/sweetalert2.all.min.js"></script>
@if(session('message'))
    <script>
        Swal.fire('',"{{ session('message') }}","{{ session('status') }}");
    </script>
@endif
</html>