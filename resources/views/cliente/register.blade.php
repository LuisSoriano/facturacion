<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="Solicitud de cuenta - SIFEL VUCE" />
    <meta name="author" content="SakCode" />
    <title>SIFEL/VUCE - Registro</title>
    <link href="{{ asset('css/styles.css') }}" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.1.0/js/all.js" crossorigin="anonymous"></script>
</head>

<body class="bg-light">
    <nav class="navbar navbar-expand-md bg-success navbar-dark shadow-sm">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{route('panel')}}">
                <img src="{{ asset('assets/img/icon.png') }}" alt="Logo" width="30" height="30" class="d-inline-block align-text-top">
                SIFEL \ VUCE INSO
            </a>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('login.index')}}">Regresar al Login</a>
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
                        <div class="col-lg-6">
                            <div class="card shadow-lg border-0 rounded-lg">
                                <div class="card-header bg-white text-center py-4">
                                    <div class="mb-3">
                                        <i class="fas fa-user-shield fa-3x text-success"></i>
                                    </div>
                                    <h3 class="font-weight-light">Solicitud de Registro</h3>
                                </div>
                                <div class="card-body p-5 text-center">
                                    <h5 class="text-secondary mb-4">¿No tienes una cuenta?</h5>
                                    <p class="lead mb-4">
                                        Por motivos de seguridad y normatividad de medicina laboral, la creación de usuarios es gestionada exclusivamente por la administración del <strong>INSO</strong>.
                                    </p>
                                    
                                    <div class="alert alert-info border-0 shadow-sm mb-4 text-start">
                                        <div class="d-flex">
                                            <div class="me-3">
                                                <i class="fas fa-info-circle fa-2x"></i>
                                            </div>
                                            <div>
                                                <strong>Instrucciones:</strong><br>
                                                Debe ponerse en contacto con el departamento de sistemas o su gestor asignado en el INSO para proporcionar su documentación y formalizar el alta en el sistema SIFELCE.
                                            </div>
                                        </div>
                                    </div>

                                    <div class="d-grid gap-2">
                                        <a href="mailto:soporte@inso.gob.bo" class="btn btn-success py-2">
                                            <i class="fas fa-envelope me-2"></i>Contactar por Correo
                                        </a>
                                        <a href="{{route('panel')}}" class="btn btn-link text-decoration-none text-muted">
                                            Volver al inicio
                                        </a>
                                    </div>
                                </div>
                                <div class="card-footer bg-light text-center py-3">
                                    <small class="text-muted">Sistema Integrado de Facturacion Electronica y Comercio Exterior INSO</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
        
        <div id="layoutAuthentication_footer">
            <footer class="py-4 bg-white border-top mt-auto">
                <div class="container-fluid px-4">
                    <div class="d-flex align-items-center justify-content-between small">
                        <div class="text-muted">Copyright &copy; INSO - VUCE {{ date('Y') }}</div>
                        <div>
                            <a href="#" class="text-decoration-none text-muted">Política de Privacidad</a>
                            &middot;
                            <a href="#" class="text-decoration-none text-muted">Términos y Condiciones</a>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>