<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\Models\Project;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateProjectRequest extends FormRequest
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
     * Validation rules for updating a project.
     *
     * @return array<string, mixed> Rule set for the validator
     */
    public function rules(): array
    {
        /** @var Project $project */
        $project = $this->route('project');

        return [
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('projects', 'name')->ignore($project->id),
            ],
        ];
    }
}
