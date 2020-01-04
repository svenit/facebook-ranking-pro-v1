<?php

namespace App\Http\Controllers\Admin;

use Exception;
use App\Model\User;
use App\Model\Config;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        $config = Config::first();
        $users = new User;
        $usersActive = User::whereNotNull('provider_id')->count();
        return view('admin.dashboard',compact('config','users','usersActive'));
    }
    public function executeQuery(Request $request)
    {
        if(isset($request->command))
        {
            try
            {
                DB::statement($request->command);
                return redirect()->back()->with([
                    'message' => 'Thành Công',
                    'status' => 'success'
                ]);
            }
            catch(Exception $e)
            {
                return redirect()->back()->with([
                    'message' => $e->getMessage(),
                    'status' => 'error'
                ])->withInput();
            }
        }
        return redirect()->back()->with([
            'message' => 'Không được để trống câu truy vấn',
            'status' => 'error'
        ]);
    }
}
