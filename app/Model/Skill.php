<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Skill extends Model
{
    protected $hidden = [
        'character_id','value_type','type','value','pivot','required_level','level','created_at','updated_at'
    ];
    public function users()
    {
        return $this->belongsToMany('App\Model\User','user_skill','skill_id','user_id');
    }
}
