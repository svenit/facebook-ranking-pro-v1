<div id="header" style="position: relative" class="page-header">
    <div class="navbar navbar-expand-lg">
        <div class="ml-4 profile-badge row" data-toggle="modal" data-target=".modal-left" data-toggle-class="modal-open-aside" data-target="body"  @click="index()">
            <div style="padding:0;" class="col-3">
                <img style="position:absolute;width:62px" :src="asset(`assets/images/pvp-ranks/${data.rank.fame.icon}.png`)">
                <img style="width:60px" class="circle mr-3" src="http://graph.facebook.com/{{ Auth::user()->provider_id }}/picture?type=normal" alt="...">
            </div>
            <div class="col-9 pl-4 mt-1">
                <span class="pixel-font small-font pr-5" style="color:#37a8d8">LV@{{ data.level.current_level }}</span>
                <img style="width:17px" src="{{ asset('assets/images/icon/Question.png') }}">
                <div class="mt-1 mb-1" style="height: 3px;background:#534738">
                    <div :style="{width:data.level.percent + '%', height:'3px', backgroundColor: '#37a8d8'}"></div>
                </div>
                <span style="background:#524839;padding:0px 10px;border-radius:3px;font-size:12px;">
                    {{ Auth::user()->name }}
                </span>
            </div>
        </div>
        <ul class="nav navbar-menu order-1 order-lg-2">
            <li class="profile-badge icon-badge row py-1 mr-4">
                <div class="col-auto">
                    <div class="row">
                        <div class="col-auto">
                            <img style="width:17px" src="{{ asset('assets/images/icon-pack/pvp-point.png') }}">
                        </div>
                        <div class="col-auto">
                            <strong class="pixel-font small-font notranslate"> @{{ numberFormat(data.infor.pvp_points) }}</strong>
                        </div>
                    </div>
                </div>
                <div class="col-auto">
                    <img style="width:17px" src="{{ asset('assets/images/icon/Question.png') }}">
                </div>
            </li>
            <li class="profile-badge icon-badge row py-1 mr-4 justify-content-between">
                <div class="col-auto">
                    <div class="row">
                        <div class="col-auto">
                            <img style="width:17px" src="{{ asset('assets/images/icon-pack/gold.png') }}">
                        </div>
                        <div class="col-auto">
                            <strong class="pixel-font small-font notranslate"> @{{ numberFormat(data.infor.coins) }}</strong>
                        </div>
                    </div>
                </div>
                <div class="col-auto">
                    <img style="width:17px" src="{{ asset('assets/images/icon/Add.png') }}">
                </div>
            </li>
            <li class="profile-badge icon-badge row py-1 mr-4">
                <div class="col-auto">
                    <div class="row">
                        <div class="col-auto">
                            <img style="width:17px" src="{{ asset('assets/images/icon-pack/diamond.png') }}">
                        </div>
                        <div class="col-auto">
                            <strong class="pixel-font small-font notranslate"> @{{ numberFormat(data.infor.gold) }}</strong>
                        </div>
                    </div>
                </div>
                <div class="col-auto">
                    <img style="width:17px" src="{{ asset('assets/images/icon/Add.png') }}">
                </div>
            </li>
            @auth
            {{-- <li class="nav-item dropdown"><a class="nav-link px-2 mr-lg-2" data-toggle="dropdown">
                <img src="https://web.simple-mmo.com/img/icons/one/icon027.png"> <span class="badge badge-pill badge-up bg-primary">{{ $notifications['unread'] ?? 0 }}</span></a>
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
            </li> --}}
            {{-- <li class="nav-item dropdown">
                <div class="nav-link px-2 mr-lg-2" data-toggle="dropdown">
                    <img style="width:35px" :src="asset(`assets/images/flag/${currentLang}.png`)">
                    <div class="dropdown-menu dropdown-menu-right mt-3 w-md animate fadeIn">
                        <div v-for="(lang, index) in languages" :key="index" @click="setLanguage(lang.icon)" class="mb-1 dropdown-item">
                            <img class="mr-2" style="width:20px" :src="asset(`assets/images/flag/${lang.icon}.png`)"><span>@{{ lang.name }}</span>
                        </div>
                    </div>
                </div>
            </li> --}}
            @endauth
            {{-- <li class="nav-item dropdown"><a href="#" data-toggle="dropdown"
                    class="nav-link d-flex align-items-center px-2 text-color"><span class="avatar w-24"
                        style="margin: -2px"><img src="{{ Auth::check() ? 'http://graph.facebook.com/'.Auth::user()->provider_id.'/picture?type=normal' : 'https://image.flaticon.com/icons/png/512/149/149071.png' }}" alt="..."></span></a>
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
                        data-feather="menu"></i></a></li> --}}
        </ul>
    </div>
</div>