<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginUserRequest;
use App\Http\Requests\RegisterUserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function register(RegisterUserRequest $request)
    {
        $data = $request->validated();

        data_set($data, 'password', bcrypt($data['password']));

        $user = User::create($data);

        return response()->json([
            'message'   => 'User registered successfully',
            'user'      => UserResource::make($user),
        ]);
    }

    public function login(LoginUserRequest $request)
    {
        $credentials = $request->only('email', 'password');

        if (!Auth::attempt($credentials)) {
            return response()->json([
                'message' => 'The provided credentials do not match our records.',
            ], 401);
        }

        /** @var User $user */
        $user   = Auth::user();
        $token  = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message'   => 'User logged in successfully',
            'user'      => UserResource::make($user),
            'token'     => $token,
        ]);
    }
}
