<?php

namespace App\Http\Requests;

use App\Enum\TaskStatusEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class IndexTaskRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'status' => ['nullable', new Enum(TaskStatusEnum::class)],
            'priority' => ['nullable', 'in:1,2,3,4,5'],
            'description' => ['nullable', 'string'],
            'title' => ['nullable', 'string'],
            'sorting' => ['nullable', 'array'],
            'sorting.*.direction' => ['required_with:sorting,sorting.*.column', 'in:asc,desc',],
            'sorting.*.column' => ['required_with:sorting,sorting.*.direction', 'in:createdAt,completedAt,priority'],
        ];
    }
}
