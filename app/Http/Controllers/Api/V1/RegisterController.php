<?php

namespace App\Http\Controllers\Api\V1;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Models\User;


class RegisterController extends Controller
{
   public function __invoke(RegisterRequest $request)
   {


    // check if the required data inserted or not
    if (!$request->has("name") && !$request->has("email") && !$request->has("password") && !$request->has("password_confirmation")) {
     {
        return response()->json( ['msg' => 'Missing Credentials']);
     }
    }

    $user = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password),
    ]);

    // Create the token
    $tokenResult = $user->createToken('signup-token');
    $plainTextToken = $tokenResult->plainTextToken;
    $accessToken = $tokenResult->accessToken;

    // Set the token to expire in 1 day
    $accessToken->expires_at = now()->addDay();
    $accessToken->save();

    $user = $user->only('id', 'name', 'email');

    // Return response
    return response()->json([
        'user_data' => $user,
        'token' => $plainTextToken,
        'expires_at' => $accessToken->expires_at,
    ], 201);
   }
}
