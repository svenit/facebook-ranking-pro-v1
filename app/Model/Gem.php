<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Gem extends Model
{
    protected $guarded = [];

    public function getGear()
    {
        return $this->belongsTo('App\Model\UserGear','user_gear_id', 'gem_id');
    }
}
