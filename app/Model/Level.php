<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Level extends Model
{
    protected $fillable = [
        'level','exp_required'
    ];
}
