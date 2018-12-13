<nav class="navbar navbar-vertical fixed-left navbar-expand-md navbar-light bg-white" id="sidenav-main">
    <div class="container-fluid">
        <div class="collapse navbar-collapse" id="sidenav-collapse-main">

            <a class="navbar-brand pt-0" href="../index.html">
                <img src=" ../../../assets/img/brand/blue.png" class="navbar-brand-img" alt="...">
            </a>
            <img src="../../../assets/img/brand/logo3.png" align="center" width="100" height="150">
            <!-- Collapse header -->
            <div class="navbar-collapse-header d-md-none">
                <div class="row">

                    <div class="col-6 collapse-close">
                        <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#sidenav-collapse-main" aria-controls="sidenav-main" aria-expanded="false" aria-label="Toggle sidenav">
                            <span></span>
                            <span></span>
                        </button>
                    </div>
                </div>
            </div>
            <!-- Form -->
            <form class="mt-4 mb-3 d-md-none">
                <div class="input-group input-group-rounded input-group-merge">
                    <input type="search" class="form-control form-control-rounded form-control-prepended" placeholder="Search" aria-label="Search">
                    <div class="input-group-prepend">
                        <div class="input-group-text">
                            <span class="fa fa-search"></span>
                        </div>
                    </div>
                </div>
            </form>
            <!-- Navigation -->

            <!-- AQUI PONER EL MENU DEL ADMINISTRADOR -->

            <ul class="navbar-nav">
            @if (auth::user ()->myActualRole () == 1)
                <li class="nav-item">
                    <a class="nav-link" href="{{ url('zona') }}">
                        <i class="ni ni-world"></i> Zonas
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="{{ url('parqueo_admin') }}">
                        <i class="ni ni-pin-3"></i> Parqueos Registrados
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="{{ url('users') }}">
                        <i class="ni ni-circle-08 text-black"></i> Usuarios
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="{{ url('reservas') }}">
                        <i class="ni ni-single-copy-04"></i> Reservas
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="{{ url('validacion') }}">
                        <i class="ni ni-key-25"></i> validacion parqueos
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="{{ url('reservaValidacion') }}">
                        <i class="ni ni-calendar-grid-58"></i> Visitas validacion
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="{{ url('roles') }}">
                        <i class="ni ni-circle-08 text-black"></i> Roles
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="{{ route('logout') }}"
                       onclick="event.preventDefault();
                               document.getElementById('logout-form').submit();">
                               <i class="ni ni-button-power text-red"></i> Cerrar Sesión
                    </a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </li>

            <!-- AQUI PONER EL MENU DEL USUARIO -->
            @elseif (auth::user()->myActualRole () == 2)

                <li class="nav-item">
                    <a class="nav-link" href="/">
                        <i class="ni ni-square-pin"></i> Buscar Parqueos
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ url('list') }}">
                        <i class="ni ni-bus-front-12"></i> Vehiculos Registrados
                    </a>
                </li>
                <li class="nav-item">
                        <a class="nav-link" href="{{ url('reservacliente') }}">
                            <i class="ni ni-single-02"></i> Reservas
                        </a>
                    </li>
                <li class="nav-item">
                    <a class="nav-link" href="">
                        <i class="ni ni-favourite-28"></i> Parqueos Favoritos
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="{{ action('DenunciaController@create') }}">
                        <i class="ni ni-collection"></i>realizar denuncia
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="">
                        <i class="ni ni-settings"></i> Editar Perfil
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="{{ route('logout') }}"
                       onclick="event.preventDefault();
                               document.getElementById('logout-form').submit();">
                               <i class="ni ni-button-power text-red"></i> Cerrar Sesión
                    </a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </li>


            <!-- AQUI PONER EL MENU DEL OWNER -->
            @else
                <li class="nav-item">
                    <a class="nav-link" href="{{ url('zona') }}">
                        <i class="ni ni-world"></i> Zonas
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="{{ url('parqueos') }}">
                        <i class="ni ni-pin-3"></i> Parqueos
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="{{ url('reservasanfitrion') }}">
                        <i class="ni ni-single-02"></i> Reservas
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="{{ url('notificacion') }}">
                        <i class="ni ni-bell-55"></i> Notificaciones
                    </a>
                </li>


                <li class="nav-item">
                    <a class="nav-link" href="{{ route('logout') }}"
                       onclick="event.preventDefault();
                               document.getElementById('logout-form').submit();">
                               <i class="ni ni-button-power text-red"></i> Cerrar Sesión
                    </a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </li>

            @endif
            @if (auth::user()->hasRole ('Admin') && auth::user ()->myActualRole () != 1)
            <li class="nav-item">
                <a class="nav-link" href="{{ url('roles') }}">
                    <i class="ni ni-circle-08 text-pink"></i>Modo Administrador
                </a>
            </li>
            @endif

            @if (auth::user()->hasRole ('User') && auth::user ()->myActualRole () != 2)
            <li class="nav-item">
                <a class="nav-link" href="{{ url('/') }}">
                    <i class="ni ni-circle-08 text-blue"></i>Modo Usuario
                </a>
            </li>
            @endif

            @if (auth::user()->hasRole ('Owner') && auth::user ()->myActualRole () != 3)
            <li class="nav-item">
                <a class="nav-link" href="{{ url('zona') }}">
                    <i class="ni ni-circle-08 text-yellow"></i>Modo Host
                </a>
            </li>
            @endif

            </ul>

            <!-- Divider -->
            <hr class="my-3">
            <!-- Heading -->

            <!-- Navigation -->

        </div>
    </div>
</nav>
