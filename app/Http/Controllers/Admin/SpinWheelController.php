<?php

namespace App\Http\Controllers\Admin;

use App\Model\SpinWheel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class SpinWheelController extends Controller
{
    public function list()
    {
        $gifts = SpinWheel::all();
        $logFiles = Storage::allFiles('public/spin');
        $logs = [];
        foreach($logFiles as $log)
        {
            $logs[] = [
                'file' => $log,
                'data' => Storage::get($log)
            ];
        }
        return view('admin.spin-wheel.list',compact('gifts','logs'));
    }
}
