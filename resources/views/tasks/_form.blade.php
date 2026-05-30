@php
    $task = $task ?? null;
@endphp

<x-form.select
    label="Project"
    name="project_id"
    :required="true"
    :placeholder="$task ? null : 'Select project'"
>
    @foreach ($projects as $project)
        <option value="{{ $project->id }}" @selected(old('project_id', $task?->project_id) == $project->id)>
            {{ $project->name }}
        </option>
    @endforeach
</x-form.select>

<x-form.input
    label="Task name"
    name="name"
    :value="$task?->name"
    :required="true"
/>

@if (! $task)
    <x-form.input
        label="Priority"
        name="priority"
        type="number"
        :hint="'Optional. Leave empty to add at the end. Set a number to insert at that position.'"
        min="1"
    />
@endif
