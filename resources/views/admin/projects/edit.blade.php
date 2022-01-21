@extends('admin.layouts.admin_layout')
@push('_styles')
    <link rel="stylesheet" href="{{ asset('assets/vendor/plugins/dropzone/dropzone.min.css') }}">
@endpush
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5>Editar Proyecto</h5>
                </div>
                <div class="card-block">
                    <project-form p-project="{{ $project }}" p-action="edit"
                                  p-url-data="{{ route('admin.projects.get_clients', ['project_id' => $project->hashid]) }}">
                    </project-form>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5>Licencia de Construcción</h5>
                </div>
                <div class="card-block">
                    <construction-licences
                            p-project-image="{{ (!empty($project->licenses()->first()) && $project->licenses()->first()->count() > 0) ? asset($project->licenses()->first()->path) : ''}}"
                            p-project-name="{{ $project->name }}"
                            p-url="{{ route('admin.projects.upload_license', ['project_id' => $project->hashid]) }}">

                    </construction-licences>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5>Plan de Calidad</h5>
                </div>
                <div class="card-block">
                    <quality-plan
                            p-project-image="{{ (!empty($project->qualityPlan()->first()) && $project->qualityPlan()->first()->count() > 0) ? asset($project->qualityPlan()->first()->path) : ''}}"
                            p-project-name="{{ $project->name }}"
                            p-url="{{ route('admin.projects.upload_quality_plan', ['project_id' => $project->hashid]) }}">

                    </quality-plan>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5>ESPECIFICACIONES TÉCNICAS DE CONSTRUCCIÓN</h5>
                </div>
                <div class="card-block">
                    <esp-tec
                            p-project-image="{{ (!empty($project->espTec()->first()) && $project->espTec()->first()->count() > 0) ? asset($project->espTec()->first()->path) : ''}}"
                            p-project-name="{{ $project->name }}"
                            p-url="{{ route('admin.projects.upload_esp_tec', ['project_id' => $project->hashid]) }}">
                    </esp-tec>
                </div>
            </div>
        </div>
    </div>

    {{--  <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5>RELACION DE PLANOS</h5>
                </div>
                <div class="card-block">
                    <quality-plan
                            p-project-image="{{ (!empty($project->qualityPlan()->first()) && $project->qualityPlan()->first()->count() > 0) ? asset($project->qualityPlan()->first()->path) : ''}}"
                            p-project-name="{{ $project->name }}"
                            p-url="{{ route('admin.projects.upload_quality_plan', ['project_id' => $project->hashid]) }}">

                    </quality-plan>
                </div>
            </div>
        </div>
    </div>  --}}

@endsection

@push('_scripts')
    <script src="{{ asset('assets/vendor/plugins/dropzone/dropzone.min.js') }}"></script>
@endpush