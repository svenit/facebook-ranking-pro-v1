@extends('app')

@section('hero','PVP')
@section('sub_hero','Vinh quang chỉ dành cho người chiến thắng')

@section('content')
<div id="list-fight-room">
    <div class="page-content page-container" id="page-content">
        <div class="padding-x">
            @include('user.theme.parameter')
            <div class="row">
                <div class="col-auto">
                    <div class="card vip-bordered">
                        <div class="media media-4x3">
                            <a class="media-content" style="background-position:center;background-image:url({{ asset('assets/images/dungeon/gate.gif') }})">
                            </a>
                        </div>
                        <div class="btn-group">
                            <button type="button" class="btn btn-secondary active">Cổng E Rank</button> 
                            <a href="{{ Route('user.dungeon.join',['gate' => 'e']) }}" style="border-radius:0px !important"><button style="border-top-left-radius:0px;border-bottom-left-radius:0px" type="button" class="btn btn-secondary">Vào</button></a>
                        </div>
                    </div>
                </div>
                <div class="col-auto">
                    <div class="card vip-bordered">
                        <div class="media media-4x3">
                            <a class="media-content" style="background-image:url({{ asset('assets/images/dungeon/gate.gif') }})">
                            </a>
                        </div>
                        <div class="btn-group">
                            <button type="button" class="btn btn-secondary active">Cổng D Rank</button> 
                            <a href="{{ Route('user.dungeon.join',['gate' => 'd']) }}" style="border-radius:0px !important"><button style="border-top-left-radius:0px;border-bottom-left-radius:0px" type="button" class="btn btn-secondary">Vào</button></a>
                        </div>
                    </div>
                </div>
                <div class="col-auto">
                    <div class="card vip-bordered">
                        <div class="media media-4x3">
                            <a class="media-content" style="background-image:url({{ asset('assets/images/dungeon/gate.gif') }})">
                            </a>
                        </div>
                        <div class="btn-group">
                            <button type="button" class="btn btn-secondary active">Cổng C Rank</button> 
                            <a href="{{ Route('user.dungeon.join',['gate' => 'c']) }}" style="border-radius:0px !important"><button style="border-top-left-radius:0px;border-bottom-left-radius:0px" type="button" class="btn btn-secondary">Vào</button></a>
                        </div>
                    </div>
                </div>
                <div class="col-auto">
                    <div class="card vip-bordered">
                        <div class="media media-4x3">
                            <a class="media-content" style="background-image:url({{ asset('assets/images/dungeon/gate.gif') }})">
                            </a>
                        </div>
                        <div class="btn-group">
                            <button type="button" class="btn btn-secondary active">Cổng B Rank</button> 
                            <a href="{{ Route('user.dungeon.join',['gate' => 'b']) }}" style="border-radius:0px !important"><button style="border-top-left-radius:0px;border-bottom-left-radius:0px" type="button" class="btn btn-secondary">Vào</button></a>
                        </div>
                    </div>
                </div>
                <div class="col-auto">
                    <div class="card vip-bordered">
                        <div class="media media-4x3">
                            <a class="media-content" style="background-image:url({{ asset('assets/images/dungeon/gate.gif') }})">
                            </a>
                        </div>
                        <div class="btn-group">
                            <button type="button" class="btn btn-secondary active">Cổng A Rank</button> 
                            <a href="{{ Route('user.dungeon.join',['gate' => 'a']) }}" style="border-radius:0px !important"><button style="border-top-left-radius:0px;border-bottom-left-radius:0px" type="button" class="btn btn-secondary">Vào</button></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- .modal -->
<div id="modal" class="modal fade ultra-bordered" data-backdrop="true">
    <div class="modal-dialog bg-dark">
        <div class="modal-content bg-dark">
            <div class="modal-header bg-dark">
                <button class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body bg-dark">
                <div class="text-center">
                    <p>Beep beep boo boo ?</p>
                    <form method="POST" action="{{ Route('user.pvp.create') }}">
                        {{ csrf_field() }}
                        <center>
                            <div class="g-recaptcha" data-sitekey="6LccQnEUAAAAABNb2nR1r6RucjwkkUpmBTMomCku"></div>
                        </center>
                        <div style="margin-top:20px">
                            <button type="submit" class="btn btn-success">Tạo Phòng</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="modal-footer bg-dark">
                <button type="button" class="btn btn-dark" data-dismiss="modal">Đóng</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
</div>
@endsection
@push('js')
@if($errors->any())
    <script>
        Swal.fire('',"{{ $errors->first() }}",'error');
    </script>
@endif
<script src="https://www.google.com/recaptcha/api.js"></script>
<script>
    var page = {
        path:'dungeon.index'
    };
</script>
@endpush