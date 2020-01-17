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
            'id' => 'required|numeric|exists:user_items,id'
        ]);
        if($validate->fails())
        {
            return response()->json([
                'code' => 500,
                'status' => 'error',
                'message' => 'Vật phẩm không tồn tại'
            ],200);
        }
        else
        {
            $userItem = UserItem::where([['id',$request->id],['item_id',$request->item_id],['user_id',Auth::id()]])->first();
            if(isset($userItem))
            {
                if($userItem->quantity >= 1)
                {
                    if(isset($userItem->item->query))
                    {
                        $this->removeItem($userItem);
                        if($userItem->item->success_rate >= rand(0,100))
                        {
                            $queries = explode('^',$userItem->item->query);
                            foreach($queries as $query)
                            {
                                $exec = DB::statement($this->replaceStatement($query));
                            }
                            if(isset($exec))
                            {
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
                                    'code' => 500,
                                    'status' => 'error',
                                    'message' => 'Đã có lỗi xảy ra'
                                ];
                            }
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
                    else
                    {
                        $response = [
                            'code' => 200,
                            'status' => 'success',
                            'message' => 'OK'
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
    public function removeItem($item)
    {
        if($item->quantity == 1)
        {
            Auth::user()->items()->detach($item->item_id);
        }
        else
        {
            Auth::user()->items()->updateExistingPivot($item->item_id,[
                'quantity' => DB::raw('quantity - 1')
            ]);
        }
    }
    public function delete(Request $request)
    {
        $userItem = UserItem::where([['id',$request->id],['item_id',$request->item_id],['user_id',Auth::id()]])->first();
        if(isset($userItem))
        {
            $this->removeItem($userItem);
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
