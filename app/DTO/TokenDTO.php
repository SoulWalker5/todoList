<?php

namespace App\DTO;

use App\DTO\Concrete\Arrayable as ArrayableTrait;
use Carbon\CarbonInterface;
use Illuminate\Contracts\Support\Arrayable;
use Laravel\Sanctum\NewAccessToken;

class TokenDTO implements Arrayable
{
    use ArrayableTrait;
    public function __construct(private readonly NewAccessToken $token, private readonly CarbonInterface $expiresAt)
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