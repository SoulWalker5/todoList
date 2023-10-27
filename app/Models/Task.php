<?php

namespace App\Models;

use App\Enum\TaskStatusEnum;
use Carbon\CarbonInterface;
use Illuminate\Contracts\Database\Query\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 * @property int $user_id
 * @property int $parent_id
 * @property string $title
 * @property string|null $description
 * @property TaskStatusEnum $status
 * @property int $priority
 * @property CarbonInterface $completed_at
 */
class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'parent_id',
        'title',
        'description',
        'status',
        'priority',
        'completed_at',
        'has_todo_tasks',
    ];

    protected $casts = [
        'has_todo_tasks' => 'boolean',
        'completed_at' => 'datetime',
        'status' => TaskStatusEnum::class,
    ];

    public function children(): HasMany
    {
        return $this->hasMany(Task::class, 'parent_id');
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(Task::class, 'parent_id');
    }

    public function isNotDone(): bool
    {
        return $this->status === TaskStatusEnum::ToDo;
    }

    public function scopeParentOnly(Builder $builder): Builder
    {
        return $builder->whereNull('parent_id');
    }
}
