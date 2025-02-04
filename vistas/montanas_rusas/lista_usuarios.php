<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Montañas Rusas - Lista</title>
    <link rel="stylesheet" href="../css/style.css">
</head>

<body>
    <nav id="listaMontañas">
        <h2>Lista de Montañas Rusas</h2>
        <div>
            <a href="index.php?accion=index">Ver Montaña Rusa</a>
            <a href="?accion=agregar">Agregar Montaña Rusa</a>
            <a href="?accion=agregar_evento">Crear evento</a>
            <a href="?accion=listar_eventos">Ver eventos</a>
            <a href="?accion=logout">Cerrar sesión</a>
        </div>
    </nav>
    <?php if (empty($montanasRusas)): ?>
        <p>No hay montañas rusas disponibles.</p>
    <?php else: ?>
        <table id="tablaMontañas">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Velocidad (km/h)</th>
                    <th>Altura (m)</th>
                    <th>Fabricante</th>
                    <th>Tipo</th>
                    <th>Ubicación</th>
                    <th>Fecha de Inauguración</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($montanasRusas as $montana): ?>
                    <?php if ($montana['Valido'] == 'Si') : ?>
                        <tr>
                            <td><?php echo htmlspecialchars($montana['nombre']); ?></td>
                            <td><?php echo htmlspecialchars($montana['velocidad']); ?> km/h</td>
                            <td><?php echo htmlspecialchars($montana['altura']); ?> m</td>
                            <td><?php echo htmlspecialchars($montana['fabricante']); ?></td>
                            <td><?php echo htmlspecialchars($montana['tipo']); ?></td>
                            <td><?php echo htmlspecialchars($montana['ubicacion']); ?></td>
                            <td><?php echo htmlspecialchars($montana['fecha_inauguracion']); ?></td>
                        </tr>
                    <?php endif; ?>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</body>

</html>