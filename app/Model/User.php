<?php

namespace App\Model;

use App\Income\Helper;
use App\Services\RedisCache;
use Illuminate\Support\Facades\Auth;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use HighIdeas\UsersOnline\Traits\UsersOnlineTrait;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;
    use UsersOnlineTrait;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

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
        'stats' => 'array',
        'location' => 'array',
        'config' => 'array'
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
        return $this->coins;
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
        return $this->belongsToMany('App\Model\Gear','user_gears','user_id','gear_id')->withPivot(['status', 'id']);
    }
    public function pets()
    {
        return $this->belongsToMany('App\Model\Pet','user_pets','user_id','pet_id')->withPivot(['status','id']);
    }
    public function items()
    {
        return $this->belongsToMany('App\Model\Item','user_items','user_id','item_id')->withPivot(['quantity','id']);
    }
    public function recoveryRoom()
    {
        return $this->belongsToMany('App\Model\RecoveryRoom','user_recovery_rooms','user_id','recovery_room_id')->withPivot(['end_at']);
    }
    public function chat()
    {
        return $this->belongsToMany('App\Model\ChatRoom','chat_conversations','user_id','room_id');
    }
    public function giftcode()
    {
        return $this->belongsToMany('App\Model\GiftCode','user_gift_codes','user_id','gift_code_id');
    }
    public function usingSkills()
    {
        $data = [];
        foreach($this->skills as $key => $skill)
        {
            if($skill->pivot->status == 1)
            {
                $data[] = $skill->load('character');
            }
        }
        return $data;
    }
    public function usingGears()
    {
        return RedisCache::rememberForever("user.{$this->id}.using-gears", function () {
            $data = [];
            $gears = $this->gears()->wherePivot('status', 1)->get();
            foreach ($gears as $key => $gear) {
                $gear->gems->load(['gems', 'gemItem']);
                $data[] = $gear->load(['character', 'cates']);
            }
            return array_reverse($data);
        });
    }
    public function usingPets()
    {
        return $this->pets->filter(function($status){
            return $status->pivot->status == 1;
        });
    }

    public function gems()
    {
        return $this->belongsToMany('App\Model\Gem', 'user_gems', 'user_id', 'gem_id')->withPivot(['status']);
    }

    public function usingGems()
    {
        return RedisCache::rememberForever("user.{$this->id}.using-gems", function () {
            $data = [];
            $gears = collect($this->usingGears());
            foreach ($gears as $gear) {
                foreach($gear->gems as $gem) {
                    $data[] = $gem->gems->gem;
                }
            }
            return $data;
        });
    }

    public function power()
    {
        $gearPower = $this->getGearsPower();
        return collect($this->getPower())->map(function($each, $key) use($gearPower){
            $raw = $each + $gearPower['raw'][$key];
            $percentBonus = ($raw * $gearPower['percent'][$key])/100;
            return $raw + $percentBonus;
        });
    }
    public function getPower()
    {
        $properties = [
            'health_points' => 2,
            'strength' => 1.5,
            'intelligent' => 1.5,
            'agility' => 1,
            'lucky' => 1,
            'armor_strength' => 1,
            'armor_intelligent' => 1
        ];
        $power = [];
        foreach ($properties as $key => $property) {
            $power[$key] = (((collect($this->usingPets())->sum($key) + collect($this->usingGems())->sum($key) + ($this->stats()[$key] ?? 0) + ($this[$key])) * $property) * $this->relife());
        }
        return collect($power);
    }

    public function getGearsPower()
    {
        $properties = $percentPower = [
            'health_points' => 0,
            'strength' => 0,
            'intelligent' => 0,
            'agility' => 0,
            'lucky' => 0,
            'armor_strength' => 0,
            'armor_intelligent' => 0
        ];
        $allPower = $this->getPower();
        foreach($this->usingGears() as $gear)
        {
            foreach($properties as $key => $property)
            {
                $properties[$key] += $gear[$key]['default'] ?? 0;
                $percentPower[$key] += $gear[$key]['percent'] ?? 0;
            }
        }
        return [
            'raw' => $properties,
            'percent' => $percentPower
        ];
    }
    public function fullPower($id)
    {
        $helper = new Helper($id);
        return $this->power()->sum() + $helper->level();
    }

    public function getFame()
    {
        $helper = new Helper($this->id);
        return $helper->fameBrand();
    }

    public function level()
    {
        $helper = new Helper($this->id);
        return $helper->level();
    }
    public function nextLevel()
    {
        $helper = new Helper($this->id);
        return $helper->nextLevel();
    }

    public function stats()
    {
        return is_array($this->stats) ? $this->stats : [
            'strength' => 0,
            'intelligent' => 0,
            'agility' => 0,
            'lucky' => 0,
            'health_points' => 0,
            'armor_strength' => 0,
            'armor_intelligent' => 0
        ];
    }

    public function relife()
    {
        return isset($this->config['relife']) && $this->config['relife'] ? 2 : 1;
    }

    public function availableStats()
    {
        $statPerLevel = 5;
        return $allStats = ($this->level() * $statPerLevel) + $this->stat_points + $this->relife();
    }

    public function usedStats()
    {
        return collect(array_values($this->stats()))->sum();
    }

    public function guildMember()
    {
        return $this->hasOne('App\Model\GuildMember', 'member_id', 'id');
    }

}
