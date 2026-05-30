@extends('layouts.app')

@section('title', 'Tasks')

@section('content')
    <x-page-header
        title="Tasks"
        description="Manage work across projects. Lower priority number appears higher in the list."
    >
        <x-slot:actions>
            <x-button tag="a" :href="route('tasks.create')">New task</x-button>
        </x-slot:actions>
    </x-page-header>

    <form method="get" action="{{ route('tasks.index') }}" class="filter-panel">
        <label for="project_id" class="form-label">Filter by project</label>
        <div class="filter-toolbar">
            <div class="filter-toolbar-field">
                <select
                    name="project_id"
                    id="project_id"
                    class="form-input @error('project_id') form-input-error @enderror"
                    onchange="this.form.submit()"
                >
                    <option value="">All projects</option>
                    @foreach ($projects as $project)
                        <option value="{{ $project->id }}" @selected($selectedProjectId === $project->id)>
                            {{ $project->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="filter-toolbar-actions">
                <x-button type="submit" variant="secondary">Apply</x-button>
                @if ($selectedProjectId)
                    <x-button tag="a" variant="secondary" :href="route('tasks.index')">Clear</x-button>
                @endif
            </div>
        </div>
    </form>

    @if ($tasks->isEmpty())
        <div class="empty-state">
            <p class="empty-state-title">No tasks yet</p>
            <p class="empty-state-text">
                @if ($projects->isNotEmpty())
                    <a href="{{ route('tasks.create') }}">Create your first task</a> or pick a project filter above.
                @else
                    <a href="{{ route('projects.create') }}">Create a project</a> first, then add tasks.
                @endif
            </p>
        </div>
    @else
        <section
            class="panel"
            x-data="taskList({
                reorderUrl: @js($reorderUrl),
                csrfToken: @js(csrf_token()),
                canReorder: @js($selectedProjectId === null),
            })"
        >
            <div class="panel-header">
                <span class="panel-title">
                    @if ($selectedProjectId)
                        {{ $projects->firstWhere('id', $selectedProjectId)?->name }}
                    @else
                        All tasks
                    @endif
                    <span class="ml-1 font-normal text-slate-500">({{ $tasks->count() }})</span>
                </span>
                <span class="saving-badge" x-show="saving" x-cloak>Saving order…</span>
            </div>

            <p class="px-5 py-2 text-sm text-red-600" x-show="error" x-text="error" x-cloak></p>

            @if ($selectedProjectId)
                <p class="panel-hint">
                    Filter active. Drag reorder is available on
                    <a href="{{ route('tasks.index') }}">all tasks</a>.
                </p>
            @else
                <p class="panel-hint">
                    Drag rows to reorder. Priority is renumbered 1, 2, 3… from top to bottom.
                </p>
            @endif

            <div class="task-table">
                <div class="task-table-header task-row-cols-full" aria-hidden="true">
                    <span class="task-col-priority">Priority</span>
                    <span class="task-col-task">Task</span>
                    <span class="task-col-project">Project</span>
                    <span class="task-col-actions">Actions</span>
                </div>

                <ul x-ref="list" class="task-table-body">
                    @foreach ($tasks as $task)
                        <x-task.row :task="$task" />
                    @endforeach
                </ul>
            </div>
        </section>
    @endif
@endsection
