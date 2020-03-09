@extends('app')

@section('hero','Trang bị')
@section('sub_hero','Kho trang bị của bạn')

@section('content')
<div id="list-fight-room">
    <div class="page-content page-container" id="page-content">
        <div class="padding-x">
            @include('user.theme.parameter')
            @include('user.profile.base')
            <div class="card vip-bordered">
                <div style="padding:20px 20px 0px 20px" class="row">
                    @foreach($gems as $key => $gem)
                        <div data-title="tooltip" title="Click vào để xem chi tiết" class="hoverable col-auto">
                            <div class="card">
                                <span style="border:1px solid {{ $gem->rgb }}" class="w-64 avatar gd-dark">
                                    <span class="avatar-status {{ $gem->pivot->status == 1 ? 'on' : 'away' }} b-white avatar-right"></span> 
                                    <img src="{{ $gem->image }}" @click="showGem({{ json_encode($gem) }},1)" class="pixel">
                                </span>
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
@endpush