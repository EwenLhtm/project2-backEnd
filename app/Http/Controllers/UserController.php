<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\UserService;
use App\Http\Requests\UserRequest;
use App\Http\Requests\LoginRequest;

class UserController extends Controller
{
    public function register(UserRequest $request, UserService $userService)
    {
        $data = $request->validated();

        try {
            $newUser = $userService->register($data);

            return response()->json([
                'message' => 'User registered successfully.',
                'user' => $newUser
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to register user.',
                "error" => $e->getMessage()
                ], 500);
        }
    }

    public function login(LoginRequest $request, UserService $userService)
    {
        $data = $request->validated();

        try {
            $token = $userService->login($data);

            if ($token) {
                return response()->json([
                    'message' => 'User logged in successfully.',
                    'token' => $token
                ]);
            } else {
                return response()->json([
                    'message' => 'Invalid credentials.'
                ], 401);
            }
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to log in user.',
                "error" => $e->getMessage()
                ], 500);
        }
    }

    public function logout(Request $request, UserService $userService)
    {
        try {
            $userService->logout($request->user());
            return response()->json([
                'message' => 'User logged out successfully.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to log out user.',
                "error" => $e->getMessage()
                ], 500);
        }
    }
}
