@extends('app')
@section('content')

@section('hero','Thêm Quà Tặng')
@section('sub_hero','Thêm quà tặng')

<div id="content" class="flex">
    <div id="ranking" class="">
        <div class="page-content page-container" id="page-content">
            <div class="padding-x">
                <div class="col-12 vip-bordered">
                    @if($errors->any())
                    <div class="alert alert-danger">
                        @foreach($errors->all() as $err)
                            <div>{{ $err }}</div>
                        @endforeach
                    </div>
                    @endif
                    <div class="b-b">
                        <div class="nav-active-border b-primary bottom">
                            <ul class="nav" id="myTab" role="tablist">
                                <li class="nav-item"><a class="nav-link active" id="add-tab" data-toggle="tab" href="#home-add" role="tab" aria-controls="home-add" aria-selected="false">Thêm</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="tab-content p-3">
                        <div class="tab-pane active show" id="home-add" role="tabpanel" aria-labelledby="add-tab">
                            <div>
                                <div class="card">
                                    <div class="card-body">
                                        <form method="POST" action="{{ Route('admin.events.update',['id' => $spin->id]) }}" class="row">
                                            @csrf
                                            <div class="form-group col-6">
                                                <label class="text-muted" for="exampleInputEmail1">Giá Trị</label>
                                                <input type="text" value="{{ $spin->value }}" class="form-control" name="value" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="">
                                            </div>
                                            <div class="form-group col-6">
                                                <label class="text-muted" for="exampleInputEmail1">Kiểu</label>
                                                <select placeholder="Chọn trang bị" class="chosen form-control form-control-sm" name="type">
                                                    <option {{ $spin->type == 'string' ? 'selected' : '' }} value="string">Chữ</option>
                                                    <option {{ $spin->type == 'image' ? 'selected' : '' }} value="image">Hình Ảnh</option>
                                                </select>
                                            </div>
                                            <div class="form-group col-6">
                                                <label class="text-muted" for="exampleInputEmail1">Xác Suất</label>
                                                <input type="number" value="{{ $spin->probability }}" class="form-control" name="probability" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="">
                                            </div>
                                            <div class="form-group col-6">
                                                <label class="text-muted" for="exampleInputEmail1">Lời Hiển Thị</label>
                                                <input type="text" value="{{ $spin->result_text }}" class="form-control" name="result_text" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="">
                                            </div>
                                            <div class="form-group col-12">
                                                <label class="text-muted" for="exampleInputEmail1">SQL Query</label>
                                                <textarea rows="4" class="form-control" name="query">
                                                    {{ $spin->query }}
                                                </textarea>
                                            </div>
                                            <div class="form-group col-12">
                                                <button type="submit" class="btn btn-success">Thêm</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('css')
    <link rel="stylesheet" href="{{ asset('assets/css/plugins/chosen.css') }}">
@endpush
@push('js')
<script src="{{ asset('assets/js/plugins/chosen/chosen.jquery.js') }}"></script>
<script src="{{ asset('assets/js/vue/app.js') }}"></script>
<script>
    $(document).ready( function () {
        $('.chosen').chosen({
            width: '100%'
        });
    });
</script>
@endpush