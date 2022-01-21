@extends('errors.error_layout')
@section('title')
    Error 401 | Usuario no autorizado
@endsection

@section('content')
    <h1 id="_404" class="text-center text-white">
        401
    </h1>
    <p class="text-white text-center">
        {{ $exception->getMessage() }}
    </p>
@endsection