<?php

namespace App\DTO;

use App\Enum\TaskStatusEnum;

class TaskFilteringDTO
{
    public function __construct(
        public readonly ?TaskStatusEnum $status = null,
        public readonly ?int $priority = null,
        public readonly ?string $description = null,
        public readonly ?string $title = null,
        public readonly ?array $sorting = null
    ) {
    }
}