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
                    <td><?php echo htmlspecialchars($montana['fabricante']); ?> m</td>
                    <td><?php echo htmlspecialchars($montana['ubicacion']); ?></td>
                    <td><?php echo htmlspecialchars($montana['fecha_inauguracion']); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

</body>
</html>