<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('template_title', 'Colegio Shaddai')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.22/js/dataTables.bootstrap5.min.js"></script>
    <link rel="stylesheet" href="/css/admin_custom.css">
    <link href="https://cdn.datatables.net/1.10.22/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>

    <style>
        :root {
            --navbar-bg-color: #000080;
            --navbar-hover-color: #0000b3;
            --text-hover-color: #ffd700;
            --navbar-width: 285px;
        }

        body {
            min-height: 100vh;
            margin: 0;
            padding: 0;
            display: flex;
        }

        .navbar-vertical {
            background: linear-gradient(to bottom, #002878, #021599);
            width: var(--navbar-width);
            height: 100vh;
            position: fixed;
            left: 0;
            top: 0;
            padding-top: 20px;
            transition: all 0.3s ease;
            overflow-y: auto;
            z-index: 1000;
        }

        .navbar-brand {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100px;
            margin-bottom: 20px;
        }

        .navbar-brand img {
            max-height: 100px;
            max-width: 90%;
            object-fit: contain;
        }

        .nav-link {
            color: white !important;
            padding: 15px 20px;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
        }

        .nav-link:hover {
            background-color: var(--navbar-hover-color);
            transform: translateX(10px);
        }
        .nav-item.active, .nav-item.active .nav-link, .nav-item.active .nav-link span {
            background-color: var(--navbar-hover-color); /* Fondo resaltado */
            color: var(--text-hover-color); /* Color de texto resaltado */
        }

        .nav-item.active .nav-link {
            transform: translateX(10px); /* Mantiene el efecto de desplazamiento */
        }

        .nav-item.active .nav-link span {
            transform: scale(1.05); /* Resalta el texto */
        }

        .nav-link i {
            font-size: 1.2rem;
            margin-right: 15px;
            width: 20px;
            text-align: center;
        }

        .nav-link span {
            font-size: 1rem;
            transition: all 0.3s ease;
        }

        .nav-link:hover span {
            color: var(--text-hover-color);
            transform: scale(1.05);
        }

        .main-content {
            margin-left: var(--navbar-width);
            padding: 20px;
            flex-grow: 1;
            transition: margin-left 0.3s ease;
        }

        #sidebarToggle {
            position: fixed;
            top: 10px;
            left: 10px;
            z-index: 1001;
            background-color: var(--navbar-bg-color);
            color: white;
            border: none;
            padding: 10px;
            border-radius: 5px;
            cursor: pointer;
            display: none;
        }
        /* Flecha por defecto: Apunta hacia la derecha */
        .rotate-icon {
            transition: transform 0.3s ease; /* Transición suave */
        }

        /* Flecha rotada: Apunta hacia abajo cuando el submenú está expandido */
        .nav-link[aria-expanded="true"] .rotate-icon {
            transform: rotate(90deg);
        }


        @media (max-width: 768px) {
            .navbar-vertical {
                transform: translateX(-100%);
            }

            .navbar-vertical.show {
                transform: translateX(0);
            }

            .main-content {
                margin-left: 0;
            }

            #sidebarToggle {
                display: block;
            }

            body {
                flex-direction: column;
            }
        }
    </style>
</head>

<body>
<button id="sidebarToggle" aria-label="Toggle Sidebar">
    <i class="fas fa-bars"></i>
</button>

<nav class="navbar-vertical">
    <div class="navbar-brand">
        <a href="{{ route('home') }}">
            <img src="{{ asset('imagenes/logo.png') }}" alt="Logo">
        </a>
    </div>
    <ul class="nav flex-column">

        <li class="nav-item {{ request()->is('home') ? 'active' : '' }}">
            <a class="nav-link" href="/home">
                <i class="fas fa-home"></i>
                <span>Inicio</span>
            </a>
        </li>

        <li class="nav-item">
            <!-- Menú principal: Alumno -->
            <a class="nav-link d-flex justify-content-between align-items-center"
               data-bs-toggle="collapse"
               href="#submenu-alumno"
               role="button"
               aria-expanded="{{ request()->is('registro-alumnos*') ? 'true' : 'false' }}"
               aria-controls="submenu-alumno">
                <div>
                    <i class="fas fa-user"></i>
                    <span>Alumno</span>
                </div>
                <i class="fas fa-chevron-right ms-2 rotate-icon" style="font-size: 0.8rem;"
                   aria-hidden="true"></i>
            </a>
            <!-- Submenús -->
            <div class="collapse {{ request()->is('registro-alumnos*') ? 'show' : '' }}" id="submenu-alumno">
                <ul class="list-unstyled ps-3">
                    <li class="nav-item {{ request()->is('registro-alumnos/create') ? 'active' : '' }}">
                        <a class="nav-link" href="/registro-alumnos/create">
                            <i class="fas fa-user-plus"></i>
                            <span>Registrar Alumno</span>
                        </a>
                    </li>
                    <li class="nav-item {{ request()->is('registro-alumnos') ? 'active' : '' }}">
                        <a class="nav-link" href="/registro-alumnos">
                            <i class="fas fa-list"></i>
                            <span>Lista de Alumnos</span>
                        </a>
                    </li>
                </ul>
            </div>
        </li>




        <li class="nav-item {{ request()->is('inscripcions') ? 'active' : '' }}">
            <a class="nav-link" href="/inscripcions">
                <i class="fas fa-edit"></i>
                <span>Lista de Alumnos Inscritos</span>
            </a>
        </li>

        <li class="nav-item {{ request()->is('grados') ? 'active' : '' }}">
            <a class="nav-link" href="/grados">
                <i class="fas fa-graduation-cap"></i>
                <span>Grados y Carreras</span>
            </a>
        </li>

        <li class="nav-item {{ request()->is('pagos/create') ? 'active' : '' }}">
            <a class="nav-link" href="/pagos/create">
                <i class="fas fa-money-bill-wave"></i>
                <span>Pagos</span>
            </a>
        </li>
        <li class="nav-item {{ request()->is('pagos/inscripcion*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('pagos.indexp') }}">
                <i class="fas fa-user-check"></i>
                <span>Pagos de inscripción</span>
            </a>
        </li>

        <li class="nav-item {{ request()->is('pagos') ? 'active' : '' }}">
            <a class="nav-link" href="/pagos">
                <i class="fas fa-check-circle"></i>
                <span>Solvencia de alumnos</span>
            </a>
        </li>

        <li class="nav-item {{ request()->is('tipopagos') ? 'active' : '' }}">
            <a class="nav-link" href="/tipopagos">
                <i class="bi bi-credit-card me-2"></i>
                <span>Tipo de pagos</span>
            </a>
        </li>

        <li class="nav-item {{ request()->is('contrato') ? 'active' : '' }}">
            <a class="nav-link" href="/contrato">
                <i class="bi bi-file-earmark-text "></i>
                <span>Contrato de adhesión</span>
            </a>
        </li>
        <li class="nav-item {{ request()->is(' ') ? 'active' : '' }}">
            <a class="nav-link" href="/reglamento">
                <i class="bi bi-journal-text me-2"></i>
                <span>Reglamento interno</span>
            </a>
        </li>
        <li class="nav-item">
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
            <a class="nav-link" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <i class="fas fa-sign-out-alt"></i>
                <span>Cerrar sesión</span>
            </a>
        </li>
    </ul>
</nav>


<div class="main-content">
    @yield('content')
</div>

</body>
</html>
