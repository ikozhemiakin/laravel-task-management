@extends('layouts.app')

@section('title', 'Projects')

@section('content')
    <x-page-header
        title="Projects"
        description="Group tasks by project. Open tasks or manage project details from here."
    >
        <x-slot:actions>
            <x-button tag="a" :href="route('projects.create')">New project</x-button>
        </x-slot:actions>
    </x-page-header>

    @if ($projects->isEmpty())
        <div class="empty-state">
            <p class="empty-state-title">No projects yet</p>
            <p class="empty-state-text">
                <a href="{{ route('projects.create') }}">Create a project</a> to start adding tasks.
            </p>
        </div>
    @else
        <section class="panel">
            <div class="panel-header">
                <span class="panel-title">Your projects <span class="font-normal text-slate-500">({{ $projects->count() }})</span></span>
            </div>

            <ul class="project-list">
                @foreach ($projects as $project)
                    <li class="project-row">
                        <span class="project-row-name">{{ $project->name }}</span>
                        <div class="task-row-actions">
                            <x-button tag="a" variant="sm" :href="route('tasks.index', ['project_id' => $project->id])">Tasks</x-button>
                            <x-button tag="a" variant="sm" :href="route('projects.edit', $project)">Edit</x-button>
                            <form method="post" action="{{ route('projects.destroy', $project) }}"
                                  onsubmit="return confirm('Delete project and all its tasks?');">
                                @csrf
                                @method('DELETE')
                                <x-button type="submit" variant="danger">Delete</x-button>
                            </form>
                        </div>
                    </li>
                @endforeach
            </ul>
        </section>
    @endif
@endsection
