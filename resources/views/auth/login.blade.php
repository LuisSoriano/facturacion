<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="Inicio de sesión del sistema" />
    <meta name="author" content="SakCode" />
    <title>Sistema de ventas - Login</title>
    <link href="{{ asset('css/styles.css') }}" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.1.0/js/all.js" crossorigin="anonymous"></script>
</head>

<body class="bg-secondary">
    <!--Barra de navegación--->
    <nav class="navbar navbar-expand-md bg-success navbar-dark">
        <div class="container-fluid">
            <!---Marca navegación-->
            <a class="navbar-brand" href="{{route('panel')}}">
                <img src="{{ asset('assets/img/icon.png') }}" alt="Logo" width="30" height="30" class="d-inline-block align-text-top">
                SIFEL - VUCE INSO
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <!----Lista de opciones del menú-->
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="{{route('panel')}}">Inicio</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Acerca de</a>
                    </li>
                </ul>

            </div>
        </div>
    </nav>
    
    <div id="layoutAuthentication">
        <div id="layoutAuthentication_content">
            <main class="d-flex align-items-center vh-100">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-5">
                            <div class="card shadow-lg border-0 rounded-lg">
                                <div class="card-header">
                                    <h3 class="text-center font-weight-light my-4">Acceso al sistema</h3>
                                    <div class="d-flex justify-content-center">
                                        <a class="navbar-brand" href="{{route('panel')}}">
                                            <img src="{{ asset('assets/img/icon.png') }}" alt="Logo" width="30" height="30" class="d-inline-block align-text-center">
                                            SIFEL\VUCE INSO
                                        </a>
                                    </div>
                                </div>
                                <div class="card-body">
                                    @if ($errors->any())
                                        @foreach ($errors->all() as $item)
                                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                                {{$item}}
                                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                            </div>
                                        @endforeach
                                    @endif
                                    
                                    <form action="{{route('login.login')}}" method="post">
                                        @csrf
                                        <div class="form-floating mb-3">
                                            <input autofocus autocomplete="off"  class="form-control" name="email" id="inputEmail" type="email" value="admin@admin.com" placeholder="name@example.com" />
                                            <label for="inputEmail">Correo eléctronico</label>
                                        </div>
                                        <div class="form-floating mb-3">
                                            <input class="form-control" name="password" id="inputPassword" type="password"value ="12345678" placeholder="Password" />
                                            <label for="inputPassword">Contraseña</label>
                                        </div>
                                        <div class="d-flex align-items-center justify-content-between mt-4 mb-0">
                                            <button class="btn btn-primary w-100 py-2" type="submit">Iniciar sesión</button>
                                        </div>
                                        <a class="py-2" href="{{ route('register') }}">
                                            Crear una cuenta nueva
                                        </a>
                                        
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
        <div id="layoutAuthentication_footer">
            <footer class="py-4 bg-light mt-auto">
                <div class="container-fluid px-4">
                    <div class="d-flex align-items-center justify-content-between small">
                        <div class="text-muted">Copyright &copy; Your Website 2022</div>
                        <div>
                            <a href="#">Privacy Policy</a>
                            &middot;
                            <a href="#">Terms &amp; Conditions</a>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
</body>

</html>