@extends('admin.layouts.admin_layout')
@section('content')
    @if(!empty($alert))
        <div class="row">
            <div class="col-md-12">
                <div class="alert alert-info" role="alert">
                    <h4 class="alert-heading">Información!</h4>
                    <p>{{ $alert }}</p>
                </div>
            </div>
        </div>
    @endif
    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-block">
                    <upload-avatar user-id="{{ auth()->user()->hashid }}" p-context="admin"
                                   img-url="{{ !empty(auth()->user()->avatar) ? auth()->user()->avatar : asset('assets/global/images/avatar5.png') }}">
                    </upload-avatar>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="profile-content">
                <div class="row">
                    <div class="col-md-12">
                        <profile p-hash="{{ auth()->user()->hashid }}"></profile>
                    </div>
                </div>
            </div>
            <!-- ./profile-content -->
        </div>
    </div>
@endsection