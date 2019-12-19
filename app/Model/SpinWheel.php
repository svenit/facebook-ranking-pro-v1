<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class SpinWheel extends Model
{
    protected $hidden = [
        'query','created_at','updated_at'
    ];
}
