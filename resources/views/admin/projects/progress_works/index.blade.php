@extends('admin.layouts.admin_layout')


@section('content')
    <progress-work
            p-project-id="{{ $project->hashid }}"
            url-data-progress-works="{{ route('admin.projects.progress_works.get_data', ['project_id' => $project->hashid]) }}"
            p-last-update="{{ $lastUpdate }}"
    ></progress-work>
@endsection