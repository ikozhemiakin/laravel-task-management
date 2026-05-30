@extends('layouts.app')

@section('title', 'Edit task')

@section('content')
    <a href="{{ route('tasks.index') }}" class="form-back">← Back to tasks</a>

    <x-page-header title="Edit task" :description="'Update «' . $task->name . '»'" />

    <form method="post" action="{{ route('tasks.update', $task) }}" class="card-form">
        @csrf
        @method('PUT')
        @include('tasks._form', ['task' => $task, 'projects' => $projects])

        <div class="flex flex-wrap gap-3 border-t border-slate-100 pt-5">
            <x-button type="submit">Save changes</x-button>
            <x-button tag="a" variant="secondary" :href="route('tasks.index')">Cancel</x-button>
        </div>
    </form>
@endsection
