<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administración de Usuarios</title>
    <link rel="stylesheet" href="{{ asset('css/MainSS.css') }}">
</head>
<body>
    <header class="banner">
        <h1 style="text-align: center;">Administración de Usuarios</h1>
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
            <h2 style="text-align: center;">Gestión de Usuarios</h2>
            <p>Bienvenido/a, aquí puedes gestionar los usuarios del sistema. Puedes ver detalles de los usuarios registrados en el sistema.</p>

            <!-- Mostrar mensajes de error o éxito -->
            @if($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if(session('success'))
                <div class="alert alert-success">
                    <p>{{ session('success') }}</p>
                </div>
            @endif

            <!-- Formulario para registrar nuevos usuarios -->
            <h3>Registrar Nuevo Usuario</h3>
            <form action="{{ route('usuarios.store') }}" method="POST" autocomplete="off">
                @csrf
                <label for="username">Usuario:</label>
                <input type="text" id="username" name="username" minlength="5" required placeholder="Ingrese su nombre">

                <label for="password">Contraseña:</label>
                <input type="password" id="password" name="password" minlength="8" required placeholder="Ingrese una contraseña">

                <label for="clock_number">No.Reloj:</label>
                <input type="number" id="clock_number" name="clock_number" min"10000" required placeholder="Ingrese el no.reloj">

                <button type="submit">Registrar Usuario</button>
            </form>
            <hr>

            <!-- Listado de usuarios -->
            <h3>Listado de Usuarios</h3>
            <ul class="user-list">
                @foreach($users as $user)
                    <li>
                        <h4>{{ $user->username }}</h4>
                        <p><strong>Número de Reloj:</strong> {{ $user->clock_number }}</p>
                        <p><strong>Posición:</strong> {{ $user->position }}</p>
                        <p><strong>Estado:</strong> {{ $user->status }}</p>
                        @if($user->role === 'usuario')
                            <form action="{{ route('usuarios.destroy', $user->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit">Eliminar</button>
                            </form>
                        @endif
                    </li>
                    <hr>
                @endforeach
            </ul>
            <hr>

            <!-- Formulario para editar el estado del usuario -->
            <h3>Editar Estado de Usuario</h3>
            <form action="{{ route('usuarios.updateStatus') }}" method="POST">
                @csrf
                <label for="user_id">Seleccionar Usuario:</label>
                <select id="user_id" name="user_id" required>
                    <option value="">Seleccionar usuario</option>
                    @foreach($users as $user)
                        @if($user->role === 'usuario')
                            <option value="{{ $user->id }}">{{ $user->username }} ({{ $user->clock_number }})</option>
                        @endif
                    @endforeach
                </select>

                <label for="status">Estado:</label>
                <select id="status" name="status" required>
                    <option value="activo">Activo</option>
                    <option value="inactivo">Inactivo</option>
                </select>

                <button type="submit">Actualizar Estado</button>
            </form>
        </section>
    </main>
    <footer class="footer">
        <p>Datos reservados</p>
    </footer>
</body>
</html>