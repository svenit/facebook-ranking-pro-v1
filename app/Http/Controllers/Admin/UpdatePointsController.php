<?php

namespace App\Http\Controllers\Admin;

use App\User;
use App\Config;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class UpdatePointsController extends Controller
{
    private $config;

    public function __construct(Config $config)
    {
        $this->config = $config->first();
    }
    public function index()
    {
        $this->config->started_day = Carbon::parse($this->config->started_day)->diffInDays();
        return view('admin.update-points')->with('config',$this->config);
    }
    public function store(Request $request)
    {
        if($request->has('data'))
        {
            Storage::put('data.json',json_encode($request->data));
            foreach($request->data as $key => $rank)
            {
                User::updateOrCreate(
                    [
                        'user_id' => $rank['id']
                    ],
                    [
                        'user_id' => $rank['id'],
                        'name' => $rank['name'],
                        'posts' => $rank['post'],
                        'comments' => $rank['comment'],
                        'reactions' => $rank['reaction'],
                        'coins' => $rank['points']
                    ]
                );
            }
        }
    }
}
