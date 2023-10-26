<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateTaskRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user() && $this->task->user_id === $this->user()->id && $this->task->isNotDone();
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
            'priority' => ['required', 'in:1,2,3,4,5'],
            'parentId' => [
                'nullable',
                Rule::exists('tasks', 'parent_id')->where('user_id', $this->user()->id),
            ],
        ];
    }
}
