<?php

namespace App\Income;

use App\Model\User;
use App\Model\Config;
use Illuminate\Support\Facades\Auth;

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
    public function character()
    {
        return User::find($this->userID)->character;
    }
    public function skills()
    {
        return User::find($this->userID)->skills;
    }
    public function fullPower()
    {
        $properties = [
            'strength' => 5,
            'agility' => 3,
            'intelligent' => 5,
            'lucky' => 2,
            'health_points' => 1.5
        ];
        $power = 0;
        foreach($properties as $key => $property)
        {
            $power += $this->totalNumeral($key) * $property;
        }
        return $power;
    }
    public function numeralSkills($type)
    {
        return $this->skills()
            ->where('type',$type)
            ->where('value_type',0)
            ->sum('value');
    }
    public function percentSkills($type)
    {
        return $this->skills()
            ->where('type',$type)
            ->where('value_type',1)
            ->sum('value');
    }
    public function totalNumeral($type)
    {
        $number = $this->numeralSkills($type) + User::find($this->userID)[$type];
        $percent = $this->percentSkills($type);
        return $number + (($number * $percent)/100);
    }
    public function coins()
    {
        return User::find($this->userID)->getCoins();
    }
    public function coinsCustom($coins,$incomeCoins)
    {
        return $coins + $incomeCoins;
    }
    public function demicalCoins()
    {
        return number_format($this->coins());
    }
    public function gold()
    {
        return User::find($this->userID)->gold;
    }
    public function demicalGold()
    {
        return number_format($this->gold());
    }
    public function rankCoin() : int
    {
        $userCompare = $this->coins();
        User::where('character_id','!=',0)->chunkById(100,function($users) use($userCompare){
            foreach($users as $user)
            {
                $userCompare < $this->coinsCustom($user->coins,$user->income_coins) ? $this->rankCoin++ : $this->rankCoin; 
            }
        });
        return $this->rankCoin;
    }
    public function rankPower()
    {
        $userCompare = $this->fullPower();
        User::where('character_id','!=',0)->chunkById(100,function($users) use($userCompare){
            foreach($users as $user)
            {
                $this->userID = $user->id;
                $userCompare < $this->fullPower() ? $this->rankPower++ : $this->rankPower; 
            }
        });
        return $this->rankPower;
    }
    public function requestRaw($url)
    {
        $ch = curl_init();
        CURL_SETOPT_ARRAY($ch,[
            CURLOPT_URL => $url,
            CURLOPT_USERAGENT => 'Opera/9.80 (Windows NT 6.0) Presto/2.12.388 Version/12.14',
            CURLOPT_ENCODING => '',
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_SSL_VERIFYHOST => FALSE,
            CURLOPT_SSL_VERIFYPEER => FALSE,
            CURLOPT_TIMEOUT => 60,
            CURLOPT_CONNECTTIMEOUT => 60,
            CURLOPT_FOLLOWLOCATION => TRUE,
        ]);
        $excec = curl_exec($ch);
        curl_close($ch);
        return $excec;
    }
}