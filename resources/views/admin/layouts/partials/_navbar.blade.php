<nav class="site-navbar navbar fixed-top navbar-toggleable-sm bg-indigo-500 navbar-inverse">
    <!-- navbar header -->
    <div class="navbar-header">
        <a href="{{ route('admin.dashboard') }}" class="navbar-brand">
        <span class="brand-icon">
          GM
        </span>
            <span class="brand-name hidden-fold">Proyectos S.A.S</span>
        </a>
        <button data-toggle="menubar" class="mr-auto hidden-md-up hamburger hamburger--collapse js-hamburger"
                type="button">
        <span class="hamburger-box">
          <span class="hamburger-inner"></span>
        </span>
        </button>
        <button type="button" class="navbar-toggler hidden-md-up collapsed" data-toggle="site-search">
            <span class="sr-only">Toggle navigation</span>
            <span class="zmdi zmdi-hc-lg zmdi-search"></span>
        </button>
        <button type="button" class="navbar-toggler hidden-md-up collapsed" data-toggle="collapse"
                data-target="#site-navbar-collapse" aria-expanded="false">
            <span class="sr-only">Toggle navigation</span>
            <span class="zmdi zmdi-hc-lg zmdi-more"></span>
        </button>
    </div>
    <!-- .navbar-header -->
    <div class="collapse navbar-collapse" id="site-navbar-collapse">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item hidden-sm-down">
                <button data-toggle="menubar-fold" class="nav-link hamburger hamburger--arrowalt is-active js-hamburger"
                        type="button"><span class="hamburger-box"><span class="hamburger-inner"></span></span></button>
            </li>
            <li class="nav-item d-flex align-items-center">
                <h5 class="hidden-sm-down m-0 ml-3 page-title">Inicio</h5>
            </li>
        </ul>
        <ul class="navbar-nav">
            <li class="nav-item dropdown">
                <a href="javascript:void(0)" class="nav-link dropdown-toggle" data-toggle="dropdown" role="button"
                   aria-haspopup="true" aria-expanded="false">
                    <i class="zmdi zmdi-hc-lg zmdi-settings"></i>
                </a>
                <div class="dropdown-menu float-right animated scaleInDownLeft">
                    <a href="{{ route('admin.users.profile') }}" class="dropdown-item py-3">
                        <i class="zmdi mr-3 zmdi-hc-lg zmdi-account-box"></i>Perfil
                    </a>

                    <a href="{{ route('logout') }}" class="dropdown-item py-3"
                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="zmdi mr-3 zmdi-hc-lg zmdi-power"></i>Cerrar Sesión
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            {{ csrf_field() }}
                        </form>
                    </a>
                </div>
            </li>
        </ul>
    </div>
    <!-- /.navbar-collapse -->
</nav>