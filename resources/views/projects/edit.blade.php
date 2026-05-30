@extends('layouts.app')

@section('title', 'Edit project')

@section('content')
    <a href="{{ route('projects.index') }}" class="form-back">← Back to projects</a>

    <x-page-header title="Edit project" :description="'Rename «' . $project->name . '»'" />

    <form method="post" action="{{ route('projects.update', $project) }}" class="card-form">
        @csrf
        @method('PUT')

        <x-form.input label="Project name" name="name" :value="$project->name" :required="true" />

        <div class="flex flex-wrap gap-3 border-t border-slate-100 pt-5">
            <x-button type="submit">Save changes</x-button>
            <x-button tag="a" variant="secondary" :href="route('projects.index')">Cancel</x-button>
        </div>
    </form>
@endsection
