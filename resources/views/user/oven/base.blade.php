<div style="position:relative">
    <p class="text-dark" class="hide-in-mobile" style="width:135px;position: absolute;top:5px;left:135px;z-index:9">
        Chào bạn
    </p>
    <img class="hide-in-mobile" style="width:135px;position: absolute;top:0px;left:130px" src="{{ asset('assets/images/comment.png') }}">
    <img width="130px" class="pixel" src="{{ asset('assets/images/icon/Smith-NPC.png') }}">
</div>
<a href="{{ Route('user.oven.gem') }}" class="{{ Request::is("oven/gem") ? 'active' : '' }} btn btn-dark">Khảm Ngọc</a>