<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
class RecoveryRoom extends Model
{
    public function users()
    {
        return $this->belongsToMany('App\Model\User','user_recovery_rooms','recovery_room_id','user_id');
    }
}
