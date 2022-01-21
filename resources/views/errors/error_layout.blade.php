<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>@yield('title', 'Error')</title>
    <meta name="description" content="Kiwi is a premium adman dashboard template based on bootstrap">
    <meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=0,minimal-ui">
    <link rel="apple-touch-icon" href="apple-touch-icon.png"><!-- core plugins -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/plugins/animate.css/animate.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/plugins/font-awesome/css/font-awesome.min.css') }}">
    <link rel="stylesheet"
          href="{{ asset('assets/vendor/plugins/material-design-iconic-font/dist/css/material-design-iconic-font.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/bootstrap.css') }}">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,600">
    <!-- core plugins -->
    <!-- styles for the current page -->
    <link rel="stylesheet" href="{{ asset('assets/examples/css/pages/404.css') }}">
    <!-- / styles for the current page -->
</head>
<body class="simple-page page-404">
<!--[if lt IE 10]>
<p class="browserupgrade">Usted esta usando una version<strong>desactualizada</strong> de su navegador.
    Por favor
    <a href="http://browsehappy.com/">
        actualice su navegador
    </a> para una mejor experiencia.
</p>
<![endif]-->
<header class="simple-page-header">
    <div class="home-btn">
        <a href="{{ auth()->user()->isAdminOrSupervisor() ? route('admin.dashboard') : route('home') }}" class="btn btn-outline-secondary">
            <i class="fa fa-home animated zoomIn"></i>
        </a>
    </div>
</header>
<div class="simple-page-wrap">
    <div class="simple-page-content mb-4">
        <div class="simple-page-logo animated zoomIn">
            <a href="index.html">
                <span>
                    GM
                </span>
                <span>
                    Proyectos
                </span>
            </a>
        </div>
        <!-- logo -->
        <div class="animated shake">
            @yield('content')
        </div>
    </div>
    <!-- /.simple-page-content -->
</div>
<!-- .simple-page-wrap -->
<!-- core plugins -->
<script src="{{ asset('assets/vendor/plugins/jquery/dist/jquery.min.js') }}"></script>
<script src="{{ asset('assets/vendor/plugins/tether/dist/js/tether.min.js') }}"></script>
<script src="{{ asset('assets/vendor/plugins/bootstrap/dist/js/bootstrap.min.js') }}"></script>
</body>
</html>