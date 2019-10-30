<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Gear extends Model
{
    protected $hidden = [
        'character_id','cate_gear_id','status','pivot','created_at','updated_at'
    ];
    public function users()
    {
        return $this->belongsToMany('App\Model\User','user_gears','gear_id','user_id');
    }
}
