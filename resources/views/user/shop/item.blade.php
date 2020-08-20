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
                @if($items->count() > 0)
                    @foreach($items as $key => $item)
                        <div style="margin:15px 0px"  data-title="tooltip" title="Click vào để xem chi tiết" class="col-6 col-md-4 col-lg-3">
                            <div class="card vip-bordered">
                                <div class="text-center hoverable">
                                    <div @click="showInforItem({{ json_encode($item) }},0)" style="margin:0 auto !important" class="pixel {{ $item->class_tag }}"></div>
                                    <p style="margin-top:10px;color:{{ $item->rgb }}">{{ $item->name }}</p>
                                </div>
                                <div class="btn-group">
                                    <button type="button" class="btn btn-secondary active">
                                        {{ number_format($item->price) }} <img style="width:16px" class="ml-2" src="{{ showUnit($item->price_type) }}">
                                    </button> 
                                    <button @click="buyItem({{ json_encode($item) }},$event)" style="border-top-left-radius:0px;border-bottom-left-radius:0px" type="button" class="btn btn-secondary">Mua</button>
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