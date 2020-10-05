<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserItem extends Model
{
    use SoftDeletes;

    protected $guarded = [];

    public function item()
    {
        return $this->belongsTo('App\Model\Item','item_id','id');
    }
}
