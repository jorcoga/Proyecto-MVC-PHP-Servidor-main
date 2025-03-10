<?php

// Comprobar si el usuario tiene el rol de 'fabricante'
if (!isset($_SESSION['user']) || $_SESSION['user']['rol'] !== 'fabricante') {
    echo "Acceso denegado. Necesitas ser fabricante para acceder a esta página.";
    exit();
}

// Filtrar las montañas rusas creadas por el fabricante
$montanasRusasFabricante = (new BDA)->obtenerMontanasPorFabricante($_SESSION['user']['nombreUsuario']);
?>


<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Montañas Rusas - Panel del Fabricante</title>
    <link rel="stylesheet" href="../css/style.css">
</head>

<body>
    <nav id="listaMontañas">
        <h2>Lista de Montañas Rusas</h2>
        <div>
            <a href="index.php?accion=index">Ver Montaña Rusa</a>
            <a href="index.php?accion=agregar">Agregar Montaña Rusa</a>
            <a href="index.php?accion=agregar_evento">Crear evento</a>
            <a href="index.php?accion=listar_eventos">Ver eventos</a>
            <a href="index.php?accion=logout">Cerrar sesión</a>
        </div>
    </nav>

    <!-- Tabla de montañas rusas creadas por el fabricante -->
    <h3>Mis Montañas Rusas</h3>
    <table id="tablaMontañas">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Velocidad</th>
                <th>Altura</th>
                <th>Tipo</th>
                <th>Ubicación</th>
                <th>Fecha de Inauguración</th>
                <th colspan="2">Funciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($montanasRusasFabricante as $montana) : ?>
                <tr>
                    <td><?php echo htmlspecialchars($montana['nombre']); ?></td>
                    <td><?php echo htmlspecialchars($montana['velocidad']); ?> km/h</td>
                    <td><?php echo htmlspecialchars($montana['altura']); ?> m</td>
                    <td><?php echo htmlspecialchars($montana['tipo']); ?></td>
                    <td><?php echo htmlspecialchars($montana['ubicacion']); ?></td>
                    <td><?php echo htmlspecialchars($montana['fecha_inauguracion']); ?></td>
                    <td><a href="index.php?accion=eliminar&atraccion=<?php echo htmlspecialchars($montana['nombre']); ?>"><button>Eliminar</button></a></td>
                    <?php if ($montana['Valido'] == 'No') : ?>
                        <td><a href="index.php?accion=validar&atraccion=<?php echo htmlspecialchars($montana['nombre']); ?>"><button>Validar</button></a></td>
                    <?php endif; ?>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>


    <?php
    $alturaFiltrada = isset($_GET['altura']) ? (int) $_GET['altura'] : null;

    // Filtrar montañas rusas si se proporciona un valor en el filtro
    if ($alturaFiltrada) {
        $montanasRusasGenerales = array_filter($montanasRusasGenerales, function ($montana) use ($alturaFiltrada) {
            return $montana['altura'] >= $alturaFiltrada;
        });
    }
    ?>
    
    <!-- Formulario de filtro para las montañas rusas generales -->
    <h3>Montañas Rusas Generales</h3>
    <form class="filtro" method="GET" action="" id="filtro">
        <label for="altura">Altura: </label>
        <input type="number" id="altura" name="altura" value="<?php echo htmlspecialchars($filtrar['altura'] ?? ''); ?>"><br>

        <button type="submit">Filtrar</button>
    </form>

    <!-- Tabla de montañas rusas generales filtradas -->
    <table id="tablaMontañas">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Velocidad</th>
                <th>Altura</th>
                <th>Tipo</th>
                <th>Fabricante</th>
                <th>Ubicación</th>
                <th>Fecha de Inauguración</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($montanasRusasGenerales as $montana) : ?>
                <tr>
                    <td><?php echo htmlspecialchars($montana['nombre']); ?></td>
                    <td><?php echo htmlspecialchars($montana['velocidad']); ?> km/h</td>
                    <td><?php echo htmlspecialchars($montana['altura']); ?> m</td>
                    <td><?php echo htmlspecialchars($montana['tipo']); ?></td>
                    <td><?php echo htmlspecialchars($montana['fabricante']); ?> </td>
                    <td><?php echo htmlspecialchars($montana['ubicacion']); ?></td>
                    <td><?php echo htmlspecialchars($montana['fecha_inauguracion']); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

</body>
</html>