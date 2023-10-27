<?php

namespace App\DTO;

use App\Enum\TaskStatusEnum;
use App\Helpers\RequestHelpers;
use Carbon\CarbonInterface;

class CompleteTaskDTO extends DTO
{
    public function __construct(
        public readonly CarbonInterface $completedAt,
        public readonly TaskStatusEnum $status = TaskStatusEnum::Done,
        public readonly bool $hasTodoTasks = false,
    ) {
    }

    public function toArray(): array
    {
        return RequestHelpers::snakeKeys(get_object_vars($this));
    }
}