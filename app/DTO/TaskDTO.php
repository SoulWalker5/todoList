<?php

namespace App\DTO;

use App\DTO\Concrete\Arrayable as ArrayableTrait;
use App\Enum\TaskStatusEnum;
use App\Helpers\RequestHelpers;
use Illuminate\Contracts\Support\Arrayable;

class TaskDTO implements Arrayable
{
    use ArrayableTrait;

    public function __construct(
        private readonly string $title,
        private readonly int $priority,
        private readonly int $userId,
        private readonly ?string $description = null,
        private readonly TaskStatusEnum $status = TaskStatusEnum::ToDo,
        private ?int $parentId = null,
    ) {
    }

    public function toArray(): array
    {
        return RequestHelpers::snakeKeys(get_object_vars($this));
    }
}