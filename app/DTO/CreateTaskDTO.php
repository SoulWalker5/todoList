<?php

namespace App\DTO;

use App\Enum\TaskStatusEnum;
use App\Helpers\RequestHelpers;
use App\Models\User;

class CreateTaskDTO extends DTO
{
    public readonly User $user;

    public function __construct(
        public readonly string $title,
        public readonly int $priority,
        public readonly int $userId,
        public readonly ?string $description = null,
        public readonly ?TaskStatusEnum $status = null,
        public readonly ?int $parentId = null,
    ) {
    }

    public function toArray(): array
    {
        return RequestHelpers::snakeKeys(get_object_vars($this));
    }
}