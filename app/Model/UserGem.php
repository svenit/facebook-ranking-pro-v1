<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class UserGem extends Model
{
    protected $fillable = [
        'user_id', 'gem_id', 'status'
    ];
    public function gem()
    {
        return $this->belongsTo('App\Model\Gem','gem_id','id');
    }
}
