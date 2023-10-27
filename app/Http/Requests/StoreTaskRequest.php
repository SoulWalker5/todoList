<?php

namespace App\Http\Requests;

use App\Enum\TaskStatusEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreTaskRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return (bool) $this->user();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => ['required', 'string'],
            'description' => ['nullable', 'string'],
            'priority' => ['required', 'integer', 'in:1,2,3,4,5'],
            'parentId' => [
                'nullable',
                'integer',
                Rule::exists('tasks', 'id')
                    ->where('user_id', $this->user()->id)
                    ->where('status', TaskStatusEnum::ToDo),
            ],
        ];
    }
}
