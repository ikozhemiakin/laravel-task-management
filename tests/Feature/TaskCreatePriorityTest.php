<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\Project;
use App\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TaskCreatePriorityTest extends TestCase
{
    use RefreshDatabase;

    public function test_create_without_priority_appends_at_end(): void
    {
        $project = Project::query()->create(['name' => 'Work']);

        Task::query()->create([
            'project_id' => $project->id,
            'name' => 'Existing',
            'priority' => 5,
        ]);

        $this->post(route('tasks.store'), [
            'project_id' => $project->id,
            'name' => 'New task',
        ])->assertRedirect(route('tasks.index'));

        $this->assertDatabaseHas('tasks', [
            'name' => 'New task',
            'priority' => 6,
        ]);
    }

    public function test_create_with_priority_shifts_other_tasks_down(): void
    {
        $project = Project::query()->create(['name' => 'Work']);

        Task::query()->create([
            'project_id' => $project->id,
            'name' => 'First',
            'priority' => 1,
        ]);

        Task::query()->create([
            'project_id' => $project->id,
            'name' => 'Second',
            'priority' => 2,
        ]);

        $this->post(route('tasks.store'), [
            'project_id' => $project->id,
            'name' => 'Inserted',
            'priority' => 2,
        ])->assertRedirect(route('tasks.index'));

        $this->assertDatabaseHas('tasks', ['name' => 'Inserted', 'priority' => 2]);
        $this->assertDatabaseHas('tasks', ['name' => 'Second', 'priority' => 3]);
    }
}
