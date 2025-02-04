<?php
if (!isset($_COOKIE['logueado'])) {
    //header('Location: /vistas/usuario/login.php');
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Montañas rusas - Agregar Evento</title>
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
    <h2>Agregar Evento</h2>
    <form action="index.php?accion=agregar_evento" method="POST" id="agregar">
        <label for="nombre">Nombre del Evento:</label>
        <input type="text" name="nombre" required>

        <label for="fecha">Fecha:</label>
        <input type="date" name="fecha" required>

        <label for="descripcion">Descripción:</label>
        <textarea name="descripcion" required></textarea>

        <button type="submit">Agregar Evento</button>
    </form>

    <h2>Compartir Evento</h2>
    <form action="index.php?accion=compartir_evento" method="POST" id="agregar">
        <label for="nombre">Nombre del Evento:</label>
        <input type="text" name="nombre" required>

        <label for="usuario">Nombre del usuario</label>
        <input type="text" name="usuario" required>

        <button type="submit">Compartir Evento</button>
    </form>

    <a href="?accion=index">Volver atras</a>
</body>

</html>