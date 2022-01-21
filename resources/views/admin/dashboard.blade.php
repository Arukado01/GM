@extends('admin.layouts.admin_layout')

@section('content')
    <unload-overlay></unload-overlay>
    <div class="row">
        <div class="col-md-6 col-sm-6">
            <div class="widget p-3 clearfix">
                <div class="float-left"><h3 class="widget-title">Bienvenidos a la plataforma GM Proyectos</h3>
                    <small class="text-color">Numero de proyectos</small>
                </div>
                <span class="float-right fz-lg counter" data-plugin="counterUp">{{ $totalProjects }}</span>
            </div>
            <!-- /.widget -->
        </div>
        <div class="col-md-6 col-sm-6">
            <div class="widget p-3 clearfix">
                <div class="float-left"><h3 class="widget-title">Usuarios Activos</h3>
                    <small class="text-color">Administradores / Supervisores / Clientes</small>
                </div>
                <span class="float-right fz-lg counter" data-plugin="counterUp">{{ $usersAct }}</span>
            </div>
            <!-- /.widget -->
        </div>
    </div><!-- /.row -->
    <div class="row">
        <div class="col-lg-4 col-sm-6">
            <div class="widget stats-widget">
                <div class="widget-body">
                    <div class="float-left"><h3 class="widget-title text-primary">
                            <span class="counter" data-plugin="counterUp">{{ $admins }}</span>
                        </h3>
                        <small class="text-color">Usuarios Administradores</small>
                    </div>
                    <span class="float-right big-icon watermark"><i class="fa fa-lock"></i></span>
                </div>
            </div><!-- /.widget -->
        </div>
        <div class="col-lg-4 col-sm-6">
            <div class="widget stats-widget">
                <div class="widget-body">
                    <div class="float-left"><h3 class="widget-title text-danger">
                            <span class="counter" data-plugin="counterUp">{{ $supervisors }}</span>
                        </h3>
                        <small class="text-color">Usuarios Supervisores</small>
                    </div>
                    <span class="float-right big-icon watermark"><i class="fa fa-user"></i></span>
                </div>
            </div><!-- /.widget -->
        </div>
        <div class="col-lg-4 col-sm-6">
            <div class="widget stats-widget">
                <div class="widget-body">
                    <div class="float-left"><h3 class="widget-title text-success">
                            <span class="counter" data-plugin="counterUp">{{ $clients }}</span>
                        </h3>
                        <small class="text-color">Usuarios Cliente</small>
                    </div>
                    <span class="float-right big-icon watermark"><i class="fa fa-user-secret"></i></span>
                </div>
            </div><!-- /.widget -->
        </div>
    </div><!-- /.row -->
@endsection

@push('_scripts')
    {{--<script src="{{ asset('assets/examples/js/dashboards/dashboard.v1.js') }}"></script>--}}
@endpush