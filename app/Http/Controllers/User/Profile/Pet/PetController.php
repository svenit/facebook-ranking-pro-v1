<?php

namespace App\Http\Controllers\User\Profile\Pet;

use App\Model\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class PetController extends Controller
{
    public function index()
    {
        return view('user.profile.pet');
    }
}
