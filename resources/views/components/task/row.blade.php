@props(['task'])

<li
    class="task-row task-row-draggable task-row-cols-full"
    data-task-id="{{ $task->id }}"
    data-project-id="{{ $task->project_id }}"
>
    <div class="task-col-priority">
        <span class="priority-badge" data-priority-badge title="Priority">{{ $task->priority }}</span>
    </div>

    <p class="task-col-task truncate" title="{{ $task->name }}">
        {{ $task->name }}
    </p>

    <p class="task-col-project" title="{{ $task->project->name }}">
        <span class="project-pill">{{ $task->project->name }}</span>
    </p>

    <div class="task-col-actions task-row-actions">
        <x-button tag="a" variant="sm" :href="route('tasks.edit', $task)">Edit</x-button>
        <form method="post" action="{{ route('tasks.destroy', $task) }}"
              onsubmit="return confirm('Delete this task?');">
            @csrf
            @method('DELETE')
            <x-button type="submit" variant="danger">Delete</x-button>
        </form>
    </div>
</li>
