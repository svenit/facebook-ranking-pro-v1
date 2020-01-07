@extends('app')
@section('content')

@section('hero','Danh Mục Trang Bị')
@section('sub_hero','Danh Mục Trang Bị')

<div id="content" class="flex">
    <div id="ranking" class="">
        <div class="page-content page-container" id="page-content">
            <div class="padding-x">
                <div class="col-12 vip-bordered">
                    <div class="card">
                        <div class="card-body">
                            <form method="POST" action="{{ Route('admin.cate-gears.store') }}" class="row">
                                @csrf
                                <div class="form-group col-6">
                                    <label class="text-muted" for="exampleInputEmail1">Tên Danh Mục</label>
                                    <input type="text" value="" class="form-control" name="name" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="">
                                </div>
                                <div class="col-12"></div>
                                <div class="form-group col-6">
                                    <label class="text-muted" for="exampleInputEmail1">Mô Tả</label>
                                    <textarea class="form-control" name="description" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder=""></textarea>
                                </div>
                                <div class="form-group col-12">
                                    <button type="submit" class="btn btn-success">Thêm</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div>
                        <table id="myTable" class="table table-theme v-middle table-hover" data-toolbar="#toolbar"
                            data-search="true" data-search-align="left" data-show-export="true"
                            data-show-columns="true" data-detail-view="false" data-mobile-responsive="true"
                            data-pagination="true" data-page-list="[10, 25, 50, 100, ALL]">
                            <thead>
                                <tr>
                                    <th style="" data-field="owner">
                                        <div class="th-inner text-gold sortable both">#</div>
                                    </th>
                                    <th style="" data-field="owner">
                                        <div class="th-inner text-gold sortable both">Tên</div>
                                    </th>
                                    <th data-field="project">
                                        <div class="th-inner text-gold sortable both">Mô Tả</div>
                                    </th>
                                    <th style="" data-field="owner">
                                        <div class="th-inner text-gold sortable both">SLVP</div>
                                    </th>
                                    <th style="" data-field="task">
                                        <div class="th-inner text-gold"><span class="d-none d-sm-block">Hành Động</span>
                                        </div>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($cates as $key => $cate)
                                    <tr>
                                        <td style=""><small class="text-muted">{{ $key + 1 }}</small></td>
                                        <td style=""><small class="text-muted">{{ $cate->name }}</small></td>
                                        <td style=""><small class="text-muted">{{ $cate->description }}</small></td>
                                        <td style=""><small class="text-muted">{{ $cate->gears->count() }}</small></td>
                                        <td class="flex" style="">
                                            <div class="dropdown mb-2"><button class="btn btn-white dropdown-toggle" data-toggle="dropdown"
                                                aria-expanded="false">Hành Động</button>
                                                <div class="dropdown-menu bg-dark" role="menu" x-placement="bottom-start"
                                                    style="position: absolute; transform: translate3d(0px, 34px, 0px); top: 0px; left: 0px; will-change: transform;">
                                                    <a href="#" class="dropdown-item">Xóa</a>
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
@endsection
@push('js')
<script src="{{ asset('assets/js/plugins/datatable/datatable.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins/datatable/dataTables.bootstrap4.min.js') }}"></script>
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
    });
</script>
@endpush