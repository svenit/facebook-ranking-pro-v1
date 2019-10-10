<?php

namespace App\Income;

use stdClass;
use App\Model\User;
use App\Model\Config;
use Illuminate\Support\Facades\Auth;

class Helper
{
    private $rank = 1;
    public $config;

    public function __construct()
    {
        $config = new Config();
        $this->config = $config->first();
    }
    public function character()
    {
        return User::find(Auth::id())->character;
    }
    public function skills()
    {
        return User::find(Auth::id())->skills;
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
        $number = $this->numeralSkills($type) + Auth::user()[$type];
        $percent = $this->percentSkills($type);
        return $number + (($number * $percent)/100);
    }
    public function coins() : float
    {
        return Auth::user()->coins + Auth::user()->income_coins;
    }
    public function coinsCustom($coins,$incomeCoins) : float
    {
        return $coins + $incomeCoins;
    }
    public function demicalCoins()
    {
        return number_format($this->coins(),2);
    }
    public function gold()
    {
        return Auth::user()->gold;
    }
    public function demicalGold()
    {
        return number_format($this->gold(),2);
    }
    public function rank() : int
    {
        foreach(User::all() as $user)
        {
            $this->coins() < $this->coinsCustom($user->coins,$user->income_coins) ? $this->rank++ : $this->rank; 
        }
        return $this->rank;
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