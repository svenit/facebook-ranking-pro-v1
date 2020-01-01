<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class UserItem extends Model
{
    public function item()
    {
        return $this->belongsTo('App\Model\Item','item_id','id');
    }
}
