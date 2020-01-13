<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Pet extends Model
{
    protected $fillable = [
        'name','class_tag',
        'strength','intelligent','agility','lucky','armor_strength',
        'armor_intelligent','heath_points','description','rgb','level_required',
        'price','price_type','status'
    ];
    public function users()
    {
        return $this->belongsToMany('App\Model\User','user_pets','pet_id','user_id');
    }
}
