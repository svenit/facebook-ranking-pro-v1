<?php

namespace App\Model;

use App\Income\Helper;
use Illuminate\Support\Facades\Auth;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use HighIdeas\UsersOnline\Traits\UsersOnlineTrait;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;
    use UsersOnlineTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id','provider_id','character_id','posts','reactions','comments','coins',
        'income_coins','exp','isVip','isAdmin',
        'name', 'email', 'password','lng','lat'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function scopeIsAdmin($query)
    {
        return $query->isAdmin == 1 ? TRUE : FALSE;
    }
    public function getId()
    {
        return $this->id;
    }
    public function getCoins()
    {
        return $this->coins + $this->income_coins;
    }
    public function character()
    {
        return $this->hasOne('App\Model\Character','id','character_id');
    }
    public function skills()
    {
        return $this->belongsToMany('App\Model\Skill','user_skills','user_id','skill_id')->withPivot('status');
    }
    public function gears()
    {
        return $this->belongsToMany('App\Model\Gear','user_gears','user_id','gear_id')->withPivot('status');
    }
    public function pets()
    {
        return $this->belongsToMany('App\Model\Pet','user_pets','user_id','pet_id')->withPivot('status');
    }
    public function usingSkills()
    {
        return $this->skills->filter(function($status){
            return $status->pivot->status == 1;
        });
    }
    public function usingGears()
    {
        return $this->gears->filter(function($status){
            return $status->pivot->status == 1;
        });
    }
    public function usingPets()
    {
        return $this->pets->filter(function($status){
            return $status->pivot->status == 1;
        });
    }
    public function power()
    {
        return $this->getPower();
    }
    public function getPower()
    {
        $properties = [
            'strength' => 20,
            'agility' => 15,
            'intelligent' => 20,
            'lucky' => 10,
            'health_points' => 8,
            'armor_strength' => 5,
            'armor_intelligent' => 5
        ];
        $power = [];
        foreach($properties as $key => $property)
        {
            $power[$key] =  collect($this->usingPets())->sum($key) + collect($this->usingGears())->sum($key) + ($this[$key]);
        }
        return collect($power);
        return 1;
    }
    public function fullPower($id)
    {
        $helper = new Helper($id);
        return $this->power()->sum() * $helper->level();
    }
}
