<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class FightRoom extends Model
{
    protected $fillable = [
        'user_challenge','user_challenge_hp','user_receive_challenge'
    ];
}
