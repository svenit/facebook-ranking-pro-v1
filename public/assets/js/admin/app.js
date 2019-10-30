new Vue({
    el: "#ranking",
    data: {
        ranks: [],
        all: [],
        loading: true,
        percent: 0,
        total: 0,
        page: 1,
        maxPages: 0,
        message: '',
        perPage: 25
    },
    computed: {
        next()
        {
            return this.page < this.maxPages
        },
        back()
        {
            return this.page > 1
        },
    },
    methods: {
        rankStart(groupId,accessToken,day,perPost,perComment,perCommented,perReact,perReacted) 
        {
            try
            {
                const self = this;
                this.loading = true;
                var ranking = new Ranking(groupId, accessToken, {
                    points_per_post: perPost,
                    points_per_comment: perComment,
                    points_per_commented: perCommented,
                    points_per_reaction: perReact,
                    points_per_reacted: perReacted
                });
                ranking.since(day).progress(function (completed, requests) {
                    self.percent = (completed / requests * 100).toFixed(2);
                }).done((ranks) => {
                    self.all = ranks;
                    self.total = self.all.length;
                    self.maxPages = Math.ceil(self.total / self.perPage);
                    self.loadPage(1);
                    self.percent = 0;
                });
                this.percent = 0;
                ranking.get();
            }
            catch(e)
            {
                alert('Đã có lỗi xảy ra ! : ' + e);
            }
        },
        async publicToServer()
        {
            const self = this;
            let res = await axios.post(`${config.root}/admin/update-points`,{
                data:this.all,
            },{
                onUploadProgress: progressEvent => {
                    self.percent = Math.floor((progressEvent.loaded * 100) / progressEvent.total);
                }
            });
            Swal.fire('',res.data.message,res.data.status);
        },
        loadPage(page) 
        {
            if (page) {
                this.page = page;
            }
            this.page = Math.max(1, this.page);
            var offset = (this.page - 1) * this.perPage;
            this.ranks = this.all.slice(offset, offset + this.perPage);
            this.loading = false;
        },
        goNext() 
        {
            this.page++;
            this.loadPage();
        },
        goBack()
        {
            this.page--;
            this.loadPage();
        },
    }
});
