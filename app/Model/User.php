<?php

namespace App\Model;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id','provider_id','character_id','posts','reactions','comments','coins',
        'income_coins','exp','isVip','isAdmin',
        'name', 'email', 'password',
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
        return $this->belongsToMany('App\Model\Skill','user_skills','user_id','skill_id');
    }
}
