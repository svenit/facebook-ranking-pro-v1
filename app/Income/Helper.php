<?php

namespace App\Income;

use App\Model\User;
use App\Model\Level;
use App\Model\Config;
use Illuminate\Support\Facades\Cache;

class Helper
{
    private $rankCoin = 1;
    private $rankPower = 1;
    public $config;
    private $userID;

    public function __construct($userID = null)
    {
        $config = new Config();
        $this->config = $config->first();
        $this->userID = User::findOrFail($userID) ? $userID : 0;
    }
    public function user()
    {
        return User::find($this->userID);
    }
    public function character()
    {
        return $this->user()->character;
    }
    public function skills()
    {
        return $this->user()->skills;
    }
    public function usingSkills()
    {
        return $this->user()->usingSkills();
    }
    public function gears()
    {
        return $this->user()->gears;
    }
    public function usingGears()
    {
        return $this->user()->usingGears();
    }
    public function usingPets()
    {
        return $this->user()->usingPets();
    }
    public function power()
    {
        return $this->user()->power();
    }
    public function fullPower($id)
    {
        return $this->user()->fullPower($id);
    }
    public function updateFullPower()
    {
        $user = $this->user();
        $user->full_power = $this->fullPower($user->id);
        $user->save();
    }
    public function level()
    {
        $allLevel = Level::all();
        for($i = $allLevel->count() - 1;$i >= 0;$i--)
        {
            if($this->user()->exp >= $allLevel[$i]->exp_required)
            {
                $level = $allLevel[$i]->level;
                break;
            }
        }
        return isset($level) ? $level : 0;
    }
    public function nextLevel()
    {
        $currentLevel = Level::whereLevel($this->level())->first();
        $nextLevel = Level::where('id', '>', $currentLevel->id)->first();
        return [
            'next_level' => isset($nextLevel) ? $nextLevel->level : 'MAX',
            'next_level_exp' => isset($nextLevel) ? $nextLevel->exp_required : 0,
            'current_level' => $currentLevel->level,
            'current_user_exp' => (int)$this->user()->exp,
            'percent' => isset($nextLevel) ? round(((int)$this->user()->exp/$nextLevel->exp_required)*100) : 100
        ];
    }
    public function coins()
    {
        return $this->user()->getCoins();
    }
    public function coinsCustom($coins,$incomeCoins)
    {
        return $coins + $incomeCoins;
    }
    public function gold()
    {
        return $this->user()->gold;
    }
    public function rankCoin() : int
    {
        $userCompare = $this->coins();
        User::where('character_id','!=',0)->chunkById(2000,function($users) use($userCompare){
            $users->each(function($user) use($userCompare) {
                $userCompare < $this->coinsCustom($user->coins,$user->income_coins) ? $this->rankCoin++ : $this->rankCoin; 
            });
        });
        return $this->rankCoin;
    }
    public function rankPower()
    {
        $userCompare = $this->user()->full_power;
        User::where('character_id','!=',0)->whereNotNull('provider_id')->chunkById(2000,function($users) use($userCompare){
            $users->each(function($user) use ($userCompare){
                $userCompare < $user->full_power ? $this->rankPower++ : $this->rankPower;
            });
        });
        return $this->rankPower;
    }

    public function stats()
    {
        return [
            'data' => $this->user()->stats(),
            'used' => $this->user()->usedStats(),
            'available' => $this->user()->availableStats()
        ];
    }
}