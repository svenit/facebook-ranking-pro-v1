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
                <div class="alert bg-dark">Phí lập Guild : 10KC</div>         
                <form class="row" method="POST" enctype="multipart/form-data" action="{{ Route('user.guild.create') }}">
                    @csrf
                    <div class="form-group col-6">
                        <label class="text-muted" for="exampleInputEmail1">Tên Guild</label>
                        <input type="text" value="" class="form-control" name="name" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="">
                    </div>
                    <div class="form-group col-6">
                        <label class="text-muted" for="exampleInputEmail1">Biểu Tượng</label>
                        <input type="file" value="" class="form-control" name="branch" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="">
                    </div>
                    <div class="form-group col-12">
                        <div class="g-recaptcha" data-sitekey="6LccQnEUAAAAABNb2nR1r6RucjwkkUpmBTMomCku"></div>
                    </div>
                    <div class="form-group col-12">
                        <button class="btn btn-success">Tạo Guild</button>
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