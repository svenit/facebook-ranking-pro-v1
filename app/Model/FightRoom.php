<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class FightRoom extends Model
{
    protected $fillable = [
        'room_id','user_challenge','user_challenge_hp','user_receive_challenge','user_challenge_energy',
        'is_ready','status','turn','effected','countdown_skill','buff',
        'check_status'
    ];

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
