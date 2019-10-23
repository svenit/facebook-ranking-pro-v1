<?php

namespace App\Http\Controllers\Admin;

use App\Model\User;
use App\Model\Config;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class UpdatePointsController extends Controller
{
    private $config;

    // public function __construct(Config $config)
    // {
    //     $this->config = $config->first();
    // }
    public function index()
    {
        $this->config->started_day = Carbon::parse($this->config->started_day)->diffInDays();
        return view('admin.update-points')->with('config',$this->config);
    }
    public function store(Request $request)
    {
        if($request->has('data') && count($request->data) !== 0)
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
                        'coins' => $rank['points'],
                    ]
                );
            }
            $response = [
                'status' => 'success',
                'message' => 'Cập nhật thành công'
            ];
        }
        else
        {
            $response = [
                'status' => 'error',
                'message' => 'Không có dữ liệu để cập nhật'
            ];
        }
        return response()->json($response,200);
    }
}
