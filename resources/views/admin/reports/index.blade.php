@extends('admin.layouts.admin_layout')
@push('_styles')
    <link rel="stylesheet" href="{{ asset('assets/vendor/plugins/dropzone/dropzone.min.css') }}">
@endpush
@section('content')
    <div class="row">
        <div class="col-md-12">

            <upload-report p-url="{{ route('admin.reports.store', ['project_id' => $project->hashid]) }}"
                           p-project="{{ $project->name }}"
                           p-url-data-reports="{{ route('admin.projects.reports', [
                                        'project_id' => $project->hashid
                                   ]) }}">
            </upload-report>
        </div>
    </div>
@endsection
@push('_scripts')
    <script src="{{ asset('assets/vendor/plugins/dropzone/dropzone.min.js') }}"></script>
@endpush