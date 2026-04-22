<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Sistema Lavera</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Iconos -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body {
            background-color: #f4f6f9;
        }

        .sidebar {
            width: 250px;
            height: 100vh;
            position: fixed;
            background: #fff;
            border-right: 1px solid #ddd;
            padding-top: 10px;
        }

        .sidebar h5 {
            padding: 15px;
            color: #0d6efd;
        }

        .sidebar a {
            display: block;
            padding: 12px 20px;
            color: #333;
            text-decoration: none;
        }

        .sidebar a:hover {
            background: #f0f0f0;
        }

        .content {
            margin-left: 250px;
            padding: 20px;
        }

        .card-box {
            border-radius: 15px;
            border: none;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            position: relative;
        }

        .card-icon {
            position: absolute;
            right: 15px;
            top: 15px;
            font-size: 24px;
            padding: 10px;
            border-radius: 10px;
            color: #fff;
        }

        .bg-blue { background: #3b82f6; }
        .bg-green { background: #10b981; }
        .bg-orange { background: #f59e0b; }
        .bg-cyan { background: #06b6d4; }
    </style>
</head>

<body>

<!-- SIDEBAR -->
<div class="sidebar">

    <h5>SISTEMA LAVERA</h5>

    <a href="{{ route('dashboard') }}">
        <i class="bi bi-speedometer2"></i> Dashboard
    </a>

    <a href="{{ route('lavados.index') }}">
        <i class="bi bi-car-front"></i> Lavados
    </a>

    <a href="{{ route('clientes.index') }}">
        <i class="bi bi-people"></i> Clientes
    </a>

    <a href="{{ route('trabajadores.index') }}">
        <i class="bi bi-person-badge"></i> Trabajadores
    </a>

    <a href="{{ route('servicios.index') }}">
        <i class="bi bi-gear"></i> Servicios
    </a>

    <a href="{{ route('motos.index') }}">
        <i class="bi bi-truck"></i> Motos
    </a>

    <a href="#">
        <i class="bi bi-bar-chart"></i> Reportes
    </a>

</div>

<!-- CONTENIDO -->
<div class="content">
    @yield('content')
</div>

</body>
</html>