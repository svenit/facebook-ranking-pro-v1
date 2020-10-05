<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ChatConversation extends Model
{
    use SoftDeletes;

    protected $guarded = [];

    public $timestamps = false;

    public function room()
    {
        return $this->belongsTo('App\Model\ChatRoom','room_id','id');
    }
}
