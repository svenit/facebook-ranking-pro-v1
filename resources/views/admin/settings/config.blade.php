@extends('app')
@section('content')

@section('hero','Cấu Hình')
@section('sub_hero','Cấu Hình')

<div id="content" class="flex">
    <div id="ranking" class="">
        <div class="page-content page-container" id="page-content">
            <div class="padding-x">
                <div class="col-12 vip-bordered">
                    @if($errors->any())
                    <div class="alert alert-danger">
                        @foreach($errors->all() as $err)
                            <div>{{ $err }}</div>
                        @endforeach
                    </div>
                    @endif
                    <div class="tab-content p-3">
                        <div class="tab-pane active show" id="home-add" role="tabpanel" aria-labelledby="add-tab">
                            <div>
                                <div class="card">
                                    <div class="card-body">
                                        <div style="margin:20px 0px">
                                            <button class="btn btn-success" @click="deleteGlobalChat()">Xóa Chat Thế Giới</button>
                                            <button class="btn btn-success" @click="deleteStrangerChat()">Xóa CVNL</button>
                                        </div>
                                        <form method="POST" action="{{ Route('admin.settings.config-update') }}" class="row">
                                            @csrf
                                            <div class="form-group col-6">
                                                <label class="text-muted" for="exampleInputEmail1">Bảo Trì</label>
                                                <select placeholder="Chọn trang bị" class="chosen form-control form-control-sm" name="maintaince">
                                                    <option {{ $config->maintaince == 0 ? 'selected' : '' }} value="0">Không</option>
                                                    <option {{ $config->maintaince == 1 ? 'selected' : '' }} value="1">Có</option>
                                                </select>
                                            </div>
                                            <div class="form-group col-6">
                                                <label class="text-muted" for="exampleInputEmail1">Chat</label>
                                                <select placeholder="Chọn trang bị" class="chosen form-control form-control-sm" name="open_chat">
                                                    <option {{ $config->open_chat == 0 ? 'selected' : '' }} value="0">Đóng</option>
                                                    <option {{ $config->open_chat == 1 ? 'selected' : '' }} value="1">Mở</option>
                                                </select>
                                            </div>
                                            <div class="form-group col-6">
                                                <label class="text-muted" for="exampleInputEmail1">PVP</label>
                                                <select placeholder="Chọn trang bị" class="chosen form-control form-control-sm" name="open_pvp">
                                                    <option {{ $config->open_pvp == 0 ? 'selected' : '' }} value="0">Đóng</option>
                                                    <option {{ $config->open_pvp == 1 ? 'selected' : '' }} value="1">Mở</option>
                                                </select>
                                            </div>
                                            <div class="form-group col-6">
                                                <label class="text-muted" for="exampleInputEmail1">Giới Hạn PVP</label>
                                                <select placeholder="Chọn trang bị" class="chosen form-control form-control-sm" name="limit_pvp_time_status">
                                                    <option {{ $config->limit_pvp_time_status == 0 ? 'selected' : '' }} value="0">Không</option>
                                                    <option {{ $config->limit_pvp_time_status == 1 ? 'selected' : '' }} value="1">Có</option>
                                                </select>
                                            </div>
                                            <div class="form-group col-6">
                                                <label class="text-muted" for="exampleInputEmail1">Thời Gian Gới Hạn PVP</label>
                                                <input type="number" min="0" value="{{ $config->limit_pvp_time }}" class="form-control" name="limit_pvp_time" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="">
                                            </div>
                                            <div class="form-group col-6">
                                                <label class="text-muted" for="exampleInputEmail1">ID Nhóm</label>
                                                <input type="number" value="{{ $config->group_id }}" class="form-control" name="group_id" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="">
                                            </div>
                                            <div class="form-group col-6">
                                                <label class="text-muted" for="exampleInputEmail1">Ngày Bắt Đầu</label>
                                                <input type="date" value="{{ $config->started_day }}" class="form-control" name="started_day" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="">
                                            </div>
                                            <div class="form-group col-6">
                                                <label class="text-muted" for="exampleInputEmail1">Điểm Bài Viết</label>
                                                <input type="number" value="{{ $config->per_post }}" class="form-control" name="per_post" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="">
                                            </div>
                                            <div class="form-group col-6">
                                                <label class="text-muted" for="exampleInputEmail1">Điểm Bình Luận</label>
                                                <input type="number" value="{{ $config->per_comment }}" class="form-control" name="per_comment" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="">
                                            </div>
                                            <div class="form-group col-6">
                                                <label class="text-muted" for="exampleInputEmail1">Điểm Được Bình Luận</label>
                                                <input type="number" value="{{ $config->per_commented }}" class="form-control" name="per_commented" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="">
                                            </div>
                                            <div class="form-group col-6">
                                                <label class="text-muted" for="exampleInputEmail1">Điểm Biểu Cảm</label>
                                                <input type="number" value="{{ $config->per_react }}" class="form-control" name="per_react" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="">
                                            </div>
                                            <div class="form-group col-6">
                                                <label class="text-muted" for="exampleInputEmail1">Điểm Được Biểu Cảm</label>
                                                <input type="number" value="{{ $config->per_reacted }}" class="form-control" name="per_reacted" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="">
                                            </div>
                                            <div class="form-group col-12">
                                                <label class="text-muted" for="exampleInputEmail1">Access Token</label>
                                                <input type="text" value="{{ $config->access_token }}" class="form-control" name="access_token" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="">
                                            </div>
                                            <div class="form-group col-12">
                                                <button type="submit" class="btn btn-success">Cập Nhật</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('css')
    <link rel="stylesheet" href="{{ asset('assets/css/plugins/chosen.css') }}">
@endpush
@push('js')
<script src="{{ asset('assets/js/plugins/chosen/chosen.jquery.js') }}"></script>
<script>
    $(document).ready( function () {
        $('.chosen').chosen({
            width: '100%'
        });
    });
    new Vue({
        el:'#ranking',
        methods: {
            async deleteGlobalChat()
            {
                await firebase.database().ref('global').remove();
                Swal.fire('','Đã xóa','success');
            },
            async deleteStrangerChat()
            {
                await firebase.database().ref('strangers').remove();
                Swal.fire('','Đã xóa','success');
            },
        },
    });
</script>
@endpush