@extends('layouts.app')

@section('title', 'New task')

@section('content')
    <a href="{{ route('tasks.index') }}" class="form-back">← Back to tasks</a>

    <x-page-header title="New task" description="Add a task to a project. Priority is optional." />

    <form method="post" action="{{ route('tasks.store') }}" class="card-form">
        @csrf
        @include('tasks._form', ['projects' => $projects])

        <div class="flex flex-wrap gap-3 border-t border-slate-100 pt-5">
            <x-button type="submit">Create task</x-button>
            <x-button tag="a" variant="secondary" :href="route('tasks.index')">Cancel</x-button>
        </div>
    </form>
@endsection
