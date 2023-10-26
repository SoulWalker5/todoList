<?php

namespace App\Services;

use App\DTO\LoginDTO;
use App\DTO\TokenDTO;
use App\Exceptions\LoginException;
use Illuminate\Support\Facades\Auth;

class LoginService
{
    /** @throws LoginException */
    public function login(LoginDTO $dto): TokenDTO
    {
        if (!Auth::attempt($dto->toArray())) {
            throw new LoginException();
        }

        $expireAt = now()->addMinutes(config('sanctum.expiration'));

        return new TokenDTO(Auth::user()->createToken(name: 'main', expiresAt: $expireAt), $expireAt);
    }
}