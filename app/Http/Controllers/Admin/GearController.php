<?php

namespace App\Http\Controllers\Admin;

use App\Model\Gear;
use App\Model\CateGear;
use App\Model\Character;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class GearController extends Controller
{
    public function list()
    {
        $gears = Gear::with('character','cates','users')->get();
        return view('admin.gears.list',compact('gears'));
    }
    public function add()
    {
        $characters = Character::where('id','!=',0)->get();
        $cateGears = CateGear::all();
        return view('admin.gears.add',compact('characters','cateGears'));
    }
    public function store(Request $request)
    {
        $this->validate($request,[
            'name' => 'required|unique:gears,name',
            'class_tag' => 'required|unique:gears,class_tag',
            'shop_tag' => 'required|unique:gears,shop_tag',
            'characters' => 'required|array',
            'cate_gear_id' => 'required|exists:cate_gears,id',
            'strength' => 'required|numeric|min:0',
            'intelligent' => 'required|numeric|min:0',
            'agility' => 'required|numeric|min:0',
            'lucky' => 'required|numeric|min:0',
            'health_points' => 'required|numeric|min:0',
            'armor_strength' => 'required|numeric|min:0',
            'armor_intelligent' => 'required|numeric|min:0',
            'rgb' => 'required',
            'level_required' => 'required|min:0|numeric',
            'price' => 'required|numeric|min:0',
            'price_type' => 'required|min:0|max:1|integer',
            'status' => 'required|min:0|max:1|integer',
        ]);
        foreach($request->characters as $character)
        {
            $request['character_id'] = $character;
            $store = Gear::create($request->except('_token'));
        }
        if(isset($store))
        {
            $cate = Str::slug(CateGear::findOrFail($request->cate_gear_id)->name);
            $this->removeCache("shop.$cate");
            return redirect()->back()->with([
                'status' => 'success',
                'message' => 'Thêm trang bị thành công'
            ]);
        }
    }
    public function edit($id)
    {
        $gear = Gear::findOrFail($id)->load('users');
        $characters = Character::where('id','!=',0)->get();
        $cateGears = CateGear::all();
        return view('admin.gears.edit',compact('gear','characters','cateGears'));
    }

    public function update(Request $request,$id)
    {
        $this->validate($request,[
            'name' => 'required',
            'class_tag' => 'required',
            'shop_tag' => 'required',
            'character_id' => 'required|exists:characters,id',
            'cate_gear_id' => 'required|exists:cate_gears,id',
            'strength' => 'required|numeric|min:0',
            'intelligent' => 'required|numeric|min:0',
            'agility' => 'required|numeric|min:0',
            'lucky' => 'required|numeric|min:0',
            'health_points' => 'required|numeric|min:0',
            'armor_strength' => 'required|numeric|min:0',
            'armor_intelligent' => 'required|numeric|min:0',
            'rgb' => 'required',
            'level_required' => 'required|min:0|numeric',
            'price' => 'required|numeric|min:0',
            'price_type' => 'required|min:0|max:1|integer',
            'status' => 'required|min:0|max:1|integer',
        ]);
        $update = Gear::findOrFail($id)->update($request->except('_token'));
        if(isset($update))
        {
            return redirect()->back()->with([
                'status' => 'success',
                'message' => 'Cập nhật trang bị thành công'
            ]);
        }
    }

    public function delete($id)
    {
        Gear::findOrFail($id)->delete();
        return redirect()->back()->with([
            'status' => 'success',
            'message' => 'Xóa trang bị thành công'
        ]);
    }
}
