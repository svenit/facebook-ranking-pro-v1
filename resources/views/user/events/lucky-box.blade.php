@extends('app')

@section('hero','Vật phẩm')
@section('sub_hero','Kho vật phẩm của bạn')

@section('content')
<div id="list-fight-room">
    <div class="page-content page-container" id="page-content">
        <div class="padding-x">
            @include('user.theme.parameter')
            <div class="vip-bordered row">                    
                <div class="col-4 col-md-3 col-lg-2" data-title="tooltip" title="Click vào để sử dụng">
                    <div class="card">
                        Tính năng này chưa mở :)
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('js')
<script>
    var page = {
        path:'event.lucky-box'
    };
</script>
@endpush