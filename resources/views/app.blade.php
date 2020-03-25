
{{-- 
	A TextBased Game Platform - Developed by Sven 

  _________      .__           .__                     .__  .__                   _________.__        .__.__          __                
 /   _____/ ____ |  |   ____   |  |   _______  __ ____ |  | |__| ____    ____    /   _____/|__| _____ |__|  | _____ _/  |_  ___________ 
 \_____  \ /  _ \|  |  /  _ \  |  | _/ __ \  \/ // __ \|  | |  |/    \  / ___\   \_____  \ |  |/     \|  |  | \__  \\   __\/  _ \_  __ \
 /        (  <_> )  |_(  <_> ) |  |_\  ___/\   /\  ___/|  |_|  |   |  \/ /_/  >  /        \|  |  Y Y  \  |  |__/ __ \|  | (  <_> )  | \/
/_______  /\____/|____/\____/  |____/\___  >\_/  \___  >____/__|___|  /\___  /  /_______  /|__|__|_|  /__|____(____  /__|  \____/|__|   
        \/                               \/          \/             \//_____/           \/          \/             \/                   

--}}
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
	<link rel="stylesheet" href="{{ asset('css/app.min.css') }}">
	<link rel="stylesheet" href="{{ asset('assets/css/inventory.css') }}">
	<link href="{{ asset('cdn/css/all.min.css') }}" rel="stylesheet">
	{{-- <link rel="shortcut icon" href="{{ asset('favicon.ico') }}" /> --}}
	<meta name="csrf-token" content="{{ str_random(50) }}"/>

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
	<div id="app" style="height:100%;min-height:100vh" class="layout-row" v-if="!detect">
		@if(!request()->is('admin/*'))
			<div v-if="flash" id="loader" class="loading-screen">
				<div class="loading-spinner" style=""><div class="loading-spinner-box"><div class="cube"><div class="side"></div><div class="side"></div><div class="side"></div><div class="side"></div><div class="side"></div><div class="side"></div></div><div class="loading-spinner-ment">
					<p class="mt-5">Đang tải dữ liệu...</p></div></div></div>
			</div>
		@endif
		@include('user.theme.aside')
		<div data-id="{{ csrf_token() }}" id="main" style="background: url({{ asset('assets/images/background.jpg') }});" class="layout-column flex">
			@include('user.theme.header')
			<div id="content" class="flex">
				<div>
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
			</div>
			<div id="footer" style="margin-top:0px" class="page-footer">
				<div class="d-flex p-3"><span class="text-sm pixel-font text-muted flex">&copy;Copyright {{ date('Y') }} Coded by <a class="text-gold" href="https://facebook.com/sven307">Sven</a></span>
					<div style="font-family: pixel !important" class="text-sm text-muted">Version {{ env('APP_VERSION') }}</div>
				</div>
			</div>
		</div>
	</div>
</body>
	<script src="https://www.gstatic.com/firebasejs/7.6.1/firebase-app.js"></script>
	<script src="https://www.gstatic.com/firebasejs/7.6.1/firebase-database.js"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@8.18.2/dist/sweetalert2.all.min.js"></script>	
	<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
	<script src="{{ asset('js/vendor.min.js') }}"></script>
	<script>
		var socket = io.connect(config.socketHost);
		socket.on('notify-global',(data) => {
			Swal.fire(data.title,data.message,data.type);
		});
		@if(Auth::check())
			socket.on("notify-to-{{ Auth::id() }}",(data) => {
				Swal.fire(data.title,data.message,data.type);
			});
			socket.on(`invite-to-pvp-{{ Auth::id() }}`,data => {
				Swal.fire({
					title: ``,
					type: '',
					showCancelButton: true,
					showConfirmButton:true,
					confirmButtonText: 'Không',
					cancelButtonText: 'Chơi Luôn',
					cancelButtonColor: '#f21378',
					html: `${data.from.name} muốn thách đấu với bạn trong PVP Area`
				}).then((result) => {
					if(result.value) 
					{
						socket.emit('denied-invite-pvp',{
							from:"{{ Auth::user()->name }}",
							to:data.from.id,
							channel:data.from.channel
						});
					} 
					else if (result.dismiss === Swal.DismissReason.cancel) {
						window.location.href = data.room;
					}
				});
			});
		@endif
	</script>
	@stack('js')
	@if(session('message'))
		<script>
			Swal.fire('',"{{ session('message') }}","{{ session('status') }}");
		</script>
	@endif
</html>