@extends('admin.layouts.admin_layout')
@push('_styles')
    {{--<link rel="stylesheet" href="{{ asset('assets/vendor/plugins/datatables.net-dt/css/jquery.dataTables.min.css') }}">--}}
@endpush
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5>
                        @switch($role->hashid)
                            @case($role_admin)
                            Usuarios Administradores
                            @break
                            @case($role_supervisors)
                            Usuarios Supervisores
                            @break
                            @case($role_clients)
                            Usuarios Clientes
                            @break
                        @endswitch
                    </h5>
                </div>
                <div class="card-block">
                    <user-index
                            url-data="{{ route('admin.users.get_data', ['role_id' => $role->hashid]) }}"></user-index>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('_scripts')
    <script src="{{ asset('assets/vendor/plugins/datatables.net/js/jquery.dataTables.min.js') }}"></script>
@endpush