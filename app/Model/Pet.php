<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
class Pet extends Model
{
    protected $guarded = [];

    public function users()
    {
        return $this->belongsToMany('App\Model\User','user_pets','pet_id','user_id');
    }
}
