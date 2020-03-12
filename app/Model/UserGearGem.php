<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class UserGearGem extends Model
{
    protected $fillable = [
        'user_gear_id','user_gem_id','gem_id'
    ];
    protected $hidden = [
        
    ];

    public function gemItem()
    {
        return $this->belongsTo('App\Model\Gem','gem_id','id');
    }

    public function gems()
    {
        return $this->belongsTo('App\Model\UserGem', 'user_gem_id', 'id');
    }
}
