<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<title>Group Game</title>
	<meta http-equiv="x-dns-prefetch-control" content="on">
	<link rel="dns-prefetch" href="//cdnjs.cloudflare.com" />
	<link rel="dns-prefetch" href="//cdn.jsdelivr.net" />
	<link rel="dns-prefetch" href="//ajax.googleapis.com" />
	<meta name="description" content="Facebook Group Ranking System">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<link rel="stylesheet" href="{{ asset('assets/css/site.min.css') }}">
	<link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
	<link href="{{ asset('cdn/css/all.min.css') }}" rel="stylesheet">
	<link rel="shortcut icon" href="{{ asset('favicon.ico') }}" />
	<meta name="csrf-token" content="{{ csrf_token() }}"/>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.7.2/animate.min.css">
	<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
	@stack('css')
</head>
<body>
	<div id="app" class="layout-row">
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
<script>
	config = {
		root:"{{ url('/') }}",
		current_url:"{{ url()->current() }}",
		auth:{{ Auth::check() ? 1 : 0 }},
		bearer:"{{ str_random(50) }}"
	};
	</script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@8.18.2/dist/sweetalert2.all.min.js"></script>	
	<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
	<script src="{{ asset('assets/js/plugins/speed/refresh.min.js') }}"></script>
	<script src="{{ asset('assets/js/plugins/speed/trasher.js') }}"></script>
	<script src="{{ asset('assets/js/site.min.js') }}"></script>
	<script src="{{ asset('assets/js/plugins/axios/axios.min.js') }}"></script>
	<script src="{{ asset('assets/js/vue/vue.js') }}"></script>
	@stack('js')
	@if(session('message'))
		<script>
			Swal.fire('',"{{ session('message') }}","{{ session('status') }}");
		</script>
	@endif
</html>