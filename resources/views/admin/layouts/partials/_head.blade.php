<meta charset="utf-8">
<meta http-equiv="x-ua-compatible" content="ie=edge">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>Plataforma GM Proyectos</title>
<meta name="description" content="Kiwi is a premium adman dashboard template based on bootstrp">
<meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=0">
<link rel="apple-touch-icon" href="apple-touch-icon.png">
<!-- theme customizier \ demo only -->
<link rel="stylesheet" href="{{ asset('assets/examples/css/theme-customizer.css') }}">
<!-- core plugins -->
<link rel="stylesheet" href="{{ asset('assets/vendor/css/hamburgers.css') }}">
<link rel="stylesheet" href="{{ asset('assets/vendor/plugins/animate.css/animate.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/vendor/plugins/perfect-scrollbar/css/perfect-scrollbar.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/vendor/plugins/switchery/dist/switchery.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/vendor/plugins/sweetalert/dist/sweetalert.css') }}">
<!-- Site-wide styles -->
<link rel="stylesheet" href="{{ asset('assets/vendor/css/bootstrap.css') }}">
<link rel="stylesheet" href="{{ asset('admin/css/site.css') }}">
<!-- plugins for the current page -->
<link rel="stylesheet" href="{{ asset('assets/vendor/owl-carousel/owl.carousel.css') }}">
<!-- current page styles -->
<link rel="stylesheet" href="{{ asset('assets/examples/css/dashboards/dashboard.v1.css') }}">
@stack('_styles')
<!-- Fonts -->

<link rel="stylesheet" href="{{ asset('assets/vendor/plugins/font-awesome/css/font-awesome.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/vendor/plugins/material-design-iconic-font/dist/css/material-design-iconic-font.css') }}">
{{--<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet"
      integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
<link rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/material-design-iconic-font/2.2.0/css/material-design-iconic-font.min.css">--}}

<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway:300,400,500,600">
@stack('_styles')
<link rel="stylesheet" href="{{ asset('admin/css/admin_core.min.css') }}">
<script src="{{ asset('assets/vendor/plugins/breakpoints.js/dist/breakpoints.min.js') }}"></script>
<script>
    Breakpoints({
        xs: {min: 0, max: 575},
        sm: {min: 576, max: 767},
        md: {min: 768, max: 991},
        lg: {min: 992, max: 1199},
        xl: {min: 1200, max: Infinity}
    });
</script>