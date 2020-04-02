@extends('app')

@section('hero','PVP')
@section('sub_hero','Vinh quang chỉ dành cho người chiến thắng')

@section('content')
<div id="list-fight-room">
    <div class="page-content page-container" id="page-content">
        <div class="padding-x">
            @include('user.theme.parameter')
            <p class="text-gold">
                <button id='fight-button' data-toggle="modal" data-target="#modal" style="width:300px" class="vip-bordered">Tạo Phòng</button>
                <button style="width:300px" class="vip-bordered">Vé Tham Gia : {{ Auth::user()->pvp_times }}</button>
            </p>
            <div style="margin-top:20px" class="row">
                <div v-for="(room,index) in pvp.rooms" :key="index" class="col-auto">
                    <a :href="`join/${room.name}`">
                        <div class="card vip-bordered">
                            <div class="media media-4x3">
                                <a class="media-content" style="background-size:80%;background-image:url({{ asset('assets/images/pvp.png') }})">
                                </a>
                            </div>
                            <div class="btn-group">
                                <button type="button" class="btn btn-secondary active">@{{ room.people }} Người </button> 
                                <a v-if="room.people == 1" style="border-radius:0px !important" :href="`join/${room.name}`"><button style="border-top-left-radius:0px;border-bottom-left-radius:0px" type="button" class="btn btn-secondary">Vào</button></a>
                            </div>
                        </div>
                    </a>
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
        path:'pvp.list'
    };
</script>
@endpush