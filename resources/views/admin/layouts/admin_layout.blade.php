<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    @include('admin.layouts.partials._head')
</head>
<body class="menubar-left menubar-inverse dashboard">
<!--[if lt IE 10]>
<p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade
    your browser</a> to improve your experience.</p>
<![endif]-->
@include('admin.layouts.partials._navbar')
<!-- .site-navbar -->
<div class="site-wrapper">
@include('admin.layouts.partials._site_menubar')
<!-- site-menubar -->
    <main class="site-main">
        <div class="site-content" id="admin-app">
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
        </div>
        {{--<!-- .site-footer -->
        <footer class="site-footer">
            <div class="copyright">
                Made with <i class="fa fa-heart text-danger"></i>by
                <a class="text-info" href="http://spantags.com">
                    SpanTags
                </a>
                2017
            </div>
            <div class="footer-menu"><a href="javascript:void(0)">Careers</a> <a href="javascript:void(0)">Privacy
                    Policy</a> <a href="javascript:void(0)">Feedback</a></div>
        </footer>
        <!-- /.site-footer -->--}}
    </main>
    <!-- .site-main -->
</div>
<!-- ./sit-wrapper -->

<div id="site-panel" class="site-panel">
    <div class="site-panel-tabs"><!-- tabs list -->
        <ul class="nav nav-tabs" role="tablist">
            <li class="nav-item"><a class="nav-link active" href="#friends-panel" data-toggle="tab" role="tab"><i
                            class="zmdi zmdi-comments zmdi-hc-lg"></i></a></li>
            <li class="nav-item"><a class="nav-link" href="#notifications-panel" data-toggle="tab" role="tab"><i
                            class="zmdi zmdi-notifications zmdi-hc-lg"></i></a></li>
            <li class="nav-item"><a class="nav-link" href="#settings-panel" data-toggle="tab" role="tab"><i
                            class="zmdi zmdi-settings zmdi-hc-lg"></i></a></li>
        </ul><!-- .nav-tabs -->
        <div class="tab-content">
            <div role="tabpanel" class="tab-pane active" id="friends-panel">
                <div class="scroll-container">
                    <div class="py-4 px-3"><h6 class="text-uppercase m-0 text-muted">Active Now</h6></div>
                    <div class="media-list"><a href="javascript:void(0)" class="media">
                            <div class="avatar avatar-circle"><img src="{{ asset('assets/global/images/203.jpg') }}" alt=""> <i
                                        class="status status-online"></i></div>
                            <div class="media-body"><h6 class="media-heading">Patrice Semo</h6>
                                <small>Lorem ipsum dolor sit amet</small>
                            </div>
                        </a><a href="javascript:void(0)" class="media">
                            <div class="avatar avatar-circle"><img src="{{ asset('assets/global/images/101.jpg') }}" alt=""> <i
                                        class="status status-online"></i></div>
                            <div class="media-body"><h6 class="media-heading">Audry Rowbotham</h6>
                                <small>Lorem ipsum dolor sit amet</small>
                            </div>
                        </a><a href="javascript:void(0)" class="media">
                            <div class="avatar avatar-circle"><img src="{{ asset('assets/global/images/202.jpg') }}" alt=""> <i
                                        class="status status-online"></i></div>
                            <div class="media-body"><h6 class="media-heading">Jonathan Radej</h6>
                                <small>Lorem ipsum dolor sit amet</small>
                            </div>
                        </a></div><!-- /.media-list -->
                    <div class="py-4 px-3"><h6 class="text-uppercase m-0 text-muted">Other Users</h6></div>
                    <div class="media-list"><a href="javascript:void(0)" class="media">
                            <div class="avatar avatar-circle"><img src="{{ asset('assets/global/images/204.jpg') }}" alt=""> <i
                                        class="status status-away"></i></div>
                            <div class="media-body"><h6 class="media-heading">Joelle Pabon</h6>
                                <small>Lorem ipsum dolor sit amet</small>
                            </div>
                        </a><a href="javascript:void(0)" class="media">
                            <div class="avatar avatar-circle"><img src="{{ asset('assets/global/images/201.jpg') }}" alt=""> <i
                                        class="status status-away"></i></div>
                            <div class="media-body"><h6 class="media-heading">Fae Atamanczyk</h6>
                                <small>Lorem ipsum dolor sit amet</small>
                            </div>
                        </a><a href="javascript:void(0)" class="media">
                            <div class="avatar avatar-circle"><img src="{{ asset('assets/global/images/101.jpg') }}" alt=""> <i
                                        class="status status-away"></i></div>
                            <div class="media-body"><h6 class="media-heading">German Rosch</h6>
                                <small>Lorem ipsum dolor sit amet</small>
                            </div>
                        </a><a href="javascript:void(0)" class="media">
                            <div class="avatar avatar-circle"><img src="{{ asset('assets/global/images/102.jpg') }}" alt=""> <i
                                        class="status status-away"></i></div>
                            <div class="media-body"><h6 class="media-heading">Aurora Nemet</h6>
                                <small>Lorem ipsum dolor sit amet</small>
                            </div>
                        </a><a href="javascript:void(0)" class="media">
                            <div class="avatar avatar-circle"><img src="{{ asset('assets/global/images/103.jpg') }}" alt=""> <i
                                        class="status status-busy"></i></div>
                            <div class="media-body"><h6 class="media-heading">Letisha Eroman</h6>
                                <small>Lorem ipsum dolor sit amet</small>
                            </div>
                        </a><a href="javascript:void(0)" class="media">
                            <div class="avatar avatar-circle"><img src="{{ asset('assets/global/images/105.jpg') }}" alt=""> <i
                                        class="status status-busy"></i></div>
                            <div class="media-body"><h6 class="media-heading">Zina Sivert</h6>
                                <small>Lorem ipsum dolor sit amet</small>
                            </div>
                        </a><a href="javascript:void(0)" class="media">
                            <div class="avatar avatar-circle"><img src="{{ asset('assets/global/images/211.jpg') }}" alt=""> <i
                                        class="status status-busy"></i></div>
                            <div class="media-body"><h6 class="media-heading">Annie Vanderbeek</h6>
                                <small>Lorem ipsum dolor sit amet</small>
                            </div>
                        </a><a href="javascript:void(0)" class="media">
                            <div class="avatar avatar-circle"><img src="{{ asset('assets/global/images/208.jpg') }}" alt=""> <i
                                        class="status status-busy"></i></div>
                            <div class="media-body"><h6 class="media-heading">Karoline Herrling</h6>
                                <small>Lorem ipsum dolor sit amet</small>
                            </div>
                        </a></div><!-- /.media-list --></div><!-- /.scroll-container --></div><!-- /.tab-pane -->
            <div role="tabpanel" class="tab-pane" id="notifications-panel">
                <div class="scroll-container">
                    <div class="py-4 px-3"><h6 class="text-uppercase m-0 text-muted">Notifications</h6></div>
                    <div class="media-list"><a href="javascript:void(0)" class="media"><span class="avatar bg-success"
                                                                                             data-plugin="firstLitter"
                                                                                             data-target="#notification-1"></span>
                            <div class="media-body"><h6 class="media-heading" id="notification-1">Raye Nolton</h6>
                                <small>Lorem ipsum dolor sit amet.</small>
                            </div>
                        </a><a href="javascript:void(0)" class="media"><span class="avatar bg-info"
                                                                             data-plugin="firstLitter"
                                                                             data-target="#notification-02"></span>
                            <div class="media-body"><h6 class="media-heading" id="notification-02">Lucretia
                                    Philipson</h6>
                                <small>Lorem ipsum dolor sit amet.</small>
                            </div>
                        </a><a href="javascript:void(0)" class="media"><span class="avatar bg-warning"
                                                                             data-plugin="firstLitter"
                                                                             data-target="#notification-2"></span>
                            <div class="media-body"><h6 class="media-heading" id="notification-2">Roxy Heckerman</h6>
                                <small>Lorem ipsum dolor sit amet</small>
                            </div>
                        </a><a href="javascript:void(0)" class="media"><span class="avatar bg-primary"
                                                                             data-plugin="firstLitter"
                                                                             data-target="#notification-3"></span>
                            <div class="media-body"><h6 class="media-heading" id="notification-3">Glennis Nest</h6>
                                <small>Lorem ipsum dolor sit amet</small>
                            </div>
                        </a><a href="javascript:void(0)" class="media"><span class="avatar bg-success"
                                                                             data-plugin="firstLitter"
                                                                             data-target="#notification-4"></span>
                            <div class="media-body"><h6 class="media-heading" id="notification-4">Basil Hugo</h6>
                                <small>Lorem ipsum dolor sit amet</small>
                            </div>
                        </a><a href="javascript:void(0)" class="media"><span class="avatar bg-danger"
                                                                             data-plugin="firstLitter"
                                                                             data-target="#notification-5"></span>
                            <div class="media-body"><h6 class="media-heading" id="notification-5">Anamaria
                                    Piedrahita</h6>
                                <small>Lorem ipsum dolor sit amet</small>
                            </div>
                        </a><a href="javascript:void(0)" class="media"><span class="avatar bg-primary"
                                                                             data-plugin="firstLitter"
                                                                             data-target="#notification-6"></span>
                            <div class="media-body"><h6 class="media-heading" id="notification-6">Karl SlomaLuanna</h6>
                                <small>Lorem ipsum dolor sit amet</small>
                            </div>
                        </a><a href="javascript:void(0)" class="media"><span class="avatar bg-success"
                                                                             data-plugin="firstLitter"
                                                                             data-target="#notification-7"></span>
                            <div class="media-body"><h6 class="media-heading" id="notification-7">Willa Santolucito</h6>
                                <small>Lorem ipsum dolor sit amet</small>
                            </div>
                        </a><a href="javascript:void(0)" class="media"><span class="avatar bg-info"
                                                                             data-plugin="firstLitter"
                                                                             data-target="#notification-8"></span>
                            <div class="media-body"><h6 class="media-heading" id="notification-8">Justin Bogaert</h6>
                                <small>Lorem ipsum dolor sit amet</small>
                            </div>
                        </a><a href="javascript:void(0)" class="media"><span class="avatar bg-warning"
                                                                             data-plugin="firstLitter"
                                                                             data-target="#notification-9"></span>
                            <div class="media-body"><h6 class="media-heading" id="notification-9">Gino Kinderknecht</h6>
                                <small>Lorem ipsum dolor sit amet</small>
                            </div>
                        </a></div><!-- /.media-list --></div><!-- /.scroll-container --></div><!-- /.tab-pane -->
            <div role="tabpanel" class="tab-pane" id="settings-panel">
                <div class="scroll-container">
                    <div class="py-4 px-3"><h6 class="text-uppercase m-0 text-muted">Account Settings</h6></div>
                    <div class="p-3">
                        <div class="d-flex mb-3"><label for="user-settings-option1">Show My username</label><span
                                    class="ml-auto"><input id="user-settings-option1" type="checkbox"
                                                           data-plugin="switchery" data-color="#60c84c"
                                                           data-size="small" checked="checked"></span></div>
                        <div class="d-flex mb-3"><label for="user-settings-option2">Make my profile public</label><span
                                    class="ml-auto"><input id="user-settings-option2" type="checkbox"
                                                           data-plugin="switchery" data-color="#60c84c"
                                                           data-size="small" checked="checked"></span></div>
                        <div class="d-flex mb-3"><label for="user-settings-option3">Allow cloud backups</label><span
                                    class="ml-auto"><input id="user-settings-option3" type="checkbox"
                                                           data-plugin="switchery" data-color="#60c84c"
                                                           data-size="small" checked="checked"></span></div>
                    </div><!-- /.p-3 --></div><!-- /.scroll-container --></div><!-- /.tab-pane --></div>
        <!-- /.tab-content --></div><!-- /.site-panel-tabs --></div>
<!-- Video modal -->
<div class="modal fade video-modal" id="video-modal" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <iframe src="about:blank" width="760" height="440" allowfullscreen></iframe>
        </div>
    </div>
</div>
<!-- #video-modal -->
@include('admin.layouts.partials._scripts')
</body>
</html>