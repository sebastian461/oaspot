<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
  //
  public function login(Request $request)
  {
    if (!Auth::attempt($request->only('email', 'password'))) {
      return response()->json(['message' => 'Unauthorized'], 401);
    }

    $user = User::where('email', $request['email'])->firstOrFail();

    $token = $user->createToken('auth_token')->plainTextToken;

    return response()->json([
      'message' => 'Hi ' . $user->email,
      'accessToken' => $token,
      'token_type' => 'Bearer',
      'user' => $user,
    ]);
  }

  public function logout(Request $request)
  {
    $request->user()->tokens()->delete();

    return [
      'message' => 'You have successfully logged out',
    ];
  }
}
