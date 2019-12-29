<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ChatRoom extends Model
{
    protected $fillable = [
        'name','people'
    ];
    public function user()
    {
        return $this->belongsToMany('App\Model\User','chat_conversations','user_id','room_id');
    }
}
