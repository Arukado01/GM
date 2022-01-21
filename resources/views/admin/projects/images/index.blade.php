@extends('admin.layouts.admin_layout')
@push('_styles')
    <link rel="stylesheet" href="{{ asset('assets/vendor/plugins/dropzone/dropzone.min.css') }}">
@endpush
@section('content')
    <div class="row">
        <div class="col-md-12">
            <upload-project-images p-project="{{ $project->hashid }}"></upload-project-images>
        </div>
    </div>
@endsection
@push('_scripts')
    <script src="{{ asset('assets/vendor/plugins/dropzone/dropzone.min.js') }}"></script>
@endpush