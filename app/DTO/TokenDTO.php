<?php

namespace App\DTO;

use Carbon\CarbonInterface;
use Laravel\Sanctum\NewAccessToken;

class TokenDTO extends DTO
{
    public function __construct(public readonly NewAccessToken $token, public readonly CarbonInterface $expiresAt)
    {
    }

    public function toArray(): array
    {
        return [
            'token' => $this->token->plainTextToken,
            'expiresAt' => $this->expiresAt,
        ];
    }
}