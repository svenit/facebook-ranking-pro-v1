@extends('app')
@section('content')

@section('hero','Giải Trí')
@section('sub_hero','Quản lý giải trí & sự kiện')

<div id="content" class="flex">
    <div id="ranking" class="">
        <div class="page-content page-container" id="page-content">
            <div class="padding-x">
                <div class="col-12 vip-bordered">
                    <div class="b-b">
                        <div class="nav-active-border b-primary bottom">
                            <ul class="nav" id="myTab" role="tablist">
                                <li class="nav-item"><a class="nav-link active" id="index-tab" data-toggle="tab" href="#home-index" role="tab" aria-controls="home-index" aria-selected="true">Danh Sách</a></li>
                                <li class="nav-item"><a class="nav-link" id="own-tab" data-toggle="tab" href="#home-own" role="tab" aria-controls="home-own" aria-selected="false">Log</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="tab-content p-3">
                        <div class="tab-pane fade show active" id="home-index" role="tabpanel" aria-labelledby="index-tab">
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
                                            <div class="th-inner text-gold sortable both">Giá Trị</div>
                                        </th>
                                        <th style="" data-field="owner">
                                            <div class="th-inner text-gold sortable both">Kiểu</div>
                                        </th>
                                        <th style="" data-field="owner">
                                            <div class="th-inner text-gold sortable both">Xác Suất</div>
                                        </th>
                                        <th style="width:100px" data-field="task">
                                            <div class="th-inner text-gold"><span class="d-none d-sm-block">Hành Động</span>
                                            </div>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($gifts as $key => $gift)
                                        <tr>
                                            <td>
                                                <div class="checkbox">
                                                    <label class="ui-check ui-check-md">
                                                        <input value="{{ $gift->id }}" type="checkbox" v-model="selected"> 
                                                        <i class="dark-white"></i>
                                                    </label>
                                                </div>
                                            </td>
                                            <td style=""><small class="text-muted">{{ $key + 1 }}</small></td>
                                            <td style=""><small class="text-muted">{{ $gift->value }}</small></td>
                                            <td style=""><small class="text-muted">{{ $gift->type }}</small></td>
                                            <td style=""><small class="text-muted">{{ $gift->probability }}</small></td>
                                            <td class="flex" style="">
                                                <div class="dropdown mb-2"><button class="btn btn-white dropdown-toggle" data-toggle="dropdown"
                                                    aria-expanded="false">Hành Động</button>
                                                    <div class="dropdown-menu bg-dark" role="menu" x-placement="bottom-start"
                                                        style="position: absolute; transform: translate3d(0px, 34px, 0px); top: 0px; left: 0px; will-change: transform;">
                                                        <a href="{{ Route('admin.events.edit',['id' => $gift->id]) }}" class="dropdown-item">Xem & Sửa</a>
                                                        <a onclick="return confirm('Sao chép ?')" href="{{ Route('admin.events.replicate',['id' => $gift->id]) }}" class="dropdown-item">Sao Chép</a>
                                                        <a onclick="return confirm('Xóa ?')" href="{{ Route('admin.events.delete',['id' => $gift->id]) }}" class="dropdown-item">Xóa</a>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <form id="form" class="form" action="{{ Route('admin.events.delete-multi') }}" method="POST">
                                @csrf
                                <input style="display:none" v-model="selected" type="text" name="selected[]">
                            </form>
                        </div>
                        <div class="tab-pane fade" id="home-own" role="tabpanel" aria-labelledby="own-tab">
                            <table id="myTable" class="table table-striped">
                                <thead>
                                    <tr>
                                        <th style="" data-field="owner">
                                            <div class="th-inner text-gold sortable both">#</div>
                                        </th>
                                        <th style="" data-field="owner">
                                            <div class="th-inner text-gold sortable both">File</div>
                                        </th>
                                        <th style="" data-field="owner">
                                            <div class="th-inner text-gold sortable both">Log</div>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($logs as $key => $log)
                                        <tr>
                                            <td style=""><small class="text-muted">{{ $key + 1 }}</small></td>
                                            <td style=""><small class="text-muted">{{ $log['file'] }}</small></td>
                                            <td style="">
                                                <small class="text-muted">
                                                    @foreach($log['data'] as $data)
                                                    <p>{{ $data }}</p>
                                                    @endforeach
                                                </small>
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