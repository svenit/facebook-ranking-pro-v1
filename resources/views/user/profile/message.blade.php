@extends('app')

@section('hero','Tin Nhắn')
@section('sub_hero','Tin nhắn của bạn')

@section('content')
<div id="list-fight-room">
    <div class="page-content page-container" id="page-content">
        <div class="padding-x">
            @include('user.theme.parameter')
            @include('user.profile.base')
            <div class="card vip-bordered">
                <div class="scroll-y mx-3 mb-0 card">
                    @if($messages->count() > 0)
                        <div class="list list-row">
                            @foreach($messages as $key => $message)
                                <div class="list-item" data-id="9" data-sr-id="2" style="visibility: visible; transform: none; opacity: 1; transition: transform 0.5s cubic-bezier(0.6, 0.2, 0.1, 1) 0s, opacity 0.5s cubic-bezier(0.6, 0.2, 0.1, 1) 0s;background:{{ $message->read_at ? '' : '#333' }}">
                                    <div><a href="{{ Route('user.profile.message.detail',['id' => $message->id]) }}" data-pjax-state=""><span class="w-40 avatar gd-dark" data-toggle-class="loading"><img src="http://graph.facebook.com/{{ $message->data['user_id'] }}/picture?type=normal" alt="."></span></a></div>
                                    <div class="flex"><a href="{{ Route('user.profile.message.detail',['id' => $message->id]) }}" class="item-title text-color h-1x" data-pjax-state="">
                                        {{ $message->data['title'] ?? '( Không có tiêu đề )' }}
                                    </a>
                                        <div class="item-except text-muted text-sm h-1x">
                                            {{ $message->data['name'] }} {!! $message->data['is_admin'] ? "<i class='fas fa-check-circle'></i>" : '' !!}
                                        </div>
                                    </div>
                                    <div class="no-wrap">
                                        <div class="item-date text-muted text-sm d-none d-md-block">
                                            {{ \Carbon\Carbon::parse($message->created_at)->diffForHumans() }}
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        {{ $messages->onEachSide(1)->links() }}
                    @else
                    <div class="no-result">
                        <div class="p-4 text-center">Không có tin nhắn nào</div>
                    </div>
                    @endif
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