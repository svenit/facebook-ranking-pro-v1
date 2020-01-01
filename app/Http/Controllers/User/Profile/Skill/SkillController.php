<?php

namespace App\Http\Controllers\User\Profile\Skill;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SkillController extends Controller
{
    public function index()
    {
        return view('user.profile.skill');
    }
}
