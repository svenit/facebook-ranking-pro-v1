@extends('app')

@section('hero','Ngọc Tinh Luyện')
@section('sub_hero','Ngọc Tinh Luyện')

@section('content')
<div id="list-fight-room">
    <div class="page-content page-container" id="page-content">
        <div class="padding-x">
            @include('user.theme.parameter')
            @include('user.guild.base')
            <div class="card vip-bordered">
                <div style="padding:20px 20px 0px 20px" class="row">
                    <div class="col-12">
                        <div class="card-header bg-dark bg-img p-0 no-border" data-stellar-background-ratio="0.1"
                            style="background-image: url(&quot;../assets/img/b3.jpg&quot;); background-position: 50% -197.037px;">
                            <div class="bg-dark-overlay r-2x no-r-b">
                                <div class="d-md-flex">
                                    <div class="p-4">
                                        <div class="d-flex"><a href="#"><span class="avatar w-64"><img
                                                        src="{{ asset($guild->brand) }}" alt="."> <i
                                                        class="on"></i></span></a>
                                            <div class="mx-3">
                                                <h5 class="mt-2">{{ $guild->name }}</h5>
                                                <div class="text-fade text-sm"><span class="m-r">
                                                    Level : {{ $guild->level }}
                                                    </span></div>
                                            </div>
                                        </div>
                                    </div><span class="flex"></span>
                                    <div class="align-items-center d-flex p-4">
                                        <div class="toolbar btn btn-sm bg-dark-overlay btn-rounded text-white bg-dark">
                                            Thành Viên : {{ number_format($guildMembers->count()) }}
                                        </div>
                                        <div class="ml-2 toolbar btn btn-sm bg-dark-overlay btn-rounded text-white bg-dark">
                                            Tài Sản : {{ number_format($guild->resources) }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div style="padding:10px" class="bg-dark">
                                <p class="text-gold"><strong>THÔNG BÁO</strong></p>
                                <p>{{ $guild->noti_board }}</p>
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
@if($errors->any())
<script>
    Swal.fire('', "{{ $errors->first() }}", 'error');

</script>
@endif
<script>
    const page = {
        path: 'guild.lobby'
    };

</script>
@endpush
