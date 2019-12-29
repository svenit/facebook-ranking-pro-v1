<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ChatConversation extends Model
{
    protected $fillable = [
        'user_id','room_id'
    ];
    public $timestamps = false;
    
    public function room()
    {
        return $this->belongsTo('App\Model\ChatRoom','room_id','id');
    }
}
