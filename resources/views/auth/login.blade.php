<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>GM Proyectos | Inicio de sesión</title>
    <meta name="description" content="Kiwi is a premium adman dashboard template based on bootstrap">
    <meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=0,minimal-ui">
    <link rel="apple-touch-icon" href="apple-touch-icon.png">
    {{-- core plugins --}}
    <link rel="stylesheet" href="{{ asset('assets/vendor/plugins/animate.css/animate.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/plugins/font-awesome/css/font-awesome.min.css') }}">
    <link rel="stylesheet"
          href="{{
            asset('assets/vendor/plugins/material-design-iconic-font/dist/css/material-design-iconic-font.css')
        }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/bootstrap.css') }}">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,600">
    {{-- core plugins --}}
    {{-- styles for the current page --}}
    <link rel="stylesheet" href="{{ asset('assets/examples/css/pages/login.css') }}">
    {{-- / styles for the current page --}}
</head>
<body class="simple-page page-login">
<!--[if lt IE 10]>
<p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade
    your browser</a> to improve your experience.</p>
<![endif]-->
<header class="simple-page-header" style="margin-top: 53px;">
    {{--<div class="home-btn">
        <a href="javascript:void(0);" class="btn btn-outline-secondary" style="cursor: default;">
            --}}{{--<i class="fa fa-home animated zoomIn"></i>--}}{{--
        </a>
    </div>--}}
</header>
<div class="simple-page-wrap">
    <div class="simple-page-content mb-4">
        <div class="simple-page-logo animated zoomIn">
            <a href="index.html">
                <span>
                   GM
                </span>
                <span>Proyectos</span>
            </a>
        </div>
        {{-- logo --}}
        <div class="simple-page-form animated flipInY" id="login-form">
            <h6 class="form-title mb-4 text-center">
                Ingresa tus datos para iniciar la sesión
            </h6>
            <form action="{{ route('login') }}" method="POST">
                {{ csrf_field() }}
                <div class="form-group{{ $errors->has('email') ? ' has-danger' : '' }}">
                    <input id="email" name="email" type="email" class="form-control"
                           placeholder="Correo electrónico" value="{{ old('email') }}" required autofocus>
                    @if ($errors->has('email'))
                        <span class="form-control-feedback">
                            <strong>{{ $errors->first('email') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="form-group{{ $errors->has('password') ? ' has-danger' : '' }}">
                    <input id="password" name="password" type="password" class="form-control" placeholder="Contraseña"
                           required>

                    @if ($errors->has('password'))
                        <span class="form-control-feedback">
                            <strong>{{ $errors->first('password') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="form-group mb-5">
                    <div class="checkbox checkbox-primary">
                        <input type="checkbox" id="keep_me_logged_in">
                        <label for="keep_me_logged_in">Mantener sesión abierta</label>
                    </div>
                </div>
                <input type="submit" class="btn btn-primary" value="INICIAR SESIÓN">
            </form>
        </div>
        {{-- #login-form --}}
        <div class="text-center">
            <p>
                <a href="{{ route('password.request') }}" class="text-white">¿Olvido su contraseña?</a>
            </p>
        </div>
        {{-- .simple-page-footer --}}
    </div>
    {{-- /.simple-page-content --}}
</div>
{{-- .simple-page-wrap --}}
{{-- core plugins --}}
<script src="{{ asset('assets/vendor/plugins/jquery/dist/jquery.min.js') }}"></script>
<script src="{{ asset('assets/vendor/plugins/tether/dist/js/tether.min.js') }}"></script>
<script src="{{ asset('assets/vendor/plugins/bootstrap/dist/js/bootstrap.min.js') }}"></script>
</body>
</html>