@extends('admin.layouts.admin_layout')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-block">
                    <ul id="profile-nav-tabs" class="nav nav-tabs" role="tablist">
                        <li role="presentation" class="nav-item">
                            <a href="#state-observation" class="nav-link active" aria-controls="state-observation"
                               role="tab"
                               data-toggle="tab" aria-expanded="true">
                                Estado de Observaciones
                            </a>
                        </li>
                        <li role="presentation" class="nav-item">
                            <a href="#finding-index" class="nav-link" aria-controls="finding-index" role="tab"
                               data-toggle="tab" aria-expanded="false">
                                Hallazgos por Levantar
                            </a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div role="tabpanel" class="tab-pane active pt-3" id="state-observation">
                            <state-observation p-project-id="{{ $project->hashid }}"></state-observation>
                        </div>
                        <!-- /.tab-pane -->
                        <div role="tabpanel" id="finding-index" class="tab-pane pt-3">
                            <finding-index p-project-id="{{ $project->hashid }}"></finding-index>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection