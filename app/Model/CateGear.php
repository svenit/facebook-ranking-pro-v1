<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class CateGear extends Model
{
    public function gears()
    {
        return $this->hasMany('App\Model\Gear');
    }
}
