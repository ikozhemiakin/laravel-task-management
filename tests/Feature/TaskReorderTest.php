<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\Project;
use App\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TaskReorderTest extends TestCase
{
    use RefreshDatabase;

    public function test_reorder_sets_priorities_one_two_three_in_list_order(): void
    {
        $project = Project::query()->create(['name' => 'Work']);

        $first = Task::query()->create([
            'project_id' => $project->id,
            'name' => 'First',
            'priority' => 2,
        ]);

        $second = Task::query()->create([
            'project_id' => $project->id,
            'name' => 'Second',
            'priority' => 15,
        ]);

        $this->patchJson(route('tasks.reorder'), [
            'task_ids' => [$second->id, $first->id],
        ])->assertOk();

        $this->assertDatabaseHas('tasks', ['id' => $second->id, 'priority' => 1]);
        $this->assertDatabaseHas('tasks', ['id' => $first->id, 'priority' => 2]);
    }

    public function test_tasks_index_sorts_by_priority_globally(): void
    {
        $home = Project::query()->create(['name' => 'Home']);
        $work = Project::query()->create(['name' => 'Work']);

        Task::query()->create(['project_id' => $home->id, 'name' => 'Home P2', 'priority' => 2]);
        Task::query()->create(['project_id' => $work->id, 'name' => 'Work P1', 'priority' => 1]);
        Task::query()->create(['project_id' => $home->id, 'name' => 'Home P3', 'priority' => 3]);

        $names = Task::query()->forProject(null)->ordered()->pluck('name')->all();

        $this->assertSame(['Work P1', 'Home P2', 'Home P3'], $names);
    }

    public function test_reorder_rejects_invalid_task_ids(): void
    {
        $response = $this->patchJson(route('tasks.reorder'), [
            'task_ids' => [99999],
        ]);

        $response->assertInvalid(['task_ids.0']);
    }
}
