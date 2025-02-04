<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style.css">
    <title>Montañas rusas - Ver Eventos</title>
</head>

<body>
    <nav id="listaMontañas">
        <h2>Listar Evento</h2>
        <div>
            <a href="index.php?accion=index">Ver Montaña Rusa</a>
            <a href="index.php?accion=agregar">Agregar Montaña Rusa</a>
            <a href="index.php?accion=agregar_evento">Crear evento</a>
            <a href="index.php?accion=listar_eventos">Ver eventos</a>
            <a href="index.php?accion=logout">Cerrar sesión</a>
        </div>
    </nav>
    
    <!-- Tabla de Eventos del Usuario -->
    <h3>Eventos del Usuario</h3>
    <table id="tablaMontañas">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Fecha</th>
                <th>Descripción</th>
                <th colspan="2">Funciones</th>
                <th>Días restantes</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($eventosUsuario)): ?>
                <?php foreach ($eventosUsuario as $eventos): ?>
                    <?php if ($eventos["nombreUsuario"]==$_SESSION["user"]["nombreUsuario"]): ?>
                    <?php foreach ($eventos['eventos'] as $evento): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($evento['nombre']); ?></td>
                        <td><?php echo htmlspecialchars($evento['fecha']); ?></td>
                        <td><?php echo htmlspecialchars($evento['descripcion']); ?></td>
                        <?php if ($evento['asistencia'] === false) : ?>
                            <td><a href="accion=asistir&nombre=<?php echo htmlspecialchars($evento['nombre']); ?>"><button>Asistiré</button></a></td>
                            <td><a href="accion=eliminar&nombre=<?php echo htmlspecialchars($evento['nombre']); ?>"><button>Eliminar</button></a></td>

                        <?php else: ?>
                            <td colspan="2"><a href="accion=eliminar&nombre=<?php echo htmlspecialchars($evento['nombre']); ?>"><button>Eliminar</button></a></td>
                            <?php endif; ?>
                           
                        <td>
                            <?php
                            $fechaEvento = strtotime($evento['fecha']);
                            $fechaActual = strtotime(date('Y-m-d'));
                            $diferencia = ($fechaEvento - $fechaActual) / (60 * 60 * 24);

                            if ($diferencia == 0) {
                                echo "HOY";
                            } elseif ($diferencia > 0) {
                                echo $diferencia . " días restantes";
                            } else {
                                echo "Pasado";
                            }
                            ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                    <?php endif; ?>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="6">No hay eventos de usuario registrados.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <!-- Tabla de Eventos Generales -->
    <h3>Eventos Generales</h3>
    <table id="tablaMontañas">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Fecha</th>
                <th>Descripción</th>
                <th>Días Restantes</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($eventosGenerales)): ?>
                <?php foreach ($eventosGenerales as $evento): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($evento['nombre']); ?></td>
                        <td><?php echo htmlspecialchars($evento['fecha']); ?></td>
                        <td><?php echo htmlspecialchars($evento['descripcion']); ?></td>
                        <td>
                            <?php
                            $fechaEvento = strtotime($evento['fecha']);
                            $fechaActual = strtotime(date('Y-m-d'));
                            $diferencia = ($fechaEvento - $fechaActual) / (60 * 60 * 24);

                            if ($diferencia == 0) {
                                echo "HOY";
                            } elseif ($diferencia > 0) {
                                echo $diferencia . " días restantes";
                            } else {
                                echo "Pasado";
                            }
                            ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="4">No hay eventos generales registrados.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</body>

</html>