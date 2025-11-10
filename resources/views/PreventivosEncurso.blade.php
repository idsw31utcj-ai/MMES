<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Preventivos en Curso</title>
    <link rel="stylesheet" href="{{ asset('css/MainSS.css') }}">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> <!-- Para alertas de confirmación -->
    <style>
        .filter-container {
            text-align: right;
            margin-bottom: 20px;
        }
        .filter-container label {
            margin-right: 10px;
        }
        .filter-container select {
            padding: 5px;
            font-size: 16px;
        }
    </style>
</head>
<body>
    <header class="banner">
        <h1>Preventivos en Curso</h1>
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
            <h2 style="text-align: center;">Tareas en Curso</h2>
            
            <!-- Filtro por usuario -->
            <div class="filter-container">
                <label for="user-filter">Filtrar por usuario:</label>
                <select id="user-filter">
                    <option value="">Selecciona un usuario</option>
                    @foreach($users as $user)
                        @if($user->role === 'usuario') <!-- Solo mostrar usuarios con rol 'usuario' -->
                            <option value="{{ $user->id }}">{{ $user->username }}</option>
                        @endif
                    @endforeach
                </select>
            </div>
            <hr>

            <div class="maintenance-container">
                <ul class="maintenance-list">
                    @foreach($tasks as $task)
                        <li class="maintenance-item" data-task-id="{{ $task->id }}" data-task-user-id="{{ $task->user_id }}">
                            <h3>Máquina: {{ $task->machine->machine_number ?? 'Desconocida' }}</h3>
                            <p><strong>Usuario:</strong> {{ $task->user->username ?? 'Desconocido' }}</p>
                            <p><strong>Estado:</strong> {{ $task->status_task }}</p>
                            <button class="toggle-details">Detalles</button>
                            
                            <!-- Formulario para editar la tarea -->
                            <form action="{{ route('preventivos-en-curso.update', $task->id) }}" method="POST" class="edit-form" style="display:inline;">
                                @csrf
                                @method('PATCH')
                                <select name="user_id" required>
                                    <option value="" disabled selected>Seleccionar usuario</option>
                                    @foreach($users as $user)
                                        @if($user->role === 'usuario') <!-- Solo mostrar usuarios con rol 'usuario' -->
                                            <option value="{{ $user->id }}" {{ $task->user_id == $user->id ? 'selected' : '' }}>
                                                {{ $user->username }}
                                            </option>
                                        @endif
                                    @endforeach
                                </select>
                                <button type="submit" class="edit-btn">Cambiar Responsable</button>
                            </form>

                            <!-- Formulario para eliminar la tarea -->
                            <form action="{{ route('preventivos-en-curso.destroy', $task->id) }}" method="POST" class="delete-form" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="delete-btn">Eliminar</button>
                            </form>

                            <!-- Detalles de la tarea -->
                            <div class="task-details" style="display:none;">
                                <p><strong>Fecha Límite:</strong> {{ $task->due_date->format('d/m/Y') }}</p>
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
            // Mostrar/Ocultar detalles de la tarea
            $('.toggle-details').click(function() {
                $(this).siblings('.task-details').toggle();
            });

            // Confirmación de eliminación
            $('.delete-form').submit(function(e) {
                e.preventDefault();
                const form = $(this);

                Swal.fire({
                    title: '¿Estás seguro?',
                    text: "No podrás recuperar esta tarea después de eliminarla.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Sí, eliminar',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.off('submit').submit();
                    }
                });
            });

            // Filtrado por usuario
            $('#user-filter').change(function() {
                const selectedUserId = $(this).val();
                $('.maintenance-item').each(function() {
                    const itemUserId = $(this).data('task-user-id');
                    if (selectedUserId === "" || itemUserId == selectedUserId) {
                        $(this).show();
                    } else {
                        $(this).hide();
                    }
                });
            });
        });
    </script>
</body>
</html>

