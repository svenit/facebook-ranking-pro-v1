@extends('app')

@section('hero','PVP')
@section('sub_hero','Vinh quang chỉ dành cho người chiến thắng')

@section('content')
<div id="list-fight-room">
    <div class="page-content page-container" id="page-content">
        <div class="padding-x">
            @include('user.theme.parameter')
            <div class="row">
                @foreach($gears as $key => $gear)
                <div class="col-6 col-md-4 col-lg-3">
                    <a href="#">
                        <div class="card vip-bordered">
                            <div class="gd-dark text-center">
                                <div style="margin:0 auto" class="{{ $gear->shop_tag }}"></div>
                                <p>{{ $gear->name }}</p>
                            </div>
                            <div class="btn-group">
                                <button type="button" class="btn btn-secondary active">200 Vàng</button> 
                                <a style="border-radius:0px !important"><button style="border-top-left-radius:0px;border-bottom-left-radius:0px" type="button" class="btn btn-secondary">Mua</button></a>
                            </div>
                            
                        </div>
                    </a>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection
@push('js')
@if($errors->any())
    <script>
        Swal.fire('',"{{ $errors->first() }}",'error');
    </script>
@endif
<script>
    const page = {
        path:'shop.index'
    };
</script>
@endpush