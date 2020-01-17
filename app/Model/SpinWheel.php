<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class SpinWheel extends Model
{
    protected $fillable = [
        'probability','type','value','result_text','query'
    ];
    protected $hidden = [
        'query','created_at','updated_at'
    ];
}
