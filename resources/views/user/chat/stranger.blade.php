@extends('app')

@section('hero','Chat Với Người Lạ')
@section('sub_hero','Lúc đi không biết họ lúc về không biết tên')

@section('content')
<div id="list-fight-room">
    <div class="page-content page-container" id="page-content">
        <div class="padding-x">
            @include('user.theme.parameter')
            <a href="{{ Route('user.chat.stranger.exit') }}" class="text-gold"><button style="margin-bottom:10px" id='fight-button' style="width:100px" class="vip-bordered">Thoát</button></a>
            <div class="vip-bordered d-flex flex pr-md-3" id="content-body">
                <div class="d-flex flex-column flex card m-0 mb-md-3" id="chat-list">
                    <div class="navbar flex-nowrap b-b">
                        <button data-toggle="modal" data-target="#content-aside" data-modal="" class="d-md-none btn btn-sm btn-icon no-bg"><span><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-menu"><line x1="3" y1="12" x2="21" y2="12"></line><line x1="3" y1="6" x2="21" y2="6"></line><line x1="3" y1="18" x2="21" y2="18"></line></svg></span></button> <span class="text-ellipsis flex mx-1"><span class="text-md text-highlight mx-2">Chat</span> </span><span class="flex"></span>
                        <div>
                            <div class="d-flex flex-wrap align-items-center avatar-group">
                                <i v-if="chat.noti" data-feather="bell"></i>
                                <i v-else data-feather="bell-off"></i>
                                <label class="mx-2 ui-switch ui-switch-sm danger m-t-xs"><input type="checkbox" v-model="chat.noti"> <i></i></label>
                            </div>
                        </div>
                    </div>
                    <input @change="uploadImage($event,'stranger')" type="file" id="file" style="display:none">
                    <div class="scrollable hover" id="chat-box" style="max-height:500px">
                        <div class="list">
                            <div class="p-3">
                                <div v-if="chat.messages.length == 0 && !chat.block" class="text-center">
                                    <p class="text-success" style="margin-top:20px">Đã kết nối, nói hi để bắt đầu cuộc trò chuyện</p>
                                </div>
                                <div v-else-if="chat.messages.length == 0 && chat.block">
                                    <p class="text-warning text-center" style="margin-top:20px">Đang tìm kiếm, xin vui lòng đợi trong giây lát...</p>
                                </div>
                                <div v-else class="chat-list">
                                    <p class="text-center"><i :class="chat.block ? 'text-gold' : 'text-success'">@{{ chat.block ? 'Đang kết nối...' : 'Đã kết nối' }}</i></p>
                                    <div v-for="(msg,index) in chat.messages" :key="index" class="chat-item" :data-class="msg.id == {{ Auth::user()->user_id }} ? 'alt' : 'null'" v-if="msg.message && msg.id && msg.time" data-sr-id="32" style="visibility: visible; transform: none; opacity: 1; transition: transform 0.5s cubic-bezier(0.6, 0.2, 0.1, 1) 0s, opacity 0.5s cubic-bezier(0.6, 0.2, 0.1, 1) 0s;">
                                        <a v-if="msg.id != {{ Auth::user()->user_id }}" href="#" class="avatar w-40" data-pjax-state=""><img class="image" src="https://image.flaticon.com/icons/png/512/149/149071.png" alt="."></a>
                                        <div class="chat-body">
                                            <div v-if="msg.type == 'text'" :style="{maxWidth:'300px',color:'#333',borderRadius:'25px !important',backgroundColor:msg.id == {{ Auth::user()->user_id }} ? '#e7ad55' : 'whitesmoke',}" class="chat-content rounded msg">@{{ msg.message }}</div>
                                            <div v-if="msg.type == 'attachments'" class="w-md my-3">
                                                <div class="row row-xs">
                                                    <div class="col-12">
                                                        <div class="media media-2x1 r box-shadows">
                                                            <a target="_blank" :href="msg.message" class="media-content" :style="{backgroundImage: `url(${msg.message})`}" data-pjax-state=""></a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="chat-date date">@{{ timeAgo(msg.time) }} trước</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="mt-auto b-t" id="chat-form">
                        <div class="p-2">
                            <div class="px-3">
                                <div class="toolbar my-1">
                                    <button v-if="!chat.uploading" style="background:transparent !important;border:none" class="btn btn-dark" @click="showInputFile()">
                                        <i data-feather="image"></i>
                                    </button>
                                    <button v-else style="background:transparent !important;border:none" class="btn btn-dark">
                                        @{{ chat.percent }}%
                                    </button>
                                </div>
                            </div>
                            <div class="input-group">
                                <input style="background:#0c0e11" @change="sendPrivateMessage('text')" v-model="chat.text" type="text" class="form-control p-3 no-shadow no-border" placeholder="Nhập tin nhắn..." id="newField">
                                <button @click="sendPrivateMessage('text')" class="btn btn-icon btn-rounded gd-success" type="button" id="newBtn">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-up">
                                        <line x1="12" y1="19" x2="12" y2="5"></line>
                                        <polyline points="5 12 12 5 19 12"></polyline>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('js')
<script src="https://js.pusher.com/5.0/pusher.min.js"></script>
@if($errors->any())
    <script>
        Swal.fire('',"{{ $errors->first() }}",'error');
    </script>
@endif
<script>
    var page = {
        path:'chat.stranger',
        user:{
            id:{{ Auth::user()->user_id }},
            name:"{{ Auth::user()->name }}",
        },
        room:{
            name:"{{ $room->name }}",
            people:{{ $room->people }}
        }
    };
</script>
@endpush