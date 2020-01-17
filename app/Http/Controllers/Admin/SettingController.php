<?php

namespace App\Http\Controllers\Admin;

use App\Model\Config;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SettingController extends Controller
{
    public function config()
    {
        $config = new Config();
        $config = $config->first();
        return view('admin.settings.config',compact('config'));
    }
    public function updateConfig(Request $request)
    {
        Config::first()->update($request->except('_token'));
        return redirect()->back()->with([
            'status' => 'success',
            'message' => 'Cập nhật thành công'
        ]);
    }
}
