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
<script src="{{ asset('assets/global/js/plugins/video-modal.js') }}"></script>
<script src="{{ asset('assets/examples/js/theme-customizer.js') }}"></script>
<!-- plugins for the current page -->
<script src="{{ asset('assets/vendor/flot/jquery.flot.min.js') }}"></script>
<script src="{{ asset('assets/vendor/flot/jquery.flot.resize.min.js') }}"></script>
<script src="{{ asset('assets/vendor/flot/jquery.flot.tooltip.min.js') }}"></script>
<script src="{{ asset('assets/vendor/flot/jquery.flot.curvedLines.js') }}"></script>
<script src="{{ asset('assets/vendor/flot/jquery.flot.categories.min.js') }}"></script>
<script src="{{ asset('assets/vendor/js/echarts.min.js') }}"></script>
<script src="{{ asset('assets/vendor/js/jquery.sparkline.min.js') }}"></script>
<script src="{{ asset('assets/vendor/owl-carousel/owl.carousel.min.js') }}"></script>
<!-- site-wide scripts -->
<script src="{{ asset('assets/global/js/main.js') }}"></script>
<script src="{{ asset('admin/js/site.js') }}"></script>
<script src="{{ asset('admin/js/menubar.js') }}"></script>

@stack('_scripts')
<script src="{{ asset('admin/js/admin_core.min.js') }}"></script>
