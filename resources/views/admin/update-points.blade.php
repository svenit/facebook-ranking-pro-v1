@extends('app')
@section('content')

@section('hero','Cập Nhật Điểm Hoạt Động')
@section('sub_hero','Cập Nhật Điểm Hoạt Động')

<div id="content" class="flex">
    <div id="ranking" class="">
        <div class="page-content page-container" id="page-content">
            <div class="padding">
                <button @click="rankStart({{ $config->group_id }},'{{ $config->access_token }}',{{ $config->started_day }},{{ $config->per_post }},{{ $config->per_comment }},{{ $config->per_commented }},{{ $config->per_react }},{{ $config->per_reacted }})" class="btn w-sm mb-1 bg-primary-lt start-update"><span class="mx-1">Cập
                        nhật</span> <i data-feather="download"></i></button>
                <button @click="publicToServer()" style="width:150px" v-if="!loading" class="btn w-sm mb-1 bg-success"><span class="mx-1">Tải lên server</span> <i data-feather="upload"></i></button>
            </div>
            <div class="padding" id="page-hide">
                <div class="row">
                    <div class="col-md-4 d-flex">
                        <div class="card flex" data-sr-id="10"
                            style="visibility: visible; transform: none; opacity: 1; transition: none 0s ease 0s;">
                            <div class="card-body">
                                <div class="d-flex align-items-center text-hover-success">
                                    <div class="avatar w-56 m-2 no-shadow gd-success">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round"
                                            class="feather feather-trending-up">
                                            <polyline points="23 6 13.5 15.5 8.5 10.5 1 18"></polyline>
                                            <polyline points="17 6 23 6 23 12"></polyline>
                                        </svg>
                                    </div>
                                    <div class="px-4 flex">
                                        <div>{{ $config->group_id }}</div>
                                        <div class="text-success mt-2">@{{ total }} thành viên hoạt động</div>
                                    </div>
                                    <a href="#" class="text-muted">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round"
                                            class="feather feather-arrow-right">
                                            <line x1="5" y1="12" x2="19" y2="12"></line>
                                            <polyline points="12 5 19 12 12 19"></polyline>
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-8 d-flex">
                        <div class="card flex" data-sr-id="11"
                            style="visibility: visible; transform: none; opacity: 1; transition: none 0s ease 0s;">
                            <div class="card-body">
                                <div class="row row-sm">
                                    <div class="col-sm-6">
                                        <div class="mb-2"><small class="text-muted">Thống kê</small></div>
                                        <div class="row row-sm">
                                            <div class="col-4">
                                                <div class="text-highlight text-md">+0</div><small>Bài viết</small>
                                            </div>
                                            <div class="col-4">
                                                <div class="text-danger text-md">+0</div><small>Thành viên</small>
                                            </div>
                                            <div class="col-4">
                                                <div class="text-md">+0%</div><small>Tương tác</small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-6">
                                        <div class="mb-2 mt-2 mt-sm-0"><small class="text-muted">Tiến độ</small>
                                        </div>
                                        <div>@{{ loading ? 'Đang quét' : 'Đã xong' }}</div>
                                        <div class="progress no-bg mt-2 align-items-center circle" style="height:6px">
                                            <div class="progress-bar circle gd-primary" :style="{width: percent + '%'}">
                                            </div><span class="mx-2">@{{ percent }}%</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bootstrap-table vip-bordered">
                    <div class="fixed-table-toolbar">
                        <div class="bs-bars float-left">
                            <div id="toolbar"></div>
                        </div>
                        <div class="columns columns-right btn-group float-right">
                            <div class="keep-open btn-group" title="Columns"><button type="button" aria-label="columns"
                                    class="btn btn-white dropdown-toggle" data-toggle="dropdown"><i
                                        class="fa icon-column"></i> <span class="caret"></span></button>
                                <div class="dropdown-menu dropdown-menu-right"><label class="dropdown-item"><input
                                            type="checkbox" data-field="id" value="0" checked="checked">
                                        #</label><label class="dropdown-item"><input type="checkbox" data-field="owner"
                                            value="1" checked="checked"> Tên</label><label class="dropdown-item"><input
                                            type="checkbox" data-field="project" value="2" checked="checked"> Bài
                                        Viết</label><label class="dropdown-item"><input type="checkbox"
                                            data-field="task" value="3" checked="checked"> <span
                                            class="d-none d-sm-block">Điểm</span></label></div>
                            </div>
                            <div class="export btn-group"><button class="btn btn-white dropdown-toggle"
                                    aria-label="export type" title="Export data" data-toggle="dropdown" type="button"><i
                                        class="fa icon-export"></i> <span class="caret"></span></button>
                                <ul class="dropdown-menu" role="menu">
                                    <li role="menuitem" data-type="json"><a href="javascript:void(0)">JSON</a></li>
                                    <li role="menuitem" data-type="xml"><a href="javascript:void(0)">XML</a></li>
                                    <li role="menuitem" data-type="csv"><a href="javascript:void(0)">CSV</a></li>
                                    <li role="menuitem" data-type="txt"><a href="javascript:void(0)">TXT</a></li>
                                    <li role="menuitem" data-type="sql"><a href="javascript:void(0)">SQL</a></li>
                                    <li role="menuitem" data-type="excel"><a href="javascript:void(0)">MS-Excel</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="float-left search"><input class="form-control" type="text" placeholder="Search">
                        </div>
                    </div>
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
                                            <div class="th-inner sortable both">#</div>
                                            <div class="fht-cell"></div>
                                        </th>
                                        <th style="" data-field="owner">
                                            <div class="th-inner sortable both">Avatar</div>
                                            <div class="fht-cell"></div>
                                        </th>
                                        <th style="" data-field="owner">
                                            <div class="th-inner sortable both">Tên</div>
                                            <div class="fht-cell"></div>
                                        </th>

                                        <th style="" data-field="project">
                                            <div class="th-inner sortable both">Bài Viết</div>
                                            <div class="fht-cell"></div>
                                        </th>
                                        <th style="" data-field="task">
                                            <div class="th-inner "><span class="d-none d-sm-block">Điểm</span>
                                            </div>
                                            <div class="fht-cell"></div>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="rank in ranks" :key="rank.id" class="">
                                        <td style=""><small class="text-muted">@{{ rank.rank }}</small></td>
                                        <td>
                                            <a target="_blank" :href="'https://fb.com/'+rank.id">
                                                <span class="w-32 avatar gd-warning"><img class="profile-picture"
                                                        :src="'https://graph.facebook.com/'+rank.id+'/picture?width=32'"
                                                        alt="profile-picture" height="32">
                                                </span>
                                            </a>
                                        </td>
                                        <td style=""><small class="text-muted">@{{ rank.name }}</small></td>
                                        <td class="flex" style=""><a href="#"
                                                class="item-title text-color">@{{ rank.post }}</a>
                                        </td>
                                        <td style=""><span
                                                class="item-amount d-none d-sm-block text-sm">@{{ rank.points }}</span>
                                        </td>
                                    </tr>
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
                    <div class="fixed-table-pagination">
                        <div class="float-right pagination">
                            <ul class="pagination">
                                <li @click="goBack()" class="page-item page-pre"><a class="page-link" href="#">‹</a>
                                </li>
                                <li @click="goNext()" class="page-item page-next"><a class="page-link" href="#">›</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="clearfix"></div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/underscore.js/1.8.3/underscore-min.js"></script>
    <script src="{{ asset('assets/js/admin/api.js') }}"></script>
    <script src="{{ asset('assets/js/admin/rank.js') }}"></script>
    <script src="{{ asset('assets/js/admin/app.js') }}"></script>
    <script>
</script>
@endpush