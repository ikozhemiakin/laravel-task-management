<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreTaskRequest extends FormRequest
{
    /**
     * Allow all users to create tasks (no auth in this app).
     *
     * @return bool Always true
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Validation rules for storing a task.
     *
     * @return array<string, mixed> Rule set for the validator
     */
    public function rules(): array
    {
        return [
            'project_id' => ['required', 'integer', Rule::exists('projects', 'id')],
            'name' => ['required', 'string', 'max:255'],
            'priority' => ['nullable', 'integer', 'min:1'],
        ];
    }
}
