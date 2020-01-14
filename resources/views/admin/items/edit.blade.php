@extends('app')
@section('content')

@section('hero','Thêm Vật Phẩm')
@section('sub_hero','Thêm Vật Phẩm')

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
                                        <div v-if="class_tag" style="margin:10px 0px">
                                            <div :style="{border:`1px solid #fff`}" :class="`pixel ${class_tag} item-content`"></div>
                                        </div>
                                        <form method="POST" action="{{ Route('admin.items.update',['id' => $item->id]) }}" class="row">
                                            @csrf
                                            <div class="form-group col-6">
                                                <label class="text-muted" for="exampleInputEmail1">Tên</label>
                                                <input type="text" value="{{ $item->name }}" class="form-control" name="name" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="">
                                            </div>
                                            <div class="form-group col-6">
                                                <label class="text-muted" for="exampleInputEmail1">Class Tag</label>
                                                <input type="text" v-model="class_tag" value="{{ $item->class_tag }}" class="form-control" name="class_tag" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="">
                                            </div>
                                            <div class="form-group col-6">
                                                <label class="text-muted" for="exampleInputEmail1">SQL Queries</label>
                                                <textarea rows="4" class="form-control" name="query">
                                                    {!! $item->query !!}
                                                </textarea>
                                            </div>
                                            <div class="form-group col-6">
                                                <label class="text-muted" for="exampleInputEmail1">Mô Tả</label>
                                                <textarea rows="4" class="form-control" name="description">
                                                    {{ $item->description }}
                                                </textarea>
                                            </div>
                                            <div class="form-group col-6">
                                                <label class="text-muted" for="exampleInputEmail1">Tỉ Lệ Thành Công</label>
                                                <input type="number" value="{{ $item->success_rate }}" class="form-control" name="success_rate" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="">
                                            </div>
                                            <div class="form-group col-6">
                                                <label class="text-muted" for="exampleInputEmail1">Giá</label>
                                                <input type="number" value="{{ $item->price }}" class="form-control" name="price" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="">
                                            </div>
                                            <div class="form-group col-6">
                                                <label class="text-muted" for="exampleInputEmail1">ĐVTT</label>
                                                <select placeholder="Chọn trang bị" class="chosen form-control form-control-sm" name="price_type">
                                                    <option {{ $item->price_type == 0 ? 'selected' : '' }} value="0">Vàng</option>
                                                    <option {{ $item->price_type == 1 ? 'selected' : '' }} value="1">KC</option>
                                                </select>
                                            </div>
                                            <div class="form-group col-6">
                                                <label class="text-muted" for="exampleInputEmail1">Trạng Thái</label>
                                                <select placeholder="Chọn trang bị" class="chosen form-control form-control-sm" name="status">
                                                    <option {{ $item->status == 0 ? 'selected' : '' }} value="0">Ẩn</option>
                                                    <option {{ $item->status == 1 ? 'selected' : '' }} selected value="1">Hiện</option>
                                                </select>
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
                                        <th style="" data-field="owner">
                                            <div class="th-inner text-gold sortable both">Số Lượng</div>
                                        </th>
                                        <th style="width:100px" data-field="task">
                                            <div class="th-inner text-gold"><span class="d-none d-sm-block">Hành Động</span>
                                            </div>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($item->users as $key => $user)
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
                                            <td style=""><small class="text-muted">{{ $user->pivot->quantity }}</small></td>
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
@push('js')
<script>
    new Vue({
        el:'#ranking',
        data:{
            class_tag:"{{ $item->class_tag }}",
        },
    });
</script>

@endpush