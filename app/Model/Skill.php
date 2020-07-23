<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Skill extends Model
{
    protected $fillable = [
        'name',
        'character_id',
        'image',
        'animation',
        'power_value',
        'power_type',
        'type',
        'description',
        'required_level',
        'passive',
        'energy',
        'success_rate',
        'rgb',
        'price',
        'price_type',
        'status',
        'effect_value'
    ];
    protected $casts = [
        'effect_value' => 'array',
        'stat' => 'array',
        'options' => 'array',
    ];
    protected $hidden = [
        'character_id','power_type','type','created_at','updated_at'
    ];
    public function users()
    {
        return $this->belongsToMany('App\Model\User','user_skills','skill_id','user_id');
    }
    public function character()
    {
        return $this->belongsTo('App\Model\Character','character_id','id');
    }
}
