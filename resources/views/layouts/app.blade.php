<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    @include('layouts.partials._head')
</head>
<body class="menubar-top menubar-light dashboard dashboard-v1 menubar-inverse">
<!--[if lt IE 10]>
<p class="browserupgrade">
    You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade
    your browser</a> to improve your experience.
</p>
<![endif]-->
@include('layouts.partials._navbar')
<!-- .site-navbar -->
@include('layouts.partials._site_menubar')
<!-- site-menubar -->
<main class="site-main">
    <div class="container-fluid client-content" id="app">
        <div class="overlay" id="overlay">
            <div class="overlay-text">
                <div id="floatingCirclesG">
                    <div class="f_circleG" id="frotateG_01"></div>
                    <div class="f_circleG" id="frotateG_02"></div>
                    <div class="f_circleG" id="frotateG_03"></div>
                    <div class="f_circleG" id="frotateG_04"></div>
                    <div class="f_circleG" id="frotateG_05"></div>
                    <div class="f_circleG" id="frotateG_06"></div>
                    <div class="f_circleG" id="frotateG_07"></div>
                    <div class="f_circleG" id="frotateG_08"></div>
                </div>
            </div>
        </div>
    @yield('content')
    <!-- /.widget -->
    </div>
</main>
<!-- .site-main -->

<!-- #video-modal -->
<!-- site-wide JS plugins -->
<script src="{{ asset('assets/vendor/plugins/jquery/dist/jquery.min.js') }}"></script>
<script src="{{ asset('assets/vendor/plugins/tether/dist/js/tether.min.js') }}"></script>
<script src="{{ asset('assets/vendor/plugins/bootstrap/dist/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('assets/vendor/plugins/jquery-slimscroll/jquery.slimscroll.min.js') }}"></script>
<script src="{{ asset('assets/vendor/plugins/perfect-scrollbar/js/perfect-scrollbar.jquery.min.js') }}"></script>
<script src="{{ asset('assets/vendor/plugins/sweetalert/dist/sweetalert.min.js') }}"></script>
<script src="{{ asset('assets/vendor/plugins/switchery/dist/switchery.min.js') }}"></script>
<script src="{{ asset('assets/vendor/plugins/waypoints/lib/jquery.waypoints.min.js') }}"></script>
<script src="{{ asset('assets/vendor/plugins/waypoints/lib/shortcuts/sticky.min.js') }}"></script>
<script src="{{ asset('assets/vendor/plugins/counterup/jquery.counterup.min.js') }}"></script>
<script src="{{ asset('assets/global/js/plugins/firstlitter.js') }}"></script>
<script src="{{ asset('assets/global/js/plugins/video-modal.js') }}"></script><!-- plugins for the current page -->

<script src="{{ asset('assets/vendor/js/echarts.min.js') }}"></script>
<script src="{{ asset('assets/vendor/js/jquery.sparkline.min.js') }}"></script>
<script src="{{ asset('assets/vendor/owl-carousel/owl.carousel.min.js') }}"></script><!-- site-wide scripts -->
@stack('_scripts');
<script src="{{ asset('assets/global/js/main.js') }}"></script>
<script src="{{ asset('admin/js/site.js') }}"></script>
<script src="{{ asset('admin/js/menubar.js') }}"></script>
<script src="{{ asset('js/app.min.js') }}"></script>
<!-- current page scripts -->
</body>
</html>