<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class TasksIndexRequest extends FormRequest
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

    public function rules(): array
    {
        return [
            'project_id' => ['nullable', 'integer', Rule::exists('projects', 'id')],
        ];
    }

    public function projectId(): ?int
    {
        return $this->filled('project_id') ? $this->integer('project_id') : null;
    }
}
