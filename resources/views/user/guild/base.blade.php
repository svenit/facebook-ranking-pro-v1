<a href="{{ Route('user.guild.lobby') }}" class="{{ Request::is("guild") ? 'active' : '' }} btn btn-dark">Đại Sảnh</a>
<a href="{{ Route('user.guild.member') }}" class="{{ Request::is("guild/members") ? 'active' : '' }} btn btn-dark">Thành Viên</a>

