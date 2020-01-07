<?php

namespace App\Http\Controllers\Admin;

use App\Model\Pet;
use App\Model\Gear;
use App\Model\Item;
use App\Model\User;
use App\Model\Skill;
use App\Model\UserPet;
use App\Model\Tracking;
use App\Model\UserGear;
use App\Model\UserItem;
use App\Model\Character;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Notifications\Admin\Broadcast;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function list()
    {
       $users = User::with('character')->get();
       return view('admin.users.list',compact('users'));
    }
    public function detail($id)
    {
        $detail = User::findOrFail($id);
        $detail->using_skills = $detail->usingSkills();
        $detail->using_gears = $detail->usingGears();
        $detail->using_pet = $detail->usingPets()[0]->class_tag ?? null;
        $detail->gears = $detail->gears->load('character');
        $detail->tracking = Tracking::where('user_id',$id)->first();
        $detail->level = $detail->nextLevel();

        $characters = Character::all();
        $gears = Gear::all()->load('character');
        $skills = Skill::whereNotIn('id',$detail->skills->pluck('id'))->get();
        $pets = Pet::all();
        $items = Item::all();

        return view('admin.users.detail',compact('detail','characters','gears','skills','pets','items'));
    }
    public function edit(Request $request,$id)
    {
        $update = User::findOrFail($id)->update($request->except('_token'));
        if(isset($update))
        {
            return redirect()->back()->with([
                'status' => 'success',
                'message' => 'OK'
            ]);
        }
        else
        {
            return redirect()->back()->with([
                'status' => 'error',
                'message' => 'Đã có lỗi xảy ra'
            ]);
        }
    }
    public function addGear(Request $request,$id)
    {
        User::findOrFail($id)->gears()->attach($request->gears,[
            'status' => 0
        ]);
        return redirect()->back()->with([
            'status' => 'success',
            'message' => 'Thành Công'
        ]);
    }
    public function removeGear($id,$gearId,$userId)
    {
        UserGear::where([['id',$id],['gear_id',$gearId],['user_id',$userId]])->delete();
        return redirect()->back()->with([
            'status' => 'success',
            'message' => 'Thành Công'
        ]);
    }
    public function addSkill(Request $request,$id)
    {
        User::findOrFail($id)->skills()->attach($request->skills,[
            'status' => 0
        ]);
        return redirect()->back()->with([
            'status' => 'success',
            'message' => 'Thành Công'
        ]);
    }
    public function removeSkill($skillId,$userId)
    {
        User::findOrFail($userId)->skills()->detach($skillId);
        return redirect()->back()->with([
            'status' => 'success',
            'message' => 'Thành Công'
        ]);
    }
    public function addPet(Request $request,$id)
    {
        User::findOrFail($id)->pets()->attach($request->pets,[
            'status' => 0
        ]);
        return redirect()->back()->with([
            'status' => 'success',
            'message' => 'Thành Công'
        ]);
    }
    public function removePet($id,$petId,$userId)
    {
        UserPet::where([['id',$id],['pet_id',$petId],['user_id',$userId]])->delete();
        return redirect()->back()->with([
            'status' => 'success',
            'message' => 'Thành Công'
        ]);
    }
    public function addItem(Request $request,$id)
    {
        $findItem = UserItem::where([['user_id',Auth::id()],['item_id',$request->item]])->first();
        if(isset($findItem))
        {
            User::findOrFail($id)->items()->updateExistingPivot($request->item,[
                'quantity' => DB::raw("quantity + $request->quantity")
            ]);
        }
        else
        {
            User::findOrFail($id)->items()->attach($request->item,[
                'quantity' => $request->quantity
            ]);
        }
        return redirect()->back()->with([
            'status' => 'success',
            'message' => 'Thành Công'
        ]);
    }
    public function removeItem($id,$itemId,$userId)
    {
        UserItem::where([['id',$id],['item_id',$itemId],['user_id',$userId]])->delete();
        return redirect()->back()->with([
            'status' => 'success',
            'message' => 'Thành Công'
        ]);
    }
    public function sendMessage(Request $request,$id)
    {
        $this->validate($request,[
            'message' => 'required',
            'title' => 'required'
        ]);
        User::findOrFail($id)->notify(new Broadcast([
            'message' => $request->message,
            'title' => $request->title,
            'user_id' => Auth::user()->user_id,
            'name' => Auth::user()->name
        ]));
        return redirect()->back()->with([
            'status' => 'success',
            'message' => 'Gửi tin nhắn thành công'
        ]);
    }
}
