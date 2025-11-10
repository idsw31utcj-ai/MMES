<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bienvenido</title>
    <link rel="stylesheet" href="{{ asset('css/Usercs.css') }}">
</head>
<body>
    <header class="banner">
        <h1>Tareas pendientes</h1>
    </header>
    <main class="container">
        <nav class="sidebar">
            <h2>Bienvenido</h2>
            <ul class="side-buttons">
            </ul>
            <div class="user-info">
                <h2>Usuario Logueado</h2>
                <p><strong>Nombre:</strong> {{ $user->username }}</p>
                <p><strong>Número reloj:</strong> {{ $user->clock_number }}</p>
                <p><strong>Posición:</strong> {{ $user->position }}</p> <!-- Cambiado de Rol a Posición -->
                <div class="logout">
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="button logout-button">Cerrar sesión</button>
                    </form>
                </div>
            </div>
        </nav>
        <section class="content">
            <h2>Lista de tareas</h2>
            <div style="position: relative; text-align: right;">
                
                <button class="refresh-button" onclick="window.location.reload();">Actualizar</button>
            </div>
            <ul class="task-list">
                @foreach($tasks as $task)
                    <li class="task-item">
                        <p><strong>Número de Máquina:</strong> {{ $task->machine->machine_number ?? 'Desconocido' }}</p>
                        <p><strong>Fecha Límite:</strong> {{ $task->due_date->format('d/m/Y') }}</p>
                        <p><strong>Estado:</strong> {{ $task->status_task }}</p>
                        <button onclick="window.location.href='{{ route('task', $task->id) }}'" class="view-details">Ver Detalles</button>
                    </li>
                    <hr>
                @endforeach
            </ul>
        </section>
    </main>
    <footer class="footer">
        <p>Datos reservados</p>
    </footer>
</body>
</html>
