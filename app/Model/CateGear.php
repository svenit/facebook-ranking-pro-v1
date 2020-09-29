<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class CateGear extends Model
{
    protected $guarded = [];

    public function gears()
    {
        return $this->hasMany('App\Model\Gear');
    }
}
