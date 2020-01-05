<?php

namespace App\Http\Controllers\Admin;

use App\Model\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Tracking;

class UserController extends Controller
{
    public function list()
    {
       $users = User::with('character')->get();
       return view('admin.users.list',compact('users'));
    }
    public function detail($id)
    {
        $detail = User::findOrFail($id)->load(['character','skills','gears','pets','items']);
        $detail->using_skills = $detail->usingSkills();
        $detail->using_gears = $detail->usingGears();
        $detail->using_pet = $detail->usingPets()[0]->class_tag ?? null;
        $detail->tracking = Tracking::where('user_id',$id)->first();
        $detail->level = $detail->nextLevel();
        return view('admin.users.detail',compact('detail'));
    }
}
