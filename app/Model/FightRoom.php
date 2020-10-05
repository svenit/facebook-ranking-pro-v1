<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class FightRoom extends Model
{
    protected $guarded = [];

    public function room()
    {
        return $this->belongsTo('App\Model\Room','room_id','id');
    }
}
