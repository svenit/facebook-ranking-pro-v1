@extends('app')

@section('hero','Cửa Hàng')
@section('sub_hero','Nơi bán những vật phẩm có giá trên trời')

@section('content')
<div id="list-fight-room">
    <div class="page-content page-container" id="page-content">
        <div class="padding-x">
            @include('user.theme.parameter')
            @include('user.shop.base')
            <div class="card vip-bordered">                    
                <div class="b-b">
                    <div class="nav-active-border b-primary bottom">
                        <ul class="nav" id="myTab" role="tablist">
                            @foreach($skills as $key => $character)
                                <li class="nav-item"><a class="nav-link {{ $character->id == Auth::user()->character->id ? 'active' : '' }}" id="{{ $character->id }}-tab" data-toggle="tab" href="#home{{ $character->id }}" role="tab" aria-controls="home{{ $character->id }}" aria-selected="{{ $key == 0 ? 'true' : 'false' }}">{{ $character->name }}</a></li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <div class="tab-content p-3">
                    @foreach($skills as $key => $skill)
                    <div class="tab-pane fade {{ $skill->id == Auth::user()->character->id ? 'show active' : '' }}" id="home{{ $skill->id }}" role="tabpanel" aria-labelledby="{{ $skill->id }}-tab">
                        <div class="row">
                            @if($skill->skills->count() > 0)
                                @foreach($skill->skills as $key => $item)
                                @if($item->status == 1)
                                    <div style="margin:15px 0px"  data-title="tooltip" title="Click vào để xem chi tiết" class="col-6 col-md-4 col-lg-3">
                                        <div class="card vip-bordered">
                                            <div @click="showSkillsDescription({{ json_encode($item) }},0,'{{ $skill->name }}')" class="text-center hoverable">
                                                <img style="border:1px solid {{ $item->rgb }};border-radius:5px" src="{{ $item->image }}">
                                                <p style="margin-top:10px;color:{{ $item->rgb }}">{{ $item->name }}</p>
                                            </div>
                                            <div class="btn-group">
                                                <button type="button" class="btn btn-secondary active">
                                                    {{ number_format($item->price) }} {{ $item->price_type == 0 ? 'Vàng' : 'KC' }}
                                                </button> 
                                                <button @click="buySkill({{ $item->id }},$event)" style="border-top-left-radius:0px;border-bottom-left-radius:0px" type="button" class="btn btn-secondary">Mua</button>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                                @endforeach
                            @else
                                <p class="text-center">( Chưa có mặt hàng nào )</p>
                            @endif
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