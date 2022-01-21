@extends('admin.layouts.admin_layout')


@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5>Análisis, resultados, ensayos y tomas de muestras</h5>
                </div>
                <div class="card-block">
                    <ul id="profile-nav-tabs" class="nav nav-tabs" role="tablist">
                        <li role="presentation" class="nav-item">
                            <a href="#concrete-samples" class="nav-link active" aria-controls="concrete-samples"
                               role="tab"
                               data-toggle="tab" aria-expanded="true">
                                Ensayos Concreto
                            </a>
                        </li>
                        <li role="presentation" class="nav-item">
                            <a href="#profile-photos" class="nav-link" aria-controls="profile-photos" role="tab"
                               data-toggle="tab" aria-expanded="false">
                                Ensayos Acero
                            </a>
                        </li>
                        <li role="presentation" class="nav-item">
                            <a href="#mesh-samples" class="nav-link" aria-controls="mesh-samples" role="tab"
                               data-toggle="tab" aria-expanded="false">
                                Ensayos Mallas
                            </a>
                        </li>
                        {{--@env('production')
                        <li role="presentation" class="nav-item">
                            <a href="#settlement-control" class="nav-link" aria-controls="settlement-control" role="tab"
                               data-toggle="tab" aria-expanded="false">
                                Control de Asentamientos
                            </a>
                        </li>
                        @endenv--}}
                    </ul>
                    <div class="tab-content">
                        <div role="tabpanel" class="tab-pane active pt-3" id="concrete-samples">
                            <concrete-sample
                                    :p-is-admin="{{ auth()->user()->isAdmin() ? 1 : 0 }}"
                                    p-project-id="{{ $project->hashid }}"
                                    p-sample-concrete="{{ $project->getLastUpdate('sample_concrete') }}"
                                    p-verify-concrete="{{ $project->getLastUpdate('verify_concrete') }}"
                                    url-data-concrete-samples="{{
                                        route('admin.projects.analysis.get_concrete_samples_data', [
                                                'project_id' => $project->hashid
                                            ])
                                        }}"
                                    url-data-concrete-quantity-test="{{
                                        route('admin.project.quantity_check_test.get_data', ['project_id' => $project->hashid])
                                    }}"></concrete-sample>
                        </div>
                        <!-- /.tab-pane -->
                        <div role="tabpanel" id="profile-photos" class="tab-pane pt-3">
                            <steel-sample
                                    :p-is-admin="{{ auth()->user()->isAdmin() ? 1 : 0 }}"
                                    p-project-id="{{ $project->hashid }}"
                                    p-sample-steel="{{ $project->getLastUpdate('sample_steel') }}"
                                    p-verify-steel="{{ $project->getLastUpdate('verify_steel') }}"
                                    url-data-steel-samples="{{
                                        route('admin.project.steel_samples.index', [
                                                'project_id' => $project->hashid
                                            ])
                                        }}"
                                    url-data-steel-quantity-sample="{{
                                        route('admin.project.quantity_check_sample.index', [
                                            'project_id' => $project->hashid,
                                            'quantity_check_type' => 'steel'
                                        ])
                                    }}"></steel-sample>
                        </div>
                        <!-- /.tab-pane -->
                        <div role="tabpanel" class="tab-pane pt-3" id="mesh-samples">
                            <mesh-sample
                                    :p-is-admin="{{ auth()->user()->isAdmin() ? 1 : 0 }}"
                                    p-project-id="{{ $project->hashid }}"
                                    p-sample-mesh="{{ $project->getLastUpdate('sample_mesh') }}"
                                    p-verify-mesh="{{ $project->getLastUpdate('verify_mesh') }}"
                                    url-data-mesh-samples="{{
                                        route('admin.project.mesh_samples.index', [
                                                'project_id' => $project->hashid
                                            ])
                                        }}"
                                    url-data-mesh-quantity-sample="{{
                                        route('admin.project.quantity_check_sample.index', [
                                            'project_id' => $project->hashid,
                                            'quantity_check_type' => 'mesh'
                                        ])
                                    }}"></mesh-sample>
                        </div>
                        <!-- /.tab-pane -->
                        {{--@env('production')
                            <div role="tabpanel" class="tab-pane pt-3" id="settlement-control">
                                <settlement-control
                                        :p-is-admin="{{ auth()->user()->isAdmin() ? 1 : 0 }}"
                                        p-project-id="{{ $project->hashid }}"
                                        url-data-settlement-control="{{
                                            route('admin.project.settlement_control.index', [
                                                'project_id' => $project->hashid
                                            ])
                                        }}"></settlement-control>
                            </div>
                        @endenv--}}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5>Control de Asentamientos</h5>
                </div>
                <div class="card-block">
                    <settlement-control
                            :p-is-admin="{{ auth()->user()->isAdmin() ? 1 : 0 }}"
                            p-project-id="{{ $project->hashid }}"
                            url-data-settlement-control="{{
                                            route('admin.project.settlement_control.index', [
                                                'project_id' => $project->hashid
                                            ])
                                        }}"></settlement-control>
                </div>
            </div>
        </div>
    </div>
@endsection