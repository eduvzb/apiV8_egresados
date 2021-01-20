<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin</title>

    <link rel="stylesheet" href="/css/app.css">
    <link type="image/x-icon" href="https://upload.wikimedia.org/wikipedia/commons/b/bf/Tec-Tuxtla_Logo.svg" rel="icon" />
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

</head>
<body class="hold-transition sidebar-mini">
    <div id="app">
        <div class="wrapper">

            <nav class="main-header navbar navbar-expand navbar-light" style="background-color: #76A7F5;">
                <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="material-icons">menu</i></a>
                        </li>
                        <li class="nav-item d-none d-sm-inline-block">
                            <a href="{{url('/')}}" class="nav-link">Home</a>
                        </li>
                    </ul>

                    <div class="collapse navbar-collapse">
                        <ul class="navbar-nav ml-auto">
                            <li class="nav-item">
                                <a href="{{ route('register.request')}}" class="nav-link">Registrar Usuario</a>
                            </li>
                        </ul>
                    </div>
            </nav>

            <aside class="main-sidebar sidebar-dark-primary elevation-4">
                <a href="{{ url('/') }}" class="brand-link">
                <img src="assets/img/icon.png" class="brand-image img-circle elevation-3" style="opacity: .8">
                <span class="brand-text font-weight-light">ITTG</span>
                </a>

                <div class="sidebar">
                <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                    <!--
                    <div class="image">
                    <img src="../../dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
                    </div>
                    -->
                    
                </div>

                <div class = "sidebar">
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

                    <li class="nav-item">
                        <a href="#" class="nav-link active">
                        <i class="fas fa-angle-left right material-icons">school</i>
                            <p>Egresados<i class="fas fa-angle-left right material-icons">school</i></p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{route('egresados.filtrar')}}" class="nav-link">
                                <p>Ver Egresados</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                    
                    <li class="nav-item">
                        <a href="#" class="nav-link active">
                            <i class="fas fa-angle-left right material-icons">text_snippet</i>
                            <p>Trámites<i class="fas fa-angle-left right material-icons">text_snippet</i></p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{route('tramite.filtrar')}}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Ver Trámites</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{url('crearTramite')}}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Crear Trámite</p>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <li class="nav-item">
                        <a href="#" class="nav-link active">
                            <i class="fas fa-angle-left right material-icons">event_available</i>
                            <p>Citas<i class="fas fa-angle-left right material-icons">event_available</i></p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{route('citas.filtrar')}}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Ver Citas</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{route('citas.noEnviadas')}}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Citas No Enviadas</p>
                                </a>
                            </li>
                        </ul>
                    </li>

                </nav>
                </div>
                
                <div class="user-panel mt-3 pb-3 mb-3 d-flex"></div>
                
                    <nav class="mt-2">
                        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

                        <li class="nav-item">
                        <i class="nav-icon far fa-circle text-danger material-icons">exit_to_app</i>
                            <a href="{{ route('logout') }}" 
                            onclick="event.preventDefault();
                                        document.getElementById('logout-form').submit();">
                            {{ __('Cerrar Sesion') }}
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                            </a>
                        </li>
                    </nav>
                </div>
            </aside>

            <main class="py-0">
            @yield('content')
            </main>
        </div>
    </div>
</body>
</html>

<script src="/js/app.js"></script>