<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administración de Máquinas</title>
    <link rel="stylesheet" href="{{ asset('css/MainSS.css') }}">
</head>
<body>
    <header class="banner">
        <h1 style="text-align: center;">Administración de Máquinas</h1>
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
                <p><strong>Nombre:</strong> {{ $currentUser->username }}</p>
                <p><strong>Número de Reloj:</strong> {{ $currentUser->clock_number }}</p>
                <p><strong>Posición:</strong> {{ $currentUser->position }}</p>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit">Cerrar sesión</button>
                </form>
            </div>
        </nav>
        <section class="content">
            <h2 style="text-align: center;">Gestión de Máquinas</h2>
            
            <!-- Formulario para agregar una nueva máquina -->
            <h3>Agregar Nueva Máquina</h3>
            <form action="{{ url('adminmaquinas/agregar') }}" method="POST" autocomplete="off">
                @csrf
                <div class="form-group">
                    <label for="machine_number">Número de Máquina:</label>
                    <input type="number" id="machine_number" name="machine_number" required placeholder="Ingrese no.máquina">
                </div>
                <div class="form-group">
                    <label for="machine_type">Tipo de Máquina:</label>
                    <select id="machine_type" name="machine_type" required>
                        <option value="Karl Mayer">Karl Mayer</option>
                        <option value="NK">NK</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="machine_status">Estado:</label>
                    <select id="machine_status" name="machine_status" required>
                        <option value="activo">Activo</option>
                        <option value="inactivo">Inactivo</option>
                    </select>
                </div>
                <button type="submit">Agregar Máquina</button>
            </form>
            <hr>

            <!-- Mostrar la lista de máquinas -->
            <div id="machine-list-container">
                <div id="active-machines">
                    <h3 style="text-align: center;">Activas</h3>
                    <hr>
                    <table id="active-machines-table">
                        <thead>
                            <tr>
                                <th style="padding: 10px 15px;">Número de Máquina</th>
                                <th style="padding: 10px 15px;">Tipo de Máquina</th>
                                <th style="padding: 10px 15px;">Estado</th>
                                <th style="padding: 10px 15px;">Acciones</th>
                            </tr>
                        </thead>
                        <tbody id="active-machines-body">
                            @foreach($machines as $machine)
                                <tr class="machine-row" data-machine-number="{{ $machine->machine_number }}" data-machine-status="{{ $machine->machine_status }}">
                                    <td style="padding: 10px;">{{ $machine->machine_number }}</td>
                                    <td style="padding: 10px;">{{ $machine->machine_type }}</td>
                                    <td style="padding: 10px;">{{ $machine->machine_status }}</td>
                                    <td style="padding: 10px;">
                                        <!-- Formulario para eliminar la máquina -->
                                        <form action="{{ url('adminmaquinas/eliminar', $machine->id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" onclick="return confirm('¿Estás seguro de que deseas eliminar esta máquina?')">Eliminar</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <hr>
                <div id="inactive-machines">
                    <h3 style="text-align: center;">Inactivas</h3>
                    <hr>
                    <table id="inactive-machines-table">
                        <thead>
                            <tr>
                                <th style="padding: 10px 15px;">Número de Máquina</th>
                                <th style="padding: 10px 15px;">Tipo de Máquina</th>
                                <th style="padding: 10px 15px;">Estado</th>
                                <th style="padding: 10px 15px;">Acciones</th>
                            </tr>
                        </thead>
                        <tbody id="inactive-machines-body">
                            <!-- Se llenará mediante JavaScript -->
                        </tbody>
                    </table>
                </div>
            </div>
            <hr>

            <!-- Formulario de selección y edición -->
            <h3>Actualizar Estado de Máquina</h3>
            <form action="{{ url('adminmaquinas/update') }}" method="POST">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="edit_machine_id">Selecciona Máquina:</label>
                    <select id="edit_machine_id" name="machine_id" required>
                        <option value="">Selecciona una máquina</option>
                        @foreach($machines as $machine)
                            <option value="{{ $machine->id }}">{{ $machine->machine_number }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="machine_status">Estado:</label>
                    <select id="machine_status" name="machine_status" required>
                        <option value="activo">Activo</option>
                        <option value="inactivo">Inactivo</option>
                    </select>
                </div>
                <button type="submit">Actualizar</button>
            </form>
        </section>
    </main>
    <footer class="footer">
        <p>Datos reservados</p>
    </footer>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const activeMachinesBody = document.getElementById('active-machines-body');
            const inactiveMachinesBody = document.getElementById('inactive-machines-body');

            const machineRows = Array.from(document.querySelectorAll('.machine-row'));

            const activeMachines = machineRows.filter(row => row.dataset.machineStatus === 'activo');
            const inactiveMachines = machineRows.filter(row => row.dataset.machineStatus === 'inactivo');

            // Ordenar máquinas por número de máquina de menor a mayor
            const sortByMachineNumber = (a, b) => {
                return parseInt(a.dataset.machineNumber) - parseInt(b.dataset.machineNumber);
            };

            activeMachines.sort(sortByMachineNumber).forEach(row => {
                activeMachinesBody.appendChild(row);
            });

            inactiveMachines.sort(sortByMachineNumber).forEach(row => {
                inactiveMachinesBody.appendChild(row);
            });
        });
    </script>
</body>
</html>

