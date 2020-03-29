@extends('app')

@section('hero',$message->data['title'] ?? '( Không có tiêu đề )')
@section('sub_hero','Tin nhắn của bạn')

@section('content')
<div id="list-fight-room">
    <button style="display:none" id="show-infor-user" data-toggle="modal" data-target=".modal-right" data-toggle-class="modal-open-aside" data-target="body"></button>
    <div class="page-content page-container" id="page-content">
        <div class="padding-x">
            @include('user.theme.parameter')
            @include('user.profile.base')
            <div class="card vip-bordered">
                <div style="padding:20px" class="scroll-y mx-3 mb-0 card bg-dark">
                    <div style="max-width:300px" class="row">
                        <div class="col-2">
                            <span @click="showUserInfor({{ $message->data['user_id'] }})" class="w-40 avatar gd-dark">
                                <img src="http://graph.facebook.com/{{ $message->data['user_id'] }}/picture?type=normal" alt=".">
                            </span>
                        </div>
                        <div class="col-8">
                            <div><strong>{{ $message->data['name'] }} {!! $message->data['is_admin'] ? "<i class='fas fa-check-circle'></i>" : '' !!}</strong></div>
                            <small style="font-size:11px">{{ \Carbon\Carbon::parse($message->created_at)->diffForHumans() }}</small>
                        </div>
                    </div>
                    <hr>
                    {!! $message->data['message'] !!}
                </div>
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
        path:'message.index'
    };
</script>
@endpush