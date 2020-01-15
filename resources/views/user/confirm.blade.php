<!DOCTYPE html>
<html class="bg-light" lang="en">

<head>
    <meta charset="utf-8">
    <title>{{ env('APP_NAME') }} - Xác Nhận</title>
    <link rel="stylesheet" href="{{ asset('assets/css/site.min.css') }}">
    <link href="{{ asset('cdn/css/all.min.css') }}" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}" />
</head>
<body class="layout-row">
    <div style="background:#f9f9f9 !important;color:#888 !important" id="ajax-content" class="bg-light h-v d-flex flex align-items-center">
        <div style="background:#fff;border-radius:5px;padding:40px;width:500px" class="mx-auto w-xl w-auto-xs animate fadeIn text-center">
            <div class="mb-3"><img src="{{ 'http://graph.facebook.com/'.Session('user_callback')->id.'/picture?type=normal' }}" class="w-72 circle">
                <div class="mt-3 font-bold">{{ Session('user_callback')->name ?? 'Lỗi' }} <span id='time' class="badge badge-rounded bg-warning-lt">{{ $expired }}s</span></div>
            </div>
            <form method="POST" action="{{ Route('oauth.confirm') }}">
                @csrf
                <div class="step1">
                    <div class="md-form-group token"><input name="token" readonly id='copy-text' type="text" value="{{ bcrypt(Session('user_callback')->id) ?? 'Lỗi' }}" class="md-input text-center"><label
                            class="d-block w-100">Sao chép mã Token</label></div>
                    <div class="mt-3">
                        <a href="#step2" onclick="next(2)" class="btn btn-rounded btn-primary">Tiếp theo</a>
                    </div>
                </div>
                <div class="step2">
                    <p class="text-mute">Nhấp vào đường dẫn này : <a target="_blank" href="https://www.facebook.com/groups/264815670979717/permalink/513084769486138/">Link</a></p>
                    <p>Nhập đoạn mã Token mà bạn vừa sao chép vào bài viết</p>
                    <div class="mt-3">
                        <a href="#step1" onclick="next(1)" class="btn btn-rounded bg-secondary-lt mx-2">Quay lại</a>
                        <a href="#step3" onclick="next(3)" class="btn btn-rounded btn-primary">Tiếp theo</a>
                    </div>
                </div>
                <div class="step3">
                    <p>Sau đó sao chép đường dẫn bình luận của bạn rồi nhập vào đây</p>
                    <div class="md-form-group token"><input type="url" name="url" value="" class="md-input text-center"><label
                            class="d-block w-100">Nhập URL bình luận Facebook</label></div>
                    <div class="mt-3">
                        <a href="#step2" onclick="next(2)" class="btn btn-rounded bg-secondary-lt mx-2">Quay lại</a>
                        <button class="btn btn-rounded bg-success-lt">Xác nhận</button>
                    </div>
                </div>
                <div style="margin-top:30px" class="clearfix">
                @if($errors->any())
                    <div class="alert alert-warning" role="alert">
                        @foreach($errors->all() as $err)
                            <p style="margin:0px">{{ $err }}</p>
                        @endforeach
                    </div>
                @endif
                </div>
            </form>
        </div>
    </div>
    <script src="{{ asset('assets/js/site.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@8.18.2/dist/sweetalert2.all.min.js"></script>
    <script>
        $('.step2').hide();
        $('.step3').hide();
        if(sessionStorage.getItem('page'))
        {
            next(sessionStorage.getItem('page'));
        }
        function next(page)
        {
            sessionStorage.setItem('page',page);
            for(var i = 0;i < 10;i++)
            {
                if(i == page)
                {
                    $('.step'+i).show();
                }
                else
                {
                    $('.step'+i).hide();
                }
            }
        }
        document.getElementById("copy-text").onclick = function() {
            this.select();
            document.execCommand('copy');
            alert('Đã sao chép');
        }
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
