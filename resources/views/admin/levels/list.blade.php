@extends('app')
@section('content')

@section('hero','Cấp Độ')
@section('sub_hero','Quản lý cấp độ')

<div id="content" class="flex">
    <div id="ranking" class="">
        <div class="page-content page-container" id="page-content">
            <div class="padding-x">
                <div class="col-12 vip-bordered">
                    <div class="b-b">
                        <div class="nav-active-border b-primary bottom">
                            <ul class="nav" id="myTab" role="tablist">
                                <li class="nav-item"><a class="nav-link active" id="index-tab" data-toggle="tab" href="#home-index" role="tab" aria-controls="home-index" aria-selected="true">Danh Sách</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="tab-content p-3">
                        <div class="tab-pane fade show active" id="home-index" role="tabpanel" aria-labelledby="index-tab">
                            <form method="POST" action="{{ Route('admin.levels.store') }}" class="row">
                                @csrf
                                <div class="form-group col-6">
                                    <label class="text-muted" for="exampleInputEmail1">Level</label>
                                    <input type="number" value="{{ $levels->last()->level + 1 }}" class="form-control" name="level" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="">
                                </div>
                                <div class="form-group col-6">
                                    <label class="text-muted" for="exampleInputEmail1">EXP</label>
                                    <input type="number" value="{{ $levels->last()->exp_required * 1.3 }}" class="form-control" name="exp_required" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="">
                                </div>
                                <div class="form-group col-2">
                                    <button class="btn btn-success">Thêm</button>
                                </div>
                            </form>
                            <button v-if="selected.length > 0" form="form" type="submit" class="btn bg-danger-lt">Xóa ( @{{ selected.length }} )</button>
                            <table id="myTable" class="table table-striped">
                                <thead>
                                    <tr>
                                        <th style="" data-field="owner">
                                            <div class="th-inner text-gold sortable both">Chọn</div>
                                        </th>
                                        <th style="" data-field="owner">
                                            <div class="th-inner text-gold sortable both">#</div>
                                        </th>
                                        <th style="" data-field="owner">
                                            <div class="th-inner text-gold sortable both">Level</div>
                                        </th>
                                        <th data-field="project">
                                            <div class="th-inner text-gold sortable both">EXP</div>
                                        </th>
                                        <th style="width:100px" data-field="task">
                                            <div class="th-inner text-gold"><span class="d-none d-sm-block">Hành Động</span>
                                            </div>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($levels as $key => $level)
                                        <tr>
                                            <td>
                                                <div class="checkbox">
                                                    <label class="ui-check ui-check-md">
                                                        <input value="{{ $level->id }}" type="checkbox" v-model="selected"> 
                                                        <i class="dark-white"></i>
                                                    </label>
                                                </div>
                                            </td>
                                            <td style=""><small class="text-muted">{{ $key + 1 }}</small></td>
                                            <td style=""><small class="text-muted">{{ $level->level }}</small></td>
                                            <td style=""><small class="text-muted">{{ $level->exp_required }}</small></td>
                                            <td class="flex" style="">
                                                <div class="dropdown mb-2"><button class="btn btn-white dropdown-toggle" data-toggle="dropdown"
                                                    aria-expanded="false">Hành Động</button>
                                                    <div class="dropdown-menu bg-dark" role="menu" x-placement="bottom-start"
                                                        style="position: absolute; transform: translate3d(0px, 34px, 0px); top: 0px; left: 0px; will-change: transform;">
                                                        <a href="{{ Route('admin.levels.edit',['id' => $level->id]) }}" class="dropdown-item">Xem & Sửa</a>
                                                        <a onclick="return confirm('Xóa ?')" href="{{ Route('admin.levels.delete',['id' => $level->id]) }}" class="dropdown-item">Xóa</a>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <form id="form" class="form" action="{{ Route('admin.levels.delete-multi') }}" method="POST">
                                @csrf
                                <input style="display:none" v-model="selected" type="text" name="selected[]">
                            </form>
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