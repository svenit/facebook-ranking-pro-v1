<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Pusher extends Model
{
    protected $fillable = [
        'app_id','app_key','app_secret','cluster','selected'
    ];

    public function config()
    {
        return $this->whereSelected(1)->first();
    }
}
