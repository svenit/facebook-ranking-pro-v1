<?php

namespace App\Income;

use App\Model\User;
use App\Model\Level;
use App\Model\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;

class Helper
{
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
    public function rank() 
    {
        $rankLevels = [
            'E' => 1,
            'D' => 20,
            'C' => 40,
            'B' => 65,
            'A' => 100,
            'S' => 170
        ];
        $currentLevel = $this->nextLevel()['current_level'];
        return array_reverse(array_keys(collect($rankLevels)->filter(function($item) use($currentLevel){
            return $item <= $currentLevel;
        })->toArray()))[0] ?? 'E';
    }
    public function pvpBrand()
    {
        $rankLevels = [
            [
                'id' => 0,
                'mark' => 1,
                'point' => 0,
                'name' => 'Đồng 1',
                'icon' => 'bronze_1',
                'group' => 'Bronze'
            ],
            [
                'id' => 1,
                'mark' => 2,
                'point' => 100,
                'name' => 'Đồng 2',
                'icon' => 'bronze_2',
                'group' => 'Bronze'
            ],
            [
                'id' => 2,
                'mark' => 3,
                'point' => 300,
                'name' => 'Đồng 3',
                'icon' => 'bronze_3',
                'group' => 'Bronze'
            ],
            [
                'id' => 3,
                'mark' => 4,
                'point' => 700,
                'name' => 'Đồng 4',
                'icon' => 'bronze_4',
                'group' => 'Bronze'
            ],
            [
                'id' => 4,
                'mark' => 5,
                'point' => 1000,
                'name' => 'Đồng 5',
                'icon' => 'bronze_5',
                'group' => 'Bronze'
            ],
            [
                'id' => 5,
                'mark' => 6,
                'point' => 1500,
                'name' => 'Đồng 6',
                'icon' => 'bronze_6',
                'group' => 'Bronze'
            ],
            [
                'id' => 6,
                'mark' => 1,
                'point' => 2200,
                'name' => 'Bạc 1',
                'icon' => 'silver_1',
                'group' => 'Silver'
            ],
            [
                'id' => 7,
                'mark' => 2,
                'point' => 3000,
                'name' => 'Bạc 2',
                'icon' => 'silver_2',
                'group' => 'Silver'
            ],
            [
                'id' => 8,
                'mark' => 3,
                'point' => 4500,
                'name' => 'Bạc 3',
                'icon' => 'silver_3',
                'group' => 'Silver'
            ],
            [
                'id' => 9,
                'mark' => 4,
                'point' => 7000,
                'name' => 'Bạc 4',
                'icon' => 'silver_4',
                'group' => 'Silver'
            ],
            [
                'id' => 10,
                'mark' => 5,
                'point' => 13000,
                'name' => 'Bạc 5',
                'icon' => 'silver_5',
                'group' => 'Silver'
            ],
            [
                'id' => 11,
                'mark' => 6,
                'point' => 20000,
                'name' => 'Bạc 6',
                'icon' => 'silver_6',
                'group' => 'Silver'
            ],
        ];
        $currentPvPPoints = $this->user()->pvp_points;
        $currentPvP = array_reverse(collect($rankLevels)->filter(function($item) use($currentPvPPoints){
            return $item['point'] <= $currentPvPPoints;
        })->values()->toArray())[0];
        $currentPvP['next'] = $rankLevels[$currentPvP['id'] + 1] ?? $currentPvP;
        return $currentPvP ?? $rankLevels[0];
    }
    public function fameBrand()
    {
        $rankLevels = config('game.fame');
        $currentFamePoints = $this->user()->fame;
        $currentFame = array_reverse(collect($rankLevels)->filter(function($item) use($currentFamePoints){
            return $item['point'] <= $currentFamePoints;
        })->values()->toArray())[0];
        $currentFame['next'] = $rankLevels[$currentFame['id'] + 1] ?? $currentFame;
        return $currentFame ?? $rankLevels[0];
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

    public function getRank($field)
    {
        return collect(DB::select(DB::raw("SELECT er.*, (@rank := if(@points = {$field}, @rank, if(@points := {$field}, @rank + 1, @rank + 1 ) ) ) AS ranking FROM users er CROSS JOIN (SELECT @rank := 0, @points := -1) params ORDER BY {$field} DESC")))->where('id', $this->user()->id)->values()[0]->ranking;
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