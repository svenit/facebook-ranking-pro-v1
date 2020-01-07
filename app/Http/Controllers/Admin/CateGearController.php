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
    public function store(Request $request)
    {
        $this->validate($request,[
            'name' => 'required|unique:cate_gears,name'
        ]);
        $store = CateGear::create([
            'name' => $request->name,
            'description' => $request->description
        ]);
        if(isset($store))
        {
            return redirect()->back()->with([
                'status' => 'success',
                'message' => 'Thành công'
            ]);
        }
    }
    public function detail($id)
    {
        $detail = CateGear::findOrFail($id)->load('gears');
        return view('admin.cate-gears.detail',compact('detail'));
    }
    public function delete($id)
    {
        $delete = CateGear::findOrFail($id)->delete();
        if(isset($delete))
        {
            return redirect()->back()->with([
                'status' => 'success',
                'message' => 'Thành công'
            ]);
        }
    }
}
