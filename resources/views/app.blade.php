
<!--
	A TextBased Game Platform - Developed by Sven 

  _________      .__           .__                     .__  .__                   _________.__        .__.__          __                
 /   _____/ ____ |  |   ____   |  |   _______  __ ____ |  | |__| ____    ____    /   _____/|__| _____ |__|  | _____ _/  |_  ___________ 
 \_____  \ /  _ \|  |  /  _ \  |  | _/ __ \  \/ // __ \|  | |  |/    \  / ___\   \_____  \ |  |/     \|  |  | \__  \\   __\/  _ \_  __ \
 /        (  <_> )  |_(  <_> ) |  |_\  ___/\   /\  ___/|  |_|  |   |  \/ /_/  >  /        \|  |  Y Y  \  |  |__/ __ \|  | (  <_> )  | \/
/_______  /\____/|____/\____/  |____/\___  >\_/  \___  >____/__|___|  /\___  /  /_______  /|__|__|_|  /__|____(____  /__|  \____/|__|   
        \/                               \/          \/             \//_____/           \/          \/             \/                   

 -->
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>{{ env('APP_NAME','Solo Leveling') }} - @yield('hero')</title>
	<meta http-equiv="x-dns-prefetch-control" content="on">
	<link rel="dns-prefetch" href="//cdnjs.cloudflare.com" />
	<link rel="dns-prefetch" href="//cdn.jsdelivr.net" />
	<link rel="dns-prefetch" href="//ajax.googleapis.com" />
	<meta name="description" content="@yield('sub_hero')">
	<meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests"> 
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<link rel="stylesheet" href="{{ mix('css/app.min.css') }}">
	<link rel="stylesheet" href="{{ asset('assets/css/inventory.css') }}">
	<link rel="stylesheet" href="{{ asset('assets/css/gem.css') }}">
	<link href="{{ asset('cdn/css/all.min.css') }}" rel="stylesheet">
	<link rel="stylesheet" href="https://introjs.com/introjs.css">
	<meta name="csrf-token" content="{{ csrf_token() }}"/>
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
		const config = {
			appName: "{{ env('APP_NAME') }}",
			appVersion: "{{ env('APP_VERSION') }}",
			maintainer: "{{ env('MAINTAINER') }}",
			socketHost: "{{ env('SOCKET_HOST') }}",
			root: "{{ url('/') }}",
			currentUrl: "{{ url()->current() }}",
			apiUrl: "{{ url('api') }}/{{ env('API_VERSION') }}",
			auth: {{ Auth::check() ? 1 : 0 }},
			bearer: "{{ str_random(50) }}",
			bcrypt: "{{ bcrypt(str_random(50)) }}",
			detect: {{ Auth::check() && Auth::user()->isAdmin ? 'false' : 'true' }}
		};
	</script>
	<noscript>
		<style type="text/css">
			.layout-row {display:none;}
		</style>
		<div class="noscriptmsg">
			You don't have javascript enabled.  Good luck with that.
		</div>
	</noscript>
	<div id="app" style="height:100%;min-height:100vh" class="layout-row" v-if="!detect">
		@if(!request()->is('admin/*'))
			<div v-if="flash" id="loader" class="loading-screen">
				<div class="loading-spinner" style=""><div class="loading-spinner-box"><div class="cube"><div class="side"></div><div class="side"></div><div class="side"></div><div class="side"></div><div class="side"></div><div class="side"></div></div><div class="loading-spinner-ment">
					<p class="mt-5">Đang tải dữ liệu...</p></div></div></div>
			</div>
		@endif
		@include('user.theme.aside')
		<div data-id="{{ session('client_key') }}" id="main" style="background: url({{ asset('assets/images/background.jpg') }});" class="layout-column flex">
			@include('user.theme.header')
			<div id="content" class="flex">
				@if(!request()->is('pvp/room/*'))
				<div class="page-hero page-container" id="page-hero">
					<div class="padding d-flex">
						<div style="width:100%" class="vip-bordered page-title">
							<h2 data-title="tooltip" class="ribbon"> <button style="background:transparent;border:none">@yield('hero')</button></h2>
							<p style="margin-top:40px" class="text-muted text-center">@yield('sub_hero','')</p>
						</div>
					</div>
				</div>
				@endif
				@yield('content')
			</div>
			<div v-if="!moreMenu" @click="moreMenu = true" style="position: fixed; right:-10px;top:50%;transform:rotate(180deg)">
				<img width="70%" src="{{ asset('assets/images/more-menu.png') }}">
			</div>
			<div v-else>
				<div @click="moreMenu = false" style="position: fixed; right:-6px;top:50%;">
					<img width="70%" src="{{ asset('assets/images/more-menu.png') }}">
				</div>
				<div class="animated slideInRight faster navbar-menu-fix">
					@php
						$tracking = new \App\Http\Controllers\Controller();
					@endphp
					@if($tracking->checkTracking())
						<a data-title="tooltip" title="Bạn đang ở trong một hoạt động" href="{{ url($tracking->getTrackingHref()) }}" class="btn btn-transparent" id="show_chat_wa"><img src="{{ asset('assets/images/icon-pack/no-action.png') }}"></a>
					@endif
					<a @click="gotoBottomChat" data-toggle="modal" data-target="#global-chat" class="btn btn-transparent" id="show_chat_wa"><img src="{{ asset('assets/images/icon-pack/message-box.png') }}"></a>
				</div>
			</div>
			<div id="footer" style="margin-top:0px" class="page-footer">
				<div class="d-flex p-3"><span copyright-id="{{ config('services.crypto.salt') }}" class="copyright text-sm pixel-font text-muted flex">&copy;Copyright {{ date('Y') }} Coded by <a class="text-gold" href="https://facebook.com/sven307">Sven</a></span>
				</div>
			</div>
		</div>
	</div>
	<script src="https://ajax.aspnetcdn.com/ajax/jQuery/jquery-3.4.1.min.js"></script>
	<script src="https://www.gstatic.com/firebasejs/7.6.1/firebase-app.js"></script>
	<script src="https://www.gstatic.com/firebasejs/7.6.1/firebase-database.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@8.18.2/dist/sweetalert2.all.min.js"></script>	
	<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
	<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
	<script src="https://introjs.com/intro.js"></script>
	<script src="{{ mix('js/vendor.min.js') }}"></script>
	<script>
		@auth
			const user = {
				id: {{ Auth::id() }},
				provider_id: {{ Auth::user()->provider_id }},
				name: "{{ Auth::user()->name }}",
				character: "{{ Auth::user()->character->name }}"
			};
		@endauth
	</script>
	@stack('js')
	@if(session('message'))
		<script>
			Swal.fire('',"{{ session('message') }}","{{ session('status') }}");
		</script>
	@endif
</body>
</html>