<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class UserSkill extends Model
{
    public function skill()
    {
        return $this->belongsTo('App\Model\Skill','skill_id','id');
    }
}
