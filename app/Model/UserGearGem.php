<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class UserGearGem extends Model
{
    protected $hidden = [
        
    ];

    public function gemItem()
    {
        return $this->belongsTo('App\Model\Gem','user_gem_id','id');
    }
}
