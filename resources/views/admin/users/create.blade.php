@extends('admin.layouts.admin_layout')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5>Crear Nuevo Usuario</h5>
                </div>
                <div class="card-block">
                    <user-form p-action="create"
                               :p-is-admin="{{ auth()->user()->isAdmin() ? true : false }}">
                    </user-form>
                </div>
            </div>
        </div>
    </div>
@endsection