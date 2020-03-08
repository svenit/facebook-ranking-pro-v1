<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class UserGear extends Model
{
    public $timestamps = false;
    
    protected $fillable = [
        'status'
    ];
    public function gear()
    {
        return $this->belongsTo('App\Model\Gear','gear_id','id');
    }

    public function gems()
    {
        return $this->hasMany('App\Model\UserGearGem','user_gear_id','id');
    }
}
