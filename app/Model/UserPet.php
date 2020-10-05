<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserPet extends Model
{
    use SoftDeletes;

    public $timestamps = false;

    protected $guarded = [];

    public function users()
    {
        return $this->belongsToMany('App\Model\User','user_pets','pet_id','user_id');
    }
    public function pets()
    {
        return $this->belongsTo('App\Model\Pet','pet_id','id');
    }
}
