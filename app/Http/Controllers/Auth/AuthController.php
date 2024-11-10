<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Services\AuthService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    protected AuthService $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function register(RegisterRequest $request): JsonResponse
    {
        $data = $request->validated();

        $token = $this->authService->registerUser($data);

        return response()->json([
            'token' => $token,
            'message' => 'Registration successful',
        ], 201);
    }

    public function login(LoginRequest $request): JsonResponse
    {
        $data = $request->validated();
        $token = $this->authService->loginUser($data);

        if (!$token) {
            return response()->json([
                'message' => 'Invalid credentials',
            ], 401);
        }

        return response()->json([
            'token' => $token,
            'message' => 'Login successful',
        ], 200);
    }

    public function logout(Request $request): JsonResponse
    {
        $this->authService->logoutUser($request->user());

        return response()->json([
            'message' => 'Logged out successfully',
        ]);
    }
}
