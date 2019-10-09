@extends('app')
@section('content')

@section('hero','Trang Chủ')
@section('sub_hero',"Xin chào, $welcome")

<div class="page-content page-container" id="page-content">
    <div class="padding-x">
        @include('user.theme.parameter')
    </div>
</div>
@endsection

@section('js')
    @if(session('message'))
        <script>
            Swal.fire('',"{{ session('message') }}","{{ session('status') }}");
        </script>
    @endif
@endsection