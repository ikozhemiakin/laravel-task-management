<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreProjectRequest extends FormRequest
{
    /**
     * Allow all users to create projects.
     *
     * @return bool Always true
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Validation rules for storing a project.
     *
     * @return array<string, mixed> Rule set for the validator
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255', Rule::unique('projects', 'name')],
        ];
    }
}
