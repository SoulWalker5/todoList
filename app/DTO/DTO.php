<?php

namespace App\DTO;

use App\DTO\Concrete\Arrayable as ArrayableTrait;
use Illuminate\Contracts\Support\Arrayable;

abstract class DTO implements Arrayable
{
    use ArrayableTrait;
}