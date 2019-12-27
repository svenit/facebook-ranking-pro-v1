@extends('app')

@section('hero','PVP')
@section('sub_hero','Vinh quang chỉ dành cho người chiến thắng')

@section('content')
<div id="list-fight-room">
    <div class="page-content page-container" id="page-content">
        <div class="padding-x">
            @include('user.theme.parameter')
            <div class="card vip-bordered">
                <div class="b-b">
                    <div class="nav-active-border b-primary bottom">
                        <ul class="nav" id="myTab" role="tablist">
                            @foreach($gears as $key => $character)
                                <li class="nav-item"><a class="nav-link {{ $key == 0 ? 'active' : '' }}" id="{{ $character->id }}-tab" data-toggle="tab" href="#home{{ $character->id }}" role="tab" aria-controls="home{{ $character->id }}" aria-selected="{{ $key == 0 ? 'true' : 'false' }}">{{ $character->name }}</a></li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <div class="tab-content p-3">
                    @foreach($gears as $key => $gear)
                    <div class="tab-pane fade {{ $key == 0 ? 'show active' : '' }}" id="home{{ $gear->id }}" role="tabpanel" aria-labelledby="{{ $gear->id }}-tab">
                        <div class="row">
                            @foreach($gear->items as $key => $item)
                            <div class="col-6 col-md-4 col-lg-3">
                                <div class="card vip-bordered">
                                    <div @click="showGearsDescription({{ json_encode($item) }},0)" class="text-center hoverable">
                                        <div style="margin:0 auto" class="{{ $item->shop_tag }}"></div>
                                        <p :style="{color:'{{ $item->rgb }}'}">{{ $item->name }}</p>
                                        <p class="gear-description">
                                            {{ $item->description }}
                                        </p>
                                    </div>
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-secondary active">
                                            {{ $item->price }} {{ $item->price_type == 0 ? 'Vàng' : 'KC' }}
                                        </button> 
                                        <button @click="buyItem({{ $item->id }},$event)" style="border-top-left-radius:0px;border-bottom-left-radius:0px" type="button" class="btn btn-secondary">Mua</button>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endforeach
                </div>
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