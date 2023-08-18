<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function signIn(Request $request): JsonResponse
    {
        if (
            Auth::attempt(
                $request->only(['email', 'password'])
            )
        ) {
            return response()->json([
                'user' => Auth::user(),
                'token' => Auth::user()->createToken('api-token'),
            ], 201);
        }

        return response()->json(
            ['message' => 'Os dados informados não conferem'], 
            Response::HTTP_UNAUTHORIZED
        );
    }

    public function logout(): JsonResponse
    {   
        $user = Auth::user();
        $user->currentAccessToken()->delete();

        return response()->json('', Response::HTTP_NO_CONTENT);
    }
}
