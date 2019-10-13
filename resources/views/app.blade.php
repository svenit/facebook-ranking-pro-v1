<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<title>Group Game</title>
	<meta name="description" content="Responsive, Bootstrap, BS4">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<link rel="stylesheet" href="{{ asset('assets/css/site.min.css') }}">
	<link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
	<link href="{{ asset('cdn/css/all.min.css') }}" rel="stylesheet">
	<link rel="shortcut icon" href="{{ asset('favicon.ico') }}" />
	<meta name="csrf-token" content="{{ csrf_token() }}"/>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.7.2/animate.min.css">
	@yield('css')
</head>

<body>
	<div id="app" class="layout-row">
		@include('user.theme.aside')
		{{-- <button class="btn btn-white btn-block mb-2" data-toggle="modal" data-target="#modal-left" data-toggle-class="modal-open-aside" data-target="body">Left</button> --}}
		<div id="main" style="background: url(https://darktown.itam.store/_nuxt/img/5442740.jpg);" class="layout-column flex">
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
		root:'{{ url('/') }}',
	};
	</script>
	<script src="{{ asset('assets/js/site.min.js') }}"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.19.0/axios.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@8.18.2/dist/sweetalert2.all.min.js"></script>
	@yield('js')
	@yield('after-js')
</html>