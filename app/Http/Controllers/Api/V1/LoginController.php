<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;


class LoginController extends Controller
{
    public function __invoke(LoginRequest $request)
     {
        if(!auth()->attempt($request->validated())) {
            return response()->json([
                'msg' => 'Login failed'
            ], 400); // 444 => bad request
        }

        $user = $request->user();
         // Create the token
        $tokenResult = $user->createToken('login-token');
        $plainTextToken = $tokenResult->plainTextToken;
        $accessToken = $tokenResult->accessToken;

         // Set the token to expire in 1 day
        $accessToken->expires_at = now()->addDay();
        $accessToken->save();

        $user = $user->only('id', 'name', 'email');

        return response()->json([
            'user_data' => $user,
            'token'=> $plainTextToken,
            'expires_at' => $accessToken->expires_at
        ]);
     }
}
