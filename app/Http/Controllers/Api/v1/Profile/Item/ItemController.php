<?php

namespace App\Http\Controllers\Api\v1\Profile\Item;

use App\Model\UserItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ItemController extends Controller
{
    public function __construct()
    {
        return $this->middleware('prevent.api')->except(['__invoke']);
    }
    public function __invoke()
    {
        return response()->json(Auth::user()->items,200);
    }
    public function use(Request $request)
    {
        $validate = Validator::make($request->all(),[
            'item_id' => 'required|numeric|exists:items,id',
            'id' => 'required|numeric|exists:user_items,id',
            'quantity' => 'required|numeric|between:0,20'
        ],[
            'quantity.between' => 'Số lượng nhập chỉ được từ 0 - 20 cho mỗi lượt'
        ]);
        if($validate->fails())
        {
            return response()->json([
                'code' => 500,
                'status' => 'error',
                'message' => $validate->errors()->first()
            ],200);
        }
        else
        {
            $userItem = UserItem::where([['id',$request->id],['item_id',$request->item_id],['user_id',Auth::id()]])->first();
            if(isset($userItem))
            {
                if($userItem->quantity >= 1)
                {
                    if($userItem->quantity >= $request->quantity)
                    {
                        if(isset($userItem->item->query))
                        {
                            $this->removeItem($userItem, $request->quantity);
                            for($i = 0; $i < $request->quantity; $i++)
                            {
                                if($userItem->item->success_rate >= rand(0,100))
                                {
                                    $queries = explode('^',$userItem->item->query);
                                    foreach($queries as $query)
                                    {
                                        $exec = DB::statement($this->replaceStatement($query));
                                    }      
                                    $this->updatePower();
                                    $response = [
                                        'code' => 200,
                                        'status' => 'success',
                                        'message' => "Sử dụng ".$userItem->item->name." thành công"
                                    ];
                                }
                                else
                                {
                                    $response = [
                                        'code' => 200,
                                        'status' => 'success',
                                        'message' => 'Sử dụng vật phẩm thất bại :('
                                    ];
                                }
                            }
                        }
                        else
                        {
                            $response = [
                                'code' => 500,
                                'status' => 'error',
                                'message' => 'Sử dụng vật phẩm thất bại :('
                            ];
                        }
                    }
                    else
                    {
                        $response = [
                            'code' => 500,
                            'status' => 'error',
                            'message' => 'Số lượng vật phẩm không đủ'
                        ];
                    }
                }
                else
                {
                    $response = [
                        'code' => 500,
                        'status' => 'error',
                        'message' => 'Vật phẩm không tồn tại'
                    ];
                }
            }
            else
            {
                $response = [
                    'code' => 500,
                    'status' => 'error',
                    'message' => 'Vật phẩm không tồn tại'
                ];
            }
            return response()->json($response,200);
        }
    }
    public function removeItem($item, $quantity)
    {
        if($item->quantity == 1 || $item->quantity == $quantity)
        {
            $item->delete();
        }
        else
        {
            $item->decrement('quantity', $quantity);
        }
    }
    public function delete(Request $request)
    {
        $userItem = UserItem::where([['id',$request->id],['item_id',$request->item_id],['user_id',Auth::id()]])->first();
        if(isset($userItem))
        {
            $this->removeItem($userItem, 1);
            $response = [
                'code' => 200,
                'status' => 'success',
                'message' => 'Đã vứt bỏ vật phẩm'
            ];
        }
        else
        {
            $response = [
                'code' => 500,
                'status' => 'error',
                'message' => 'Vật phẩm không tồn tại'
            ];
        }
        return response()->json($response,200);
    }
    public function deleteAll(Request $request)
    {
        $userItem = UserItem::where([['id',$request->id],['item_id',$request->item_id],['user_id',Auth::id()]])->first();
        if(isset($userItem))
        {
            Auth::user()->items()->detach($userItem->item_id);
            $response = [
                'code' => 200,
                'status' => 'success',
                'message' => 'Đã vứt bỏ hết vật phẩm này'
            ];
        }
        else
        {
            $response = [
                'code' => 500,
                'status' => 'error',
                'message' => 'Vật phẩm không tồn tại'
            ];
        }
        return response()->json($response,200);
    }
}
