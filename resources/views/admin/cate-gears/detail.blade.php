@extends('app')
@section('content')

@section('hero',$detail->name)
@section('sub_hero','Danh Mục Trang Bị')

<div id="content" class="flex">
    <div id="ranking" class="">
        <div class="page-content page-container" id="page-content">
            <div class="padding-x">
                <div class="col-12 vip-bordered">
                    <div>
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
                                    <th style="" data-field="owner">
                                        <div class="th-inner text-gold sortable both">Hệ Phái</div>
                                    </th>
                                    <th style="" data-field="owner">
                                        <div class="th-inner text-gold sortable both">Mô Tả</div>
                                    </th>
                                    <th style="width:100px" data-field="task">
                                        <div class="th-inner text-gold"><span class="d-none d-sm-block">Hành Động</span>
                                        </div>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($detail->gears as $key => $item)
                                    <tr>
                                        <td style=""><small class="text-muted">{{ $key + 1 }}</small></td>
                                        <td style=""><small class="text-muted">{{ $item->name }}</small></td>
                                        <td @click="showGearsDescription({{ json_encode($gear) }},0)" style="">
                                            <small class="text-muted">
                                                <div class="pixel {{ $item->shop_tag }}"></div>
                                            </small>
                                        </td>
                                        <td style=""><small class="text-muted">{{ $item->character->name }}</small></td>
                                        <td style=""><small class="text-muted">{{ $item->description }}</small></td>
                                        <td class="flex" style="">
                                            <div class="dropdown mb-2"><button class="btn btn-white dropdown-toggle" data-toggle="dropdown"
                                                aria-expanded="false">Hành Động</button>
                                                <div class="dropdown-menu bg-dark" role="menu" x-placement="bottom-start"
                                                    style="position: absolute; transform: translate3d(0px, 34px, 0px); top: 0px; left: 0px; will-change: transform;">
                                                    <a href="#" class="dropdown-item">Xem</a>
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
    });
</script>
@endpush