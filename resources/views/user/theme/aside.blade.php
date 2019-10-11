@auth
<div id="modal-left" class="modal fade" data-backdrop="true">
    <div style="overflow:auto" class="modal-dialog modal-left w-xl">
        <div style="min-height:100vh;background:#111 !important" class="modal-content vip-bordered no-radius">
            <div class="modal-header">
                <button class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="p-4 text-center">
                    <img width="80%" src="{{ $user->character()->avatar }}">
                    <p>{{ $user->character()->name }}</p>
                </div>
                <div class="row row-sm">
                    <div class="col-12 d-flex">
                        <div class="flex">
                                <div class="text-info">
                                <div class="progress my-3 circle" style="height:6px">
                                    <div  class="progress-bar circle gd-info"
                                        data-toggle="tooltip" title="Kinh nghiệm" style="width: 63.9%">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 d-flex">
                        <div class="flex">
                            <div class="text-light"><small><i class="fas fa-angle-up"></i> Level <strong
                                        class="text-light">{{ 65 }}</strong></small>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 d-flex">
                        <div class="flex">
                            <div class="text-info"><small><i class="fas fa-heart"></i> Sinh Lực <strong
                                        class="text-info">{{ $user->totalNumeral('health_points') }}</strong></small>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 d-flex mt-2">
                        <div class="flex">
                            <div class="text-danger"><small><i class="fas fa-swords"></i> Sát Thương <strong
                                        class="text-danger">{{ $user->totalNumeral('strength') }}</strong></small>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 d-flex mt-2">
                        <div class="flex">
                            <div class="text-success"><small><i class="fas fa-brain"></i> Trí Tuệ <strong
                                        class="text-success">{{ $user->totalNumeral('intelligent') }}</strong></small>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 d-flex mt-2">
                        <div class="flex">
                            <div class="text-primary"><small><i class="fas fa-bolt"></i> Nhanh Nhẹn <strong
                                        class="text-primary">{{ $user->totalNumeral('agility') }}</strong></small>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 d-flex mt-2">
                        <div class="flex">
                            <div class="text-warning"><small><i class="fas fa-stars"></i> May Mắn <strong
                                        class="text-warning">{{ $user->totalNumeral('lucky') }}</strong></small>
                            </div>
                        </div>
                    </div>
                </div>
                <br>
                
                <div class="row row-sm">
                    @foreach($user->skills() as $skill)
                        <div style="margin-bottom:15px" class="col-3 d-flex">
                            <div class="flex">
                                <img data-toggle="tooltip" title="{{ $skill->description }}" style="border-radius:5px;width:100%" src="{{ $skill->image }}">
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-dark">Kĩ Năng</button>
                <button type="button" class="btn btn-dark">Túi Đồ</button>
            </div>
        </div>
    </div>
