<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\Project;
use App\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TaskCrudTest extends TestCase
{
    use RefreshDatabase;

    public function test_task_can_be_created(): void
    {
        $project = Project::query()->create(['name' => 'Work']);

        $response = $this->post(route('tasks.store'), [
            'project_id' => $project->id,
            'name' => 'Deploy release',
        ]);

        $response->assertRedirect(route('tasks.index'));
        $this->assertDatabaseHas('tasks', [
            'project_id' => $project->id,
            'name' => 'Deploy release',
            'priority' => 1,
        ]);
    }

    public function test_task_can_be_updated(): void
    {
        $project = Project::query()->create(['name' => 'Work']);
        $task = Task::query()->create([
            'project_id' => $project->id,
            'name' => 'Old name',
            'priority' => 1,
        ]);

        $response = $this->put(route('tasks.update', $task), [
            'project_id' => $project->id,
            'name' => 'New name',
        ]);

        $response->assertRedirect(route('tasks.index'));
        $this->assertDatabaseHas('tasks', [
            'id' => $task->id,
            'name' => 'New name',
            'priority' => 1,
        ]);
    }

    public function test_changing_project_keeps_priority(): void
    {
        $work = Project::query()->create(['name' => 'Work']);
        $home = Project::query()->create(['name' => 'Home']);

        $task = Task::query()->create([
            'project_id' => $work->id,
            'name' => 'Move me',
            'priority' => 1,
        ]);

        Task::query()->create([
            'project_id' => $home->id,
            'name' => 'Other',
            'priority' => 2,
        ]);

        $this->put(route('tasks.update', $task), [
            'project_id' => $home->id,
            'name' => 'Move me',
        ])->assertRedirect(route('tasks.index'));

        $this->assertDatabaseHas('tasks', [
            'id' => $task->id,
            'project_id' => $home->id,
            'priority' => 1,
        ]);
    }

    public function test_task_can_be_deleted(): void
    {
        $project = Project::query()->create(['name' => 'Work']);
        $task = Task::query()->create([
            'project_id' => $project->id,
            'name' => 'Remove me',
            'priority' => 1,
        ]);

        $response = $this->delete(route('tasks.destroy', $task));

        $response->assertRedirect(route('tasks.index'));
        $this->assertDatabaseMissing('tasks', ['id' => $task->id]);
    }
}
