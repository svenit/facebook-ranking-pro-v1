<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Gear extends Model
{
    protected $guarded = [];

    protected $casts = [
        'strength' => 'array',
        'intelligent' => 'array',
        'agility' => 'array',
        'lucky' => 'array',
        'armor_strength' => 'array',
        'armor_intelligent' => 'array',
        'health_points' => 'array',
    ];

    protected $hidden = [
        'character_id', 'cate_gear_id' ,'created_at','updated_at'
    ];
    public function users()
    {
        return $this->belongsToMany('App\Model\User','user_gears','gear_id','user_id');
    }
    public function character()
    {
        return $this->belongsTo('App\Model\Character','character_id', 'id');
    }
    public function cates()
    {
        return $this->belongsTo('App\Model\CateGear','cate_gear_id','id');
    }

    public function userGears()
    {
        return $this->hasMany('App\Model\UserGear', 'gear_id', 'id');
    }

    public function gems()
    {
        return $this->hasManyThrough('App\Model\UserGearGem', 'App\Model\UserGear','gear_id', 'user_gear_id', 'id');
    }

    public function getGems()
    {
        return $this->belongsTo('App\Model\CateGear','user_gear_id', 'gem_id');
    }
}
