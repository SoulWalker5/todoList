<?php

namespace App\Http\Controllers\Api\v1;

use App\DTO\CompleteTaskDTO;
use App\DTO\TaskDTO;
use App\DTO\TaskFilteringDTO;
use App\Enum\TaskStatusEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\CompleteTaskRequest;
use App\Http\Requests\DeleteTaskRequest;
use App\Http\Requests\IndexTaskRequest;
use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Http\Resources\TaskResource;
use App\Models\Task;
use App\Services\TaskService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Response;

class TaskController extends Controller
{
    public function __construct(private readonly TaskService $taskService)
    {
    }

    /**
     * Display a listing of the resource.
     */
    public function index(IndexTaskRequest $request): AnonymousResourceCollection
    {
        $data['status'] = $request->input('status') ? TaskStatusEnum::from($request->input('status')) : null;

        $tasks = $this->taskService->buildTasksTree(
            $request->user(),
            new TaskFilteringDTO(...$data + $request->validated())
        );

        return TaskResource::collection($tasks);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTaskRequest $request): JsonResource
    {
        $task = $this->taskService->createTask(
            new TaskDTO(
                ...$request->validated() + ['userId' => $request->user()->id]
            )
        );

        return new TaskResource($task);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTaskRequest $request, Task $task): JsonResource
    {
        $this->taskService->updateTask(
            $task,
            new TaskDTO(...$request->validated() + ['userId' => $request->user()->id])
        );

        return new TaskResource($task);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function complete(CompleteTaskRequest $request, Task $task): JsonResponse
    {
        if (!$this->taskService->canBeCompleted($task)) {
            return new JsonResponse(['message' => 'This task cannot be completed'], Response::HTTP_FORBIDDEN);
        }

        $this->taskService->updateTask($task, new CompleteTaskDTO(now()));

        return new JsonResponse(['message' => 'Completed successfully']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DeleteTaskRequest $request, Task $task): JsonResponse
    {
        $this->taskService->deleteTask($task);

        return new JsonResponse(['message' => 'Deleted successfully']);
    }
}
