@extends('admin.layouts.admin_layout')
@push('_styles')
    <link rel="stylesheet" href="{{ asset('assets/vendor/plugins/dropzone/dropzone.min.css') }}">
@endpush
@section('content')
    <zone-checked
            p-project-id="{{ $project->hashid }}"
            p-route-get-data="{{ route('admin.projects.zones_checked.getData', ['project_id' => $project->hashid]) }}"
    ></zone-checked>
@endsection
@push('_scripts')
    <script src="{{ asset('assets/vendor/plugins/dropzone/dropzone.min.js') }}"></script>
@endpush