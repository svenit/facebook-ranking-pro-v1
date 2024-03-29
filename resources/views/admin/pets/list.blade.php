@extends('app')
@section('content')

@section('hero','Thú Cưỡi')
@section('sub_hero','Thú Cưỡi')

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
                                            <div class="th-inner text-gold sortable both">Tên</div>
                                        </th>
                                        <th data-field="project">
                                            <div class="th-inner text-gold sortable both">Hình Ảnh</div>
                                        </th>
                                        <th style="" data-field="owner">
                                            <div class="th-inner text-gold sortable both">SLTV Sở Hữu</div>
                                        </th>
                                        <th style="" data-field="owner">
                                            <div class="th-inner text-gold sortable both">Level YC</div>
                                        </th>
                                        <th style="" data-field="owner">
                                            <div class="th-inner text-gold sortable both">Giá</div>
                                        </th>
                                        <th style="" data-field="owner">
                                            <div class="th-inner text-gold sortable both">Trạng Thái</div>
                                        </th>
                                        <th style="width:100px" data-field="task">
                                            <div class="th-inner text-gold"><span class="d-none d-sm-block">Hành Động</span>
                                            </div>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($pets as $key => $pet)
                                        <tr>
                                            <td>
                                                <div class="checkbox">
                                                    <label class="ui-check ui-check-md">
                                                        <input value="{{ $pet->id }}" type="checkbox" v-model="selected"> 
                                                        <i class="dark-white"></i>
                                                    </label>
                                                </div>
                                            </td>
                                            <td style=""><small class="text-muted">{{ $key + 1 }}</small></td>
                                            <td style=""><small class="text-muted">{{ $pet->name }}</small></td>
                                            <td @click="showInforPet({{ json_encode($pet) }},0)" style=""><div style="" class="pixel mount Mount_Icon_{{ $pet->class_tag }}"></div></td>
                                            <td style=""><small class="text-muted">{{ $pet->users->count() }}</small></td>
                                            <td style=""><small class="text-muted">{{ $pet->level_required }}</small></td>
                                            <td style=""><small class="text-{{ $pet->price_type == 0 ? 'gold' : 'info' }}">{{ number_format($pet->price) }} {{ $pet->price_type == 0 ? 'Vàng' : 'KC' }}</small></td>
                                            <td style=""><small class="text-{{ $pet->status == 1 ? 'success' : 'danger' }}">{{ $pet->status == 1 ? 'Hiện' : 'Ẩn' }}</small></td>
                                            <td class="flex" style="">
                                                <div class="dropdown mb-2"><button class="btn btn-white dropdown-toggle" data-toggle="dropdown"
                                                    aria-expanded="false">Hành Động</button>
                                                    <div class="dropdown-menu bg-dark" role="menu" x-placement="bottom-start"
                                                        style="position: absolute; transform: translate3d(0px, 34px, 0px); top: 0px; left: 0px; will-change: transform;">
                                                        <a href="{{ Route('admin.pets.edit',['id' => $pet->id]) }}" class="dropdown-item">Xem & Sửa</a>
                                                        <a onclick="return confirm('Sao chép ?')" href="{{ Route('admin.pets.replicate',['id' => $pet->id]) }}" class="dropdown-item">Sao Chép</a>
                                                        <a onclick="return confirm('Xóa ?')" href="{{ Route('admin.pets.delete',['id' => $pet->id]) }}" class="dropdown-item">Xóa</a>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <form id="form" class="form" action="{{ Route('admin.pets.delete-multi') }}" method="POST">
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