</div>
@endauth
<div id="aside-left" class="page-sidenav no-shrink bg-light nav-dropdown fade" aria-hidden="true">
    <div class="sidenav h-100 modal-dialog bg-light normal-bordered">
        <div class="navbar"><a href="index.html" class="navbar-brand"><svg width="32" height="32"
                    viewBox="0 0 512 512" xmlns="http://www.w3.org/2000/svg" fill="currentColor">
                    <g class="loading-spin" style="transform-origin: 256px 256px">
                        <path
                            d="M200.043 106.067c-40.631 15.171-73.434 46.382-90.717 85.933H256l-55.957-85.933zM412.797 288A160.723 160.723 0 0 0 416 256c0-36.624-12.314-70.367-33.016-97.334L311 288h101.797zM359.973 134.395C332.007 110.461 295.694 96 256 96c-7.966 0-15.794.591-23.448 1.715L310.852 224l49.121-89.605zM99.204 224A160.65 160.65 0 0 0 96 256c0 36.639 12.324 70.394 33.041 97.366L201 224H99.204zM311.959 405.932c40.631-15.171 73.433-46.382 90.715-85.932H256l55.959 85.932zM152.046 377.621C180.009 401.545 216.314 416 256 416c7.969 0 15.799-.592 23.456-1.716L201.164 288l-49.118 89.621z">
                        </path>
                    </g>
                </svg> <span class="hidden-folded d-inline l-s-n-1x">Game</span></a></div>
        <div class="flex scrollable hover">
            <div class="nav-active-text-primary" data-nav>
                <ul class="nav bg">
                    <li class="nav-header hidden-folded"><span class="text-muted">Trang Chủ</span></li>
                    <li><a href="{{ Route('user.index') }}"><span class="nav-icon"><i
                                    data-feather="home"></i></span> <span class="nav-text">Trang Chủ</span></a></li>
                </ul>
                <ul class="nav">
                    <li class="nav-header hidden-folded"><span class="text-muted">Hoạt Động</span></li>
                    <li><a href="#" class=""><span class="nav-icon"><i data-feather="award"></i></span> <span
                        class="nav-text">BXH</span> <span class="nav-caret"></span></a>
                        <ul class="nav-sub nav-mega">
                            <li><a href="ui.alert.html" class=""><span class="nav-text">Đại Gia</span></a></li>
                            <li><a href="ui.badge.html" class=""><span class="nav-text">Hoạt Động</span></a></li>
                        </ul>
                    </li>
                    <li><a href="#" class=""><span class="nav-icon"><i data-feather="calendar"></i></span> <span
                                class="nav-text">Sự Kiện</span> <span class="nav-caret"></span></a>
                        <ul class="nav-sub nav-mega">
                            <li><a href="{{ Route('user.events.wheel') }}" class=""><span class="nav-text">VQMM</span></a></li>
                            <li><a href="ui.badge.html" class=""><span class="nav-text">Kho Báu</span></a></li>
                        </ul>
                    </li>
                    <li><a href="#" class=""><span class="nav-icon"><i data-feather="activity"></i></span> <span
                        class="nav-text">Khám Phá</span> <span class="nav-caret"></span></a>
                        <ul class="nav-sub nav-mega">
                            <li><a href="ui.alert.html" class=""><span class="nav-text">Khu Tập Luyện</span></a></li>
                            <li><a href="ui.badge.html" class=""><span class="nav-text">Trường Học</span></a></li>
                            <li><a href="ui.badge.html" class=""><span class="nav-text">Nhiệm Vụ</span></a></li>
                            <li><a href="ui.badge.html" class=""><span class="nav-text">Phòng Hồi Phục</span></a></li>
                        </ul>
                    </li>
                    <li><a href="#" class=""><span class="nav-icon"><i data-feather="shopping-cart"></i></span> <span
                        class="nav-text">Cửa Hàng</span> <span class="nav-caret"></span></a>
                        <ul class="nav-sub nav-mega">
                            <li><a href="ui.alert.html" class=""><span class="nav-text">Vũ Khí</span></a></li>
                            <li><a href="ui.badge.html" class=""><span class="nav-text">Mũ</span></a></li>
                            <li><a href="ui.badge.html" class=""><span class="nav-text">Áo Giáp</span></a></li>
                            <li><a href="ui.badge.html" class=""><span class="nav-text">Quần</span></a></li>
                            <li><a href="ui.badge.html" class=""><span class="nav-text">Giày</span></a></li>
                            <li><a href="ui.badge.html" class=""><span class="nav-text">Trang Sức</span></a></li>
                            <li><a href="ui.badge.html" class=""><span class="nav-text">Thần Thú</span></a></li>
                        </ul>
                    </li>
                    <li><a href="#" class=""><span class="nav-icon"><i data-feather="zap"></i></span> <span
                        class="nav-text">Trinh Phạt</span> <span class="nav-caret"></span></a>
                        <ul class="nav-sub nav-mega">
                            <li><a href="ui.alert.html" class=""><span class="nav-text">Farm Quái</span></a></li>
                        </ul>
                    </li>
                    <li><a href="#" class=""><span class="nav-icon"><i data-feather="users"></i></span> <span
                        class="nav-text">Bang Hội</span> <span class="nav-caret"></span></a>
                        <ul class="nav-sub nav-mega">
                            <li><a href="ui.alert.html" class=""><span class="nav-text">Tạo</span></a></li>
                            <li><a href="ui.alert.html" class=""><span class="nav-text">Đại Sảnh</span></a></li>
                            <li><a href="ui.alert.html" class=""><span class="nav-text">Thành Viên</span></a></li>
                            <li><a href="ui.alert.html" class=""><span class="nav-text">Hoạt Động</span></a></li>
                            <li><a href="ui.alert.html" class=""><span class="nav-text">Khiêu Chiến</span></a></li>
                            <li><a href="ui.alert.html" class=""><span class="nav-text">Thiết Lập</span></a></li>
                        </ul>
                    </li>
                    <li><a href="#" class=""><span class="nav-icon"><i data-feather="shield"></i></span> <span
                        class="nav-text">PVP</span> <span class="nav-caret"></span></a>
                        <ul class="nav-sub nav-mega">
                            <li><a href="ui.alert.html" class=""><span class="nav-text">Khiêu Chiến</span></a></li>
                        </ul>
                    </li>
                    <li class="nav-header hidden-folded"><span class="text-muted">Admin Cpanel</span></li>
                    <li><a href="#" class=""><span class="nav-icon"><i data-feather="grid"></i></span> <span
                                class="nav-text">Admin</span> <span class="nav-caret"></span></a>
                        <ul class="nav-sub nav-mega">
                            <li><a href="{{ Route('admin.update-points') }}" class=""><span class="nav-text">Cập Nhật Điểm</span></a></li>
                            <li><a href="ui.badge.html" class=""><span class="nav-text">Badge</span></a></li>
                            <li><a href="ui.button.html" class=""><span class="nav-text">Button</span></a></li>
                            <li><a href="ui.card.html" class=""><span class="nav-text">Card</span></a></li>
                            <li><a href="ui.carousel.html" class=""><span class="nav-text">Carousel</span></a></li>
                            <li><a href="ui.color.html" class=""><span class="nav-text">Color</span></a></li>
                            <li><a href="ui.dropdown.html" class=""><span class="nav-text">Dropdown</span></a></li>
                            <li><a href="ui.grid.html" class=""><span class="nav-text">Grid</span></a></li>
                            <li><a href="ui.icon.html" class=""><span class="nav-text">Icon</span></a></li>
                            <li><a href="ui.list.html" class=""><span class="nav-text">List</span></a></li>
                            <li><a href="ui.modal.html" class=""><span class="nav-text">Modal</span></a></li>
                            <li><a href="ui.navbar.html" class=""><span class="nav-text">Navbar</span></a></li>
                            <li><a href="ui.sidenav.html" class=""><span class="nav-text">Sidenav</span></a></li>
                            <li><a href="ui.timeline.html" class=""><span class="nav-text">Timeline</span></a></li>
                            <li><a href="ui.tab.html" class=""><span class="nav-text">Tab &amp; Collpase</span></a>
                            </li>
                            <li><a href="ui.tooltip.html" class=""><span class="nav-text">Tooltip &amp;
                                        Popover</span></a></li>
                        </ul>
                    </li>
                    <li class="nav-header hidden-folded"><span class="text-muted">UI elements</span></li>
                    <li><a href="#" class=""><span class="nav-icon"><i data-feather="grid"></i></span> <span
                                class="nav-text">Components</span> <span class="nav-caret"></span></a>
                        <ul class="nav-sub nav-mega">
                            <li><a href="ui.alert.html" class=""><span class="nav-text">Xin chào</span></a></li>
                            <li><a href="ui.badge.html" class=""><span class="nav-text">Badge</span></a></li>
                            <li><a href="ui.button.html" class=""><span class="nav-text">Button</span></a></li>
                            <li><a href="ui.card.html" class=""><span class="nav-text">Card</span></a></li>
                            <li><a href="ui.carousel.html" class=""><span class="nav-text">Carousel</span></a></li>
                            <li><a href="ui.color.html" class=""><span class="nav-text">Color</span></a></li>
                            <li><a href="ui.dropdown.html" class=""><span class="nav-text">Dropdown</span></a></li>
                            <li><a href="ui.grid.html" class=""><span class="nav-text">Grid</span></a></li>
                            <li><a href="ui.icon.html" class=""><span class="nav-text">Icon</span></a></li>
                            <li><a href="ui.list.html" class=""><span class="nav-text">List</span></a></li>
                            <li><a href="ui.modal.html" class=""><span class="nav-text">Modal</span></a></li>
                            <li><a href="ui.navbar.html" class=""><span class="nav-text">Navbar</span></a></li>
                            <li><a href="ui.sidenav.html" class=""><span class="nav-text">Sidenav</span></a></li>
                            <li><a href="ui.timeline.html" class=""><span class="nav-text">Timeline</span></a></li>
                            <li><a href="ui.tab.html" class=""><span class="nav-text">Tab &amp; Collpase</span></a>
                            </li>
                            <li><a href="ui.tooltip.html" class=""><span class="nav-text">Tooltip &amp;
                                        Popover</span></a></li>
                        </ul>
                    </li>
                    <li><a href="#" class=""><span class="nav-icon"><i data-feather="box"></i></span> <span
                                class="nav-text">Plugins</span> <span class="nav-caret"></span></a>
                        <ul class="nav-sub nav-mega">
                            <li><a href="ui.scroll.html" class=""><span class="nav-text">Infinite Scroll</span></a>
                            </li>
                            <li><a href="ui.sortable.html" class=""><span class="nav-text">Sortable</span></a></li>
                            <li><a href="ui.map.html" class=""><span class="nav-text">Vector Map</span></a></li>
                        </ul>
                    </li>
                    <li><a href="#" class=""><span class="nav-icon"><i data-feather="disc"></i></span> <span
                                class="nav-text">Form</span> <span class="nav-caret"></span></a>
                        <ul class="nav-sub nav-mega">
                            <li><a href="form.element.html" class=""><span class="nav-text">Form Element</span></a>
                            </li>
                            <li><a href="form.layout.html" class=""><span class="nav-text">Form Layout</span></a>
                            </li>
                            <li><a href="form.validation.html" class=""><span class="nav-text">Form
                                        Validation</span></a></li>
                            <li><a href="form.editor.html" class=""><span class="nav-text">Editor</span></a></li>
                            <li><a href="form.datepicker.html" class=""><span class="nav-text">Datepicker</span></a>
                            </li>
                            <li><a href="form.select.html" class=""><span class="nav-text">Select</span></a></li>
                            <li><a href="form.wizard.html" class=""><span class="nav-text">Wizard</span></a></li>
                            <li><a href="form.dropzone.html" class=""><span class="nav-text">File Upload</span></a>
                            </li>
                        </ul>
                    </li>
                    <li><a href="#" class=""><span class="nav-icon"><i data-feather="list"></i></span> <span
                                class="nav-text">Tables</span> <span class="nav-caret"></span></a>
                        <ul class="nav-sub nav-mega">
                            <li><a href="table.style.html" class=""><span class="nav-text">Style</span></a></li>
                            <li><a href="table.bootstrap.html" class=""><span class="nav-text">Bootstrap
                                        Table</span></a></li>
                            <li><a href="table.datatables.html" class=""><span
                                        class="nav-text">Datatables</span></a></li>
                        </ul>
                    </li>
                    <li><a href="#" class=""><span class="nav-icon"><i data-feather="pie-chart"></i></span> <span
                                class="nav-text">Charts</span> <span class="nav-caret"></span></a>
                        <ul class="nav-sub nav-mega">
                            <li><a href="chart.chartist.html" class=""><span class="nav-text">Chartist</span></a>
                            </li>
                            <li><a href="chart.chartjs.html" class=""><span class="nav-text">Chartjs</span></a></li>
                        </ul>
                    </li>
                    <li class="nav-header hidden-folded"><span class="text-muted">Extra</span></li>
                    <li><a href="#" class=""><span class="nav-icon"><i data-feather="file"></i></span> <span
                                class="nav-text">Pages</span> <span class="nav-caret"></span></a>
                        <ul class="nav-sub nav-mega">
                            <li><a href="page.profile.html" class=""><span class="nav-text">Profile</span></a></li>
                            <li><a href="page.search.html" class=""><span class="nav-text">Search</span></a></li>
                            <li><a href="page.invoice.html" class=""><span class="nav-text">Invoice</span></a></li>
                            <li><a href="page.faq.html" class=""><span class="nav-text">FAQ</span></a></li>
                            <li><a href="page.price.html" class=""><span class="nav-text">Price</span></a></li>
                            <li><a href="page.setting.html" class=""><span class="nav-text">Setting</span></a></li>
                            <li><a href="page.blank.html" class=""><span class="nav-text">Blank</span></a></li>
                        </ul>
                    </li>
                    <li><a href="#" class=""><span class="nav-icon"><i data-feather="lock"></i></span> <span
                                class="nav-text">Auth</span> <span class="nav-caret"></span></a>
                        <ul class="nav-sub nav-mega">
                            <li><a href="signin.1.html" class=""><span class="nav-text">Signin</span></a></li>
                            <li><a href="signup.1.html" class=""><span class="nav-text">Signup</span></a></li>
                            <li><a href="forgot-password.html" class=""><span class="nav-text">Forgot
                                        Password</span></a></li>
                            <li><a href="lockme.html" class=""><span class="nav-text">Lockme Screen</span></a></li>
                            <li><a href="404.html" class=""><span class="nav-text">Error 404</span></a></li>
                            <li><a href="505.html" class=""><span class="nav-text">Error 505</span></a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
        <div class="no-shrink">
            <div class="p-3 d-flex align-items-center">
                <div class="text-sm hidden-folded text-muted">Trial: 35%</div>
                <div class="progress mx-2 flex" style="height:4px">
                    <div class="progress-bar gd-success" style="width: 35%"></div>
                </div>
            </div>
        </div>
    </div>
</div>