<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\Project;
use App\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TaskListSortTest extends TestCase
{
    use RefreshDatabase;

    public function test_tasks_are_sorted_by_priority_within_filtered_project(): void
    {
        $project = Project::query()->create(['name' => 'Work']);

        Task::query()->create(['project_id' => $project->id, 'name' => 'Third', 'priority' => 3]);
        Task::query()->create(['project_id' => $project->id, 'name' => 'First', 'priority' => 1]);
        Task::query()->create(['project_id' => $project->id, 'name' => 'Second', 'priority' => 2]);

        $tasks = Task::query()->forProject($project->id)->ordered()->get();

        $this->assertSame(['First', 'Second', 'Third'], $tasks->pluck('name')->all());
        $this->assertSame([1, 2, 3], $tasks->pluck('priority')->all());
    }
}
