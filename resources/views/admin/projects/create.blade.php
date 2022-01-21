@extends('admin.layouts.admin_layout')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5>Nuevo Proyecto</h5>
                </div>
                <div class="card-block">
                    <project-form></project-form>
                </div>
            </div>
        </div>
    </div>
@endsection