@extends('app')

@section('hero','Phòng Hồi Phục')
@section('sub_hero','Hồi phục năng lượng')

@section('content')
<div id="list-fight-room">
    <div class="page-content page-container" id="page-content">
        <div class="padding-x">
            @include('user.theme.parameter')
            <div style="margin-top:20px" class="row">
                @foreach($recoveries as $key => $recovery)
                    <div class="col-6 col-md-4 col-lg-3">
                        <div class="card vip-bordered">
                            <br>
                            <p class="text-center text-gold"><strong>{{ $recovery->name }}</strong></p>
                            <p class="text-center">{{ $recovery->description }}</p>
                            <div class="btn-group">
                                @if(isset($isJoined))
                                    @if($isJoined->id == $recovery->id)
                                        @if(now() < $isJoined->pivot->end_at)
                                            <button type="button" class="btn btn-warning">
                                                {{ \Carbon\Carbon::parse($isJoined->pivot->end_at)->diffInMinutes() }} phút nữa
                                            </button>
                                            <a onclick="return confirm('Bạn có chắc muốn hủy ?')" href="{{ Route('user.explore.recovery-room.cancle',['id' => $isJoined->id]) }}">
                                                <button style="width:100%" type="button" class="btn btn-secondary active">
                                                    Hủy
                                                </button>
                                            </a>
                                        @else
                                        <a href="{{ Route('user.explore.recovery-room.receive',['room_id' => $isJoined->id]) }}" style="width:100%">
                                            <button style="width:100%" type="button" class="btn btn-success">
                                                Nhận
                                            </button>
                                        </a>
                                        @endif
                                    @else
                                        <a style="width:100%">
                                            <button style="width:100%" disabled type="button" class="btn btn-secondary">
                                                Vào
                                            </button>
                                        </a>
                                    @endif
                                @else
                                    <a href="{{ Route('user.explore.recovery-room.join',['id' => $recovery->id]) }}" style="width:100%">
                                        <button style="width:100%" type="button" class="btn btn-secondary">
                                            Vào
                                        </button>
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection
@push('js')
@if($errors->any())
    <script>
        Swal.fire('',"{{ $errors->first() }}",'error');
    </script>
@endif
<script>
    var page = {
        path:'recovery-room.index'
    };
</script>
@endpush