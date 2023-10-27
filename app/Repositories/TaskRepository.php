<?php

namespace App\Repositories;

use App\DTO\DTO;
use App\DTO\TaskFilteringDTO;
use App\Models\Task;
use App\Models\User;
use Illuminate\Contracts\Database\Query\Builder;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class TaskRepository
{
    /** @return Collection<Task> */
    public function getUserParentTasks(User $user, TaskFilteringDTO $dto): Collection
    {
        return $user->tasks()
            ->when($dto->status, function (Builder $query) use ($dto) {
                $query->where('status', $dto->status);
            })
            ->when($dto->priority, function (Builder $query) use ($dto) {
                $query->where('priority', $dto->priority);
            })
            ->when($dto->title, function (Builder $query) use ($dto) {
                $query->where('title', 'LIKE', "%$dto->title%");
            })
            ->when($dto->description, function (Builder $query) use ($dto) {
                $query->where('description', 'LIKE', "%$dto->description%");
            })
            ->when($dto->sorting, function (Builder $query) use ($dto){
                array_map(function ($item) use ($query) {
                    $query->orderBy(Str::snake($item['column']), $item['direction']);
                }, $dto->sorting);
            })
            ->get();
    }

    public function create(DTO $dto): Task
    {
        return Task::create($dto->toArray());
    }

    public function update(Task $task, DTO $dto): bool
    {
        return $task->update($dto->toArray());
    }

    public function delete(Task $task): bool
    {
        return $task->delete();
    }
}