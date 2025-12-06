<?php

namespace App\Services;

use App\Http\Resources\Api\UserResource;
use App\Models\User;
use App\Trait\ApiResonseTrait;

class AuthService {

    use ApiResonseTrait;


    public function attemptLogin(array $data): ?User
    {
        return $user = User::query()->card()->with('city')
            ->where('phone' , $data['phone'])
            ->first();
    }

    public function generateToken(User $user): string
    {
        return $user->createToken('auth_token')->plainTextToken;
    }




}
