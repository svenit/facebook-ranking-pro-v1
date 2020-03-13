<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Guild extends Model
{
    protected $fillable = [
        'master_id','name', 'brand', 'noti_board', 'level', 'resources'
    ];
}
