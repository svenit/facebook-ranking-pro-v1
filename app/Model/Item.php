<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $fillable = [
        'name','description','class_tag','query','success_rate','price',
        'price_type','status'
    ];
    protected $hidden = [
        'query','created_at','updated_at'
    ];
    public function users()
    {
        return $this->belongsToMany('App\Model\User','user_items','item_id','user_id')->withPivot(['quantity']);
    }
}
