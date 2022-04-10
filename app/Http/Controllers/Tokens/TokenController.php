<?php

namespace App\Http\Controllers\Tokens;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TokenController extends Controller
{
    public function show(Request $request)
    {
        $user = $request->user();
        $tokens = [];
        foreach ($user->tokens as $token)
        {
            $tokens[$token->created_at->format('M d Y h:i A')] = $token->name;
        }
        return response()->json([
            'tokens' => $tokens,
            'message' => "Don't recognize any of these tokens? contact @kuro_vale",
        ], 200);
    }
}
