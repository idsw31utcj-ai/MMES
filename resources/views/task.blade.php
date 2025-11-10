<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bienvenido</title>
    <link rel="stylesheet" href="{{ asset('css/Usercs.css') }}">
</head>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const checkboxes = document.querySelectorAll('.check-item');
            const finalizeButton = document.querySelector('#finalize-btn');

            function updateButtons() {
                const allChecked = Array.from(checkboxes).every(checkbox => checkbox.checked);
                finalizeButton.disabled = !allChecked;
                finalizeButton.classList.toggle('disabled', !allChecked);
            }

            checkboxes.forEach(checkbox => {
                checkbox.addEventListener('change', updateButtons);
            });

            updateButtons();
        });
    </script>
<body>
    <header class="banner">
        <h1>Detalles de la Tarea</h1>
    </header>
    <main class="container">
        <nav class="sidebar">
            <h2>Bienvenido</h2>
            <ul class="side-buttons">
                <!-- Botones de otras páginas removidos -->
            </ul>
            <div class="user-info">
                <h2>Usuario Logueado</h2>
                <p><strong>Nombre:</strong> {{ Auth::user()->username }}</p>
                <p><strong>Número reloj:</strong> {{ Auth::user()->clock_number }}</p>
                <p><strong>Posición:</strong> {{ Auth::user()->position }}</p> <!-- Cambiado de Rol a Posición -->
                <div class="logout">
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="button logout-button">Cerrar sesión</button>
                    </form>
                </div>
            </div>
        </nav>
        <section class="content">
            <div>
                <h2>Detalles de la Tarea</h2>
                <p><strong>Número de Máquina:</strong> {{ $task->machine->machine_number ?? 'Desconocido' }}</p>
                <p><strong>Fecha Límite:</strong> {{ $task->due_date->format('d/m/Y') }}</p>
                <p><strong>Estado:</strong> {{ $task->status_task }}</p>

                <h3>CheckList</h3>
                <ul>
                    @foreach(json_decode($task->checklist) as $item)
                        <li>
                            <input type="checkbox" id="check_{{ $loop->index }}" class="check-item" name="checklist[]" value="{{ $item }}">
                            <label for="check_{{ $loop->index }}">{{ $item }}</label>
                        </li>
                        <hr>
                    @endforeach
                </ul>

                <div class="buttons">
                    <form action="{{ route('welcome') }}" method="GET">
                        <button type="submit" class="button cancel-button">Cancelar</button>
                    </form>
                    <form action="{{ route('task.complete', $task->id) }}" method="POST">
                        @csrf
                        <button type="submit" id="finalize-btn" class="button finish-button" disabled>Finalizar</button>
                    </form>
                </div>
            </div>
        </section>
    </main>
    <footer class="footer">
        <p>Datos reservados</p>
    </footer>
</body>
</html>
