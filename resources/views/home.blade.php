@extends('layouts.app')
@push('_styles')
    <link rel="stylesheet" href="{{ asset('assets/vendor/plugins/fullcalendar/dist/fullcalendar.min.css') }}">
@endpush
@section('content')
    @if(!empty($projects) && $projects->count() > 0)
        {{--Seleccionar proyecto--}}
        @include('client_partials._project_selector')
        {{--Proyect Info--}}
        @include('client_partials._project_header')
        {{--Slider--}}
        @include('client_partials._project_images')

        {{--Licencia de construcción--}}
        <div class="row mt-5">
            <div class="col-md-12">
                <div class="widget">
                    <div class="widget-header">
                        <h5>
                            @if(!empty($project->licenses()->first()) && $project->licenses()->first()->count() > 0)
                                <a href="{{ asset($project->licenses()->first()->path) }}" target="_blank">
                                    Licencia de Construcción ({{ $project->name }}) <i class="fa fa-external-link"></i>
                                </a>
                            @else
                                No se ha subido la Licencia de Construcción
                            @endif
                        </h5>
                    </div>
                </div>
            </div>
        </div>

        {{--Plan de Calidad--}}
        <div class="row">
            <div class="col-md-12">
                <div class="widget">
                    <div class="widget-header">
                        <h5>
                            @if(!empty($project->qualityPlan()->first()) && $project->qualityPlan()->first()->count() > 0)
                                <a href="{{ asset($project->qualityPlan()->first()->path) }}" target="_blank">
                                    Plan de Calidad ({{ $project->name }}) <i class="fa fa-external-link"></i>
                                </a>
                            @else
                                No se ha subido el Plan de Calidad
                            @endif
                        </h5>
                    </div>
                </div>
            </div>
        </div>
        {{--Calendario--}}
        @include('client_partials._project_calendar')
        {{--Acence de Obra--}}
        <progress-works
                url-data-progress-works="{{ route('users.project.progress_works.get_data', ['project_id' => $project->hashid]) }}"
                p-last-update="{{ $project->progressWorkLastUpdate() }}"></progress-works>
        {{--Estado de Observaciones--}}
        @include('client_partials._project_state_observation')
        {{--Hallazgos--}}
        <finding-index p-project-id="{{ $project->hashid }}"></finding-index>
        {{--Certificados de Calibracion--}}
        <calibration-certificates
                p-url-table-data="{{ route('project.calibration_certificate.get_data', ['project_id' => $project->hash_id]) }}">
        </calibration-certificates>
        {{--Analisis de resultados--}}
        @include('client_partials._project_analysis_results')
        {{--Control de Asentamientos--}}
        <div class="row">
            <div class="col-md-12">
                <div class="widget">
                    <div class="widget-header">
                        <h5>Control de Asentamientos</h5>
                    </div>
                    <hr class="widget-separator">
                    <div class="widget-body">
                        <settlement-control
                                p-project-id="{{ $project->hashid }}"
                                url-data-settlement-control="{{
                                        route('users.project.settlement_control.index', [
                                                'project_id' => $project->hashid
                                            ])
                                        }}"></settlement-control>
                    </div>
                </div>
            </div>
        </div>
        {{--Zonas Verificadas Dimensionalmente--}}
        <zones-checked
                p-project-id="{{ $project->hashid }}"
                p-route-get-data="{{ route('users.projects.zones_checked.getData', ['project_id' => $project->hashid]) }}"
        ></zones-checked>
    @else
        <div class="row">
            <div class="col-md-12 text-center">
                No tiene Proyectos asignados.
                <unload-overlay></unload-overlay>
            </div>
        </div>
    @endif
@endsection

@push('_scripts')
    {{--<script src="{{ asset('assets/vendor/plugins/moment/min/moment.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/plugins/fullcalendar/dist/fullcalendar.min.js') }}"></script>--}}
    <script type="text/javascript">
        $(document).ready(function () {
            $('#sl_projects').change(function (e) {
                let url = $(this).find(':selected').data('url');
                console.log(url);
                window.location = url;
            });
        })
    </script>
@endpush