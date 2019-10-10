<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Skill extends Model
{
    public function users()
    {
        return $this->belongsToMany('App\Model\User','user_skill','skill_id','user_id');
    }
}
