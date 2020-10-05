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
	<link rel="stylesheet" href="{{ asset('assets/css/ui.css') }}">
	<link href="{{ asset('cdn/css/all.min.css') }}" rel="stylesheet">
	<link rel="stylesheet" href="https://introjs.com/introjs.css">
	<link href='https://fonts.googleapis.com/css?family=VT323' rel='stylesheet' type='text/css'>
	<link rel="icon" href="{{ asset('favicon.ico') }}" sizes="32px" type="image/x-icon">
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
			detect: {{ Auth::check() && Auth::user()->isAdmin ? 'false' : 'true' }},
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
	<div style="height:100%;min-height:100vh;background-image:url({{ asset('assets/images/icon/Screen-Parttern-Left.png') }});position:fixed;width:3%;filter: brightness(0.5);"></div>
	<div style="height:100%;min-height:100vh;background-image:url({{ asset('assets/images/icon/Screen-Parttern-Right.png') }});position:fixed;right:0;width:3%;filter: brightness(0.5);"></div>
	<div id="app" style="height:640px;width:94%;margin:0 auto;" class="layout-row" v-if="!detect">
		@if(!request()->is('admin/*'))
			<div v-if="flash" id="loader" class="loading-screen">
				<div class="loading-spinner" style=""><div class="loading-spinner-box"><div class="cube"><div class="side"></div><div class="side"></div><div class="side"></div><div class="side"></div><div class="side"></div><div class="side"></div></div><div class="loading-spinner-ment">
					<p notranslate class="mt-5 pixel-font notranslate">Loading...</p></div></div></div>
			</div>
		@endif
		@include('user.theme.aside')
		<div style="position: absolute;top:15%;" class="ml-4 aside-icon profile-badge">
			<div data-step="6" data-intro="{{ $intro[5] }}" class="col">
				<img class="text-center footer-icon pixel" src="{{ asset('assets/images/icon/Dungeon.png') }}">
				<p class="text-center">Boss</p>
			</div>
			<div data-toggle="modal" data-target=".modal-world-map" data-toggle-class="modal-open-aside" data-target="body" data-step="7" data-intro="{{ $intro[6] }}" class="col">
				<img class="text-center footer-icon pixel" src="{{ asset('assets/images/icon/Blue-Gate.gif') }}">
				<p class="text-center">Dungeon</p>
			</div>
			<div data-step="8" data-intro="{{ $intro[7] }}" class="col">
				<img class="text-center footer-icon pixel" src="{{ asset('assets/images/icon/PVP.png') }}">
				<p class="text-center">PVP</p>
			</div>
		</div>
		<div data-id="{{ session('client_key') }}" id="main" style="border-radius:3px;background: url({{ asset('assets/images/icon/Background-2.png') }});image-rendering: pixelated;background-position:top;background-size:cover;background-repeat: no-repeat" class="layout-column flex">
			@include('user.theme.header')
			<div id="content" class="flex">
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
			<div v-if="showIntro" class="intro">
				<img data-step="1" data-intro="{{ $intro[0] }}" width="150px" class="pixel" src="{{ asset('assets/images/icon/Presenter.png') }}">
			</div>
			@include('user.theme.footer')
		</div>
	</div>
	<script src="https://ajax.aspnetcdn.com/ajax/jQuery/jquery-3.4.1.min.js"></script>
	<script src="https://www.gstatic.com/firebasejs/7.6.1/firebase-app.js"></script>
	<script src="https://www.gstatic.com/firebasejs/7.6.1/firebase-database.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@8.18.2/dist/sweetalert2.all.min.js"></script>
	<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
	<script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
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
		function googleTranslateElementInit() {
            new google.translate.TranslateElement({pageLanguage: 'vi', multilanguagePage: true}, 'gg-translate');
		}
	</script>
	<script async src="{{ mix('js/bundle.min.js') }}"></script>
	@stack('js')
	@if(session('message'))
		<script>
			Swal.fire('',"{{ session('message') }}","{{ session('status') }}");
		</script>
	@endif
</body>
</html>