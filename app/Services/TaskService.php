<?php

namespace App\Services;

use App\DTO\TaskDTO;
use App\Models\Task;
use App\Repositories\TaskRepository;

class TaskService
{
    public function __construct(private readonly TaskRepository $repository)
    {
    }

    public function createTask(TaskDTO $dto): Task
    {
        return $this->repository->create($dto->toArray());
    }

    public function updateTask(Task $task, TaskDTO $dto): bool
    {
        return $this->repository->update($task, $dto->toArray());
    }
}