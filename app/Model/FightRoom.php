<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class FightRoom extends Model
{
    protected $guarded = [];

    protected $casts = [
        'effected' => 'array',
        'countdown_skill' => 'array',
        'buff' => 'array'
    ];

    public function room()
    {
        return $this->belongsTo('App\Model\Room','room_id','id');
    }
}
