<?php

namespace App\Http\Controllers\Admin;

use App\Model\Pet;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PetController extends Controller
{
    public function list()
    {
        $pets = Pet::all();
        return view('admin.pets.list',compact('pets'));
    }
    public function store(Request $request)
    {
        $this->validate($request,[
            'name' => 'required|unique:gears,name',
            'class_tag' => 'required|unique:pets,class_tag',
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
        $store = Pet::create($request->except('_token'));
        if(isset($store))
        {
            $this->removeCache("shop.pet");
            return redirect()->back()->with([
                'status' => 'success',
                'message' => 'Thêm thú cưỡi thành công'
            ]);
        }
    }
    public function edit($id)
    {
        $pet = Pet::findOrFail($id);
        return view('admin.pets.edit',compact('pet'));
    }
    public function update(Request $request,$id)
    {
        $this->validate($request,[
            'name' => 'required',
            'class_tag' => 'required',
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
        $update = Pet::findOrFail($id)->update($request->except('_token'));
        if(isset($update))
        {
            return redirect()->back()->with([
                'status' => 'success',
                'message' => 'Cập nhật thú cưỡi thành công'
            ]);
        }
    }
    public function delete($id)
    {
        Pet::findOrFail($id)->delete();
        return redirect()->back()->with([
            'status' => 'success',
            'message' => 'Đã xóa thú cưỡi'
        ]);
    }
}
