@extends('admin.layouts.admin_layout')
@push('_styles')
    <link rel="stylesheet" href="{{ asset('assets/vendor/plugins/dropzone/dropzone.min.css') }}">
@endpush
@section('content')
    <calibration-certificates p-project-hashid="{{ $project->hashid }}"
                              p-url="{{ route('admin.project.calibration_certificate.store', ['project_id' => $project->hashid]) }}"
                              p-url-table-data="{{ route('admin.project.calibration_certificate.get_data', ['project_id' => $project->hash_id]) }}">
    </calibration-certificates>
@endsection

@push('_scripts')
    <script src="{{ asset('assets/vendor/plugins/dropzone/dropzone.min.js') }}"></script>
@endpush