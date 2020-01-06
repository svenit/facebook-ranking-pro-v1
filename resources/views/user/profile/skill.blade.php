@extends('app')

@section('hero','Kỹ Năng')
@section('sub_hero','')

@section('content')
<div id="list-fight-room">
    <div class="page-content page-container" id="page-content">
        <div class="padding-x">
            @include('user.theme.parameter')
            @include('user.profile.base')
            <div class="card vip-bordered">
                <div class="b-b">
                    <div class="nav-active-border b-primary bottom">
                        <ul class="nav" id="myTab" role="tablist">
                            <li v-if="data.skills" class="nav-item"><a :class="[`nav-link ${data.skills ? 'active' : ''}`]" id="current-skills-tab" data-toggle="tab" href="#home-current-skills" role="tab" aria-controls="home-current-skills" aria-selected="true">Hiện Tại</a></li>
                            <li class="nav-item"><a :class="[`nav-link ${!data.skills ? 'active' : ''}`]" id="list-skills-tab" data-toggle="tab" href="#home-list-skills" role="tab" aria-controls="home-list-skills" aria-selected="true">Kỹ Năng</a></li>
                        </ul>
                    </div>
                </div>
                <div class="tab-content p-3">
                    <div v-if="data.skills" :class="[`tab-pane fade ${data.skills ? 'show active' : ''}`]" id="home-current-skills" role="tabpanel" aria-labelledby="current-skills-tab">
                        <div v-if="data.skills.length > 0" class="row">
                            <div v-for="(skills,index) in data.skills" :key="index" class="col-lg-1 col-md-2 col-sm-2">
                                <div @click="showSkillsDescription(skills,1)" data-title="tooltip" title="Click vào để xem chi tiết" class="hoverable col-sm-3 col-md-2 col-lg-1">
                                    <span :style="{border:`1px solid ${skills.rgb}`}" class="w-56 avatar gd-dark">
                                        <span :class="`avatar-status ${skills.pivot.status == 1 ? 'on' : 'away'} b-white avatar-right`"></span> 
                                        <img :src="skills.image" alt=".">
                                    </span>
                                </div>
                            </div>
                            <div v-for="n in 4 - data.skills.length" :key="Math.random(1,n)" class="col-lg-1 col-md-2 col-sm-2">
                                <span :style="{border:`1px dashed #eee`}" class="w-56 avatar gd-dark">
                                    <span class="avatar-status of b-white avatar-right"></span> 
                                    
                                </span>
                            </div>
                        </div>
                        <div v-else>
                            <p class="text-center">( Không có kỹ năng nào )</p>
                        </div>
                    </div>
                    <div :class="[`tab-pane fade ${!data.skills ? 'show active' : ''}`]" id="home-list-skills" role="tabpanel" aria-labelledby="list-skills-tab">
                        <div v-if="skills.length > 0" class="row">
                            <div v-for="(skills,index) in skills" :key="index" class="col-lg-1 col-md-2 col-sm-2">
                                <div @click="showSkillsDescription(skills,1)" data-title="tooltip" title="Click vào để xem chi tiết" class="hoverable col-sm-3 col-md-2 col-lg-1">
                                    <span :style="{border:`1px solid ${skills.rgb}`}" class="w-56 avatar gd-dark">
                                        <span :class="`avatar-status ${skills.pivot.status == 1 ? 'on' : 'away'} b-white avatar-right`"></span> 
                                        <img :src="skills.image" alt=".">
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div v-else>
                            <p class="text-center">( Không có kỹ năng nào )</p>
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
        Swal.fire('',"{{ $errors->first() }}",'error');
    </script>
@endif
<script>
    const page = {
        path:'skill.index'
    };
</script>
@endpush