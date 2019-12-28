<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class UserPet extends Model
{
    public function users()
    {
        return $this->belongsToMany('App\Model\User','user_pets','pet_id','user_id');
    }
    public function pets()
    {
        return $this->belongsTo('App\Model\Pet','pet_id','id');
    }
}
