<div id="header" class="page-header">
    <div class="navbar navbar-expand-lg">
        <a href="#" class="navbar-brand">
            <small class="badge badge-secondary" style="font-weight:initial;font-size:12px"><span id="user-count"></span> Đang Online</small>
        </a>
        <ul class="nav navbar-menu order-1 order-lg-2">
            <li class="nav-item d-none d-sm-block"><a class="nav-link px-2" data-toggle="fullscreen"
                    data-plugin="fullscreen"><i data-feather="maximize"></i></a></li>
            <li class="nav-item dropdown"><a class="nav-link px-2" data-toggle="dropdown"><i
                        data-feather="settings"></i></a>
                <div class="dropdown-menu dropdown-menu-center mt-3 w animate fadeIn">
                    <div class="setting px-3">
                        <div class="mb-2 text-muted"><strong>Cài đặt :</strong></div>
                        <div class="mb-3" id="settingLayout"><label
                                class="ui-check ui-check-rounded my-1 d-block"><input type="checkbox"
                                    name="stickyHeader"> <i></i> <small>Cố định phần đầu</small></label><label
                                class="ui-check ui-check-rounded my-1 d-block"><input type="checkbox"
                                    name="stickyAside"> <i></i> <small>Cố định phần bên</small></label><label
                                class="ui-check ui-check-rounded my-1 d-block"><input type="checkbox"
                                    name="foldedAside"> <i></i> <small>Thu gọn phần bên</small></label><label
                                class="ui-check ui-check-rounded my-1 d-block"><input type="checkbox"
                                    name="hideAside"> <i></i> <small>Ẩn phần bên</small></label></div>
                        <div class="mb-2 text-muted"><strong>Giao diện :</strong></div>
                        <div class="mb-2">
                            <label class="radio radio-inline ui-check ui-check-md">
                                <input
                                    type="radio" name="bg" value=""> <i></i>
                            </label>
                            <label
                                class="radio radio-inline ui-check ui-check-color ui-check-md"><input
                                    type="radio" name="bg" value="bg-dark"> <i class="bg-dark"></i>
                                </label>
                        </div>
                    
                    </div>
                </div>
            </li>
            @auth
            <li class="nav-item dropdown"><a class="nav-link px-2 mr-lg-2" data-toggle="dropdown"><i
                        data-feather="bell"></i> <span class="badge badge-pill badge-up bg-primary">{{ $notifications['unread'] ?? 0 }}</span></a>
                <div style="width:500px" class="dropdown-menu dropdown-menu-right mt-3 w-md animate fadeIn p-0">
                    <div class="scrollable hover" style="max-height: 250px">
                        <div class="list list-row">
                            @if(isset($notifications['data']) && Auth::check())
                                @foreach($notifications['data'] as $noti)
                                    <div style="background:{{ $noti->read_at ? '' : 'rgba(135,150,165,.1)' }}" class="list-item" data-id="10">
                                        <div>
                                            <a href="{{ Route('user.profile.message.detail',['id' => $noti->id]) }}"><span class="w-32 avatar gd-dark">
                                                <img src="http://graph.facebook.com/{{ $noti->data['user_id'] }}/picture?type=normal" alt="."></span></a></div>
                                        <div class="flex">
                                            <a class="text-muted" href="{{ Route('user.profile.message.detail',['id' => $noti->id]) }}"><div style="font-size:13px" class="item-feed h-2x">{{ $noti->data['title'] ?? '' }}</div></a>
                                        </div>
                                        <span style="font-size:13px">{{ \Carbon\Carbon::parse($noti->created_at)->diffForHumans() }}</span>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div>
                    <div class="d-flex px-3 py-2 b-t">
                        <div class="flex"><span>{{ $notifications['unread'] }} Tin Nhắn</span></div><a class="text-silver" href="{{ Route('user.profile.message.index') }}">Xem Tất Cả
                            <i class="fa fa-angle-right text-muted"></i></a>
                    </div>
                </div>
            </li>
            @endauth
            <li class="nav-item dropdown"><a href="#" data-toggle="dropdown"
                    class="nav-link d-flex align-items-center px-2 text-color"><span class="avatar w-24"
                        style="margin: -2px"><img src="{{ Auth::check() ? 'http://graph.facebook.com/'.Auth::user()->user_id.'/picture?type=normal' : 'https://image.flaticon.com/icons/png/512/149/149071.png' }}" alt="..."></span></a>
                <div class="dropdown-menu dropdown-menu-right w mt-3 animate fadeIn">
                    
                    <a class="dropdown-item"
                        href=""><span>{{ Auth::user()->name ?? 'Xin chào, Khách' }}</span> 
                    </a>
                    @guest
                    <a class="dropdown-item"
                        href="{{ Route('oauth.index') }}"><span>Đăng nhập </span><span class="badge bg-success text-uppercase">Facebook</span>
                    </a>
                    @endguest
                    @auth
                    <div class="dropdown-divider"></div><a class="dropdown-item"
                        href="page.profile.html"><span>Profile</span> </a><a class="dropdown-item d-flex"
                        href="page.invoice.html"><span class="flex">Invoice</span> <span><b
                                class="badge badge-pill gd-warning">5</b></span> </a><a class="dropdown-item"
                        href="page.faq.html">Need help?</a>
                    <div class="dropdown-divider"></div><a class="dropdown-item"
                        href="page.setting.html"><span>Account Settings</span> </a><a class="dropdown-item"
                        href="{{ Route('oauth.logout') }}">Đăng Xuất</a>
                    @endauth
                </div>
            </li>
            <li class="nav-item d-lg-none"><a href="#" class="nav-link px-2" data-toggle="collapse"
                    data-toggle-class data-target="#navbarToggler"><i data-feather="search"></i></a></li>
            <li class="nav-item d-lg-none"><a class="nav-link px-1" data-toggle="modal" data-target="#aside-left"><i
                        data-feather="menu"></i></a></li>
        </ul>
    </div>
</div>