<?php

namespace App\Http\Controllers\Api\v1\Inventory;

use App\Model\User;
use App\Income\Helper;
use App\Model\CateGear;
use App\Model\UserGear;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class InventoryController extends Controller
{
    public function __construct()
    {
        return $this->middleware('prevent')->except(['__invoke']);
    }
    public function __invoke()
    {
        $inventories = User::find(Auth::id())->load('gears');
        $cates = CateGear::all();
        $data = [];
        foreach($inventories->gears as $key => $gear)
        {
            foreach($cates as $i => $cate)
            {
                if($gear->cate_gear_id == $cate->id)
                {
                    $data[Str::slug($cate->name)][$key] = $gear;
                }
            }
        }
        return response()->json($data,200);
    }
    public function delete(Request $request)
    {
        $find = UserGear::where([['user_id',Auth::id()],['id',$request->id],['gear_id',$request->gear_id]]);
        if(isset($find))
        {
            $removeGear = $find->delete();
            if(isset($removeGear))
            {
                $this->updatePower();
                $response = [
                    'code' => 200,
                    'status' => 'success',
                    'message' => "Trang bị của bạn đã về với cõi hư vô"
                ];
            }
            else
            {
                $response = [
                    'code' => 500,
                    'status' => 'error',
                    'message' => "Đã có lỗi xảy ra"
                ];
            }
        }
        else
        {
            $response = [
                'code' => 500,
                'status' => 'error',
                'message' => "Không tìm thấy trang bị"
            ];
        }
        return response()->json($response,200);
    }
    public function removeEquipment(Request $request)
    {
        $find = UserGear::where([['user_id',Auth::id()],['id',$request->id],['gear_id',$request->gear_id]]);
        if(isset($find))
        {
            $unWear = $find->update([
                'status' => 0
            ]);
            if(isset($unWear))
            {
                $this->updatePower();
                $response = [
                    'code' => 200,
                    'status' => 'success',
                    'message' => "Tháo trang bị thành công !"
                ];
            }
            else
            {
                $response = [
                    'code' => 500,
                    'status' => 'error',
                    'message' => "Đã có lỗi xảy ra"
                ];
            }
        }
        else
        {
            $response = [
                'code' => 500,
                'status' => 'error',
                'message' => "Không tìm thấy trang bị"
            ];
        }
        return response()->json($response,200);
    }
    public function equipment(Request $request)
    {
        $all =  UserGear::with('gear')->where([['user_id',Auth::id()],['status',1]])->get(); 
        $find = UserGear::where([['user_id',Auth::id()],['id',$request->id],['gear_id',$request->gear_id]])->first();
        if(isset($find) && $find->status == 0)
        {
            if($find->load('gear')->gear->character_id == Auth::user()->character->id)
            {
                if($find->load('gear')->gear->level_required <= Auth::user()->level())
                {
                    foreach($all as $key => $each)
                    {
                        if($each->gear->cate_gear_id == $find->load('gear')->gear->cate_gear_id)
                        {
                            Auth::user()->gears()->updateExistingPivot($each->gear->id,[
                                'status' => 0
                            ],false);
                        }
                    }
                    $wear = UserGear::findOrFail($find->id)->update([
                        'status' => 1
                    ]);
                    if(isset($wear))
                    {
                        $this->updatePower();
                        $response = [
                            'code' => 200,
                            'status' => 'success',
                            'message' => "Đã trang bị ".$find->load('gear')->gear->name." thành công !"
                        ];
                    }
                    else
                    {
                        $response = [
                            'code' => 500,
                            'status' => 'success',
                            'message' => "Đã có lỗi xảy ra"
                        ];
                    }
                }
                else
                {
                    $response = [
                        'code' => 500,
                        'status' => 'success',
                        'message' => "Bạn chưa đủ cấp độ để sử dụng vật phẩm này"
                    ];
                }
            }
            else
            {
                $response = [
                    'code' => 500,
                    'status' => 'success',
                    'message' => "Bạn không thể sử dụng vật phấm của lớp khác"
                ];
            }
        }
        else
        {
            $response = [
                'code' => 500,
                'status' => 'success',
                'message' => "Vật phẩm không tồn tại hoặc đã được trang bị"
            ];
        }
        return response()->json($response,200);
    }
}
