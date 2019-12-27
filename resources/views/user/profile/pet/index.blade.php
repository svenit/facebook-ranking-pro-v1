@extends('app')

@section('hero','Kho Đồ')
@section('sub_hero','Kho đồ của bạn')

@section('content')
<div id="list-fight-room">
    <div class="page-content page-container" id="page-content">
        <div class="padding-x">
            @include('user.theme.parameter')
            <div class="row vip-bordered">
                <div class="col-4">
                    <div class="card">
                        <div class="text-center hoverable">
                            <div @click="showGearsDescription(data.pet,1)" style="margin:0 auto" class="character-sprites">
                                <span v-if="data.pet" style="right:33%" :class="`Mount_Body_${data.pet.class_tag}`"></span>
                                <span v-if="data.pet" style="right:33%" :class="`Mount_Head_${data.pet.class_tag}`"></span>
                            </div>
                            <div style="margin-top:50px">
                                <p :style="{color:data.pet.rgb}" v-html="data.pet.name"></p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-8">
                    
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
        path:'inventory.index'
    };
</script>
@endpush