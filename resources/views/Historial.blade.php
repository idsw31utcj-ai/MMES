<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Historial de Preventivos</title>
    <link rel="stylesheet" href="{{ asset('css/MainSS.css') }}">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        .maintenance-item {
            margin-bottom: 10px;
        }

        .maintenance-item + hr {
            margin: 20px 0;
        }

        /* Agregar estilos para el filtro */
        .filter-container {
            margin-bottom: 20px;
        }

        .filter-container select {
            padding: 5px;
            font-size: 16px;
        }
    </style>
</head>
<body>
    <header class="banner">
        <h1 style="text-align: center;">Historial de Mantenimiento</h1>
    </header>
    <main class="container">
        <nav class="sidebar">
            <h2>Menú de Navegación</h2>
            <ul class="side-buttons">
                <li><button class="nav-button" onclick="location.href='{{ url('inicio') }}'">Inicio</button></li>
                <li><button class="nav-button" onclick="location.href='{{ url('adminmaquinas') }}'">Administración de Máquinas</button></li>
                <li><button class="nav-button" onclick="location.href='{{ url('asignacion') }}'">Asignar trabajo preventivo</button></li>
                <li><button class="nav-button" onclick="location.href='{{ url('historial') }}'">Historial</button></li>
                <li><button class="nav-button" onclick="location.href='{{ url('preventivos') }}'">Datos preventivos</button></li>
                <li><button class="nav-button" onclick="location.href='{{ url('usuarios') }}'">Administración de usuarios</button></li>
                <li><button class="nav-button" onclick="location.href='{{ url('preventivos-en-curso') }}'">Preventivos en curso</button></li>
            </ul>
            <div class="user-info">
                <h2>Usuario Logueado</h2>
                <p><strong>Nombre:</strong> {{ $user->username }}</p>
                <p><strong>Número de Reloj:</strong> {{ $user->clock_number }}</p>
                <p><strong>Posición:</strong> {{ $user->position }}</p>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit">Cerrar sesión</button>
                </form>
            </div>
        </nav>
        <section class="content">
            <h2 style="text-align: center;">Historial General</h2>

            <!-- Menú desplegable para filtrar tareas -->
            <div class="filter-container" style="text-align: right; margin-bottom: 20px;">
                <label for="status_filter">Filtrar por estado:</label>
                <select id="status_filter">
                    <option value="">-- Selecciona un estado --</option>
                    <option value="Completada">Completada</option>
                    <option value="Incompleta">Incompleta</option>
                </select>
            </div>
            <hr>

            <div class="maintenance-container">
                <ul class="maintenance-list">
                    @foreach($tasks as $task)
                        <li class="maintenance-item" data-task-status="{{ $task->status_task }}" data-task-id="{{ $task->id }}">
                            <h3>Máquina: {{ $task->machine->machine_number ?? 'Desconocida' }}</h3>
                            <p><strong>Usuario:</strong> {{ $task->user->username ?? 'Desconocido' }}</p>
                            <p><strong>Estado:</strong> {{ $task->status_task }}</p>
                            <button class="toggle-details">Detalles</button>
                            <div class="task-details" style="display:none;">
                                <p><strong>Fecha Límite:</strong> {{ $task->due_date->format('d/m/Y') }}</p>
                                <p><strong>Fecha Finalizada:</strong> {{ $task->updated_at->format('d/m/Y') }}</p>
                                <p><strong>Checklist:</strong> {{ implode(', ', json_decode($task->checklist)) }}</p>
                            </div>
                        </li>
                        <hr>
                    @endforeach
                </ul>
            </div>
        </section>
    </main>
    <footer class="footer">
        <p>Datos reservados</p>
    </footer>

    <script>
        $(document).ready(function() {
            // Filtrar tareas según el estado seleccionado
            $('#status_filter').change(function() {
                var selectedStatus = $(this).val();
                
                $('.maintenance-item').each(function() {
                    var taskStatus = $(this).data('task-status');
                    
                    if (selectedStatus === '' || taskStatus === selectedStatus) {
                        $(this).show();
                        $(this).next('hr').show(); // Mostrar la línea <hr> asociada
                    } else {
                        $(this).hide();
                        $(this).next('hr').hide(); // Ocultar la línea <hr> asociada
                    }
                });
            });

            // Toggle details
            $('.toggle-details').click(function() {
                $(this).siblings('.task-details').toggle();
            });
        });
    </script>
</body>
</html>

