<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Character extends Model
{
    protected $guarded = [];

    public function scopeAvaiable($query)
    {
        $hiddenId = [0];
        return $query->whereNotIn('id',$hiddenId)->get();
    }
    public function gears()
    {
        return $this->hasMany('App\Model\Gear','character_id','id');
    }
    public function skills()
    {
        return $this->hasMany('App\Model\Skill','character_id','id');
    }
}
