<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio</title>
    <link rel="stylesheet" href="{{ asset('css/inic.css') }}">
</head>
<body>
    <header class="banner">
        <h1>BIENVENIDO</h1>
    </header>
    <main class="container">
        <section class="main-wrapper">
            <div class="side-container">
                <div class="user-info">
                    <h2>Usuario Logueado</h2>
                    <p><strong>Nombre:</strong> {{ $user->username }}</p>
                    <p><strong>Número de Reloj:</strong> {{ $user->clock_number }}</p>
                    <p><strong>Posición:</strong> {{ $user->position }}</p>
                    <div class="logout">
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit">Cerrar sesión</button>
                        </form>
                    </div>
                </div>
                <nav class="side-buttons">
                    <ul>
                        <li><a href="{{ url('/adminmaquinas') }}">Administración de Máquinas</a></li>
                        <li><a href="{{ url('/asignacion') }}">Asignar trabajo preventivo</a></li>
                        <li><a href="{{ url('/historial') }}">Historial</a></li>
                        <li><a href="{{ url('/preventivos') }}">Datos preventivos</a></li>
                        <li><a href="{{ url('/usuarios') }}">Administración de usuarios</a></li>
                        <li><a href="{{ url('/preventivos-en-curso') }}">Preventivos en curso</a></li>
                    </ul>
                </nav>
            </div>
            <div class="main-container">
    <article class="machine-info">
        <h2>Machine Maintenance Essential Software</h2>
        <img src="{{ asset('images/log.png') }}" alt="Máquina" style="max-width: 100%; height: auto;">
        <p>Bienvenido al sistema de gestión del mantenimiento. Aquí encontrarás herramientas para gestionar el mantenimiento preventivo de nuestras máquinas.</p>
        <p>Explora las opciones en el menú para acceder a las funcionalidades del sistema y contribuir a un mantenimiento eficiente.</p>
    </article>
</div>

        </section>
    </main>
    <footer class="footer">
        <p>Datos reservados</p>
    </footer>
</body>
</html>

