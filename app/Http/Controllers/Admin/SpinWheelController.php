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
                'data' => array_filter(array_map('trim',explode("=>",Storage::get($log))))
            ];
        }
        return view('admin.spin-wheel.list',compact('gifts','logs'));
    }
    public function store(Request $request)
    {
        $this->validate($request,[
            'probability' => 'required|numeric|min:0',
            'type' => 'required',
            'value' => 'required',
            'result_text' => 'required',
        ]);
        $store = SpinWheel::create($request->except('_token'));
        if(isset($store))
        {
            return redirect()->back()->with([
                'status' => 'success',
                'message' => 'Thêm thành công'
            ]);
        }
    }
    public function edit($id)
    {
        $spin = SpinWheel::findOrFail($id);
        return view('admin.spin-wheel.edit',compact('spin'));
    }
    public function update(Request $request,$id)
    {
        $this->validate($request,[
            'probability' => 'required|numeric|min:0',
            'type' => 'required',
            'value' => 'required',
            'result_text' => 'required',
        ]);
        $update = SpinWheel::findOrFail($id)->update($request->except('_token'));
        if(isset($update))
        {
            return redirect()->back()->with([
                'status' => 'success',
                'message' => 'Cập nhật vật phẩm thành công'
            ]);
        }
    }
    public function replicate($id)
    {
        $item = SpinWheel::findOrFail($id);
        $newItem = $item->replicate();
        $newItem->save();
        return redirect()->route('admin.events.edit',['id' => $newItem->id])->with([
            'status' => 'success',
            'message' => 'Đã sao chép'
        ]);
    }
    public function delete($id)
    {
        SpinWheel::findOrFail($id)->delete();
        return redirect()->back()->with([
            'status' => 'success',
            'message' => 'Đã xóa'
        ]);
    }
    public function deleteMulti(Request $request)
    {
        if(isset($request->selected))
        {
            foreach(explode(",",$request->selected[0]) as $selected)
            {
                $delete = SpinWheel::findOrFail($selected)->delete();
            }
            if($delete)
            {
                return redirect()->back()->with([
                    'status' => 'success',
                    'message' => 'Đã xóa'
                ]);
            }
        }
    }
}
