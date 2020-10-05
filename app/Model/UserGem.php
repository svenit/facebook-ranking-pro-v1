<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserGem extends Model
{
    use SoftDeletes;

    protected $guarded = [];

    public function gem()
    {
        return $this->belongsTo('App\Model\Gem','gem_id','id');
    }
}
