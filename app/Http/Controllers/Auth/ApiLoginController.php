<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ApiLoginController extends Controller
{
    use authenticatesUsers;

    public function login(Request $request): JsonResponse
    {
        $this->validateLogin($request);

        if ($this->attemptLogin($request)) {
            $user = $this->guard()->user();
            $token = $user->createToken('apiToken')->plainTextToken;

            return response()->json([
                'token' => $token,
                'user' => new UserResource($user),
            ]);
        }

        return response()->json([
            'message' => 'Invalid login details',
        ], 401);
    }
}
