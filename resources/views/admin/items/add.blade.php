@extends('app')
@section('content')

@section('hero','Thêm Vật Phẩm')
@section('sub_hero','Thêm Vật Phẩm')

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
                                        <div v-if="shop_tag" style="margin:10px 0px">
                                            <div :style="{border:`1px solid #fff`}" :class="`pixel ${shop_tag} item-content`"></div>
                                        </div>
                                        <form method="POST" action="{{ Route('admin.items.store') }}" class="row">
                                            @csrf
                                            <div class="form-group col-6">
                                                <label class="text-muted" for="exampleInputEmail1">Tên</label>
                                                <input type="text" value="" class="form-control" name="name" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="">
                                            </div>
                                            <div class="form-group col-6">
                                                <label class="text-muted" for="exampleInputEmail1">Class Tag</label>
                                                <input type="text" v-model="shop_tag" value="" class="form-control" name="class_tag" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="">
                                            </div>
                                            <div class="form-group col-6">
                                                <label class="text-muted" for="exampleInputEmail1">SQL Queries</label>
                                                <textarea rows="4" class="form-control" name="query" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder=""></textarea>
                                            </div>
                                            <div class="form-group col-6">
                                                <label class="text-muted" for="exampleInputEmail1">Mô Tả</label>
                                                <textarea rows="4" class="form-control" name="description"></textarea>
                                            </div>
                                            <div class="form-group col-6">
                                                <label class="text-muted" for="exampleInputEmail1">Tỉ Lệ Thành Công</label>
                                                <input type="number" value="" class="form-control" name="success_rate" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="">
                                            </div>
                                            <div class="form-group col-6">
                                                <label class="text-muted" for="exampleInputEmail1">Giá</label>
                                                <input type="number" value="" class="form-control" name="price" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="">
                                            </div>
                                            <div class="form-group col-6">
                                                <label class="text-muted" for="exampleInputEmail1">ĐVTT</label>
                                                <select placeholder="Chọn trang bị" class="chosen form-control form-control-sm" name="price_type">
                                                    <option value="0">Vàng</option>
                                                    <option value="1">KC</option>
                                                </select>
                                            </div>
                                            <div class="form-group col-6">
                                                <label class="text-muted" for="exampleInputEmail1">Trạng Thái</label>
                                                <select placeholder="Chọn trang bị" class="chosen form-control form-control-sm" name="status">
                                                    <option value="0">Ẩn</option>
                                                    <option selected value="1">Hiện</option>
                                                </select>
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
@push('js')
<script src="{{ asset('assets/js/vue/app.js') }}"></script>
@endpush