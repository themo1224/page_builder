<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthService
{
    public function registerUser(array $data): string
    {
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        return $user->createToken('auth_token')->plainTextToken;
    }

    public function loginUser(array $data): ?string
    {
        $user = User::where('email', $data['email'])->first();

        if (!$user || !Hash::check($data['password'], $user->password)) {
            return null;
        }

        return $user->createToken('auth_token')->plainTextToken;
    }

    public function logoutUser($user): void
    {
        $user->currentAccessToken()->delete();
    }
}
