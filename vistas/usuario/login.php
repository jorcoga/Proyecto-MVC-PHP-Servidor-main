<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style.css">
    <title>Montañas Rusas - Login</title>
</head>

<body id="loginRegister">
    <h2>INICIAR SESIÓN</h2>
    <form action="index.php?accion=login" method="POST">
        <label for="nombreUsuario">Nombre de Usuario</label><br>
        <input type="text" name="nombreUsuario" required><br>

        <label for="contrasena">Contraseña</label><br>
        <input type="password" name="contrasena" required><br>

        <input type="submit" value="Entrar"></input>
        <p>¿No tienes cuenta? Regístrate <a href="index.php?accion=registrar">aquí</a></p>
    </form>
</body>

</html>