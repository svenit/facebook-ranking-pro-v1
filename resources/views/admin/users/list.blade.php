@extends('app')
@section('content')

@section('hero','Thành Viên')
@section('sub_hero','Danh sách thành viên')
<div class="page-content page-container" style="margin-bottom:400px" id="page-content">
    <div class="padding-x">
        <div class="col-12 vip-bordered user-list">
            <form action="" method="GET">
                <input name="search" placeholder="Tìm kiếm" type="text" class="form-control">
            </form>
            <table id="myTable" class="table table-striped">
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
                                        <a href="{{ $user->status == 1 ? Route('admin.users.lock',['id' => $user->id]) : Route('admin.users.unlock',['id' => $user->id])  }}" class="dropdown-item">{{ $user->status == 0 ? 'Mở Khóa' : 'Khóa' }}</a>
                                        <a onclick="return confirm('Xóa tài khoản này ?')" href="{{ Route('admin.users.delete',['id' => $user->id]) }}" class="dropdown-item">Xóa</a>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $users->appends(request()->query())->links() }}
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
@endpush