<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Asignación</title>
    <link rel="stylesheet" href="{{ asset('css/MainSS.css') }}">
</head>
<body>
    <header class="banner">
        <h1 style="text-align: center;">Administración de Asignación</h1>
    </header>
    <main>
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
            <h2 style="text-align: center;">Detalles de la Asignación</h2>
            
            <!-- Mostrar mensaje de éxito -->
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Mostrar mensaje de error -->
            @if($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Formulario de asignación -->
            <form id="assignment-form" action="{{ route('asignacion.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="machine_id">Seleccionar Máquina</label>
                    <select name="machine_id" id="machine_id" required>
                        <option value="">Seleccionar máquina</option>
                        @foreach($machines as $machine)
                            <option value="{{ $machine->id }}">{{ $machine->machine_number }} - {{ $machine->machine_type }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="user_id">Seleccionar Usuario</label>
                    <select name="user_id" id="user_id" required>
                        <option value="">Seleccionar usuario</option>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}">{{ $user->username }} - {{ $user->clock_number }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">

                    <label for="due_date">Fecha de cierre</label>

                    <input type="date" name="due_date" id="due_date" required>
                </div>
                <hr>
                <div id="checklist-options">
                    <!-- Checklist options will be dynamically inserted here -->
                </div>
                <hr>


                <button type="submit">Asignar Tarea</button>
            </form>
        </section>
    </main>
    <footer class="footer">
        <p>Datos reservados</p>
    </footer>

    <script>
        document.getElementById('machine_id').addEventListener('change', function() {
            var machineType = this.options[this.selectedIndex].text.split(' - ')[1];
            var checklistOptions = [];

            if (machineType === 'NK') {
                checklistOptions = [
                    'Verificar cubierta de rodillos',
                    'Verificar Guia de la cadena',
                    'Verificar agujas de la trama',
                    'Verificar rieles',
                    'Verificar Rastrillos',
                    'Verificar rieles del carrier',
                    'Verificar limpieza de carriers',
                    'Verificar banda transportadora y poleas',
                    'Limpiar filtros y tubos',
                    'Verificar baleros del rollo del "monkey swing"',
                    'Verificar corte correcto de la navaja'
                ];
            }
            
            if (machineType === 'Karl Mayer') {
                checklistOptions = [
                    'Verificar cubierta de rodillos',
                    'Verificar Guia de la cadena',
                    'Verificar agujas de la trama',
                    'Verificar rieles',
                    'Verificar Rastrillos',
                    'Verificar rieles del carrier',
                    'Verificar limpieza de carriers',
                    'Verificar banda transportadora y poleas',
                    'Limpiar filtros y tubos',
                    'Verificar baleros del rollo del "monkey swing"',
                    'Verificar corte correcto de la navaja'
                ];
            }

            var checklistHtml = checklistOptions.map(function(option) {
                return '<label><input type="checkbox" name="checklist[]" value="' + option + '"> ' + option + '</label><br>';
            }).join('');

            document.getElementById('checklist-options').innerHTML = checklistHtml;
        });

        document.getElementById('assignment-form').addEventListener('submit', function(event) {
            var checkboxes = document.querySelectorAll('input[name="checklist[]"]');
            var checkedOne = Array.prototype.slice.call(checkboxes).some(function(checkbox) {
                return checkbox.checked;
            });

            if (!checkedOne) {
                event.preventDefault();
                alert('Por favor, seleccione al menos un ítem de la lista de verificación.');
            }
        });
    </script>
</body>
</html>
