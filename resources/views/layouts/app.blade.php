<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('template_title', 'Colegio Shaddai')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        :root {
            --navbar-bg-color: #000080; /* Azul pavo */
            --navbar-hover-color: #0000b3; /* Un tono más claro de azul pavo */
            --text-hover-color: #ffd700; /* Dorado para el hover del texto */
            --navbar-width: 20%; /* Ancho del navbar */
        }

        body {
            min-height: 100vh;
            margin: 0;
            padding: 0;
            display: flex;
        }

        .navbar-vertical {
            background: linear-gradient(to bottom, #1442f4, #021599);
            width: var(--navbar-width);
            height: 100vh;
            position: fixed;
            left: 0;
            top: 0;
            padding-top: 20px;
            transition: all 0.3s ease;
            overflow-y: auto;
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
        }


        @media (max-width: 768px) {
            .navbar-vertical {
                width: 100%;
                height: auto;
                position: relative;
            }

            .main-content {
                margin-left: 0;
            }

            body {
                flex-direction: column;
            }
        }
    </style>
</head>
<body>
<nav class="navbar-vertical">
    <div class="navbar-brand">
        <img src="{{ asset('imagenes/logo.png') }}" alt="Logo">

    </div>
    <ul class="nav flex-column">
        <li class="nav-item">
            <a class="nav-link" href="/inscripcions">
                <i class="fas fa-edit"></i>
                <span>Inscripcion de alumnos</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="/grados">
                <i class="fas fa-graduation-cap"></i>
                <span>Grados y Carreras</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#">
                <i class="fas fa-user"></i>
                <span>Alumnos</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="/pagos">
                <i class="fas fa-money-bill-wave"></i>
                <span>Pagos</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#">
                <i class="fas fa-check-circle"></i>
                <span>Solvencia de alumnos </span>
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

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
