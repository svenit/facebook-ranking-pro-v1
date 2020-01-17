<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Config extends Model
{
    protected $fillable = [
        'maintaince','limit_pvp_time_status','limit_pvp_time',
        'access_token','group_id','started_day','per_post','per_comment',
        'per_commented','per_react','per_reacted','open_chat','open_pvp'
    ];
}
