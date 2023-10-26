<?php

namespace App\DTO\Concrete;

trait Arrayable
{
    public function toArray(): array
    {
        return get_object_vars($this);
    }
}