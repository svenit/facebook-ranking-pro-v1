<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserGear extends Model
{
    use SoftDeletes;
    public $timestamps = false;
    protected $dates = ['deleted_at'];

    protected $guarded = [];

    public function gear()
    {
        return $this->belongsTo('App\Model\Gear','gear_id','id');
    }

    public function gems()
    {
        return $this->hasMany('App\Model\UserGearGem','user_gear_id','id');
    }
}
