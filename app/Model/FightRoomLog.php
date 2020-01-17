<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class FightRoomLog extends Model
{
    protected $fillable = [
        'user_win_id','user_lose_id'
    ];
}
