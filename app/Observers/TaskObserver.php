<?php

namespace App\Observers;

use App\Models\Task;

class TaskObserver
{
    /**
     * Handle the Task "created" event.
     */
    public function creating(Task $task): void
    {
        if ($task->parent_id) {
            $task->parent->update(['has_todo_tasks' => true]);
        }
    }

    /**
     * Handle the Task "updating" event.
     */
    public function updating(Task $task): void
    {
        if ($task->isDirty('status') && $task->parent_id) {
            $task->parent->update(['has_todo_tasks' => false]);
        }
    }
}
