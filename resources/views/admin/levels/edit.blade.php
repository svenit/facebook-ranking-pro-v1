@extends('app')
@section('content')

@section('hero','Sửa Trang Bị')
@section('sub_hero','Sửa Trang Bị')

<div id="content" class="flex">
    <div id="ranking" class="">
        <div class="page-content page-container" id="page-content">
            <div class="padding-x">
                <div class="col-12 vip-bordered">
                    <div class="b-b">
                        <div class="nav-active-border b-primary bottom">
                            <ul class="nav" id="myTab" role="tablist">
                                <li class="nav-item"><a class="nav-link active" id="add-tab" data-toggle="tab" href="#home-add" role="tab" aria-controls="home-add" aria-selected="false">Sửa</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="tab-content p-3">
                        <div class="tab-pane fade active show" id="home-add" role="tabpanel" aria-labelledby="add-tab">
                            <div>
                                <div class="card">
                                    <div class="card-body">
                                        @if($errors->any())
                                        <div class="alert alert-danger">
                                            @foreach($errors->all() as $err)
                                                <div>{{ $err }}</div>
                                            @endforeach
                                        </div>
                                        @endif
                                        <form method="POST" action="{{ Route('admin.levels.update',['id' => $level->id]) }}" class="row">
                                            @csrf
                                            <div class="form-group col-6">
                                                <label class="text-muted" for="exampleInputEmail1">Level</label>
                                                <input type="number" value="{{ $level->level }}" class="form-control" name="level" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="">
                                            </div>
                                            <div class="form-group col-6">
                                                <label class="text-muted" for="exampleInputEmail1">EXP</label>
                                                <input type="number" value="{{ $level->exp_required }}" class="form-control" name="exp_required" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="">
                                            </div>
                                            <div class="form-group col-12">
                                                <button type="submit" class="btn btn-success">Cập Nhật</button>
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