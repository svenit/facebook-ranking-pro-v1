<?php

namespace App\Http\Controllers\Admin;

use App\Model\Item;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ItemController extends Controller
{
    public function list()
    {
        $items = Item::all();
        return view('admin.items.list',compact('items'));
    }
    public function store(Request $request)
    {
        $this->validate($request,[
            'name' => 'required|unique:items,name',
            'class_tag' => 'required|unique:items,class_tag',
            'query' => 'required',
            'success_rate' => 'required|between:0,10',
            'price' => 'required|numeric|min:0',
            'price_type' => 'required|min:0|max:1|integer',
            'status' => 'required|min:0|max:1|integer',
        ]);
        $store = Item::create($request->except('_token'));
        if(isset($store))
        {
            $this->removeCache("shop.item");
            return redirect()->back()->with([
                'status' => 'success',
                'message' => 'Thêm vật phẩm thành công'
            ]);
        }
    }
    public function edit($id)
    {
        $item = Item::findOrFail($id);
        return view('admin.items.edit',compact('item'));
    }
    public function update(Request $request,$id)
    {
        $this->validate($request,[
            'name' => 'required',
            'class_tag' => 'required',
            'query' => 'required',
            'success_rate' => 'required|between:0,10',
            'price' => 'required|numeric|min:0',
            'price_type' => 'required|min:0|max:1|integer',
            'status' => 'required|min:0|max:1|integer',
        ]);
        $update = Item::findOrFail($id)->update($request->except('_token'));
        if(isset($update))
        {
            $this->removeCache("shop.item");
            return redirect()->back()->with([
                'status' => 'success',
                'message' => 'Cập nhật vật phẩm thành công'
            ]);
        }
    }
    public function replicate($id)
    {
        $item = Item::findOrFail($id);
        $newItem = $item->replicate();
        $newItem->save();
        $this->removeCache("shop.item");
        return redirect()->route('admin.items.edit',['id' => $newItem->id])->with([
            'status' => 'success',
            'message' => 'Đã sao chép'
        ]);
    }
    public function delete($id)
    {
        Item::findOrFail($id)->delete();
        $this->removeCache("shop..item");
        return redirect()->back()->with([
            'status' => 'success',
            'message' => 'Xóa vật phẩm thành công'
        ]);
    }
    public function deleteMulti(Request $request)
    {
        if(isset($request->selected))
        {
            foreach(explode(",",$request->selected[0]) as $selected)
            {
                $delete = Item::findOrFail($selected)->delete();
            }
            if($delete)
            {
                $this->removeCache("shop.item");
                return redirect()->back()->with([
                    'status' => 'success',
                    'message' => "Đã xóa vật phẩm"
                ]);
            }
        }
    }
}
