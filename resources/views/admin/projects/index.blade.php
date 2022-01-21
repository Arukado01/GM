@extends('admin.layouts.admin_layout')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5>Proyectos</h5>
                </div>
                <div class="card-block">
                    <div class="row">
                        <div class="col-md-12 pull-right">
                            <a href="{{ route('admin.projects.create') }}" class="btn btn-outline-primary">
                                <i class="fa fa-plus"></i> Crear Proyecto
                            </a>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <hr>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <project-index url-data="{{ route('admin.projects.get_data') }}"></project-index>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection