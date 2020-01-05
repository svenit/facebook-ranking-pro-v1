@extends('app')
@section('content')

@section('hero','Thành Viên')
@section('sub_hero','Danh sách thành viên')
<div class="page-content page-container" style="margin-bottom:400px" id="page-content">
    <div class="padding-x">
        <div class="row row-sm sr">
            <div class="col-md-12 col-lg-12">
                <div class="bootstrap-table vip-bordered">
                    <div class="fixed-table-container" style="padding-bottom: 0px;">
                        <div class="fixed-table-header" style="display: none;">
                            <table></table>
                        </div>
                        <div class="fixed-table-body">
                            <div class="fixed-table-loading" style="top: 41px;">Loading, please wait...</div>
                            <table id="myTable" class="table table-theme v-middle table-hover" data-toolbar="#toolbar"
                                data-search="true" data-search-align="left" data-show-export="true"
                                data-show-columns="true" data-detail-view="false" data-mobile-responsive="true"
                                data-pagination="true" data-page-list="[10, 25, 50, 100, ALL]">
                                <thead>
                                    <tr>
                                        <th style="" data-field="id">
                                            <div class="th-inner text-gold sortable both">#</div>
                                        </th>
                                        <th style="" data-field="owner">
                                            <div class="th-inner text-gold sortable both">Avatar</div>
                                        </th>
                                        <th style="" data-field="owner">
                                            <div class="th-inner text-gold sortable both">Tên</div>
                                        </th>

                                        <th style="" data-field="project">
                                            <div class="th-inner text-gold sortable both"><span class="d-none d-sm-block">Hệ Phái</span></div>
                                        </th>
                                        <th style="" data-field="task">
                                            <div class="th-inner text-gold"><span class="d-none d-sm-block">Vàng</span>
                                            </div>
                                        </th>
                                        <th style="" data-field="task">
                                            <div class="th-inner text-gold"><span class="d-none d-sm-block">Xác Thực</span>
                                            </div>
                                        </th>
                                        <th style="" data-field="task">
                                            <div class="th-inner text-gold"><span class="d-none d-sm-block">Trạng Thái</span>
                                            </div>
                                        </th>
                                        <th style="" data-field="task">
                                            <div class="th-inner text-gold"><span class="d-none d-sm-block">Hành Động</span>
                                            </div>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($users as $key => $user)
                                        <tr class="{{ Auth::check() && Auth::id() == $user->id ? 'bg-secondary' : '' }}">
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
                                            <td style=""><small class="text-gold">{{ $user->name }}</small></td>
                                            <td style=""><span
                                                class="item-amount d-none d-sm-block text-sm text-info">{{ $user->character->name }}</span>
                                            </td>
                                            <td class="flex" style=""><a href="#"
                                                class="item-title d-none d-sm-block text-color text-warning">{{ number_format($user->getCoins()) }}</a>
                                            </td>
                                            <td class="flex" style=""><a href="#"
                                                class="item-title d-none d-sm-block text-color {{ $user->provider_id ? 'text-success' : 'text-danger' }}">{{ $user->provider_id ? 'OK' : 'Chưa' }}</a>
                                            </td>
                                            <td class="flex" style=""><a href="#"
                                                class="item-title d-none d-sm-block text-color {{ $user->status == 1 ? 'text-success' : 'text-danger' }}">{{ $user->status == 1 ? 'Hoạt Động' : 'Đã Khóa' }}</a>
                                            </td>
                                            <td class="flex" style="">
                                                <div class="dropdown mb-2"><button class="btn btn-white dropdown-toggle" data-toggle="dropdown"
                                                    aria-expanded="false">Hành Động</button>
                                                    <div class="dropdown-menu bg-dark" role="menu" x-placement="bottom-start"
                                                        style="position: absolute; transform: translate3d(0px, 34px, 0px); top: 0px; left: 0px; will-change: transform;">
                                                        <a href="{{ Route('admin.users.detail',['id' => $user->id]) }}" class="dropdown-item">Xem Chi Tiết</a>
                                                        <a href="#" class="dropdown-item">{{ $user->status == 0 ? 'Mở Khóa' : 'Khóa' }}</a>
                                                        <a href="#" class="dropdown-item">Xóa</a>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="fixed-table-footer" style="display: none;">
                            <table>
                                <tbody>
                                    <tr></tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                <div class="clearfix"></div>
            </div>
        </div>
    </div>
</div>
</div>
@endsection
@push('css')
<style>
    .form-control
    {
        margin: 10px !important;
        background-color: #282c3a !important;
    }
</style>
@endpush
@push('js')
<script src="{{ asset('assets/js/plugins/datatable/datatable.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins/datatable/dataTables.bootstrap4.min') }}"></script>
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