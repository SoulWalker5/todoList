<?php

namespace App\Services;

use App\DTO\DTO;
use App\DTO\TaskFilteringDTO;
use App\Models\Task;
use App\Models\User;
use App\Repositories\TaskRepository;

class TaskService
{
    public function __construct(private readonly TaskRepository $repository)
    {
    }

    public function buildTasksTree(User $user, TaskFilteringDTO $dto)
    {
        $tasks = $this->repository->getUserParentTasks($user, $dto);

        return $tasks->each(function (Task $task) {
            $this->loadNestedTasks($task);
        });
    }


    public function loadNestedTasks(Task $task): void
    {
        $task->loadMissing('children');
        $task->children->each(function (Task $task) {
            if ($task->parent_id === null) {
                return;
            }

            $this->loadNestedTasks($task);
        });
    }

    public function canBeCompleted(Task $task): bool
    {
        if ($task->has_todo_tasks) {
            return false;
        }

        $this->loadNestedTasks($task);

        if ($task->children->isEmpty()) {
            return true;
        }

        $canBeCompleted = true;

        $task->children->each(function (Task $task) use (&$canBeCompleted) {
            $canBeCompleted &= $this->canBeCompleted($task);
        });

        return $canBeCompleted;
    }

    public function createTask(DTO $dto): Task
    {
        return $this->repository->create($dto);
    }

    public function updateTask(Task $task, DTO $dto): bool
    {
        return $this->repository->update($task, $dto);
    }

    public function deleteTask(Task $task): bool
    {
        return $this->repository->delete($task);
    }
}