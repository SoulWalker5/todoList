<?php

namespace App\DTO;


class LoginDTO extends DTO
{
    public function __construct(public readonly string $email, public readonly string $password)
    {
    }
}