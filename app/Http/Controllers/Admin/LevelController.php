<?php

namespace App\Http\Controllers\Admin;

use App\Model\Level;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LevelController extends Controller
{
    public function list()
    {
        $levels = Level::all();
        return view('admin.levels.list',compact('levels'));
    }
    public function store(Request $request)
    {
        $this->validate($request,[
            'level' => 'required|numeric|unique:levels,level',
            'exp_required' => 'required|numeric|unique:levels,exp_required',
        ]);
        $store = Level::create($request->except('_token'));
        if(isset($store))
        {
            return redirect()->back()->with([
                'status' => 'success',
                'message' => 'Thêm cấp độ thành công'
            ]);
        }
    }
    public function edit($id)
    {
        $level = Level::findOrFail($id);
        return view('admin.levels.edit',compact('level'));
    }
    public function update(Request $request,$id)
    {
        $this->validate($request,[
            'level' => 'required|numeric',
            'exp_required' => 'required|numeric',
        ]);
        $update = Level::findOrFail($id)->update($request->except('_token'));
        if(isset($update))
        {
            return redirect()->back()->with([
                'status' => 'success',
                'message' => 'Cập nhật thành công'
            ]);
        }
    }
    public function delete($id)
    {
        Level::findOrFail($id)->delete();
        return redirect()->back()->with([
            'status' => 'success',
            'message' => 'Đã xóa cấp độ'
        ]);
    }
    public function deleteMulti(Request $request)
    {
        if(isset($request->selected))
        {
            foreach(explode(",",$request->selected[0]) as $selected)
            {
                $delete = Level::findOrFail($selected)->delete();
            }
            if($delete)
            {
                return redirect()->back()->with([
                    'status' => 'success',
                    'message' => 'Đã xóa cấp độ'
                ]);
            }
        }
    }
}
