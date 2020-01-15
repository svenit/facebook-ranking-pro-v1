@extends('app')
@section('content')

@section('hero','Thêm Kỹ Năng')
@section('sub_hero','Thêm Kỹ Năng')

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
                    <div class="b-b">
                        <div class="nav-active-border b-primary bottom">
                            <ul class="nav" id="myTab" role="tablist">
                                <li class="nav-item"><a class="nav-link active" id="add-tab" data-toggle="tab" href="#home-add" role="tab" aria-controls="home-add" aria-selected="false">Thêm</a></li>
                                <li class="nav-item"><a class="nav-link" id="own-tab" data-toggle="tab" href="#home-own" role="tab" aria-controls="home-own" aria-selected="false">DSTV Sở Hữu</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="tab-content p-3">
                        <div class="tab-pane active show" id="home-add" role="tabpanel" aria-labelledby="add-tab">
                            <div>
                                <div class="card">
                                    <div class="card-body">
                                        <form method="POST" action="{{ Route('admin.skills.update',['id' => $skill->id]) }}" class="row">
                                            @csrf
                                            <div class="form-group col-6">
                                                <label class="text-muted" for="exampleInputEmail1">Tên</label>
                                                <input type="text" value="{{ $skill->name }}" class="form-control" name="name" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="">
                                            </div>
                                            <div class="form-group col-6">
                                                <label class="text-muted">Hệ Phái</label>
                                                <select autocomplete="off" placeholder="Chọn trang bị" class="chosen form-control form-control-sm" name="character_id">
                                                    @foreach($characters as $character)
                                                        <option {{ $skill->character_id == $character->id ? 'selected' : '' }} value="{{ $character->id }}">{{ $character->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group col-6">
                                                <label class="text-muted" for="exampleInputEmail1">Hình Ảnh</label>
                                                <input type="text" value="{{ $skill->image }}" class="form-control" name="image" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="">
                                            </div>
                                            <div class="form-group col-6">
                                                <label class="text-muted" for="exampleInputEmail1">Animation</label>
                                                <input type="text" value="{{ $skill->animation }}" class="form-control" name="animation" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="">
                                            </div>
                                            <div class="form-group col-6">
                                                <label class="text-muted" for="exampleInputEmail1">Sức Mạnh</label>
                                                <input type="number" value="{{ $skill->power_value }}" class="form-control" name="power_value" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="">
                                            </div>
                                            <div class="form-group col-6">
                                                <label class="text-muted" for="exampleInputEmail1">Thể Loại</label>
                                                <select autocomplete="off" placeholder="Chọn trang bị" class="chosen form-control form-control-sm" name="power_type">
                                                    <option {{ $skill->power_type == 0 ? 'selected' : '' }} value="0">Thông Số</option>
                                                    <option {{ $skill->power_type == 1 ? 'selected' : ''  }} value="1">Phần Trăm</option>
                                                </select>
                                            </div>
                                            <div class="form-group col-6">
                                                <label class="text-muted" for="exampleInputEmail1">Kiểu</label>
                                                <input type="text" value="{{ $skill->type }}" class="form-control" name="type" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="">
                                            </div>
                                            <div class="form-group col-6">
                                                <label class="text-muted" for="exampleInputEmail1">Dạng</label>
                                                <select autocomplete="off" placeholder="Chọn trang bị" class="chosen form-control form-control-sm" name="passive">
                                                    <option {{ $skill->passive == 0 ? 'selected' : '' }} value="0">Chủ Động</option>
                                                    <option {{ $skill->passive == 1 ? 'selected' : '' }} value="1">Bị Động</option>
                                                </select>
                                            </div>
                                            <div class="form-group col-6">
                                                <label class="text-muted" for="exampleInputEmail1">Cấp Độ Yêu Cầu</label>
                                                <input type="number" value="{{ $skill->required_level }}" class="form-control" name="required_level" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="">
                                            </div>
                                            <div class="form-group col-6">
                                                <label class="text-muted" for="exampleInputEmail1">Năng Lượng Tiêu Hao</label>
                                                <input type="number" min="0" max="100" value="{{ $skill->energy }}" class="form-control" name="energy" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="">
                                            </div>
                                            <div class="form-group col-6">
                                                <label class="text-muted" for="exampleInputEmail1">Tỉ Lệ Thành Công</label>
                                                <input type="number" min="0" max="100" value="{{ $skill->success_rate }}" class="form-control" name="success_rate" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="">
                                            </div>
                                            <div class="form-group col-6">
                                                <label class="text-muted" for="exampleInputEmail1">RGB</label>
                                                <input type="text" value="{{ $skill->rgb }}" class="form-control" name="rgb" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="">
                                            </div>
                                            <div class="form-group col-6">
                                                <label class="text-muted" for="exampleInputEmail1">Giá</label>
                                                <input type="number" value="{{ $skill->price }}" class="form-control" name="price" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="">
                                            </div>
                                            <div class="form-group col-6">
                                                <label class="text-muted" for="exampleInputEmail1">ĐVTT</label>
                                                <select placeholder="Chọn trang bị" class="chosen form-control form-control-sm" name="price_type">
                                                    <option {{ $skill->price_type == 0 ? 'selected' : '' }} value="0">Vàng</option>
                                                    <option {{ $skill->price_type == 1 ? 'selected' : '' }} value="1">KC</option>
                                                </select>
                                            </div>
                                            <div class="form-group col-6">
                                                <label class="text-muted" for="exampleInputEmail1">Trạng Thái</label>
                                                <select placeholder="Chọn trang bị" class="chosen form-control form-control-sm" name="status">
                                                    <option {{ $skill->status == 0 ? 'selected' : '' }} value="0">Ẩn</option>
                                                    <option {{ $skill->status == 1 ? 'selected' : '' }} value="1">Hiện</option>
                                                </select>
                                            </div>
                                            <div class="form-group col-12">
                                                <label class="text-muted" for="exampleInputEmail1">Mô Tả</label>
                                                <textarea rows="4" class="form-control" name="description"></textarea>
                                            </div>
                                            <div class="form-group col-12">
                                                <button type="submit" class="btn btn-success">Cập Nhật</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="home-own" role="tabpanel" aria-labelledby="own-tab">
                            <table id="myTable" class="table table-striped">
                                <thead>
                                    <tr>
                                        <th style="" data-field="owner">
                                            <div class="th-inner text-gold sortable both">#</div>
                                        </th>
                                        <th style="" data-field="owner">
                                            <div class="th-inner text-gold sortable both">Avatar</div>
                                        </th>
                                        <th style="" data-field="owner">
                                            <div class="th-inner text-gold sortable both">Tên</div>
                                        </th>
                                        <th style="" data-field="owner">
                                            <div class="th-inner text-gold sortable both">Hệ Phái</div>
                                        </th>
                                        <th style="width:100px" data-field="task">
                                            <div class="th-inner text-gold"><span class="d-none d-sm-block">Hành Động</span>
                                            </div>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($skill->users as $key => $user)
                                        <tr>
                                            <td style=""><small class="text-muted">{{ $key + 1 }}</small></td>
                                            <td>
                                                <a target="_blank" href="https://fb.com/{{ $user->user_id }}">
                                                    <span style="width:50px" class="avatar">
                                                        <span class="avatar-status {{ $user->isOnline() ? 'on' : 'off' }} b-white avatar-right"></span>
                                                        <img class="profile-picture"
                                                            src="https://graph.facebook.com/{{ $user->user_id }}/picture"
                                                            alt="profile-picture" height="50">
                                                    </span>
                                                </a>
                                            </td>
                                            <td style=""><small class="text-muted">{{ $user->name }}</small></td>
                                            <td style=""><small class="text-muted">{{ $user->character->name }}</small></td>
                                            <td class="flex" style="">
                                                <div class="dropdown mb-2"><button class="btn btn-white dropdown-toggle" data-toggle="dropdown"
                                                    aria-expanded="false">Hành Động</button>
                                                    <div class="dropdown-menu bg-dark" role="menu" x-placement="bottom-start"
                                                        style="position: absolute; transform: translate3d(0px, 34px, 0px); top: 0px; left: 0px; will-change: transform;">
                                                        <a href="{{ Route('admin.users.detail',['id' => $user->id]) }}" class="dropdown-item">Xem</a>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
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
<script src="{{ asset('assets/js/plugins/datatable/datatable.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins/datatable/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('assets/js/vue/app.js') }}"></script>
<script>
    $(document).ready( function () {
        $('#myTable').DataTable({
            pageLength: 10,
            responsive: true,
            dom: '<"html5buttons"B>lTfgitp',
            buttons: [
                { extend: 'copy'},
                {extend: 'csv'},
                {extend: 'excel', title: 'ExampleFile'},
                {extend: 'pdf', title: 'ExampleFile'},

                {extend: 'print',
                    customize: function (win){
                        $(win.document.body).addClass('white-bg');
                        $(win.document.body).css('font-size', '10px');

                        $(win.document.body).find('table')
                            .addClass('compact')
                            .css('font-size', 'inherit');
                    }
                }
            ]
        });
        $('.chosen').chosen({
            width: '100%'
        });
    });
</script>
@endpush