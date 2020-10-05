<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserGearGem extends Model
{
    use SoftDeletes;

    protected $guarded = [];

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
