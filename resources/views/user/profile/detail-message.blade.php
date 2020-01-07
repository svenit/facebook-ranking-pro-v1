@extends('app')

@section('hero',$message->data['title'] ?? '( Không có tiêu đề )')
@section('sub_hero','Tin nhắn của bạn')

@section('content')
<div id="list-fight-room">
    <div class="page-content page-container" id="page-content">
        <div class="padding-x">
            @include('user.theme.parameter')
            @include('user.profile.base')
            <div class="card vip-bordered">
                <div style="padding:20px" class="scroll-y mx-3 mb-0 card bg-dark">
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
    const page = {
        path:'message.index'
    };
</script>
@endpush