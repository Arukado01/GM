<div class="row">
    <div class="col-md-12">
        <div class="widget">
            <div class="widget-header">
                <h5>
                    Ensayos de calidad a materiales Críticos
                </h5>
            </div>
            <hr class="widget-separator">
            <div class="widget-body">
                <ul id="profile-nav-tabs" class="nav nav-tabs" role="tablist">
                    <li role="presentation" class="nav-item">
                        <a href="#concrete-samples" class="nav-link active" aria-controls="concrete-samples"
                           role="tab" style="text-transform: uppercase;"
                           data-toggle="tab" aria-expanded="true">
                            Ensayos Concreto
                        </a>
                    </li>
                    <li role="presentation" class="nav-item">
                        <a href="#steel-samples" class="nav-link" aria-controls="steel-samples" role="tab"
                           data-toggle="tab" aria-expanded="false" style="text-transform: uppercase;">
                            Ensayos Acero
                        </a>
                    </li>
                    <li role="presentation" class="nav-item">
                        <a href="#mesh-samples" class="nav-link" aria-controls="mesh-samples" role="tab"
                           data-toggle="tab" aria-expanded="false" style="text-transform: uppercase;">
                            Ensayos Mallas
                        </a>
                    </li>
                    {{--@env('production')
                    <li role="presentation" class="nav-item">
                        <a href="#settlement-control" class="nav-link" aria-controls="settlement-control" role="tab"
                           data-toggle="tab" aria-expanded="false" style="text-transform: uppercase;">
                            Control de Asentamientos
                        </a>
                    </li>
                    @endenv--}}
                </ul>
                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane active pt-3" id="concrete-samples">
                        <concrete-sample p-project-id="{{ $project->hashid }}"
                                         p-sample-concrete="{{ $project->getLastUpdate('sample_concrete') }}"
                                         p-verify-concrete="{{ $project->getLastUpdate('verify_concrete') }}"
                                         url-data-concrete-samples="{{ route('users.project.concrete_samples', [
                                                    'project_id' => $project->hashid
                                                 ]) }}">
                        </concrete-sample>
                    </div>
                    <!-- /.tab-pane -->
                    <div role="tabpanel" id="steel-samples" class="tab-pane pt-3">
                        <steel-samples
                                p-project-id="{{ $project->hashid }}"
                                p-sample-steel="{{ $project->getLastUpdate('sample_steel') }}"
                                p-verify-steel="{{ $project->getLastUpdate('verify_steel') }}"
                                url-data-steel-samples="{{
                                        route('users.project.steel_samples.index', [
                                                'project_id' => $project->hashid
                                            ])
                                        }}"
                                url-data-steel-quantity-sample="{{
                                        route('users.project.quantity_check_sample.getQuantityCheckSamplesData', [
                                            'project_id' => $project->hashid,
                                            'quantity_check_type' => 'steel'
                                        ])
                                    }}">

                        </steel-samples>
                    </div>
                    <!-- /.tab-pane -->
                    <div role="tabpanel" class="tab-pane pt-3" id="mesh-samples">
                        <mesh-samples
                                p-project-id="{{ $project->hashid }}"
                                p-sample-mesh="{{ $project->getLastUpdate('sample_mesh') }}"
                                p-verify-mesh="{{ $project->getLastUpdate('verify_mesh') }}"
                                url-data-mesh-samples="{{
                                        route('users.project.mesh_samples.index', [
                                                'project_id' => $project->hashid
                                            ])
                                        }}"
                                url-data-mesh-quantity-sample="{{
                                        route('users.project.quantity_check_sample.getQuantityCheckSamplesData', [
                                            'project_id' => $project->hashid,
                                            'quantity_check_type' => 'mesh'
                                        ])
                                    }}">

                        </mesh-samples>
                    </div>
                    {{--@env('production')
                    <!-- /.tab-pane -->
                    <div role="tabpanel" class="tab-pane pt-3" id="settlement-control">
                        <settlement-control
                                p-project-id="{{ $project->hashid }}"
                                url-data-settlement-control="{{
                                        route('users.project.settlement_control.index', [
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