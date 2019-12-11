@extends('app')
@section('content')

@section('hero','Top Lực Chiến')
@section('sub_hero','Top lực chiến toàn server ')
<button style="display:none" id="show-infor-user" data-toggle="modal" data-target=".modal-right" data-toggle-class="modal-open-aside" data-target="body"></button>
<div class="page-content page-container" style="margin-bottom:400px" id="page-content">
    <div class="padding-x">
        @include('user.theme.parameter')
        <div class="row row-sm sr">
            <div class="col-md-12 col-lg-12">
                <div class="bootstrap-table vip-bordered">
                    <div class="fixed-table-container" style="padding-bottom: 0px;">
                        <div class="fixed-table-header" style="display: none;">
                            <table></table>
                        </div>
                        <div class="fixed-table-body">
                            <div class="fixed-table-loading" style="top: 41px;">Loading, please wait...</div>
                            <table id="table" class="table table-theme v-middle table-hover" data-toolbar="#toolbar"
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
                                            <div class="th-inner text-gold"><span class="d-none d-sm-block">Lực Chiến</span>
                                            </div>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($ranks as $key => $rank)
                                        <tr onclick="showInfor({{ $rank->id }})" class="{{ Auth::check() && Auth::id() == $rank->id ? 'bg-secondary' : '' }}">
                                            <td style=""><small class="text-muted">{{ $key + 1 }}</small></td>
                                            <td>
                                                <a target="_blank" href="https://fb.com/{{ $rank->user_id }}">
                                                    <span style="width:50px" class="avatar">
                                                        <span class="avatar-status {{ $rank->isOnline() ? 'on' : 'off' }} b-white avatar-right"></span>
                                                        <img class="profile-picture"
                                                            src="https://graph.facebook.com/{{ $rank->user_id }}/picture"
                                                            alt="profile-picture" height="50">
                                                    </span>
                                                </a>
                                            </td>
                                            <td style=""><small class="text-gold">{{ $rank->name }}</small></td>
                                            <td style=""><span
                                                class="item-amount d-none d-sm-block text-sm text-info">{{ $rank->character->name }}</span>
                                            </td>
                                            <td class="flex" style=""><a href="#"
                                                class="item-title d-none d-sm-block text-color text-danger">{{ number_format($rank->fullPower($rank->id)) }}</a>
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
                {{ $ranks->onEachSide(1)->links() }}
            </div>
        </div>
    </div>
</div>
</div>
@endsection

@push('js')
<script>
    function showInfor(id)
    {
        return app.showUserInfor(id);
    }
</script>
@endpush