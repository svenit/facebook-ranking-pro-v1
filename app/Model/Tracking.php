<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Tracking extends Model
{
    protected $fillable = [
        'user_id','path','route','redirect'
    ];
}
