<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        $device = $request->header('User-Agent');

        if (Auth::attempt($request->only('username', 'password')))
        {
            return response()->json([
                'message' => 'Login successfully',
                'token' => $request->user()->createToken("Token for $device")->plainTextToken,
            ], Response::HTTP_OK);
        }
        else
        {
            return response()->json([
                'message' => 'Invalid credentials'
            ], Response::HTTP_UNAUTHORIZED);
        }
    }
}
