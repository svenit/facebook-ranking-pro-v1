<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserSkill extends Model
{
    use SoftDeletes;

    public $timestamps = false;

    protected $guarded = [];

    public function skill()
    {
        return $this->belongsTo('App\Model\Skill','skill_id','id');
    }
}
