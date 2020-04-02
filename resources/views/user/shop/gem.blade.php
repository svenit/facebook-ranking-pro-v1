@extends('app')

@section('hero','Cửa Hàng')
@section('sub_hero','Nơi bán những vật phẩm có giá trên trời')

@section('content')
<div id="list-fight-room">
    <div class="page-content page-container" id="page-content">
        <div class="padding-x">
            @include('user.theme.parameter')
            @include('user.shop.base')
            <div class="vip-bordered row">                    
                @if($gems->count() > 0)
                    @foreach($gems as $key => $gem)
                        <div style="margin:15px 0px" class="col-6 col-md-4 col-lg-3">
                            <div data-title="tooltip" title="Click vào để xem chi tiết" class="card vip-bordered">
                                <div @click="showGem({{ json_encode($gem) }},0)" class="text-center hoverable">
                                    <div style="margin:0 auto !important" class="pixel gem {{ $gem->image }}"></div>
                                    <p style="margin-top:10px;color:{{ $gem->rgb }}">{{ $gem->name }}</p>
                                </div>
                                <div class="btn-group">
                                    <button type="button" class="btn btn-secondary active">
                                        {{ number_format($gem->price) }} {{ $gem->price_type == 0 ? 'Vàng' : 'KC' }}
                                    </button> 
                                    <button @click="buyGem({{ $gem->id }},$event)" style="border-top-left-radius:0px;border-bottom-left-radius:0px" type="button" class="btn btn-secondary">Mua</button>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <p class="text-center">( Chưa có mặt hàng nào )</p>
                @endif
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
    var page = {
        path:'shop.index'
    };
</script>
@endpush