@extends('app')
@section('content')

@section('hero','Truy Cập')
@section('sub_hero','Cài đặt kiểu hiển thị')

<div id="content" class="flex">
    <div id="ranking" class="">
        <div class="page-content page-container" id="page-content">
            <div class="padding-x">
                <div class="col-12 vip-bordered">
                    <div class="card">
                        <div class="card-header"><strong>Dữ liệu</strong></div>
                        <div class="card-body">
                            <form method="POST" action="{{ Route('admin.analytics.setting.update') }}">
                                @csrf
                                <div class="row row-sm">
                                    @if($errors->any())
                                        <div class="alert alert-danger">
                                            @foreach($errors->all() as $error)
                                                <p>{{ $error }}</p>
                                            @endforeach
                                        </div>
                                    @endif
                                    <div class="col-sm-6">
                                        <div class="md-form-group">
                                            <input value="{{ session('analytics.date_start',now()->subDays(7)->format('Y-m-d')) }}" name="date_start" type="date" class="md-input"><label>Từ Ngày</label>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="md-form-group">
                                            <input type="date" value="{{ session('analytics.date_end',now()->format('Y-m-d')) }}" name="date_end" class="md-input"><label>Đến Ngày</label>
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <button class="btn btn-success">Cập Nhật</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
