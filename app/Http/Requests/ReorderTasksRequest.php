<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ReorderTasksRequest extends FormRequest
{
    /**
     * Allow reorder from the tasks index page.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Validate drag-and-drop payload (ordered task ids).
     */
    public function rules(): array
    {
        return [
            'task_ids' => ['required', 'array', 'min:1'],
            'task_ids.*' => ['integer', Rule::exists('tasks', 'id')],
        ];
    }
}
