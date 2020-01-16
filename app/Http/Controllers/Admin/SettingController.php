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
}
