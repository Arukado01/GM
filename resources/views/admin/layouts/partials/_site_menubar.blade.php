<aside class="site-menubar">
    <div class="site-user">
        <div class="media align-items-center">
            <a href="javascript:void(0)">
                <img class="avatar avatar-circle" id="avatar-sidebar"
                     src="{{ !empty(auth()->user()->avatar) ?
                            auth()->user()->avatar :
                            asset('assets/global/images/avatar5.png') }}"
                     alt="avatar">
            </a>
            <div class="media-body hidden-fold">
                <h6 class="mborder-a-0 username">
                    {{ auth()->user()->full_name }}
                </h6>
                <div class="dropdown">
                    <a href="javascript:void(0)" class="dropdown-toggle usertitle" data-toggle="dropdown"
                       aria-haspopup="true" aria-expanded="false">
                        <small>{{ auth()->user()->role->name }}</small>
                        <span class="caret"></span>
                    </a>
                    <div class="dropdown-menu animated scaleInDownRight">
                        <a class="dropdown-item" href="{{ route('admin.dashboard') }}">
                            <span class="mr-1">
                                <i class="fa fa-home"></i>
                            </span>
                            <span>Inicio</span>
                        </a>
                        <a class="dropdown-item" href="{{ route('admin.users.profile') }}">
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
                        </a>
                    </div>
                </div>
            </div>
            {{-- /.media-body --}}
        </div>
        {{--./media--}}
    </div>
    {{--./site-user--}}
    <div class="menubar-scroll-wrapper">
        <div class="site-menubar-inner">
            <ul class="site-menu">
                <li class="{{ request()->is('admin/dashboard') ? 'active open' : '' }}">
                    <a href="{{ route('admin.dashboard') }}">
                        <i class="menu-icon zmdi zmdi-view-dashboard zmdi-hc-lg"></i>
                        <span class="menu-text">Inicio</span>
                    </a>
                </li>
                {{--<li>
                    <a href="javascript:void(0)" class="submenu-toggle">
                        <i class="menu-icon zmdi zmdi-layers zmdi-hc-lg"></i>
                        <span class="menu-text">Layouts</span>
                        <i class="menu-caret zmdi zmdi-hc-sm zmdi-chevron-right"></i>
                    </a>
                    <ul class="submenu">
                        <li><a href="../leftbar/index.html"><span class="menu-text">Leftbar</span></a></li>
                        <li><a href="../topbar/index.html"><span class="menu-text">Topbar</span></a></li>
                    </ul>
                </li>--}}
                @if(auth()->user()->isAdmin())
                    <li class="{{ request()->is('admin/users/*') ? 'active open' : '' }}">
                        <a href="javascript:void(0)" class="submenu-toggle">
                            <i class="menu-icon zmdi zmdi-accounts zmdi-hc-lg"></i>
                            <span class="menu-text">Usuarios</span>
                            <i class="menu-caret zmdi zmdi-hc-sm zmdi-chevron-right"></i>
                        </a>
                        <ul class="submenu">
                            <li class="{{ request()->is("admin/users/create") ? 'active' : '' }}">
                                <a href="{{ route('admin.users.create') }}">
                                    <span class="menu-text">Crear Nuevo Usuario</span>
                                </a>
                            </li>
                            <li class="{{ request()->is("admin/users/roles/$role_admin") ? 'active' : '' }}">
                                <a href="{{ route('admin.users.index', ['role_id' => $role_admin]) }}">
                                    <span class="menu-text">Administradores</span>
                                    <span class="badge badge-primary menu-badge">{{ $admins }}</span>
                                </a>
                            </li>
                            <li class="{{ request()->is("admin/users/roles/$role_supervisors") ? 'active' : '' }}">
                                <a href="{{ route('admin.users.index', ['role_id' => $role_supervisors]) }}">
                                    <span class="menu-text">Supervisores</span>
                                    <span class="badge badge-success menu-badge">{{ $supervisors }}</span>
                                </a>
                            </li>
                            <li class="{{ request()->is("admin/users/roles/$role_clients") ? 'active' : '' }}">
                                <a href="{{ route('admin.users.index', ['role_id' => $role_clients]) }}">
                                    <span class="menu-text">Clientes</span>
                                    <span class="badge badge-warning menu-badge">{{ $clients }}</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                @endif

                @if(auth()->user()->isAdminOrSupervisor())
                    <li class="{{ request()->is('admin/projects') || request()->is('admin/projects/*') ? 'active open' : '' }}">
                        <a href="{{ route('admin.projects.index') }}">
                            <i class="menu-icon zmdi zmdi-view-dashboard zmdi-hc-lg"></i>
                            <span class="menu-text">Proyectos</span>
                        </a>
                    </li>
                @endif
               {{-- <li>
                    <a href="javascript:void(0)" class="submenu-toggle">
                        <i class="menu-icon zmdi zmdi-apps zmdi-hc-lg"></i>
                        <span class="menu-text">Apps</span>
                        <span class="badge badge-info menu-badge pull-left">2</span>
                        <i class="menu-caret zmdi zmdi-hc-sm zmdi-chevron-right pull-right"></i>
                    </a>
                    <ul class="submenu">
                        <li><a href="calendar.html"><span class="menu-text">Calendar</span></a></li>
                        <li><a href="contacts.html"><span class="menu-text">Contacts</span></a></li>
                    </ul>
                </li>
                <li class="menu-separator">
                    <hr>
                </li>
                <li>
                    <a href="documentation.html"><i class="menu-icon zmdi zmdi-file-text zmdi-hc-lg"></i>
                        <span class="menu-text">Documentation</span>
                    </a>
                </li>--}}
            </ul>
            {{-- .site-menu --}}
        </div>
        {{-- .menubar-scroll-inner --}}
    </div>
    {{-- /.menubar-scroll-wrapper --}}
</aside>