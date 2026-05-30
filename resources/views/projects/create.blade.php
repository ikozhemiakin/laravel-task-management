@extends('layouts.app')

@section('title', 'New project')

@section('content')
    <a href="{{ route('projects.index') }}" class="form-back">← Back to projects</a>

    <x-page-header title="New project" description="Projects organize your tasks. Name it clearly for your team." />

    <form method="post" action="{{ route('projects.store') }}" class="card-form">
        @csrf

        <x-form.input label="Project name" name="name" :required="true" />

        <div class="flex flex-wrap gap-3 border-t border-slate-100 pt-5">
            <x-button type="submit">Create project</x-button>
            <x-button tag="a" variant="secondary" :href="route('projects.index')">Cancel</x-button>
        </div>
    </form>
@endsection
