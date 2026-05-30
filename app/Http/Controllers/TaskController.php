<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Actions\Task\CreateTaskAction;
use App\Actions\Task\ReorderTasksAction;
use App\Http\Requests\ReorderTasksRequest;
use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\TasksIndexRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Models\Project;
use App\Models\Task;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class TaskController extends Controller
{
    public function index(TasksIndexRequest $request): View|RedirectResponse
    {
        if ($request->has('project_id') && ! $request->filled('project_id')) {
            return redirect()->route('tasks.index');
        }
        $projectId = $request->projectId();
        $tasks = Task::query()
            ->with('project')
            ->forProject($projectId)
            ->ordered()
            ->get();

        return view('tasks.index', [
            'tasks' => $tasks,
            'projects' => Project::orderedList(),
            'selectedProjectId' => $projectId,
            'reorderUrl' => route('tasks.reorder'),
        ]);
    }

    public function create(): View|RedirectResponse
    {
        $projects = Project::orderedList();

        if ($projects->isEmpty()) {
            return redirect()
                ->route('projects.create')
                ->with('warning', 'Create a project before adding tasks.');
        }

        return view('tasks.create', compact('projects'));
    }

    public function store(StoreTaskRequest $request, CreateTaskAction $createTask): RedirectResponse
    {
        $createTask->handle($request->validated());

        return redirect()
            ->route('tasks.index')
            ->with('success', 'Task created.');
    }

    public function edit(Task $task): View
    {
        return view('tasks.edit', [
            'task' => $task,
            'projects' => Project::orderedList(),
        ]);
    }

    public function update(UpdateTaskRequest $request, Task $task): RedirectResponse
    {
        $task->update($request->validated());

        return redirect()
            ->route('tasks.index')
            ->with('success', 'Task updated.');
    }

    public function destroy(Task $task): RedirectResponse
    {
        $task->delete();

        return redirect()
            ->route('tasks.index')
            ->with('success', 'Task deleted.');
    }

    public function reorder(ReorderTasksRequest $request, ReorderTasksAction $reorderTasks): JsonResponse
    {
        /** @var array<int> $taskIds */
        $taskIds = $request->validated('task_ids');

        $reorderTasks->handle($taskIds);

        return response()->json(['message' => 'Order saved.']);
    }
}
