<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class UserGear extends Model
{
    public function gear()
    {
        return $this->belongsTo('App\Model\Gear','gear_id','id');
    }
}
