<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>{{ env('APP_NAME') }} - Đăng Nhập </title>
    <link rel="stylesheet" href="{{ asset('assets/css/site.min.css') }}">
    <link href="{{ asset('cdn/css/all.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/app.min.css') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.7.2/animate.min.css">
</head>

<body class="bg-dark layout-row">
    <div id="app" class="dark h-v d-flex flex align-items-center">
        <div style="border-radius:5px;width:600px;margin:0px" class="bg-dark mx-auto w-xl w-auto-xs animate fadeIn text-center">
            <div>
                <div class="mb-3"><img style="width:150px" src="{{ asset('assets/images/app.png') }}" class="">
                <div class="text-warning mt-3 font-bold">Addictive Text-Based Fantasy MMORPG!</div>
                </div>
                <div class="mb-3" v-html="story"></div>
                <div v-if="next && step < stories.length - 1" @click="nextStory" class="mt-15" style="margin-top:10px;">
                    <a href="#" @click="skipStotry" class="mr-2 btn btn-rounded btn-outline-danger">
                        <span class="mx-2">Bỏ Qua</span>
                    </a>
                    <a href="#" class="btn btn-rounded btn-secondary">
                        <span class="mx-2">Tiếp</span>
                    </a>
                </div>
                <div v-if="next && step == stories.length - 1" class="animated pulse infinite mt-15" style="margin-top:10px;">
                    <a href="{{ Route('user.character.set') }}" class="btn btn-rounded btn-outline-warning">
                        <i class="fas fa-swords"></i>
                        <span class="mx-2">Thức Tỉnh</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</body>
<style>
    a:hover{
        color: #fff !important;
    }
</style>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@8.18.2/dist/sweetalert2.all.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/vue"></script>
@if(session('message'))
    <script>
        Swal.fire('',"{{ session('message') }}","{{ session('status') }}");
    </script>
@endif
<script>
    let i = 0;
    new Vue({
        el:'#app',
        data:{
            step:0,
            next:false,
            story:'',
            stories:[
                "<p>Xin chào Player [ <strong>{{ Auth::user()->name }}</strong> ]<p> Chào mừng bạn đến với Solo Leveling Simulator...",
                "Năm 2025! Khắp mọi nơi trên thế giới đều xuất hiện những cánh cổng kì lạ...",
                "Tất cả truyền thông, báo chí khắp nơi đều đăng tin về sự kiện này và làm rúng lên thông tin về ngày tận thế của trái đất...",
                "Tất cả mọi người đều tò mò về thứ đang ẩn lấp phía sau những cánh cổng kia...",
                "Và rồi... Chưa đến một tuần sau khi sự kiện những cánh cổng này xuất hiện...",
                "Từ trong cánh cổng xuất hiện những con quái vật, chúng bắt đầu tấn công và tiêu diệt loài người...",
                "Tất cả mọi thứ đều trở lên hỗn loạn, vũ khí hiện đại không hề có tác dụng đối với chúng...",
                "Lúc này con người chỉ biết cầu nguyện rằng có một phép màu nào đó xuất hiện và cứu rỗi lấy họ...",
                "Và dường như phép màu đó đã trở thành hiện thực, đã có những người nhận được sức mạnh vượt trội và có khả năng đối trọi lại với lũ quái vật...",
                "Từng người từng người một được nhận thứ sức mạnh đó, họ bắt đầu lập tổ đội với chung một mục đích là tiêu diệt lũ quái vật và đóng những cánh cổng lại...",
                "Họ - những người thức tỉnh sức mạnh được mọi người gọi là [ Thợ Săn ]"
            ],
        },
        created()
        {
            this.typeWriter();
        },
        methods:{
            typeWriter() 
            {
                if(i < this.stories[this.step].length)
                {
                    this.story += this.stories[this.step].charAt(i);
                    i++;
                    setTimeout(this.typeWriter, 30);
                    if(i == this.stories[this.step].length)
                    {
                        this.next = true;
                    }
                }
            },
            nextStory()
            {
                this.next = false;
                this.story = '';
                this.step++;
                i = 0;
                this.typeWriter();
            },
            skipStotry()
            {
                if(confirm('Bỏ qua phần giới thiệu?'))
                {
                    this.step = this.stories.length - 1;
                    this.story = this.stories[this.step];
                }
            }
        }
    })
</script>
</html>