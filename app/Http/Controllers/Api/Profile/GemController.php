<?php

namespace App\Http\Controllers\Api\Profile;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class GemController extends Controller
{
    public function __invoke()
    {
        $gems = Auth::user()->gems->where('pivot.status',0);

        return response()->json($gems, 200);
    }
}
