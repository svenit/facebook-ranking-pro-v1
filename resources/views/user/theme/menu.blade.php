<div id="aside-left" class="page-sidenav no-shrink bg-light nav-dropdown fade hide" aria-hidden="true">
    <div class="sidenav h-100 modal-dialog bg-light normal-bordered">
        <div class="navbar"><a href="{{ Route('user.index') }}" class="navbar-brand">
            <img src="{{ asset('assets/images/app.png') }}">
            <span style="font-weight:inherit;" class="notranslate pixel-font hidden-folded text-warning d-inline l-s-n-1x">{{ env('APP_NAME') }}</span></a></div>
        <div class="flex scrollable hover left-side">
            <div class="nav-active-text-primary" data-nav>
                <ul class="nav bg">
                    <li class="nav-header hidden-folded"><span class="text-muted">Hiệp Hội</span></li>
                    <li><a class="no-ajax" href="{{ Route('user.index') }}"><span class="nav-icon"><img style="width:20px" src="{{ asset('assets/images/ORG.png') }}"></span> <span class="nav-text">Hiệp Hội</span></a></li>
                </ul>
                <ul class="nav">
                    @if(!Request::is('admin/*'))
                        <li class="nav-header hidden-folded"><span class="text-muted">Hoạt Động</span></li>
                        <li class="{{ Request::is('profile/*') ? 'active' : '' }}"><a href="#"><span class="nav-icon"><img style="width:20px" src="{{ asset('assets/images/icon/Character.png') }}"></span> <span
                            class="nav-text">Nhân Vật</span> <span class="nav-caret"></span></a>
                            <ul class="nav-sub nav-mega">
                                <li><a href="{{ Route('user.profile.item.index') }}" class=""><span class="nav-text">Vật Phẩm</span></a></li>
                                <li><a href="{{ Route('user.profile.gem.index') }}" class=""><span class="nav-text">Ngọc Bổ Trợ</span></a></li>
                                <li><a href="{{ Route('user.profile.inventory.index') }}" class=""><span class="nav-text">Trang Bị</span></a></li>
                                <li><a href="{{ Route('user.profile.pet.index') }}" class=""><span class="nav-text">Thú Cưỡi</span></a></li>
                                <li><a href="{{ Route('user.profile.skill.index') }}" class=""><span class="nav-text">Kỹ Năng</span></a></li>
                                <li><a href="{{ Route('user.profile.stat.index') }}" class=""><span class="nav-text">Chỉ Số</span></a></li>
                                @auth
                                    <li><a href="{{ Route('user.profile.message.index') }}" class=""><span class="nav-text">Tin Nhắn @if(isset($notifications) && $notifications['unread'] > 0)<span class="nav-badge"><b class="badge badge-pill gd-warning">{{ $notifications['unread'] ?? 0 }}</b></span>@endif</span></a></li>
                                @endauth
                            </ul>
                        </li>
                        <li class="{{ Request::is('top/*') ? 'active' : '' }}"><a href="#"><span class="nav-icon"><img style="width:20px" src="{{ asset('assets/images/icon/Rank.png') }}"></span> <span
                            class="nav-text">Xếp Hạng</span> <span class="nav-caret"></span></a>
                            <ul class="nav-sub nav-mega">
                                <li><a href="{{ Route('user.top.power') }}" class=""><span class="nav-text">Lực Chiến</span></a></li>
                                <li><a href="{{ Route('user.top.level') }}" class=""><span class="nav-text">Cấp Độ</span></a></li>
                                <li><a href="{{ Route('user.top.pvp') }}" class=""><span class="nav-text">PVP Arena</span></a></li>
                                <li><a href="{{ Route('user.top.coin') }}" class=""><span class="nav-text">Vàng</span></a></li>
                                <li><a href="{{ Route('user.top.gold') }}" class=""><span class="nav-text">Kim Cương</span></a></li>
                                <li><a href="{{ Route('user.top.activities') }}" class=""><span class="nav-text">Hoạt Động</span></a></li>
                            </ul>
                        </li>
                        <li class="{{ Request::is('events/*') ? 'active' : '' }}"><a href="#" class=""><span class="nav-icon"><img style="width:20px" src="{{ asset('assets/images/icon/Casino.png') }}"></span> <span
                                    class="nav-text">Cansino</span> <span class="nav-caret"></span></a>
                            <ul class="nav-sub nav-mega">
                                <li><a href="{{ Route('user.events.wheel') }}" class=""><span class="nav-text">VQMM</span></a></li>
                                <li><a href="{{ Route('user.events.lucky-box') }}" class=""><span class="nav-text">Cá Cược</span></a></li>
                            </ul>
                        </li>
                        <li class="{{ Request::is('shop/*') ? 'active' : '' }}"><a href="#" class=""><span class="nav-icon"><img style="width:20px" src="{{ asset('assets/images/icon/Shop.png') }}"></span> <span
                            class="nav-text">Cửa Hàng</span> <span class="nav-caret"></span></a>
                            <ul class="nav-sub nav-mega">
                                <li><a href="{{ Route('user.shop.index',['cate' => 'items']) }}" class=""><span class="nav-text">Vật Phẩm</span></a></li>
                                <li><a href="{{ Route('user.shop.index',['cate' => 'gems']) }}" class=""><span class="nav-text">Ngọc Bổ Trợ</span></a></li>
                                @foreach($menuShop as $menu)
                                    <li><a href="{{ Route('user.shop.index',['cate' => str_slug($menu->name)]) }}" class=""><span class="nav-text">{{ $menu->name }}</span></a></li>
                                @endforeach
                                <li><a href="{{ Route('user.shop.index',['cate' => 'pets']) }}" class=""><span class="nav-text">Thú Cưỡi</span></a></li>
                                <li><a href="{{ Route('user.shop.index',['cate' => 'skills']) }}" class=""><span class="nav-text">Kỹ Năng</span></a></li>
                            </ul>
                        </li>
                        <li class="{{ Request::is('oven/*') ? 'active' : '' }}"><a href="#" class=""><span class="nav-icon"><img style="width:20px" src="{{ asset('assets/images/icon/Smith.png') }}"></span> <span
                            class="nav-text">Tiệm Rèn</span> <span class="nav-caret"></span></a>
                            <ul class="nav-sub nav-mega">
                                <li><a href="{{ Route('user.oven.gem') }}" class=""><span class="nav-text">Khảm Ngọc</span></a></li>
                            </ul>
                        </li>
                        <li class="{{ Request::is('explore/*') ? 'active' : '' }}"><a href="#" class=""><span class="nav-icon"><img style="width:32px" src="{{ asset('assets/images/icon/Quest.png') }}"></span> <span
                            class="nav-text">Nhiệm Vụ</span> <span class="nav-caret"></span></a>
                            <ul class="nav-sub nav-mega">
                                <li><a href="#" class=""><span class="nav-text">Hàng Ngày</span></a></li>
                                <li><a href="#" class=""><span class="nav-text">Thành Tựu</span></a></li>
                                {{-- <li><a href="{{ Route('user.recovery-room.index') }}" class=""><span class="nav-text">Phòng Hồi Phục</span></a></li> --}}
                            </ul>
                        </li>
                        <li class="{{ Request::is('dungeon/*') ? 'active' : '' }}"><a href="#" class=""><span class="nav-icon"><img style="width:30px" src="{{ asset('assets/images/icon/Dungeon.png') }}"></span> <span
                            class="nav-text">Dungeon</span></a>
                        </li>
                        <li class="{{ Request::is('guild/*') || Request::is('guild')  ? 'active' : '' }}"><a href="#" class=""><span class="nav-icon"><img style="width:20px" src="{{ asset('assets/images/icon/Guild.png') }}"></span> <span
                            class="nav-text">Bang Hội</span> <span class="nav-caret"></span></a>
                            <ul class="nav-sub nav-mega">
                                @if(empty(Auth::user()->guildMember))
                                    <li><a href="{{ Route('user.guild.create.form') }}" class=""><span class="nav-text">Tạo</span></a></li>
                                @else
                                    <li><a href="{{ Route('user.guild.lobby') }}" class=""><span class="nav-text">Đại Sảnh</span></a></li>
                                    <li><a href="#" class=""><span class="nav-text">Thành Viên</span></a></li>
                                    <li><a href="#" class=""><span class="nav-text">Hoạt Động</span></a></li>
                                    <li><a href="#" class=""><span class="nav-text">Thiết Lập</span></a></li>
                                @endif
                            </ul>
                        </li>
                        <li class="{{ Request::is('pvp/*') ? 'active' : '' }}"><a href="#" class=""><span class="nav-icon"><img style="width:20px" src="{{ asset('assets/images/icon/PVP.png') }}"></span> <span
                            class="nav-text">PVP Arena</span><span class="nav-badge"><b class="badge-circle xs text-success"></b></span> <span class="nav-caret"></span></a>
                            <ul class="nav-sub nav-mega">
                                <li><a href="{{ Route('user.pvp.index') }}" class=""><span class="nav-text">Tham Gia</span></a></li>
                            </ul>
                        </li>
                        {{-- <li class="{{ Request::is('chat/*') ? 'active' : '' }}"><a href="#" class=""><span class="nav-icon"><i data-feather="message-circle"></i></span> <span
                            class="nav-text">Chat</span> <span class="nav-badge"><b class="badge-circle xs text-success"></b></span><span class="nav-caret"></span></a>
                            <ul class="nav-sub nav-mega">
                                <li><a href="{{ Route('user.chat.global') }}" class=""><span class="nav-text">Thế Giới</span></a></li>
                                <li><a onclick="return confirm('Bạn đang có {{ Auth::user()->stranger_chat_times ?? 0 }} vé chat ! Tham gia ?')" href="{{ Route('user.chat.stranger.join') }}" class=""><span class="nav-text">CVNL</span></a></li>
                            </ul>
                        </li> --}}
                        <li><a href="{{ Route('user.giftcode.index') }}" class=""><span class="nav-icon"><img style="width:20px" src="{{ asset('assets/images/icon/Gift.png') }}"></span> <span
                            class="nav-text">Quà Tặng</span></a>
                        </li>
                    @endif
                    @if(Auth::check() && Auth::user()->isAdmin)
                        <li class="nav-header hidden-folded"><span class="text-muted">Admin Cpanel</span></li>
                        <li><a href="{{ Route('admin.dashboard.index') }}"><span class="nav-icon"><i
                            data-feather="cpu"></i></span> <span class="nav-text">Tổng Quan</span></a></li>
                        <li><a href="#" class=""><span class="nav-icon"><i data-feather="download"></i></span> <span
                                    class="nav-text">Cập Nhật</span> <span class="nav-caret"></span></a>
                            <ul class="nav-sub nav-mega">
                                <li><a href="{{ Route('admin.update-points') }}" class=""><span class="nav-text">Điểm Hoạt Động</span></a></li></li>
                            </ul>
                        </li>
                        <li class="{{ Request::is('admin/analytics/*') ? 'active' : '' }}"><a href="#" class=""><span class="nav-icon"><i data-feather="pie-chart"></i></span> <span
                            class="nav-text">Truy Cập</span> <span class="nav-caret"></span></a>
                            <ul class="nav-sub nav-mega">
                                <li><a href="{{ Route('admin.analytics.total') }}" class=""><span class="nav-text">Tổng Quan</span></a></li></li>
                                <li><a href="{{ Route('admin.analytics.hour') }}" class=""><span class="nav-text">Theo Giờ</span></a></li></li>
                                <li><a href="{{ Route('admin.analytics.day') }}" class=""><span class="nav-text">Theo Ngày</span></a></li></li>
                                <li><a href="{{ Route('admin.analytics.view-most') }}" class=""><span class="nav-text">Xem Nhiều</span></a></li></li>
                                <li><a href="{{ Route('admin.analytics.setting.index') }}" class=""><span class="nav-text">Cài Đặt</span></a></li></li>
                            </ul>
                        </li>
                        <li class="{{ Request::is('admin/users/*') ? 'active' : '' }}"><a href="#" class=""><span class="nav-icon"><i data-feather="users"></i></span> <span
                            class="nav-text">Người Dùng</span> <span class="nav-caret"></span></a>
                            <ul class="nav-sub nav-mega">
                                <li><a href="{{ Route('admin.users.list') }}" class=""><span class="nav-text">Danh Sách</span></a></li></li>
                            </ul>
                        </li>
                        <li class="{{ Request::is('admin/gears/*') || Request::is('admin/cate-gears/*') ? 'active' : '' }}"><a href="#" class=""><span class="nav-icon"><i data-feather="archive"></i></span> <span
                            class="nav-text">Trang Bị</span> <span class="nav-caret"></span></a>
                            <ul class="nav-sub nav-mega">
                                <li><a href="{{ Route('admin.cate-gears.list') }}" class=""><span class="nav-text">Danh Mục</span></a></li></li>
                                <li><a href="{{ Route('admin.gears.add') }}" class=""><span class="nav-text">Thêm</span></a></li></li>
                                <li><a href="{{ Route('admin.gears.list') }}" class=""><span class="nav-text">Danh Sách</span></a></li></li>
                            </ul>
                        </li>
                        <li class="{{ Request::is('admin/pets/*') ? 'active' : '' }}"><a href="#" class=""><span class="nav-icon"><i data-feather="gitlab"></i></span> <span
                            class="nav-text">Thú Cưỡi</span> <span class="nav-caret"></span></a>
                            <ul class="nav-sub nav-mega">
                                <li><a href="{{ Route('admin.pets.add') }}" class=""><span class="nav-text">Thêm</span></a></li></li>
                                <li><a href="{{ Route('admin.pets.list') }}" class=""><span class="nav-text">Danh Sách</span></a></li></li>
                            </ul>
                        </li>
                        <li class="{{ Request::is('admin/items/*') ? 'active' : '' }}"><a href="#" class=""><span class="nav-icon"><i data-feather="package"></i></span> <span
                            class="nav-text">Vật Phẩm</span> <span class="nav-caret"></span></a>
                            <ul class="nav-sub nav-mega">
                                <li><a href="{{ Route('admin.items.add') }}" class=""><span class="nav-text">Thêm</span></a></li></li>
                                <li><a href="{{ Route('admin.items.list') }}" class=""><span class="nav-text">Danh Sách</span></a></li></li>
                            </ul>
                        </li>
                        <li class="{{ Request::is('admin/skills/*') ? 'active' : '' }}"><a href="#" class=""><span class="nav-icon"><i data-feather="book-open"></i></span> <span
                            class="nav-text">Kỹ Năng</span> <span class="nav-caret"></span></a>
                            <ul class="nav-sub nav-mega">
                                <li><a href="{{ Route('admin.skills.add') }}" class=""><span class="nav-text">Thêm</span></a></li></li>
                                <li><a href="{{ Route('admin.skills.list') }}" class=""><span class="nav-text">Danh Sách</span></a></li></li>
                            </ul>
                        </li>
                        <li class="{{ Request::is('admin/levels/*') ? 'active' : '' }}"><a href="{{ Route('admin.levels.list') }}" class=""><span class="nav-icon"><i data-feather="trending-up"></i></span> <span
                            class="nav-text">Cấp Độ</span></a>
                        </li>
                        <li class="{{ Request::is('admin/characters/*') ? 'active' : '' }}"><a href="#" class=""><span class="nav-icon"><i data-feather="user"></i></span> <span
                            class="nav-text">Nhân Vật</span> <span class="nav-caret"></span></a>
                            <ul class="nav-sub nav-mega">
                                <li><a href="{{ Route('admin.pets.add') }}" class=""><span class="nav-text">Thêm</span></a></li></li>
                                <li><a href="{{ Route('admin.pets.list') }}" class=""><span class="nav-text">Danh Sách</span></a></li></li>
                            </ul>
                        </li>
                        <li class="{{ Request::is('admin/recovery-rooms/*') ? 'active' : '' }}"><a href="#" class=""><span class="nav-icon"><i data-feather="rss"></i></span> <span
                            class="nav-text">Phòng Hồi Phục</span> <span class="nav-caret"></span></a>
                            <ul class="nav-sub nav-mega">
                                <li><a href="{{ Route('admin.pets.add') }}" class=""><span class="nav-text">Thêm</span></a></li></li>
                                <li><a href="{{ Route('admin.pets.list') }}" class=""><span class="nav-text">Danh Sách</span></a></li></li>
                            </ul>
                        </li>
                        <li class="{{ Request::is('admin/pushers/*') ? 'active' : '' }}"><a href="{{ Route('admin.pushers.list') }}" class=""><span class="nav-icon"><i data-feather="database"></i></span> <span
                            class="nav-text">Pushers</span></a>
                        </li>
                        <li class="{{ Request::is('admin/events/*') ? 'active' : '' }}"><a href="#" class=""><span class="nav-icon"><i data-feather="gift"></i></span> <span
                            class="nav-text">Giải Trí</span> <span class="nav-caret"></span></a>
                            <ul class="nav-sub nav-mega">
                                <li><a href="{{ Route('admin.events.add') }}" class=""><span class="nav-text">Thêm</span></a></li></li>
                                <li><a href="{{ Route('admin.events.list') }}" class=""><span class="nav-text">Danh Sách</span></a></li></li>
                            </ul>
                        </li>
                        <li class="{{ Request::is('admin/chats/*') ? 'active' : '' }}"><a href="#" class=""><span class="nav-icon"><i data-feather="message-square"></i></span> <span
                            class="nav-text">Chat</span></span></a>
                        </li>
                        <li class="{{ Request::is('admin/pvps/*') ? 'active' : '' }}"><a href="#" class=""><span class="nav-icon"><i data-feather="shield"></i></span> <span
                            class="nav-text">PVP</span></span></a>
                        </li>
                        <li class="{{ Request::is('admin/trackings/*') ? 'active' : '' }}"><a href="#" class=""><span class="nav-icon"><i data-feather="play"></i></span> <span
                            class="nav-text">Theo Dõi</span></span></a>
                        </li>
                        <li class="{{ Request::is('admin/settings/*') ? 'active' : '' }}"><a href="#" class=""><span class="nav-icon"><i data-feather="settings"></i></span> <span
                            class="nav-text">Cài Đặt</span> <span class="nav-caret"></span></a>
                            <ul class="nav-sub nav-mega">
                                <li><a href="{{ Route('admin.settings.config') }}" class=""><span class="nav-text">Cấu Hình</span></a></li></li>
                                <li><a href="#" class=""><span class="nav-text">Slider</span></a></li></li>
                            </ul>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
        @auth
            <div class="no-shrink">
                <div class="p-3 d-flex align-items-center">
                    <div class="text-sm hidden-folded {{ Auth::user()->energy >= 60 ? 'text-success' : 'text-danger' }}">Sức Khỏe : {{ Auth::user()->energy }} <i class="fas fa-walking"></i></div>
                </div>
            </div>
        @endauth
    </div>
</div>