<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Montañas rusas - Agregar Montaña</title>
    <link rel="stylesheet" href="../css/style.css">
</head>

<body>
    <nav id="listaMontañas">
        <h1>Lista de Montañas Rusas</h1>
        <div>
            <a href="index.php?accion=index">Ver Montaña Rusa</a>
            <a href="?accion=agregar">Agregar Montaña Rusa</a>
            <a href="?accion=agregar_evento">Crear evento</a>
            <a href="?accion=listar_eventos">Ver eventos</a>
            <a href="?accion=logout">Cerrar sesión</a>
        </div>
    </nav>
    <h2>Agregar Nueva Montaña Rusa</h2>
    <form action="index.php?accion=agregar" method="POST" id="agregar">
        <label for="nombre">Nombre de la Montaña Rusa</label>
        <input type="text" name="nombre" required>

        <label for="velocidad">Velocidad (km/h)</label>
        <input type="number" name="velocidad" required>

        <label for="altura">Altura (m)</label>
        <input type="number" name="altura" required>

        <label for="fabricante">Fabricante</label>
        <input type="text" name="fabricante" required>

        <label for="tipo">Tipo</label>
        <input type="text" name="tipo" required>

        <label for="ubicacion">Ubicación</label>
        <input type="text" name="ubicacion" required>

        <label for="fecha_inauguracion">Fecha de Inauguración</label>
        <input type="date" name="fecha_inauguracion" required>

        <button type="submit">Agregar Montaña Rusa</button>
    </form>

</body>

</html>