<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<title>{{ env('APP_NAME') }} - @yield('hero')</title>
	<meta http-equiv="x-dns-prefetch-control" content="on">
	<link rel="dns-prefetch" href="//cdnjs.cloudflare.com" />
	<link rel="dns-prefetch" href="//cdn.jsdelivr.net" />
	<link rel="dns-prefetch" href="//ajax.googleapis.com" />
	<meta name="description" content="@yield('sub_hero')">
	<meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests"> 
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<link rel="stylesheet" href="{{ asset('css/app.min.css') }}">
	<link href="{{ asset('cdn/css/all.min.css') }}" rel="stylesheet">
	<link rel="shortcut icon" href="{{ asset('favicon.ico') }}" />
	<meta name="csrf-token" content="{{ csrf_token() }}"/>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.7.2/animate.min.css">
	<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
	<script src="https://www.gstatic.com/firebasejs/7.6.1/firebase-app.js"></script>
	<script src="https://www.gstatic.com/firebasejs/7.6.1/firebase-database.js"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	@stack('css')
</head>
<body>
	<!-- Global site tag (gtag.js) - Google Analytics -->
	<script async src="https://www.googletagmanager.com/gtag/js?id=UA-112101707-1"></script>
	<script>
		window.dataLayer = window.dataLayer || [];
		function gtag(){dataLayer.push(arguments);}
		gtag('js', new Date());

		gtag('config', 'UA-112101707-1');
	</script>
	<script>
		config={socketHost:"{{ env('SOCKET_HOST') }}",root:"{{url('/')}}",current_url:"{{url()->current()}}",auth:{{Auth::check() ? 1 : 0}},bearer:"{{str_random(50)}}",detect:{{Auth::check() && Auth::user()->isAdmin ? 'false' : 'true'}}};
	</script>
	<noscript>
		<style type="text/css">
			.layout-row {display:none;}
		</style>
		<div class="noscriptmsg">
			You don't have javascript enabled.  Good luck with that.
		</div>
	</noscript>
	<div id="app" class="layout-row" v-if="!detect">
		@if(!request()->is('admin/*'))
			<div v-if="flash" id="loader" class="loading-screen">
				<div class="flash-screen">
					<div class="text-center">
						<img style="width:100px" src="{{ asset('assets/images/loader.jpg') }}">
					</div>
					<div class="progress-screen">
						<div class="indeterminate"></div>
					</div>
				</div>
			</div>
		@endif
		
		@include('user.theme.aside')
		<div id="main" style="background: url({{ asset('assets/images/background.jpg') }});" class="layout-column flex">
			@include('user.theme.header')
			<div id="content" class="flex">
				<div>
					<div class="page-hero page-container" id="page-hero">
						<div class="padding d-flex">
							<div class="page-title">
								<h2 class="text-md text-highlight">@yield('hero')</h2>
								<small class="text-muted">@yield('sub_hero','')</small>
							</div>
						</div>
					</div>
					@yield('content')
				</div>
			</div>
			<div id="footer" style="margin-top:0px" class="page-footer">
				<div class="d-flex p-3"><span class="text-sm text-muted flex">&copy; Copyright {{ date('Y') }} Coded by <a href="https://facebook.com/sven307">Sven</a></span>
					<div class="text-sm text-muted">Version 1.0.0</div>
				</div>
			</div>
		</div>
	</div>
</body>
	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@8.18.2/dist/sweetalert2.all.min.js"></script>	
	<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
	<script src="{{ asset('js/vendor.min.js') }}"></script>
	<script>
		var socket = io.connect(config.socketHost);
		socket.on('notify-global',(data) => {
			Swal.fire('THÔNG BÁO',data.message,'info')
		})
		socket.on('user-count',(data) => {
			document.getElementById('user-count').innerHTML = data;
		});
	</script>
	@stack('js')
	@if(session('message'))
		<script>
			Swal.fire('',"{{ session('message') }}","{{ session('status') }}");
		</script>
	@endif
</html>