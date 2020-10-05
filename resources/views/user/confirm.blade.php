<!DOCTYPE html>
<html class="bg-light" lang="en">

<head>
    <meta charset="utf-8">
    <title>{{ env('APP_NAME') }} - Xác Nhận</title>
    <link href="{{ asset('cdn/css/all.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/app.min.css') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}" />
</head>
<body style="background:#25293e !important" class="layout-row">
    <div style="color:#888 !important" id="ajax-content" class="h-v d-flex flex align-items-center">
        <div style="border-radius:5px;padding:40px;width:500px" class="bg-dark mx-auto w-xl w-auto-xs animate fadeIn text-center">
            <div style="position: relative" class="mb-3">
                <img style="filter: brightness(.5)" src="{{ 'http://graph.facebook.com/'.Session('user_callback')->id.'/picture?type=normal' }}" class="w-72 circle">
                <span class="font-weight-bold" style="position: absolute;left: 50%;top: 40%; bottom: 50%; transform: translate(-50%, -50%)" id='time'>{{ $expired }}s</span>
            </div>
            <form method="POST" action="{{ Route('oauth.confirm') }}">
                @csrf
                <input type="hidden" name="token" value="{{ bcrypt(Session('user_callback')->id) }}">
                <div class="md-form-group">
                    <input type="email" name="email" value="{{ Session('user_callback')->email ?? '' }}" class="text-center md-input">
                    <label class="d-block w-100">Nhập email</label>
                </div>
                <div class="md-form-group">
                    <input type="text" name="name" value="{{ Session('user_callback')->name ?? '' }}" class="text-center md-input">
                    <label class="d-block w-100">Nhập họ & tên</label>
                </div>
                <div class="mt-3">
                    <button type="submit" class="btn btn-rounded bg-success-lt">Đăng Ký</button>
                </div>
                <div style="margin-top:30px" class="clearfix">
                @if($errors->any())
                    <div class="text-danger">
                        @foreach($errors->all() as $err)
                            <p>{{ $err }}</p>
                        @endforeach
                    </div>
                @endif
                </div>
            </form>
        </div>
    </div>
    <style>
        a:hover {
            color: #fff !important;
        }
    </style>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@8.18.2/dist/sweetalert2.all.min.js"></script>
    <script>
        let time = {{ $expired }};
        setInterval(() => {
            time--;
            document.getElementById('time').innerHTML = time + 's';
            if(time <= 0)
            {
                time = 0;
                location.reload();
            }
        },1000);
    </script>
    @if(session('message'))
    <script>
        Swal.fire('', "{{ session('message') }}", "{{ session('status') }}");
    </script>
    @endif
</body>

</html>
