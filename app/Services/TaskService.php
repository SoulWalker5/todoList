<?php

namespace App\Services;

use App\DTO\DTO;
use App\Models\Task;
use App\Repositories\TaskRepository;

class TaskService
{
    public function __construct(private readonly TaskRepository $repository)
    {
    }

    public function createTask(DTO $dto): Task
    {
        return $this->repository->create($dto->toArray());
    }

    public function updateTask(Task $task, DTO $dto): bool
    {
        return $this->repository->update($task, $dto->toArray());
    }
}