@extends('app')

@section('hero','Kênh Thế Giới')
@section('sub_hero','Giao lưu cùng mọi người')

@section('content')
<div id="list-fight-room">
    <div class="page-content page-container" id="page-content">
        <div class="padding-x">
            @include('user.theme.parameter')
            <div class="vip-bordered d-flex flex pr-md-3" id="content-body">
                <div class="d-flex flex-column flex card m-0 mb-md-3" id="chat-list">
                    <div class="navbar flex-nowrap b-b">
                        <button data-toggle="modal" data-target="#content-aside" data-modal="" class="d-md-none btn btn-sm btn-icon no-bg"><span><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-menu"><line x1="3" y1="12" x2="21" y2="12"></line><line x1="3" y1="6" x2="21" y2="6"></line><line x1="3" y1="18" x2="21" y2="18"></line></svg></span></button> <span class="text-ellipsis flex mx-1"><span class="text-md text-highlight mx-2">Chat</span> </span><span class="flex"></span>
                        <div>
                            <div class="d-flex flex-wrap align-items-center avatar-group">
                                <i v-if="chat.global.noti" data-feather="bell"></i>
                                <i v-else data-feather="bell-off"></i>
                                <label class="mx-2 ui-switch ui-switch-sm danger m-t-xs"><input type="checkbox" v-model="chat.global.noti"> <i></i></label>
                            </div>
                        </div>
                    </div>
                    <input @change="uploadImage" type="file" id="file" style="display:none">
                    <div class="scrollable hover" id="chat-box" style="max-height:500px">
                        <div class="list">
                            <div class="p-3">
                                <div v-if="chat.global.messages.length == 0" class="text-center">
                                    <svg width="48" height="48" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M21.1641 38.997C23.6931 40.262 26.7301 41 30.0001 41C31.1791 41 32.3261 40.898 33.4321 40.716L42.0001 45V36.919C44.4821 34.805 46.0001 32.038 46.0001 29C46.0001 27.962 45.8241 26.958 45.4941 26.001" stroke="#808080" stroke-width="2" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M22 2C10.954 2 2 9.163 2 18C2 21.594 3.499 24.9 6 27.571V38L15.665 33.167C17.658 33.7 19.783 34 22 34C33.046 34 42 26.837 42 18C42 9.163 33.046 2 22 2Z" fill="#F2F2F2" stroke="#808080" stroke-width="2" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                    <p style="margin-top:20px">( Trống )</p>
                                </div>
                                <div v-else class="chat-list">
                                    <div v-for="(msg,index) in chat.global.messages" :key="index" class="chat-item" :data-class="msg.id == {{ Auth::user()->user_id }} ? 'alt' : 'null'" v-if="msg.message && msg.id && msg.name && msg.time" data-sr-id="32" style="visibility: visible; transform: none; opacity: 1; transition: transform 0.5s cubic-bezier(0.6, 0.2, 0.1, 1) 0s, opacity 0.5s cubic-bezier(0.6, 0.2, 0.1, 1) 0s;">
                                        <a v-if="msg.id != {{ Auth::user()->user_id }}" href="#" class="avatar w-40" data-pjax-state=""><img class="image" :src="`http://graph.facebook.com/${msg.id}/picture?type=normal`" alt="."></a>
                                        <div class="chat-body">
                                            <div :style="{maxWidth:'300px',color:'#333',borderRadius:'25px !important',backgroundColor:msg.id == {{ Auth::user()->user_id }} ? '#e7ad55' : 'whitesmoke',}" class="chat-content rounded msg">@{{ msg.message }}</div>
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
                                    <button class="btn btn-dark" @click="showInputFile()">
                                        <i data-feather="image"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="input-group">
                                <input @change="sendMessage('text')" v-model="chat.global.text" type="text" class="form-control p-3 no-shadow no-border" placeholder="Nhập tin nhắn..." id="newField">
                                <button @click="sendMessage('text')" class="btn btn-icon btn-rounded gd-success" type="button" id="newBtn">
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
@if($errors->any())
    <script>
        Swal.fire('',"{{ $errors->first() }}",'error');
    </script>
@endif
<script>
    const page = {
        path:'chat.global',
        user:{
            id:{{ Auth::user()->user_id }},
            name:"{{ Auth::user()->name }}"
        }
    };
</script>
@endpush