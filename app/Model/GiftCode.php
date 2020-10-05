<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
class GiftCode extends Model
{
    public function user()
    {
        return $this->belongsToMany('App\Model\User','user_gift_codes','gift_code_id','user_id');
    }
}
