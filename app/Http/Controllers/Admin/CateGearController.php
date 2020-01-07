<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\CateGear;

class CateGearController extends Controller
{
    public function list()
    {
        $cates = CateGear::all();
        return view('admin.cate-gears.list',compact('cates'));
    }
}
