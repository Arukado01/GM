@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-block">
                    <upload-avatar user-id="{{ auth()->user()->hashid }}"
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