@extends('app')
@section('content')

@section('hero','Danh Mục Trang Bị')
@section('sub_hero','Danh Mục Trang Bị')

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
                                <li class="nav-item"><a class="nav-link active" id="index-tab" data-toggle="tab" href="#home-index" role="tab" aria-controls="home-index" aria-selected="true">Danh Sách</a></li>
                                <li class="nav-item"><a class="nav-link" id="add-tab" data-toggle="tab" href="#home-add" role="tab" aria-controls="home-add" aria-selected="false">Thêm</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="tab-content p-3">
                        <div class="tab-pane fade show active" id="home-index" role="tabpanel" aria-labelledby="index-tab">
                            <table id="myTable" class="table table-striped">
                                <thead>
                                    <tr>
                                        <th style="" data-field="owner">
                                            <div class="th-inner text-gold sortable both">#</div>
                                        </th>
                                        <th style="" data-field="owner">
                                            <div class="th-inner text-gold sortable both">Tên</div>
                                        </th>
                                        <th data-field="project">
                                            <div class="th-inner text-gold sortable both">Trang Bị</div>
                                        </th>
                                        <th data-field="project">
                                            <div class="th-inner text-gold sortable both">Loại</div>
                                        </th>
                                        <th style="" data-field="owner">
                                            <div class="th-inner text-gold sortable both">Hệ Phái</div>
                                        </th>
                                        <th style="" data-field="owner">
                                            <div class="th-inner text-gold sortable both">SLTV Sở Hữu</div>
                                        </th>
                                        <th style="width:100px" data-field="task">
                                            <div class="th-inner text-gold"><span class="d-none d-sm-block">Hành Động</span>
                                            </div>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($gears as $key => $gear)
                                        <tr>
                                            <td style=""><small class="text-muted">{{ $key + 1 }}</small></td>
                                            <td style=""><small class="text-muted">{{ $gear->name }}</small></td>
                                            <td @click="showGearsDescription({{ json_encode($gear) }},0)" style=""><div style="border:1px solid {{ $gear->rgb }}" class="{{ $gear->shop_tag }}"></div></td>
                                            <td style=""><small class="text-muted">{{ $gear->cates->name }}</small></td>
                                            <td style=""><small class="text-muted">{{ $gear->character->name }}</small></td>
                                            <td style=""><small class="text-muted">{{ $gear->users->count() }}</small></td>
                                            <td class="flex" style="">
                                                <div class="dropdown mb-2"><button class="btn btn-white dropdown-toggle" data-toggle="dropdown"
                                                    aria-expanded="false">Hành Động</button>
                                                    <div class="dropdown-menu bg-dark" role="menu" x-placement="bottom-start"
                                                        style="position: absolute; transform: translate3d(0px, 34px, 0px); top: 0px; left: 0px; will-change: transform;">
                                                        <a href="{{ Route('admin.gears.edit',['id' => $gear->id]) }}" class="dropdown-item">Sửa</a>
                                                        <a href="{{ Route('admin.gears.delete',['id' => $gear->id]) }}" class="dropdown-item">Xóa</a>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="tab-pane fade" id="home-add" role="tabpanel" aria-labelledby="add-tab">
                            <div>
                                <div class="card">
                                    <div class="card-body">
                                        <div v-if="shop_tag" style="margin:10px 0px" class="preview">
                                            <div :style="{border:`1px solid ${rgb}`}" :class="shop_tag"></div>
                                        </div>
                                        <form method="POST" action="{{ Route('admin.gears.store') }}" class="row">
                                            @csrf
                                            <div class="form-group col-6">
                                                <label class="text-muted" for="exampleInputEmail1">Tên Trang Bị</label>
                                                <input type="text" value="" class="form-control" name="name" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="">
                                            </div>
                                            <div class="form-group col-6">
                                                <label class="text-muted" for="exampleInputEmail1">Class Tag</label>
                                                <input type="text" value="" class="form-control" name="class_tag" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="">
                                            </div>
                                            <div class="form-group col-6">
                                                <label class="text-muted" for="exampleInputEmail1">Shop Tag</label>
                                                <input type="text" v-model="shop_tag" value="" class="form-control" name="shop_tag" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="">
                                            </div>
                                            <div class="form-group col-6">
                                                <label class="text-muted" for="exampleInputEmail1">Hệ Phái</label>
                                                <select placeholder="Chọn trang bị" multiple class="chosen form-control form-control-sm" name="characters[]">
                                                    @foreach($characters as $character)
                                                        <option value="{{ $character->id }}">{{ $character->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group col-6">
                                                <label class="text-muted" for="exampleInputEmail1">Bộ Trang Bị</label>
                                                <select placeholder="Chọn trang bị" class="chosen form-control form-control-sm" name="cate_gear_id">
                                                    @foreach($cateGears as $cate)
                                                        <option value="{{ $cate->id }}">{{ $cate->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group col-6">
                                                <label class="text-muted" for="exampleInputEmail1">Sức Mạnh</label>
                                                <input type="number" value="" class="form-control" name="strength" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="">
                                            </div>
                                            <div class="form-group col-6">
                                                <label class="text-muted" for="exampleInputEmail1">Trí Tuệ</label>
                                                <input type="number" value="" class="form-control" name="intelligent" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="">
                                            </div>
                                            <div class="form-group col-6">
                                                <label class="text-muted" for="exampleInputEmail1">Nhanh Nhẹn</label>
                                                <input type="number" value="" class="form-control" name="agility" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="">
                                            </div>
                                            <div class="form-group col-6">
                                                <label class="text-muted" for="exampleInputEmail1">May Mắn</label>
                                                <input type="number" value="" class="form-control" name="lucky" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="">
                                            </div>
                                            <div class="form-group col-6">
                                                <label class="text-muted" for="exampleInputEmail1">Sinh Lực</label>
                                                <input type="number" value="" class="form-control" name="health_points" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="">
                                            </div>
                                            <div class="form-group col-6">
                                                <label class="text-muted" for="exampleInputEmail1">Kháng Công</label>
                                                <input type="number" value="" class="form-control" name="armor_strength" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="">
                                            </div>
                                            <div class="form-group col-6">
                                                <label class="text-muted" for="exampleInputEmail1">Kháng Phép</label>
                                                <input type="number" value="" class="form-control" name="armor_intelligent" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="">
                                            </div>
                                            <div class="form-group col-6">
                                                <label class="text-muted" for="exampleInputEmail1">RGB</label>
                                                <input type="text" value="" v-model="rgb" class="form-control" name="rgb" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="">
                                            </div>
                                            <div class="form-group col-6">
                                                <label class="text-muted" for="exampleInputEmail1">Cấp Độ Yêu Cầu</label>
                                                <input type="number" value="" class="form-control" name="level_required" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="">
                                            </div>
                                            <div class="form-group col-6">
                                                <label class="text-muted" for="exampleInputEmail1">Giá</label>
                                                <input type="number" value="" class="form-control" name="price" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="">
                                            </div>
                                            <div class="form-group col-6">
                                                <label class="text-muted" for="exampleInputEmail1">ĐVTT</label>
                                                <select placeholder="Chọn trang bị" class="chosen form-control form-control-sm" name="price_type">
                                                    <option value="0">Vàng</option>
                                                    <option value="1">KC</option>
                                                </select>
                                            </div>
                                            <div class="form-group col-6">
                                                <label class="text-muted" for="exampleInputEmail1">Trạng Thái</label>
                                                <select placeholder="Chọn trang bị" class="chosen form-control form-control-sm" name="status">
                                                    <option value="0">Ẩn</option>
                                                    <option selected value="1">Hiện</option>
                                                </select>
                                            </div>
                                            <div class="form-group col-6">
                                                <label class="text-muted" for="exampleInputEmail1">Mô Tả</label>
                                                <textarea rows="1" class="form-control" name="description"></textarea>
                                            </div>
                                            <div class="form-group col-12">
                                                <button type="submit" class="btn btn-success">Thêm</button>
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
<script src="{{ asset('assets/js/plugins/datatable/datatable.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins/datatable/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins/chosen/chosen.jquery.js') }}"></script>
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