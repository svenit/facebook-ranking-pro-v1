<?php

namespace App\Http\Controllers\Admin;

use App\Model\Character;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Skill;

class SkillController extends Controller
{
    public function list()
    {
        $skills = Skill::all();
        return view('admin.skills.list',compact('skills'));
    }
    public function add()
    {
        $characters = Character::where('id','!=',0)->get();
        return view('admin.skills.add',compact('characters'));
    }
    public function store(Request $request)
    {
        $this->validate($request,[
            'name' => 'required|',
            'character_id' => 'required|exists:characters,id',
            'image' => 'required|url',
            'animation' => 'required|url',
            'power_value' => 'required|numeric',
            'power_type' => 'required|min:0|max:1',
            'type' => 'required',
            'passive' => 'required|min:0|max:1',
            'energy' => 'required|numeric',
            'success_rate' => 'required|min:0|max:100',
            'rgb' => 'required',
            'required_level' => 'required|min:0|numeric',
            'price' => 'required|numeric|min:0',
            'price_type' => 'required|min:0|max:1|integer',
            'status' => 'required|min:0|max:1|integer',
        ]);
        $store = Skill::create($request->except('_token'));
        if(isset($store))
        {
            $this->removeCache("shop.skill");
            return redirect()->back()->with([
                'status' => 'success',
                'message' => 'Thêm kỹ năng thành công'
            ]);
        }
    }
    public function edit($id)
    {
        $skill = Skill::findOrFail($id);
        $characters = Character::where('id','!=',0)->get();
        return view('admin.skills.edit',compact('skill','characters'));
    }

    public function update(Request $request,$id)
    {
        $this->validate($request,[
            'name' => 'required',
            'character_id' => 'required|exists:characters,id',
            'image' => 'required|url',
            'animation' => 'required|url',
            'power_value' => 'required|numeric',
            'power_type' => 'required|min:0|max:1',
            'type' => 'required',
            'passive' => 'required|min:0|max:1',
            'energy' => 'required|numeric',
            'success_rate' => 'required|min:0|max:100',
            'rgb' => 'required',
            'required_level' => 'required|min:0|numeric',
            'price' => 'required|numeric|min:0',
            'price_type' => 'required|min:0|max:1|integer',
            'status' => 'required|min:0|max:1|integer',
        ]);
        $update = Skill::findOrFail($id)->update($request->except('_token'));
        if(isset($update))
        {
            $this->removeCache("shop.skill");
            return redirect()->back()->with([
                'status' => 'success',
                'message' => 'Cập nhật kỹ năng thành công'
            ]);
        }
    }

    public function replicate($id)
    {
        $item = Skill::findOrFail($id);
        $newItem = $item->replicate();
        $newItem->save();
        $this->removeCache("shop.skill");
        return redirect()->route('admin.skills.edit',['id' => $newItem->id])->with([
            'status' => 'success',
            'message' => 'Đã sao chép'
        ]);
    }
    public function delete($id)
    {
        Skill::findOrFail($id)->delete();
        $this->removeCache("shop.skill");
        return redirect()->back()->with([
            'status' => 'success',
            'message' => 'Xóa kỹ năng thành công'
        ]);
    }
    public function deleteMulti(Request $request)
    {
        if(isset($request->selected))
        {
            foreach(explode(",",$request->selected[0]) as $selected)
            {
                $delete = Skill::findOrFail($selected)->delete();
            }
            if($delete)
            {
                $this->removeCache("shop.skill");
                return redirect()->back()->with([
                    'status' => 'success',
                    'message' => "Đã xóa kỹ năng"
                ]);
            }
        }
    }
}
