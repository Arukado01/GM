<aside class="site-menubar">
    <div class="site-user">
        <div class="media align-items-center">
            <div class="media-body user-header hidden-top">
                <h6 class="mb-0">
                    <a href="javascript:void(0)" class="username">
                        {{ auth()->user()->full_name }}
                    </a>
                </h6>
                <div class="dropdown">
                    <a href="javascript:void(0)" class="dropdown-toggle usertitle" data-toggle="dropdown"
                       aria-haspopup="true" aria-expanded="false">
                        <small>{{ auth()->user()->role->name }}</small>
                        <span class="caret"></span>
                    </a>
                    <div class="dropdown-menu animated scaleInDownRight">
                        <a class="dropdown-item" href="{{ route('home') }}">
                            <span class="mr-1">
                                <i class="fa fa-home"></i>
                            </span>
                            <span>Inicio</span>
                        </a>
                        <a class="dropdown-item" href="{{ route('profile') }}">
                            <span class="mr-1">
                                <i class="fa fa-user"></i>
                            </span>
                            <span>Perfil</span>
                        </a>
                        <div role="separator" class="divider"></div>
                        <a class="dropdown-item" href="{{ route('logout') }}"
                           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <span class="mr-1">
                                <i class="fa fa-power-off"></i>
                            </span>
                            <span>Cerrar Sesión</span>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                {{ csrf_field() }}
                            </form>
                        </a>
                    </div>
                </div>
            </div>
            <a href="javascript:void(0)">
                <img class="avatar avatar-circle" id="avatar-sidebar"
                     src="{{ !empty(auth()->user()->avatar)
                                ? auth()->user()->avatar
                                : asset('assets/global/images/avatar5.png') }}"
                     alt="avatar">
            </a>
            <!-- /.media-body -->
        </div>
        <!-- ./media -->
    </div>
    <!-- ./site-user -->
    <div class="menubar-scroll-wrapper">
        <ul class="site-menu"></ul><!-- .site-menu -->
    </div>
    <!-- /.menubar-scroll-wrapper -->
</aside>