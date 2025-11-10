<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Información de Preventivos</title>
    <link rel="stylesheet" href="{{ asset('css/MainSS.css') }}">
    <style>
        .search-container {
            margin-bottom: 20px;
        }
        .search-container select {
            padding: 10px;
            width: 100%;
            box-sizing: border-box;
        }
        .content-item {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <header class="banner">
        <h1>Datos Preventivos</h1>
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
            <h2 style="text-align: center;">Acerca de: Mantenimientos Preventivos</h2>
            <p>En esta sección encontrarás información detallada sobre el mantenimiento preventivo para las máquinas utilizadas en la producción de telas de fibra de vidrio.</p>

            <!-- Menú desplegable para filtrar contenido -->
            <div class="search-container">
                <select id="filterSelect" onchange="filterContent()">
                    <option value="">Seleccionar categoría...</option>
                    <option value="NK">Máquinas NK</option>
                    <option value="Karl Mayer">Máquinas Karl Mayer</option>
                    <option value="Inspección Regular">Inspección Regular</option>
                    <option value="Limpieza">Limpieza</option>
                    <option value="Lubricación">Lubricación</option>
                    <option value="Ajustes">Ajustes</option>
                    <option value="Reemplazo de Componentes">Reemplazo de Componentes</option>
                    <option value="Documentación y Registro">Documentación y Registro</option>
                    <option value="Entrenamiento del Personal">Entrenamiento del Personal</option>
                    <option value="Planificación del Mantenimiento">Planificación del Mantenimiento</option>
                </select>
            </div>

            <!-- Sección de contenido -->
            <div id="contentList">
                <div class="content-item" data-title="Máquinas NK">
                    <h3>Máquinas NK</h3>
                    <p>Las máquinas NK están diseñadas para ofrecer alta precisión y eficiencia en la producción de tejidos de fibra de vidrio. Estas máquinas son conocidas por su robustez y capacidad para operar a altas velocidades.</p>
                    <p><strong>Características Técnicas:</strong></p>
                    <ul>
                        <li><strong>Velocidad de Operación:</strong> Hasta 1500 rpm.</li>
                        <li><strong>Precisión:</strong> +/- 0.01 mm en el ancho del tejido.</li>
                        <li><strong>Capacidad:</strong> Hasta 10 m/min de velocidad de tejido.</li>
                        <li><strong>Tipo de Tejido:</strong> Variedad de tejidos técnicos y técnicos complejos.</li>
                    </ul>
                </div>

                <div class="content-item" data-title="Máquinas Karl Mayer">
                    <h3>Máquinas Karl Mayer</h3>
                    <p>Las máquinas Karl Mayer son especialistas en el tejido de productos técnicos y textiles avanzados. Estas máquinas destacan por su flexibilidad y la calidad superior de los tejidos producidos.</p>
                    <p><strong>Características Técnicas:</strong></p>
                    <ul>
                        <li><strong>Velocidad de Operación:</strong> Hasta 1800 rpm.</li>
                        <li><strong>Precisión:</strong> +/- 0.005 mm en el ancho del tejido.</li>
                        <li><strong>Capacidad:</strong> Hasta 12 m/min de velocidad de tejido.</li>
                        <li><strong>Tipo de Tejido:</strong> Telas de alto rendimiento y tejidos técnicos.</li>
                    </ul>
                </div>

                <div class="content-item" data-title="Inspección Regular">
                    <h3>Inspección Regular</h3>
                    <p>Revisa periódicamente las máquinas para detectar desgastes o fallos potenciales. Esto incluye la revisión de componentes clave como los rodamientos, correas y motores.</p>
                </div>

                <div class="content-item" data-title="Limpieza">
                    <h3>Limpieza</h3>
                    <p>Mantén las máquinas libres de polvo y residuos que puedan afectar su funcionamiento. La limpieza regular ayuda a prevenir acumulación de partículas que pueden causar daños o mal funcionamiento.</p>
                </div>

                <div class="content-item" data-title="Lubricación">
                    <h3>Lubricación</h3>
                    <p>Aplica lubricantes en partes móviles para reducir la fricción y el desgaste. La lubricación adecuada es crucial para el funcionamiento suave y eficiente de las partes móviles.</p>
                </div>

                <div class="content-item" data-title="Ajustes">
                    <h3>Ajustes</h3>
                    <p>Realiza calibraciones y ajustes para asegurar la precisión en el tejido. Los ajustes regulares aseguran que la máquina opere dentro de los parámetros especificados.</p>
                </div>

                <div class="content-item" data-title="Reemplazo de Componentes">
                    <h3>Reemplazo de Componentes</h3>
                    <p>Sustituye piezas desgastadas antes de que fallen. Realizar reemplazos preventivos puede evitar paradas inesperadas y daños mayores en la maquinaria.</p>
                </div>

                <div class="content-item" data-title="Documentación y Registro">
                    <h3>Documentación y Registro</h3>
                    <p>Mantén registros detallados de todas las actividades de mantenimiento realizadas. Una buena documentación ayuda a planificar futuros mantenimientos y a identificar patrones de fallos.</p>
                </div>

                <div class="content-item" data-title="Entrenamiento del Personal">
                    <h3>Entrenamiento del Personal</h3>
                    <p>Asegúrate de que el personal esté capacitado en el mantenimiento preventivo. El entrenamiento adecuado puede mejorar la eficiencia y reducir errores durante el mantenimiento.</p>
                </div>

                <div class="content-item" data-title="Planificación del Mantenimiento">
                    <h3>Planificación del Mantenimiento</h3>
                    <p>Establece un plan de mantenimiento preventivo basado en el uso y las recomendaciones del fabricante. La planificación asegura que todos los aspectos importantes sean cubiertos de manera oportuna.</p>
                </div>
            </div>
        </section>
    </main>
    <footer class="footer">
        <p>Datos reservados</p>
    </footer>

    <script>
        function filterContent() {
            var select, filter, contentList, items, title, i;
            select = document.getElementById('filterSelect');
            filter = select.value.toUpperCase();
            contentList = document.getElementById('contentList');
            items = contentList.getElementsByClassName('content-item');

            for (i = 0; i < items.length; i++) {
                title = items[i].getAttribute('data-title');
                if (title.toUpperCase().indexOf(filter) > -1 || filter === "") {
                    items[i].style.display = "";
                } else {
                    items[i].style.display = "none";
                }
            }
        }
    </script>
</body>
</html>
