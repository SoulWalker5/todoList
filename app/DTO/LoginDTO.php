<?php

namespace App\DTO;

use App\DTO\Concrete\Arrayable as ArrayableTrait;
use Illuminate\Contracts\Support\Arrayable;

class LoginDTO implements Arrayable
{
    use ArrayableTrait;
    public function __construct(private readonly string $email, private readonly string $password)
    {
    }
}