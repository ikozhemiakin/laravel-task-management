<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\Project;
use App\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProjectFilterTest extends TestCase
{
    use RefreshDatabase;

    public function test_empty_project_id_redirects_to_unfiltered_index(): void
    {
        $response = $this->get(route('tasks.index', ['project_id' => '']));

        $response->assertRedirect(route('tasks.index'));
    }

    public function test_tasks_index_can_be_filtered_by_project(): void
    {
        $work = Project::query()->create(['name' => 'Work']);
        $home = Project::query()->create(['name' => 'Home']);

        Task::query()->create(['project_id' => $work->id, 'name' => 'Work task', 'priority' => 1]);
        Task::query()->create(['project_id' => $home->id, 'name' => 'Home task', 'priority' => 1]);

        $response = $this->get(route('tasks.index', ['project_id' => $work->id]));

        $response->assertOk();
        $response->assertSee('Work task');
        $response->assertDontSee('Home task');
    }

    public function test_project_crud(): void
    {
        $create = $this->post(route('projects.store'), ['name' => 'Side project']);
        $create->assertRedirect(route('projects.index'));

        $project = Project::query()->where('name', 'Side project')->firstOrFail();

        $update = $this->put(route('projects.update', $project), ['name' => 'Main project']);
        $update->assertRedirect(route('projects.index'));

        $this->assertDatabaseHas('projects', ['id' => $project->id, 'name' => 'Main project']);

        $delete = $this->delete(route('projects.destroy', $project));
        $delete->assertRedirect(route('projects.index'));

        $this->assertDatabaseMissing('projects', ['id' => $project->id]);
    }
}
