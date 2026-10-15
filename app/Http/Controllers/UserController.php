<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\UserService;
use App\Http\Requests\UserRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\UserPasswordRequest;

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

    public function getUser(Request $request)
    {
        return response()->json($request->user());
    }

    public function updateProfile(Request $request, UserService $userService)
    {
        $data = $request->only(['name', 'email']);

        try {
            $updatedUser = $userService->updateProfile($request->user(), $data);

            return response()->json([
                'message' => 'User profile updated successfully.',
                'user' => $updatedUser
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to update user profile.',
                "error" => $e->getMessage()
                ], 500);
        }
    }

    public function updatePassword(UserPasswordRequest $request, UserService $userService)
    {
        $data = $request->validated();

        try {
            $user = $request->user();

            // Vérifiez si le mot de passe actuel est correct
            if (!password_verify($data['current_password'], $user->password)) {
                return response()->json([
                    'message' => 'Current password is incorrect.'
                ], 400);
            }

            // Mettez à jour le mot de passe
            $userService->updateProfile($user, ['password' => bcrypt($data['new_password'])]);

            return response()->json([
                'message' => 'Password updated successfully.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to update password.',
                "error" => $e->getMessage()
                ], 500);
        }
    }
}
