<?php

namespace App\Http\Controllers\Admin;

use App\Model\Pusher;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PusherController extends Controller
{
    public function list()
    {
        $pushers = Pusher::all();
        return view('admin.pushers.list',compact('pushers'));
    }
    public function store(Request $request)
    {
        $this->validate($request,[
            'app_id' => 'required|numeric|unique:pushers,app_id',
            'app_key' => 'required|numeric|unique:pushers,app_key',
            'app_secret' => 'required|numeric|unique:pushers,app_secret',
            'cluster' => 'required|numeric|unique:pushers,cluster',
        ]);
        $store = Pusher::create($request->except('_token'));
        if(isset($store))
        {
            return redirect()->back()->with([
                'status' => 'success',
                'message' => 'Thêm pusher thành công'
            ]);
        }
    }
    public function selectPusher($id)
    {
        Pusher::whereSelected(1)->update([
            'selected' => 0
        ]);
        $selectedPusher = Pusher::findOrFail($id)->update([
            'selected' => 1
        ]);
        if(isset($selectedPusher))
        {
            return redirect()->back()->with([
                'status' => 'success',
                'message' => 'Đã chọn'
            ]);
        }
    }
    public function delete($id)
    {
        Pusher::findOrFail($id)->delete();
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
                $delete = Pusher::findOrFail($selected)->delete();
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
