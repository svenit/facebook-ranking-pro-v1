@extends('app')

@section('hero','GiftCode')
@section('sub_hero','Nhận nhiều phần quà khủng')

@section('content')
<div id="list-fight-room">
    <div class="page-content page-container" id="page-content">
        <div class="padding-x">
            @include('user.theme.parameter')
            <div style="padding:20px" class="vip-bordered">    
                @if($errors->any())
                <div class="alert alert-danger">
                    @foreach($errors->all() as $err)
                        <div>{{ $err }}</div>
                    @endforeach
                </div>
                @endif                
                <form class="row" method="POST" action="{{ Route('user.giftcode.submit') }}">
                    @csrf
                    <div class="form-group col-4">
                        <label class="text-muted" for="exampleInputEmail1">Nhập GiftCode</label>
                        <input type="text" value="" class="form-control" name="code" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="">
                    </div>
                    <div class="form-group col-12">
                        <div class="g-recaptcha" data-sitekey="6LccQnEUAAAAABNb2nR1r6RucjwkkUpmBTMomCku"></div>
                    </div>
                    <div class="form-group col-12">
                        <button class="btn btn-success">Gửi</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
@push('js')
<script>
    const page = {
        path:'giftcode'
    };
</script>
<script src="https://www.google.com/recaptcha/api.js"></script>
@endpush