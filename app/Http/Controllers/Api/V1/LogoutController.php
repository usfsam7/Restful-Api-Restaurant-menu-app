<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LogoutController extends Controller
{
    public function __invoke(Request $request)
    {
        // remove all tokens associated with this user
       $request->user()->tokens()->delete();

       return response()->json([
         'msg'=> 'logged out successfully'
       ]);
    }
}
