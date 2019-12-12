<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    protected $fillable = [
        'id','name','password','people'
    ];
    protected $hidden = [
        'password'
    ];
}
